<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Welcome Back</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background: linear-gradient(135deg, #FAF9EE, #F5EFE6);
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            opacity: 0.03;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
            pointer-events: none;
        }

        .login-card {
            width: 100%;
            max-width: 28rem;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(162, 175, 155, 0.3);
            border-radius: 0.75rem;
            box-shadow: 0 10px 30px rgba(87, 95, 82, 0.15);
            animation: fadeIn 0.6s ease-out forwards;
            position: relative;
            z-index: 10;
        }

        .card-header {
            padding: 2rem 2rem 1.5rem;
            text-align: center;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .logo {
            width: 4rem;
            height: 4rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #A2AF9B, #8FA088);
        }

        .logo i {
            font-size: 2rem;
            color: white;
        }

        .card-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.875rem;
            font-weight: 700;
            color: #3D4538;
            margin-bottom: 0.5rem;
        }

        .card-description {
            font-size: 1rem;
            color: #6B7566;
        }

        .card-content {
            padding: 0 2rem 2rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
            animation: slideIn 0.5s ease-out forwards;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #8A9484;
            width: 1.25rem;
            height: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .form-input {
            width: 100%;
            height: 3rem;
            padding: 0.75rem 0.75rem 0.75rem 2.75rem;
            font-size: 1rem;
            border: 2px solid #D4DED0;
            border-radius: 0.5rem;
            background: white;
            outline: none;
        }

        .form-input:focus {
            border-color: #A2AF9B;
            box-shadow: 0 4px 12px rgba(162, 175, 155, 0.15);
        }

        .toggle-password {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #8A9484;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
        }

        .toggle-password .fa-eye,
        .toggle-password .fa-eye-slash {
            font-size: 1.25rem;
        }

        .submit-button {
            width: 100%;
            height: 3rem;
            font-size: 1rem;
            font-weight: 600;
            color: white;
            background: linear-gradient(135deg, #A2AF9B, #8FA088);
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(162, 175, 155, 0.2);
            transition: 0.3s ease;
            margin-top: 0.5rem;
        }

        .submit-button:hover {
            transform: translateY(-2px);
        }

        .loading { display: inline-flex; gap: 0.5rem; }

        .spinner {
            width: 1rem;
            height: 1rem;
            border: 2px solid white;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .error-message,
        .success-message {
            display: none;
            padding: 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .error-message {
            background: #FEE2E2;
            border: 1px solid #FCA5A5;
            color: #991B1B;
        }

        .success-message {
            background: #D1FAE5;
            border: 1px solid #6EE7B7;
            color: #065F46;
        }

        .error-message.show,
        .success-message.show {
            display: block;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="card-header">
            <div class="logo-container">
                <div class="logo">
                    <i class="fa-solid fa-utensils"></i>
                </div>
            </div>

            <h1 class="card-title">Welcome to Restoran App</h1>
            <p class="card-description">Sign in to continue to your account</p>
        </div>

        <div class="card-content">

            <div id="errorMessage" class="error-message"></div>
            <div id="successMessage" class="success-message"></div>

            <form id="loginForm" action="{{ route('auth.login') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Username</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <i class="fa-solid fa-user"></i>
                        </span>
                        <input type="text" name="username" class="form-input"
                               placeholder="Enter your username"
                               value="{{ old('username') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" id="password" name="password" class="form-input"
                               placeholder="Enter your password" required>

                        <button type="button" id="togglePassword" class="toggle-password">
                            <i id="eyeIcon" class="fa-solid fa-eye"></i>
                            <i id="eyeOffIcon" class="fa-solid fa-eye-slash" style="display:none;"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="submit-button" id="submitButton">
                    <span id="buttonText">Sign In</span>
                    <span id="buttonLoading" class="loading" style="display:none;">
                        <span class="spinner"></span>
                        <span>Signing in...</span>
                    </span>
                </button>
            </form>
        </div>
    </div>

    <script>
        const togglePassword = document.getElementById("togglePassword");
        const passwordInput = document.getElementById("password");
        const eyeIcon = document.getElementById("eyeIcon");
        const eyeOffIcon = document.getElementById("eyeOffIcon");

        togglePassword.addEventListener("click", () => {
            const type = passwordInput.type === "password" ? "text" : "password";
            passwordInput.type = type;

            eyeIcon.style.display = type === "text" ? "none" : "inline";
            eyeOffIcon.style.display = type === "text" ? "inline" : "none";
        });

        const loginForm = document.getElementById("loginForm");
        const submitButton = document.getElementById("submitButton");
        const buttonText = document.getElementById("buttonText");
        const buttonLoading = document.getElementById("buttonLoading");
        const errorMessage = document.getElementById("errorMessage");
        const successMessage = document.getElementById("successMessage");

        loginForm.addEventListener("submit", (e) => {
            errorMessage.classList.remove("show");
            successMessage.classList.remove("show");

            const username = loginForm.username.value.trim();
            const password = loginForm.password.value.trim();

            if (!username || !password) {
                e.preventDefault();
                errorMessage.textContent = "Please fill in all fields.";
                errorMessage.classList.add("show");
                return;
            }

            submitButton.disabled = true;
            buttonText.style.display = "none";
            buttonLoading.style.display = "inline-flex";
        });

        @if ($errors->any())
            errorMessage.textContent = "{{ $errors->first() }}";
            errorMessage.classList.add("show");
        @endif

        @if (session('success'))
            successMessage.textContent = "{{ session('success') }}";
            successMessage.classList.add("show");
        @endif

        @if (session('error'))
            errorMessage.textContent = "{{ session('error') }}";
            errorMessage.classList.add("show");
        @endif
    </script>

</body>
</html>
