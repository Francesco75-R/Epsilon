@php $errors = $errors ?? new \Illuminate\Support\ViewErrorBag; @endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Administrateur - Nouveau mot de passe | Epsilon</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

    <style>
        .auth-container {
            max-width: 480px;
            margin: 40px auto;
            padding: 36px 32px;
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(10, 17, 40, 0.08);
            border: 1px solid rgba(226, 232, 240, 0.9);
        }
        .auth-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 24px;
            text-decoration: none;
        }
        .steps-bar {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 24px;
        }
        .step-pill {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }
        .step-pill.done {
            background: #dcfce7;
            color: #166534;
        }
        .step-pill.active {
            background: #006c4a;
            color: #ffffff;
        }
        .error-alert {
            padding: 14px 16px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 20px;
        }
        .status-alert {
            padding: 14px 16px;
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .admin-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #0A1128;
            color: #10B981;
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }
    </style>
</head>
<body>

    <div class="auth-page">
        <div class="auth-container">
            <!-- Logo Epsilon -->
            <a href="{{ route('home') }}" class="auth-brand" aria-label="Epsilon Accueil">
                <svg width="38" height="38" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="100" height="100" rx="24" fill="#0A1128" />
                    <path d="M30 35H66C66 35 66 35 66 35C66 37.7614 63.7614 40 61 40H44V49H57C59.7614 49 62 51.2386 62 54C62 56.7614 59.7614 59 57 59H44V68H66C68.7614 68 71 70.2386 71 73C71 75.7614 68.7614 78 66 78H35C31.134 78 28 74.866 28 71V40C28 37.2386 30 35 30 35Z" fill="#FFFFFF" />
                    <circle cx="70" cy="35" r="11" fill="#10B981" />
                    <g transform="translate(52, 47)">
                        <path d="M0 7H15" stroke="#10B981" stroke-width="5" stroke-linecap="round" />
                        <path d="M10 2L15 7L10 12" stroke="#10B981" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
                    </g>
                </svg>
                <div>
                    <div style="font-weight: 800; font-size: 22px; color: #0A1128; line-height: 1;">Epsilon</div>
                    <div style="font-size: 10px; font-weight: 600; color: #10B981; letter-spacing: 2px; text-transform: uppercase;">Administration</div>
                </div>
            </a>

            <!-- Étapes -->
            <div class="steps-bar">
                <span class="step-pill done">1. E-mail ✓</span>
                <span style="color:#cbd5e1;">→</span>
                <span class="step-pill done">2. Code OTP ✓</span>
                <span style="color:#cbd5e1;">→</span>
                <span class="step-pill active">3. Nouveau mot de passe</span>
            </div>

            <div class="form-header" style="text-align: center; margin-bottom: 24px;">
                <div class="admin-badge">🔒 Sécurité Administrateur</div>
                <h2 style="font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 6px;">Définir un nouveau mot de passe</h2>
                <p style="font-size: 13px; color: #64748b; line-height: 1.5;">
                    Choisissez un mot de passe robuste (au moins 8 caractères) pour sécuriser l'accès administrateur à <strong>{{ $email }}</strong>.
                </p>
            </div>

            @if (session('status'))
                <div class="status-alert">
                    <span>✓</span>
                    <div>{{ session('status') }}</div>
                </div>
            @endif

            @if (session('error'))
                <div class="error-alert">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="error-alert">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('admin.password.reset.submit') }}" method="POST">
                @csrf

                <!-- Nouveau mot de passe -->
                <div class="form-group" style="margin-bottom: 16px;">
                    <label class="form-label" for="new-pw">Nouveau mot de passe administrateur</label>
                    <div class="input-wrapper">
                        <span class="input-icon">🔒</span>
                        <input class="form-input with-icon has-toggle" id="new-pw" name="password" type="password" placeholder="Minimum 8 caractères" required minlength="8" autocomplete="new-password">
                        <button type="button" class="btn-toggle-pw" onclick="togglePasswordVisibility('new-pw', this)" tabindex="-1">👁</button>
                    </div>
                </div>

                <!-- Confirmation -->
                <div class="form-group" style="margin-bottom: 24px;">
                    <label class="form-label" for="confirm-pw">Confirmer le nouveau mot de passe</label>
                    <div class="input-wrapper">
                        <span class="input-icon">🔒</span>
                        <input class="form-input with-icon has-toggle" id="confirm-pw" name="password_confirmation" type="password" placeholder="Répétez le mot de passe" required minlength="8" autocomplete="new-password">
                        <button type="button" class="btn-toggle-pw" onclick="togglePasswordVisibility('confirm-pw', this)" tabindex="-1">👁</button>
                    </div>
                </div>

                <button type="submit" class="form-submit" style="width: 100%; justify-content: center; padding: 14px; background: #006c4a; color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 14px; cursor: pointer; transition: background 0.2s;">
                    <span>Enregistrer le nouveau mot de passe</span>
                </button>
            </form>

            <div style="text-align: center; margin-top: 24px; padding-top: 16px; border-top: 1px solid #f1f5f9;">
                <a href="{{ route('admin.login') }}" style="font-size: 13px; font-weight: 600; color: #006c4a; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                    ← Revenir à la page de connexion
                </a>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            if (!input) return;
            if (input.type === 'password') {
                input.type = 'text';
                btn.textContent = '🙈';
            } else {
                input.type = 'password';
                btn.textContent = '👁';
            }
        }
    </script>
</body>
</html>

