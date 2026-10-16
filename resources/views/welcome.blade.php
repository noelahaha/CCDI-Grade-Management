<x-layout>

    <style>

        /* ========================================
           STUDENT INFORMATION PAGE
        ======================================== */

        .student-page {
            min-height: calc(100vh - 110px);

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 30px 20px;
        }


        /* ========================================
           STUDENT CARD
        ======================================== */

        .student-card {
            width: 100%;
            max-width: 480px;

            padding: 40px;

            background-color: var(--card-bg);

            border:
                1px solid var(--header-border);

            border-radius: 20px;

            box-shadow: var(--shadow);

            animation:
                studentAppear 0.5s ease;
        }


        @keyframes studentAppear {

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
           ICON
        ======================================== */

        .student-icon {
            width: 80px;
            height: 80px;

            margin: 0 auto 20px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 22px;

            background-color: var(--button-bg);

            font-size: 40px;

            transition:
                background-color 0.4s ease,
                transform 0.3s ease;
        }

        .student-icon:hover {
            transform: scale(1.06);
        }


        /* ========================================
           TITLE
        ======================================== */

        .student-title {
            margin: 0;

            text-align: center;

            font-size: 26px;

            font-weight: 700;

            color: var(--text-color);
        }


        .student-subtitle {
            margin: 8px auto 28px;

            max-width: 360px;

            text-align: center;

            font-size: 14px;

            line-height: 1.5;

            color: var(--muted-text);
        }


        /* ========================================
           FORM
        ======================================== */

        .student-form {
            display: flex;

            flex-direction: column;

            gap: 19px;
        }


        .form-group {
            display: flex;

            flex-direction: column;

            gap: 7px;
        }


        .form-label {
            font-size: 14px;

            font-weight: 600;

            color: var(--text-color);
        }


        /* ========================================
           INPUT
        ======================================== */

        .student-input {
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


        .student-input:focus {

            border-color: var(--accent);

            box-shadow:
                0 0 0 3px
                rgba(37, 99, 235, 0.10);

        }


        .student-input::placeholder {
            color: var(--muted-text);
        }


        /* ========================================
           SUBMIT BUTTON
        ======================================== */

        .student-submit {

            width: 100%;

            padding: 14px;

            margin-top: 3px;

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


        .student-submit:hover {

            transform: translateY(-2px);

            opacity: 0.92;

            box-shadow:
                0 7px 16px
                rgba(37, 99, 235, 0.25);

        }


        .student-submit:active {
            transform: translateY(0);
        }


        /* ========================================
           ADMIN LINK
        ======================================== */

        .admin-link-container {

            margin-top: 25px;

            padding-top: 20px;

            border-top:
                1px solid var(--header-border);

            text-align: center;
        }


        .admin-link {

            color: var(--accent);

            font-size: 13px;

            font-weight: 600;

            text-decoration: none;

            transition:
                opacity 0.2s ease;
        }


        .admin-link:hover {
            opacity: 0.75;
            text-decoration: underline;
        }


        /* ========================================
           MOBILE
        ======================================== */

        @media (max-width: 500px) {

            .student-page {
                padding: 20px 15px;
            }

            .student-card {
                padding: 30px 22px;
            }

            .student-title {
                font-size: 23px;
            }

        }

    </style>


    <!-- ========================================
         STUDENT PAGE
    ======================================== -->

    <div class="student-page">

        <div class="student-card">


            <!-- ICON -->

            <div class="student-icon">
                🎓
            </div>


            <!-- TITLE -->

            <h1 class="student-title">
                Student Information
            </h1>


            <p class="student-subtitle">
                Enter your name and student ID number
                to access the Grade Management System.
            </p>


            <!-- FORM -->

            <form
                method="POST"
                action="{{ route('student-info.store') }}"
                class="student-form"
            >

                @csrf


                <!-- NAME -->

                <div class="form-group">

                    <label
                        for="name"
                        class="form-label"
                    >
                        Full Name
                    </label>

                    <input
                        id="name"
                        type="text"
                        name="name"
                        class="student-input"
                        placeholder="Enter your full name"
                        autocomplete="name"
                        required
                    >

                </div>


                <!-- ID NUMBER -->

                <div class="form-group">

                    <label
                        for="id_number"
                        class="form-label"
                    >
                        Student ID Number
                    </label>

                    <input
                        id="id_number"
                        type="text"
                        name="id_number"
                        class="student-input"
                        placeholder="2020-00-000"
                        autocomplete="off"
                        required
                    >

                </div>


                <!-- SUBMIT -->

                <button
                    type="submit"
                    class="student-submit"
                >
                    Continue
                </button>

            </form>


            <!-- ADMIN LINK -->

            <div class="admin-link-container">

                <a
                    href="{{ route('admin-login') }}"
                    class="admin-link"
                >
                    Admin Login
                </a>

            </div>

        </div>

    </div>

</x-layout>