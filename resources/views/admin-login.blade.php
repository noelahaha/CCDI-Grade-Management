<x-layout>

    <style>

        /* ========================================
           LOGIN PAGE
        ======================================== */

        .login-wrapper {
            min-height: calc(100vh - 110px);

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 30px 20px;
        }


        /* ========================================
           LOGIN CARD
        ======================================== */

        .login-card {
            width: 100%;
            max-width: 430px;

            padding: 40px 38px;

            background-color: var(--card-bg);

            border:
                1px solid var(--header-border);

            border-radius: 20px;

            box-shadow:
                0 10px 35px rgba(0, 0, 0, 0.10);

            text-align: center;

            animation:
                loginAppear 0.5s ease;
        }


        @keyframes loginAppear {

            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }

        }


        /* ========================================
           LOGO
        ======================================== */

        .login-logo {
            width: 90px;
            height: 90px;

            margin: 0 auto 18px;

            display: flex;
            align-items: center;
            justify-content: center;

            background-color: var(--button-bg);

            border-radius: 22px;

            transition:
                background-color 0.4s ease,
                transform 0.3s ease;
        }

        .login-logo:hover {
            transform: scale(1.05);
        }

        .login-logo img {
            width: 72px;
            height: 72px;

            object-fit: contain;
        }


        /* ========================================
           LOGIN TITLE
        ======================================== */

        .login-title {
            margin: 0;

            font-size: 26px;
            font-weight: 700;

            color: var(--text-color);
        }

        .login-subtitle {
            margin: 8px 0 30px;

            font-size: 14px;

            color: var(--muted-text);
        }


        /* ========================================
           FORM
        ======================================== */

        .login-form {
            text-align: left;
        }


        .form-group {
            margin-bottom: 20px;
        }


        .form-label {
            display: block;

            margin-bottom: 8px;

            font-size: 14px;
            font-weight: 600;

            color: var(--text-color);
        }


        /* ========================================
           INPUT
        ======================================== */

        .input-wrapper {
            position: relative;
        }

        .login-input {
            width: 100%;

            padding: 13px 14px;

            border:
                1px solid var(--header-border);

            border-radius: 10px;

            background-color: var(--bg-color);

            color: var(--text-color);

            font-size: 14px;

            outline: none;

            transition:
                border-color 0.25s ease,
                box-shadow 0.25s ease,
                background-color 0.4s ease;
        }


        .login-input:focus {

            border-color: var(--accent);

            box-shadow:
                0 0 0 3px
                rgba(37, 99, 235, 0.12);

        }


        .login-input::placeholder {
            color: var(--muted-text);
        }


        /* ========================================
           PASSWORD INPUT
        ======================================== */

        .password-input {
            padding-right: 48px;
        }


        .show-password {
            position: absolute;

            right: 12px;
            top: 50%;

            transform: translateY(-50%);

            border: none;

            background: none;

            color: var(--muted-text);

            cursor: pointer;

            font-size: 18px;

            padding: 5px;

            transition:
                color 0.2s ease,
                transform 0.2s ease;
        }


        .show-password:hover {

            color: var(--accent);

            transform:
                translateY(-50%)
                scale(1.1);

        }


        /* ========================================
           LOGIN BUTTON
        ======================================== */

        .login-button {

            width: 100%;

            margin-top: 8px;

            padding: 14px;

            border: none;

            border-radius: 10px;

            background-color: var(--accent);

            color: white;

            font-size: 15px;
            font-weight: 700;

            cursor: pointer;

            transition:
                transform 0.2s ease,
                opacity 0.2s ease,
                box-shadow 0.2s ease;
        }


        .login-button:hover {

            transform: translateY(-2px);

            opacity: 0.92;

            box-shadow:
                0 6px 15px
                rgba(37, 99, 235, 0.25);

        }


        .login-button:active {
            transform: translateY(0);
        }


        /* ========================================
           ERROR MESSAGE
        ======================================== */

        .login-error {

            margin-top: 20px;

            padding: 12px 14px;

            border-radius: 10px;

            background-color: #fee2e2;

            color: #b91c1c;

            border:
                1px solid #fecaca;

            font-size: 13px;

            text-align: center;

            animation:
                errorAppear 0.3s ease;
        }


        @keyframes errorAppear {

            from {
                opacity: 0;
                transform: translateY(-5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }

        }


        /* ========================================
           DARK MODE ERROR
        ======================================== */

        body.dark-mode .login-error {

            background-color: #3b1d20;

            color: #fca5a5;

            border-color: #64262b;

        }


        /* ========================================
           FOOTER TEXT
        ======================================== */

        .login-footer {

            margin-top: 25px;

            font-size: 12px;

            color: var(--muted-text);

        }


        /* ========================================
           MOBILE
        ======================================== */

        @media (max-width: 500px) {

            .login-wrapper {
                padding: 20px 15px;
            }

            .login-card {
                padding: 30px 22px;
            }

            .login-title {
                font-size: 23px;
            }

        }

    </style>


    <!-- ========================================
         LOGIN WRAPPER
    ======================================== -->

    <div class="login-wrapper">

        <div class="login-card">


            <!-- LOGO -->

            <div class="login-logo">

                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="CCDI Logo"
                >

            </div>


            <!-- TITLE -->

            <h1 class="login-title">
                Admin Login
            </h1>

            <p class="login-subtitle">
                Sign in to access the Grade Management System
            </p>


            <!-- LOGIN FORM -->

            <form
                method="POST"
                action="{{ route('admin.login') }}"
                class="login-form"
            >

                @csrf


                <!-- USERNAME -->

                <div class="form-group">

                    <label
                        class="form-label"
                        for="name"
                    >
                        Username
                    </label>

                    <div class="input-wrapper">

                        <input
                            id="name"
                            type="text"
                            name="name"
                            class="login-input"
                            placeholder="Enter your username"
                            autocomplete="username"
                            required
                        >

                    </div>

                </div>


                <!-- PASSWORD -->

                <div class="form-group">

                    <label
                        class="form-label"
                        for="password"
                    >
                        Password
                    </label>

                    <div class="input-wrapper">

                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="login-input password-input"
                            placeholder="Enter your password"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            class="show-password"
                            onclick="togglePassword()"
                            id="passwordButton"
                            aria-label="Show password"
                        >
                            👁
                        </button>

                    </div>

                </div>


                <!-- LOGIN BUTTON -->

                <button
                    type="submit"
                    class="login-button"
                >
                    Login
                </button>

            </form>


            <!-- ERROR -->

            @if(session('error'))

                <div class="login-error">
                    {{ session('error') }}
                </div>

            @endif


            <!-- FOOTER -->

            <div class="login-footer">
                Computer Communication Development Institute
            </div>

        </div>

    </div>


    <!-- ========================================
         PASSWORD TOGGLE
    ======================================== -->

    <script>

        function togglePassword() {

            const password =
                document.getElementById('password');

            const button =
                document.getElementById('passwordButton');


            if (password.type === 'password') {

                password.type = 'text';

                button.textContent = '🙈';

                button.setAttribute(
                    'aria-label',
                    'Hide password'
                );

            } else {

                password.type = 'password';

                button.textContent = '👁';

                button.setAttribute(
                    'aria-label',
                    'Show password'
                );

            }

        }

    </script>

</x-layout>