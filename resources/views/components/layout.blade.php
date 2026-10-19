<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Grade Manager</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
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