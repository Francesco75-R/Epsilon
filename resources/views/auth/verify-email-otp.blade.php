@php 
    $errors = $errors ?? new \Illuminate\Support\ViewErrorBag; 
    $email = $email ?? session('verify_email', 'votre adresse e-mail');
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification de votre e-mail - Epsilon Marketplace</title>

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
        .resend-btn {
            background: none;
            border: none;
            color: #006c4a;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            text-decoration: underline;
            padding: 0;
        }
        .resend-btn:hover {
            color: #0A1128;
        }
    </style>
</head>
<body>

    <div class="auth-page">
        <div class="auth-container">
            <!-- Logo Epsilon -->
            <a href="{{ url('/') }}" class="auth-brand" aria-label="Epsilon Accueil">
                <svg width="38" height="38" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="100" height="100" rx="24" fill="#0A1128" />
                    <path d="M30 35H66C66 37.7614 63.7614 40 61 40H44V49H57C59.7614 49 62 51.2386 62 54C62 56.7614 59.7614 59 57 59H44V68H66C68.7614 68 71 70.2386 71 73C71 75.7614 68.7614 78 66 78H35C31.134 78 28 74.866 28 71V40C28 37.2386 30 35 30 35Z" fill="#FFFFFF" />
                    <circle cx="70" cy="35" r="11" fill="#10B981" />
                    <g transform="translate(52, 47)">
                        <path d="M0 7H15" stroke="#10B981" stroke-width="5" stroke-linecap="round" />
                        <path d="M10 2L15 7L10 12" stroke="#10B981" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
                    </g>
                </svg>
                <div>
                    <div style="font-weight: 800; font-size: 22px; color: #0A1128; line-height: 1;">Epsilon</div>
                    <div style="font-size: 10px; font-weight: 600; color: #10B981; letter-spacing: 2px; text-transform: uppercase;">Marketplace</div>
                </div>
            </a>

            <div class="form-header" style="text-align: center; margin-bottom: 20px;">
                <div style="width: 52px; height: 52px; margin: 0 auto 14px auto; background: #ecfdf5; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #006c4a; font-size: 24px;">
                    ✉
                </div>
                <h2 style="font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">Vérification de l'adresse e-mail</h2>
                <p style="font-size: 13.5px; color: #64748b; line-height: 1.5; margin: 0;">
                    Un code de validation à <strong>6 chiffres</strong> a été envoyé à l'adresse suivante :<br>
                    <span style="display: inline-block; margin-top: 4px; font-weight: 700; color: #006c4a; background: #f0fdf4; padding: 4px 10px; border-radius: 8px;">{{ $email }}</span>
                </p>
            </div>

            @if (session('status'))
                <div class="status-alert">
                    <span>✓</span>
                    <div>{{ session('status') }}</div>
                </div>
            @endif

            @if (session('success'))
                <div class="status-alert">
                    <span>✓</span>
                    <div>{{ session('success') }}</div>
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

            <form action="{{ route('verification.otp.submit') }}" method="POST" id="otp-form">
                @csrf
                <input type="hidden" name="code" id="otp-code-hidden">

                <div class="otp-inputs" id="otp-container">
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-digit" data-index="0" autofocus>
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-digit" data-index="1">
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-digit" data-index="2">
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-digit" data-index="3">
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-digit" data-index="4">
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-digit" data-index="5">
                </div>

                <button type="submit" id="btn-submit-otp" class="form-submit" style="width: 100%; justify-content: center; padding: 14px; background: #006c4a; color: white; border: none; border-radius: 14px; font-weight: 700; font-size: 15px; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 12px rgba(0,108,74,0.25);">
                    Confirmer et Activer mon compte
                </button>
            </form>

            <div style="text-align: center; margin-top: 24px; padding-top: 18px; border-top: 1px solid #f1f5f9; display: flex; flex-direction: column; gap: 10px;">
                <form action="{{ route('verification.otp.resend') }}" method="POST">
                    @csrf
                    <span style="font-size: 13px; color: #64748b;">Vous n'avez rien reçu ?</span>
                    <button type="submit" class="resend-btn">Renvoyer un code à 6 chiffres</button>
                </form>

                <a href="{{ route('login') }}" style="font-size: 13px; font-weight: 600; color: #64748b; text-decoration: none; margin-top: 6px;">
                    ← Revenir à l'écran de connexion
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const inputs = document.querySelectorAll('.otp-digit');
            const hiddenCode = document.getElementById('otp-code-hidden');
            const form = document.getElementById('otp-form');

            function updateHidden() {
                let code = '';
                inputs.forEach(input => {
                    code += input.value.trim();
                    if (input.value.trim().length > 0) {
                        input.classList.add('filled');
                    } else {
                        input.classList.remove('filled');
                    }
                });
                hiddenCode.value = code;
                return code;
            }

            inputs.forEach((input, index) => {
                input.addEventListener('input', function (e) {
                    const val = e.target.value.replace(/[^0-9]/g, '');
                    e.target.value = val ? val[0] : '';
                    updateHidden();

                    if (val && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }

                    if (updateHidden().length === 6) {
                        // All 6 digits filled, can auto-submit or leave user click
                    }
                });

                input.addEventListener('keydown', function (e) {
                    if (e.key === 'Backspace' && !input.value && index > 0) {
                        inputs[index - 1].focus();
                    }
                });

                input.addEventListener('paste', function (e) {
                    e.preventDefault();
                    const pastedData = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '');
                    if (pastedData) {
                        for (let i = 0; i < inputs.length; i++) {
                            inputs[i].value = pastedData[i] || '';
                        }
                        updateHidden();
                        const nextFocus = Math.min(pastedData.length, inputs.length - 1);
                        inputs[nextFocus].focus();
                    }
                });
            });

            form.addEventListener('submit', function (e) {
                const code = updateHidden();
                if (code.length !== 6) {
                    e.preventDefault();
                    alert('Veuillez saisir les 6 chiffres du code de vérification.');
                    inputs[0].focus();
                }
            });
        });
    </script>
</body>
</html>
