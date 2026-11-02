
<x-layout>

    <div class="combined-login-page">

        <div class="combined-login-card">

            <!-- LOGO -->

            <div class="combined-login-logo">
                <img src="{{ asset('images/logo.png') }}" alt="CCDI Logo">
            </div>

            <!-- TITLE -->

            <h1 class="combined-login-title">
                Grade Management System
            </h1>

            <p class="combined-login-subtitle">
                Sign in to continue
            </p>


            <!-- TABS -->

            <div class="login-tabs">

                <button type="button"
                        class="login-tab {{ request('tab', 'student') === 'student' ? 'active' : '' }}"
                        id="studentTab"
                        onclick="showLoginTab('student')">
                    Student
                </button>

                <button type="button"
                        class="login-tab {{ request('tab') === 'registrar' ? 'active' : '' }}"
                        id="registrarTab"
                        onclick="showLoginTab('registrar')">
                    Registrar
                </button>

            </div>


            <!-- STUDENT LOGIN -->

            <div class="login-panel"
                 id="studentPanel"
                 style="{{ request('tab', 'student') === 'student' ? '' : 'display: none;' }}">

                <h2 class="login-panel-title">
                    Student Information
                </h2>

                <p class="login-panel-description">
                    Enter your name and student ID number.
                </p>

                <form method="POST"
                      action="{{ route('student-info.store') }}?tab=student">

                    @csrf

                    <div class="login-form-group">

                        <label for="studentName">
                            Full Name
                        </label>

                        <input type="text"
                               id="studentName"
                               name="name"
                               placeholder="Enter your full name"
                               autocomplete="name"
                               required>

                    </div>


                    <div class="login-form-group">

                        <label for="studentId">
                            Student ID Number
                        </label>

                        <input type="text"
                               id="studentId"
                               name="id_number"
                               placeholder="2020-00-000"
                               autocomplete="off"
                               required>

                    </div>


                    @if (request('tab', 'student') === 'student' && session('error'))
                        <div class="login-message error">
                            {{ session('error') }}
                        </div>
                    @endif


                    <button type="submit" class="combined-login-button">
                        Continue
                    </button>

                </form>

            </div>


            <!-- REGISTRAR LOGIN -->

            <div class="login-panel"
                 id="registrarPanel"
                 style="{{ request('tab') === 'registrar' ? '' : 'display: none;' }}">

                <h2 class="login-panel-title">
                    Registrar Login
                </h2>

                <p class="login-panel-description">
                    Sign in to access the administration dashboard.
                </p>

                <form method="POST"
                      action="{{ route('admin.login') }}?tab=registrar">

                    @csrf

                    <div class="login-form-group">

                        <label for="registrarUsername">
                            Username
                        </label>

                        <input type="text"
                               id="registrarUsername"
                               name="name"
                               placeholder="Enter your username"
                               autocomplete="username"
                               required>

                    </div>


                    <div class="login-form-group">

                        <label for="registrarPassword">
                            Password
                        </label>

                        <div class="password-wrapper">

                            <input type="password"
                                   id="registrarPassword"
                                   name="password"
                                   placeholder="Enter your password"
                                   autocomplete="current-password"
                                   required>

                            <button type="button"
                                    class="show-password"
                                    onclick="toggleRegistrarPassword()"
                                    id="passwordButton"
                                    aria-label="Show password">
                                👁
                            </button>

                        </div>

                    </div>


                    @if (request('tab') === 'registrar' && session('error'))
                        <div class="login-message error">
                            {{ session('error') }}
                        </div>
                    @endif


                    <button type="submit" class="combined-login-button">
                        Login
                    </button>

                </form>

            </div>


            <!-- FOOTER -->

            <div class="combined-login-footer">
                Computer Communication Development Institute
            </div>

        </div>

    </div>


    <!-- JAVASCRIPT -->

    <script>

        // SWITCH LOGIN TABS

        function showLoginTab(tab) {

            const studentPanel = document.getElementById('studentPanel');
            const registrarPanel = document.getElementById('registrarPanel');

            const studentTab = document.getElementById('studentTab');
            const registrarTab = document.getElementById('registrarTab');

            studentPanel.style.display = 'none';
            registrarPanel.style.display = 'none';

            studentTab.classList.remove('active');
            registrarTab.classList.remove('active');

            if (tab === 'student') {

                studentPanel.style.display = 'block';
                studentTab.classList.add('active');

            } else {

                registrarPanel.style.display = 'block';
                registrarTab.classList.add('active');

            }

        }


        // SHOW / HIDE REGISTRAR PASSWORD

        function toggleRegistrarPassword() {

            const password = document.getElementById('registrarPassword');
            const button = document.getElementById('passwordButton');

            if (password.type === 'password') {

                password.type = 'text';
                button.textContent = '🙈';

                button.setAttribute('aria-label', 'Hide password');

            } else {

                password.type = 'password';
                button.textContent = '👁';

                button.setAttribute('aria-label', 'Show password');

            }

        }

    </script>

</x-layout>
