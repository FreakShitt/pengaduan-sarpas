<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — Facility Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #1a1a1a;
            --secondary: #2d2d2d;
            --accent: #c5975f;
            --text-primary: #1a1a1a;
            --text-secondary: #666666;
            --border: #e8e8e8;
            --bg-light: #fafafa;
            --shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            --shadow-hover: 0 12px 32px rgba(0, 0, 0, 0.12);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            color: var(--text-primary);
            line-height: 1.6;
            letter-spacing: -0.01em;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow);
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Left Panel - Hero */
        .hero-panel {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .hero-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(197, 151, 95, 0.1) 0%, transparent 70%);
            animation: pulse 15s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.3; }
            50% { transform: scale(1.1); opacity: 0.5; }
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 3rem;
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo::before {
            content: '';
            width: 48px;
            height: 48px;
            background: var(--accent);
            border-radius: 8px;
            display: inline-block;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.75rem;
            font-weight: 600;
            color: white;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            letter-spacing: -0.03em;
        }

        .hero-subtitle {
            font-size: 1.125rem;
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.6;
            font-weight: 300;
            letter-spacing: 0.01em;
        }

        .hero-footer {
            position: relative;
            z-index: 1;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.875rem;
            font-weight: 400;
        }

        /* Right Panel - Form */
        .form-panel {
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            margin-bottom: 3rem;
        }

        .form-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .form-header p {
            color: var(--text-secondary);
            font-size: 0.9375rem;
            font-weight: 400;
        }

        .form-group {
            margin-bottom: 1.75rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.625rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-primary);
            letter-spacing: 0.01em;
            text-transform: uppercase;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-size: 0.9375rem;
            font-family: 'Inter', sans-serif;
            background: var(--bg-light);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            letter-spacing: 0.01em;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent);
            background: white;
            box-shadow: 0 0 0 4px rgba(197, 151, 95, 0.08);
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-secondary);
            transition: color 0.3s;
            padding: 0.5rem;
        }

        .password-toggle:hover {
            color: var(--text-primary);
        }

        .error-message {
            display: none;
            color: #d32f2f;
            font-size: 0.8125rem;
            margin-top: 0.5rem;
            font-weight: 400;
        }

        .error-message.show {
            display: block;
        }

        .login-btn {
            width: 100%;
            padding: 1rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 0.9375rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-top: 1rem;
        }

        .login-btn:hover {
            background: var(--secondary);
            box-shadow: var(--shadow-hover);
            transform: translateY(-2px);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .divider {
            text-align: center;
            margin: 2rem 0;
            position: relative;
            color: var(--text-secondary);
            font-size: 0.8125rem;
            font-weight: 400;
        }

        .divider::before,
        .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 45%;
            height: 1px;
            background: var(--border);
        }

        .divider::before { left: 0; }
        .divider::after { right: 0; }

        .register-link {
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.9375rem;
        }

        .register-link a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
            border-bottom: 1px solid transparent;
        }

        .register-link a:hover {
            color: var(--primary);
            border-bottom-color: var(--primary);
        }

        @media (max-width: 968px) {
            .container {
                grid-template-columns: 1fr;
            }

            .hero-panel {
                padding: 3rem 2rem;
                min-height: 300px;
            }

            .hero-title {
                font-size: 2rem;
            }

            .form-panel {
                padding: 3rem 2rem;
            }
        }

        /* Microinteractions */
        .form-control:not(:placeholder-shown) {
            background: white;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-8px); }
            75% { transform: translateX(8px); }
        }

        .error-shake {
            animation: shake 0.4s ease-in-out;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Hero Panel -->
        <div class="hero-panel">
            <div class="hero-content">
                <div class="logo">
                    SARPAS
                </div>
                <h1 class="hero-title">
                    Facility Management<br>Excellence
                </h1>
                <p class="hero-subtitle">
                    A sophisticated platform for infrastructure oversight and maintenance coordination. Streamline reporting, enhance accountability, deliver results.
                </p>
            </div>
            <div class="hero-footer">
                © 2025 Facility Management System. All rights reserved.
            </div>
        </div>

        <!-- Form Panel -->
        <div class="form-panel">
            <div class="form-header">
                <h2>Welcome Back</h2>
                <p>Please enter your credentials to continue</p>
            </div>

            @if ($errors->any())
                <div style="padding: 1rem; background: #ffebee; border-left: 3px solid #d32f2f; border-radius: 6px; margin-bottom: 2rem;">
                    <div style="color: #d32f2f; font-size: 0.875rem; font-weight: 500;">
                        {{ $errors->first() }}
                    </div>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-wrapper">
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            class="form-control" 
                            placeholder="Enter your username"
                            value="{{ old('username') }}"
                            required
                            autocomplete="username"
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-control" 
                            placeholder="Enter your password"
                            required
                            autocomplete="current-password"
                        >
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <svg id="eye-icon" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="login-btn">
                    Sign In
                </button>
            </form>

            <div class="divider">or</div>

            <div class="register-link">
                Don't have an account? <a href="{{ route('register') }}">Create Account</a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
            }
        }

        // Add smooth focus transition
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.01)';
            });
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>
