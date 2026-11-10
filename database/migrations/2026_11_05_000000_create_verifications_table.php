<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('users', 'carte')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('carte');
            });
        }

        if (!Schema::hasColumn('users', 'profil')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('profil', 15)->default('client')->after('photo');
            });
        }

        Schema::dropIfExists('verifications');

        Schema::create('verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('photo', 255);
            $table->string('carte', 255);
            $table->string('status', 20)->default('En cours');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('verified_at')->nullable();
        });

        // Triggers MySQL pour automatiser le remplissage de verified_at et le passage de users.profil à "vendeur"
        DB::unprepared('DROP TRIGGER IF EXISTS trg_verifications_before_update');
        DB::unprepared("
            CREATE TRIGGER trg_verifications_before_update
            BEFORE UPDATE ON verifications
            FOR EACH ROW
            BEGIN
                IF LOWER(NEW.status) IN ('verifier', 'vérifié', 'verifie', 'approved') AND NEW.verified_at IS NULL THEN
                    SET NEW.verified_at = NOW();
                ELSEIF LOWER(NEW.status) NOT IN ('verifier', 'vérifié', 'verifie', 'approved') THEN
                    SET NEW.verified_at = NULL;
                END IF;
            END
        ");

        DB::unprepared('DROP TRIGGER IF EXISTS trg_verifications_after_update');
        DB::unprepared("
            CREATE TRIGGER trg_verifications_after_update
            AFTER UPDATE ON verifications
            FOR EACH ROW
            BEGIN
                IF LOWER(NEW.status) IN ('verifier', 'vérifié', 'verifie', 'approved') THEN
                    UPDATE users SET profil = 'vendeur' WHERE id = NEW.user_id;
                ELSE
                    UPDATE users SET profil = 'client' WHERE id = NEW.user_id;
                END IF;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trg_verifications_before_update');
        DB::unprepared('DROP TRIGGER IF EXISTS trg_verifications_after_update');
        Schema::dropIfExists('verifications');
    }
};
