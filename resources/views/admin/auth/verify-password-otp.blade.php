@php 
    $errors = $errors ?? new \Illuminate\Support\ViewErrorBag; 
    $email = $email ?? session('admin_reset_password_email', 'votre adresse e-mail administrateur');
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validation du code OTP Administrateur - Epsilon</title>

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
        .otp-inputs {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 24px 0;
        }
        .otp-digit {
            width: 52px;
            height: 60px;
            font-size: 24px;
            font-weight: 700;
            text-align: center;
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            background: #f8fafc;
            color: #0A1128;
            outline: none;
            transition: all 0.2s ease;
        }
        .otp-digit:focus {
            border-color: #006c4a;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(0, 108, 74, 0.12);
        }
        .otp-digit.filled {
            border-color: #006c4a;
            background: #f0fdf4;
            color: #006c4a;
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

            <!-- Progress Step -->
            <div style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 24px;">
                <span style="padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; background: #dcfce7; color: #166534;">1. E-mail ✓</span>
                <span style="color:#cbd5e1;">→</span>
                <span style="padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; background: #006c4a; color: #ffffff;">2. Code OTP</span>
                <span style="color:#cbd5e1;">→</span>
                <span style="padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; background: #f1f5f9; color: #94a3b8;">3. Nouveau mot de passe</span>
            </div>

            <div class="form-header" style="text-align: center; margin-bottom: 20px;">
                <div class="admin-badge">🔒 Sécurité Administrateur</div>
                <h2 style="font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 6px;">Vérification de sécurité</h2>
                <p style="font-size: 13px; color: #64748b; line-height: 1.5;">
                    Saisissez le code à 6 chiffres envoyé à <br><strong style="color: #0A1128;">{{ $email }}</strong>
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

            <form id="otp-form" action="{{ route('admin.password.otp.verify') }}" method="POST">
                @csrf

                <!-- 6 Cases OTP pour saisie ultra-fluide -->
                <div class="otp-inputs">
                    <input type="text" maxlength="1" class="otp-digit" name="digit1" id="d1" inputmode="numeric" pattern="[0-9]" autocomplete="one-time-code" autofocus required>
                    <input type="text" maxlength="1" class="otp-digit" name="digit2" id="d2" inputmode="numeric" pattern="[0-9]" required>
                    <input type="text" maxlength="1" class="otp-digit" name="digit3" id="d3" inputmode="numeric" pattern="[0-9]" required>
                    <input type="text" maxlength="1" class="otp-digit" name="digit4" id="d4" inputmode="numeric" pattern="[0-9]" required>
                    <input type="text" maxlength="1" class="otp-digit" name="digit5" id="d5" inputmode="numeric" pattern="[0-9]" required>
                    <input type="text" maxlength="1" class="otp-digit" name="digit6" id="d6" inputmode="numeric" pattern="[0-9]" required>
                </div>

                <input type="hidden" name="code" id="hidden-code">

                <button type="submit" class="form-submit" style="width: 100%; justify-content: center; padding: 14px; background: #006c4a; color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 14px; cursor: pointer; transition: background 0.2s;">
                    <span>Valider le code</span>
                </button>
            </form>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 24px; padding-top: 16px; border-top: 1px solid #f1f5f9; font-size: 13px;">
                <a href="{{ route('admin.password.request') }}" style="color: #64748b; text-decoration: none; font-weight: 500;">
                    ← Modifier l'e-mail
                </a>

                <form action="{{ route('admin.password.otp.resend') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" style="background: none; border: none; padding: 0; color: #006c4a; font-weight: 700; cursor: pointer; font-size: 13px;">
                        Renvoyer un code
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const digits = document.querySelectorAll('.otp-digit');
        const hiddenCode = document.getElementById('hidden-code');
        const form = document.getElementById('otp-form');

        function updateCode() {
            let full = '';
            digits.forEach(d => {
                full += d.value;
                if (d.value) {
                    d.classList.add('filled');
                } else {
                    d.classList.remove('filled');
                }
            });
            hiddenCode.value = full;
            return full;
        }

        digits.forEach((digit, index) => {
            digit.addEventListener('input', (e) => {
                const val = e.target.value.replace(/[^0-9]/g, '');
                e.target.value = val ? val[0] : '';
                updateCode();

                if (e.target.value && index < digits.length - 1) {
                    digits[index + 1].focus();
                }

                if (updateCode().length === 6) {
                    setTimeout(() => form.submit(), 150);
                }
            });

            digit.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !e.target.value && index > 0) {
                    digits[index - 1].focus();
                }
            });

            digit.addEventListener('paste', (e) => {
                e.preventDefault();
                const paste = (e.clipboardData || window.clipboardData).getData('text').trim().replace(/[^0-9]/g, '');
                if (paste.length >= 6) {
                    for (let i = 0; i < 6; i++) {
                        digits[i].value = paste[i];
                    }
                    updateCode();
                    digits[5].focus();
                    setTimeout(() => form.submit(), 150);
                }
            });
        });
    </script>
</body>
</html>

