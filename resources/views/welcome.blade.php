<x-layout>

   


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