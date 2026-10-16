<x-layout>

    <style>

        /* ========================================
           GRADE REQUEST PAGE
        ======================================== */

        .request-page {
            min-height: calc(100vh - 110px);

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 30px 20px;
        }


        /* ========================================
           REQUEST CARD
        ======================================== */

        .request-card {
            width: 100%;
            max-width: 520px;

            padding: 40px;

            background-color: var(--card-bg);

            border:
                1px solid var(--header-border);

            border-radius: 20px;

            box-shadow: var(--shadow);

            text-align: center;

            animation:
                requestAppear 0.5s ease;
        }


        @keyframes requestAppear {

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

        .request-icon {
            width: 85px;
            height: 85px;

            margin: 0 auto 20px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 22px;

            background-color: var(--button-bg);

            font-size: 42px;

            transition:
                background-color 0.4s ease,
                transform 0.3s ease;
        }

        .request-icon:hover {
            transform: scale(1.06) rotate(-3deg);
        }


        /* ========================================
           TITLE
        ======================================== */

        .request-title {
            margin: 0;

            font-size: 26px;

            font-weight: 700;

            color: var(--text-color);
        }


        .request-description {
            margin: 10px auto 28px;

            max-width: 400px;

            color: var(--muted-text);

            font-size: 14px;

            line-height: 1.6;
        }


        /* ========================================
           REQUEST BUTTON
        ======================================== */

        .request-button {

            width: 100%;

            padding: 14px 20px;

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


        .request-button:hover {

            transform: translateY(-2px);

            opacity: 0.92;

            box-shadow:
                0 7px 16px
                rgba(37, 99, 235, 0.25);

        }


        .request-button:active {
            transform: translateY(0);
        }


        /* ========================================
           INFORMATION
        ======================================== */

        .request-info {

            margin-top: 22px;

            padding: 13px 15px;

            border-radius: 10px;

            background-color: var(--button-bg);

            color: var(--muted-text);

            font-size: 12px;

            line-height: 1.5;

        }


        /* ========================================
           MOBILE
        ======================================== */

        @media (max-width: 500px) {

            .request-page {
                padding: 20px 15px;
            }

            .request-card {
                padding: 30px 22px;
            }

            .request-title {
                font-size: 23px;
            }

        }

    </style>


    <!-- ========================================
         REQUEST PAGE
    ======================================== -->

    <div class="request-page">

        <div class="request-card">


            <!-- ICON -->

            <div class="request-icon">
                📄
            </div>


            <!-- TITLE -->

            <h1 class="request-title">
                Request Your Grades
            </h1>


            <!-- DESCRIPTION -->

            <p class="request-description">
                Need a printed copy of your grades?
                Submit a request below and the administrator
                will process your request.
            </p>


            <!-- FORM -->

            <form
                method="POST"
                action="{{ route('grade-request.store') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="request-button"
                >
                    Request Printed Copy
                </button>

            </form>


            <!-- INFORMATION -->

            <div class="request-info">
                Your request will be sent to the
                Grade Management System administrator.
            </div>

        </div>

    </div>

</x-layout>