{{-- <x-layout>

    


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

</x-layout> --}}