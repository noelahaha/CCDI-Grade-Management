<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Grade Manager</title>

    <style>

        /* ========================================
           THEME COLORS
        ======================================== */

        :root {
            --bg-color: #f5f7fb;
            --text-color: #222222;
            --muted-text: #6b7280;

            --header-bg: #ffffff;
            --header-border: #e5e7eb;

            --card-bg: #ffffff;

            --button-bg: #f1f3f5;
            --button-hover: #e2e5e9;

            --shadow:
                0 4px 20px rgba(0, 0, 0, 0.08);

            --accent: #2563eb;
        }


        /* ========================================
           DARK MODE COLORS
        ======================================== */

        body.dark-mode {

            --bg-color: #101114;
            --text-color: #f5f5f5;
            --muted-text: #a1a1aa;

            --header-bg: #18191d;
            --header-border: #2b2d33;

            --card-bg: #1b1d22;

            --button-bg: #292c32;
            --button-hover: #353941;

            --shadow:
                0 4px 20px rgba(0, 0, 0, 0.35);

            --accent: #60a5fa;
        }


        /* ========================================
           BODY
        ======================================== */

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;

            background-color: var(--bg-color);
            color: var(--text-color);

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            transition:
                background-color 0.4s ease,
                color 0.4s ease;
        }


        /* ========================================
           HEADER
        ======================================== */

        header {
            width: 100%;

            display: flex;
            align-items: center;

            padding: 14px 28px;

            background-color: var(--header-bg);

            border-bottom:
                1px solid var(--header-border);

            box-shadow: var(--shadow);

            transition:
                background-color 0.4s ease,
                border-color 0.4s ease,
                box-shadow 0.4s ease;

            position: relative;
            z-index: 100;
        }


        /* ========================================
           LOGO
        ======================================== */

        .logo-container {
            width: 68px;
            height: 68px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border-radius: 16px;

            background-color: var(--button-bg);

            transition:
                background-color 0.4s ease,
                transform 0.3s ease;
        }

        .logo-container:hover {
            transform: scale(1.04);
        }

        .logo-container img {
            width: 55px;
            height: 55px;

            object-fit: contain;
        }


        /* ========================================
           HEADER TEXT
        ======================================== */

        .header-content {
            margin-left: 16px;

            display: flex;
            flex-direction: column;

            line-height: 1.2;
        }

        .school-name {
            font-size: 19px;
            font-weight: 700;

            color: var(--text-color);

            letter-spacing: 0.2px;
        }

        .system-name {
            margin-top: 5px;

            font-size: 13px;
            font-weight: 600;

            color: var(--accent);

            letter-spacing: 1px;
        }


        /* ========================================
           THEME BUTTON
        ======================================== */

        .theme-button {
            margin-left: auto;

            width: 48px;
            height: 48px;

            border: 1px solid var(--header-border);

            border-radius: 50%;

            background-color: var(--button-bg);
            color: var(--text-color);

            cursor: pointer;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 23px;

            overflow: hidden;

            transition:
                background-color 0.3s ease,
                border-color 0.3s ease,
                transform 0.3s ease,
                box-shadow 0.3s ease;
        }

        .theme-button:hover {

            background-color: var(--button-hover);

            transform:
                scale(1.08)
                rotate(8deg);

            box-shadow:
                0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .theme-button:active {
            transform: scale(0.90);
        }


        /* ========================================
           SUN / MOON ANIMATION
        ======================================== */

        #themeIcon {
            display: inline-block;

            transition:
                transform 0.5s ease,
                opacity 0.3s ease;
        }

        .rotate-icon {

            transform:
                rotate(360deg)
                scale(1.25);

        }


        /* ========================================
           MAIN CONTENT
        ======================================== */

        main {
            width: 100%;
            max-width: 1400px;

            margin: 0 auto;

            padding: 30px;
        }


        /* ========================================
           COMMON CARD STYLE
           
           You can use class="card"
           in your other Blade pages.
        ======================================== */

        .card {
            background-color: var(--card-bg);

            border:
                1px solid var(--header-border);

            border-radius: 16px;

            padding: 24px;

            box-shadow: var(--shadow);

            transition:
                background-color 0.4s ease,
                border-color 0.4s ease,
                box-shadow 0.4s ease;
        }


        /* ========================================
           BUTTON STYLE
           
           You can use class="ui-button"
           for buttons in other pages.
        ======================================== */

        .ui-button {

            border: none;

            border-radius: 10px;

            padding: 10px 18px;

            background-color: var(--accent);

            color: white;

            font-size: 14px;
            font-weight: 600;

            cursor: pointer;

            transition:
                transform 0.2s ease,
                opacity 0.2s ease;
        }

        .ui-button:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }


        /* ========================================
           RESPONSIVE DESIGN
        ======================================== */

        @media (max-width: 600px) {

            header {
                padding: 12px 16px;
            }

            .logo-container {
                width: 55px;
                height: 55px;
            }

            .logo-container img {
                width: 45px;
                height: 45px;
            }

            .header-content {
                margin-left: 12px;
            }

            .school-name {
                font-size: 15px;
            }

            .system-name {
                font-size: 10px;
                letter-spacing: 0.6px;
            }

            .theme-button {
                width: 42px;
                height: 42px;

                font-size: 20px;
            }

            main {
                padding: 18px;
            }
        }

    </style>
</head>


<body>

    <!-- ========================================
         HEADER
    ======================================== -->

    <header>

        <!-- LOGO -->
        <div class="logo-container">

            <img
                src="{{ asset('images/logo.png') }}"
                alt="CCDI Logo"
            >

        </div>


        <!-- SCHOOL / SYSTEM NAME -->
        <div class="header-content">

            <div class="school-name">
                Computer Communication Development Institute
            </div>

            <div class="system-name">
                GRADE MANAGEMENT SYSTEM
            </div>

        </div>


        <!-- LIGHT / DARK MODE -->
        <button
            class="theme-button"
            id="themeButton"
            onclick="toggleTheme()"
            aria-label="Toggle light and dark mode"
            title="Toggle light and dark mode"
        >

            <span id="themeIcon">☀️</span>

        </button>


        {{ $header ?? '' }}

    </header>


    <!-- ========================================
         PAGE CONTENT
    ======================================== -->

    <main>

        {{ $slot }}

    </main>


    <!-- ========================================
         THEME SCRIPT
    ======================================== -->

    <script>

        /*
        ========================================
        LOAD SAVED THEME
        ========================================
        */

        const savedTheme = localStorage.getItem('theme');

        const themeIcon =
            document.getElementById('themeIcon');


        if (savedTheme === 'dark') {

            document.body.classList.add('dark-mode');

            themeIcon.textContent = '🌙';

        } else {

            themeIcon.textContent = '☀️';

        }


        /*
        ========================================
        TOGGLE THEME
        ========================================
        */

        function toggleTheme() {

            const body = document.body;

            const icon =
                document.getElementById('themeIcon');


            /*
            Add animation
            */

            icon.classList.add('rotate-icon');


            setTimeout(() => {

                /*
                Switch theme
                */

                body.classList.toggle('dark-mode');


                /*
                Change icon
                */

                if (
                    body.classList.contains('dark-mode')
                ) {

                    icon.textContent = '🌙';

                    localStorage.setItem(
                        'theme',
                        'dark'
                    );

                } else {

                    icon.textContent = '☀️';

                    localStorage.setItem(
                        'theme',
                        'light'
                    );

                }

            }, 150);


            /*
            Remove animation
            */

            setTimeout(() => {

                icon.classList.remove(
                    'rotate-icon'
                );

            }, 500);

        }

    </script>

</body>

</html>