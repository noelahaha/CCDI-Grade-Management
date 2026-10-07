<x-layout>

    <style>

        /* ========================================
           DASHBOARD
        ======================================== */

        .dashboard {
            width: 100%;
        }


        /* ========================================
           PAGE TITLE
        ======================================== */

        .page-heading {
            margin-bottom: 25px;
        }

        .page-heading h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            color: var(--text-color);
        }

        .page-heading p {
            margin: 7px 0 0;
            color: var(--muted-text);
            font-size: 14px;
        }


        /* ========================================
           TAB NAVIGATION
        ======================================== */

        .tab-navigation {
            display: flex;
            gap: 8px;

            padding: 6px;

            margin-bottom: 25px;

            background-color: var(--card-bg);

            border: 1px solid var(--header-border);

            border-radius: 14px;

            box-shadow: var(--shadow);

            width: fit-content;
        }

        .tab-button {
            border: none;

            padding: 11px 22px;

            border-radius: 10px;

            background-color: transparent;

            color: var(--muted-text);

            font-size: 14px;
            font-weight: 600;

            cursor: pointer;

            transition:
                background-color 0.25s ease,
                color 0.25s ease,
                transform 0.2s ease;
        }

        .tab-button:hover {
            background-color: var(--button-bg);
            color: var(--text-color);
        }

        .tab-button.active {
            background-color: var(--accent);
            color: white;

            box-shadow:
                0 4px 10px rgba(37, 99, 235, 0.20);
        }


        /* ========================================
           TAB CONTENT
        ======================================== */

        .tab-content {
            animation: tabAppear 0.3s ease;
        }

        @keyframes tabAppear {

            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }

        }


        /* ========================================
           SECTION CARD
        ======================================== */

        .dashboard-card {
            background-color: var(--card-bg);

            border: 1px solid var(--header-border);

            border-radius: 16px;

            padding: 25px;

            box-shadow: var(--shadow);

            transition:
                background-color 0.4s ease,
                border-color 0.4s ease;
        }


        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;

            margin-bottom: 20px;
        }

        .section-title {
            margin: 0;

            font-size: 20px;
            font-weight: 700;

            color: var(--text-color);
        }

        .section-description {
            margin: 5px 0 0;

            font-size: 13px;

            color: var(--muted-text);
        }


        /* ========================================
           REQUEST TABLE
        ======================================== */

        .table-wrapper {
            width: 100%;

            overflow-x: auto;

            border-radius: 12px;

            border: 1px solid var(--header-border);
        }

        .request-table {
            width: 100%;

            border-collapse: collapse;

            min-width: 650px;
        }

        .request-table th {
            padding: 14px 16px;

            background-color: var(--button-bg);

            color: var(--text-color);

            text-align: left;

            font-size: 12px;

            text-transform: uppercase;

            letter-spacing: 0.5px;
        }

        .request-table td {
            padding: 15px 16px;

            border-top:
                1px solid var(--header-border);

            color: var(--text-color);

            font-size: 14px;
        }

        .request-table tbody tr {
            transition:
                background-color 0.2s ease;
        }

        .request-table tbody tr:hover {
            background-color: var(--button-bg);
        }


        /* ========================================
           COURSE BADGE
        ======================================== */

        .course-badge {
            display: inline-block;

            padding: 5px 10px;

            border-radius: 20px;

            background-color: var(--button-bg);

            color: var(--accent);

            font-size: 12px;

            font-weight: 700;
        }


        /* ========================================
           CHECKBOX
        ======================================== */

        .checkbox-form {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .status-checkbox {
            width: 19px;
            height: 19px;

            cursor: pointer;

            accent-color: var(--accent);
        }


        /* ========================================
           EMPTY TABLE
        ======================================== */

        .empty-message {
            text-align: center !important;

            padding: 40px !important;

            color: var(--muted-text) !important;
        }


        /* ========================================
           FORM GRID
        ======================================== */

        .form-grid {
            display: grid;

            grid-template-columns:
                repeat(2, 1fr);

            gap: 18px;

            margin-bottom: 20px;
        }

        .form-group {
            display: flex;

            flex-direction: column;

            gap: 7px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            font-size: 13px;

            font-weight: 600;

            color: var(--text-color);
        }


        /* ========================================
           INPUTS
        ======================================== */

        .dashboard-input {
            width: 100%;

            padding: 12px 13px;

            border:
                1px solid var(--header-border);

            border-radius: 9px;

            background-color: var(--bg-color);

            color: var(--text-color);

            font-size: 14px;

            outline: none;

            transition:
                border-color 0.25s ease,
                box-shadow 0.25s ease,
                background-color 0.4s ease;
        }

        .dashboard-input:focus {

            border-color: var(--accent);

            box-shadow:
                0 0 0 3px
                rgba(37, 99, 235, 0.10);

        }

        .dashboard-input::placeholder {
            color: var(--muted-text);
        }


        /* ========================================
           ACTION BUTTON
        ======================================== */

        .primary-button {
            border: none;

            padding: 12px 20px;

            border-radius: 9px;

            background-color: var(--accent);

            color: white;

            font-size: 14px;

            font-weight: 600;

            cursor: pointer;

            transition:
                transform 0.2s ease,
                opacity 0.2s ease,
                box-shadow 0.2s ease;
        }

        .primary-button:hover {

            transform: translateY(-2px);

            opacity: 0.92;

            box-shadow:
                0 5px 12px
                rgba(37, 99, 235, 0.20);

        }


        /* ========================================
           UPLOAD CARD
        ======================================== */

        .upload-section {

            margin-top: 25px;

            padding-top: 25px;

            border-top:
                1px solid var(--header-border);
        }

        .upload-title {
            margin: 0 0 5px;

            font-size: 16px;

            font-weight: 700;

            color: var(--text-color);
        }

        .upload-description {
            margin: 0 0 15px;

            font-size: 13px;

            color: var(--muted-text);
        }

        .file-row {
            display: flex;

            gap: 12px;

            align-items: center;

            flex-wrap: wrap;
        }

        .file-input {
            padding: 10px;

            border:
                1px dashed var(--header-border);

            border-radius: 9px;

            background-color: var(--bg-color);

            color: var(--text-color);

            font-size: 13px;

            cursor: pointer;

            flex: 1;
        }


        /* ========================================
           ALERTS
        ======================================== */

        .alert {

            margin-top: 20px;

            padding: 13px 15px;

            border-radius: 10px;

            font-size: 13px;

            font-weight: 500;

        }

        .success-alert {

            background-color: #dcfce7;

            color: #166534;

            border:
                1px solid #bbf7d0;

        }

        .error-alert {

            background-color: #fee2e2;

            color: #b91c1c;

            border:
                1px solid #fecaca;

        }

        body.dark-mode .success-alert {

            background-color: #16351f;

            color: #86efac;

            border-color: #245c34;

        }

        body.dark-mode .error-alert {

            background-color: #3b1d20;

            color: #fca5a5;

            border-color: #64262b;

        }


        /* ========================================
           MOBILE
        ======================================== */

        @media (max-width: 700px) {

            .tab-navigation {
                width: 100%;

                overflow-x: auto;
            }

            .tab-button {
                white-space: nowrap;

                flex: 1;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full-width {
                grid-column: auto;
            }

            .dashboard-card {
                padding: 18px;
            }

            .section-header {
                align-items: flex-start;
            }

        }

    </style>


    <div class="dashboard">


        <!-- ========================================
             PAGE HEADING
        ======================================== -->

        <div class="page-heading">

            <h1>
                Admin Dashboard
            </h1>

            <p>
                Manage student requests, grades, and student records.
            </p>

        </div>


        <!-- ========================================
     TABS
======================================== -->

<div class="tab-navigation">

    <button
        class="tab-button active"
        id="tab-students"
        onclick="showTab('students', this)"
    >
        Students
    </button>

    <button
        class="tab-button"
        id="tab-grades"
        onclick="showTab('grades', this)"
    >
        Grades
    </button>

    <button
        class="tab-button"
        id="tab-requests"
        onclick="showTab('requests', this)"
    >
        Requests
    </button>

</div>

        <!-- ========================================
             REQUESTS
        ======================================== -->

        <div
            id="requests"
            class="tab-content"
        >

            <div class="dashboard-card">

                <div class="section-header">

                    <div>

                        <h2 class="section-title">
                            Grade Requests
                        </h2>

                        <p class="section-description">
                            View and manage student grade requests.
                        </p>

                    </div>

                </div>


                <div class="table-wrapper">

                    <table class="request-table">

                        <thead>

                            <tr>

                                <th>Name</th>

                                <th>ID Number</th>

                                <th>Course</th>

                                <th>Seen</th>

                                <th>Printed</th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($requests as $request)

                                <tr>

                                    <td>
                                        {{ $request->name }}
                                    </td>

                                    <td>
                                        {{ $request->id_number }}
                                    </td>

                                    <td>

                                        <span class="course-badge">
                                            {{ $request->course }}
                                        </span>

                                    </td>


                                    <td>

                                        <form
                                            method="POST"
                                            action="{{ route('requests.seen', $request->id) }}"
                                            class="checkbox-form"
                                        >

                                            @csrf

                                            @method('PATCH')

                                            <input
                                                type="checkbox"
                                                class="status-checkbox"
                                                onchange="this.form.submit()"
                                                {{ $request->seen ? 'checked' : '' }}
                                            >

                                        </form>

                                    </td>


                                    <td>

                                        <form
                                            method="POST"
                                            action="{{ route('requests.printed', $request->id) }}"
                                            class="checkbox-form"
                                        >

                                            @csrf

                                            @method('PATCH')

                                            <input
                                                type="checkbox"
                                                class="status-checkbox"
                                                onchange="this.form.submit()"
                                                {{ $request->printed ? 'checked' : '' }}
                                            >

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="5"
                                        class="empty-message"
                                    >
                                        No grade requests yet.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        <!-- ========================================
             GRADES
        ======================================== -->

        <div
            id="grades"
            class="tab-content"
            style="display: none;"
        >

            <div class="dashboard-card">

                <div class="section-header">

                    <div>

                        <h2 class="section-title">
                            Upload Grades
                        </h2>

                        <p class="section-description">
                            Add grades manually or upload them using a Word file.
                        </p>

                    </div>

                </div>


                <!-- MANUAL ENTRY -->

                <div>

                    <h3 class="upload-title">
                        Manual Entry
                    </h3>

                    <p class="upload-description">
                        Enter the student's grade information below.
                    </p>


                    <form
                        method="POST"
                        action="/grade-upload"
                    >

                        @csrf


                        <div class="form-grid">


                            <div class="form-group">

                                <label class="form-label">
                                    Student Name
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    class="dashboard-input"
                                    placeholder="Enter student name"
                                    required
                                >

                            </div>


                            <div class="form-group">

                                <label class="form-label">
                                    ID Number
                                </label>

                                <input
                                    type="text"
                                    name="id_number"
                                    class="dashboard-input"
                                    placeholder="2020-00-000"
                                    required
                                >

                            </div>


                            <div class="form-group">

                                <label class="form-label">
                                    Subject
                                </label>

                                <input
                                    type="text"
                                    name="subject"
                                    class="dashboard-input"
                                    placeholder="Enter subject"
                                    required
                                >

                            </div>


                            <div class="form-group">

                                <label class="form-label">
                                    Grade
                                </label>

                                <input
                                    type="text"
                                    name="grade"
                                    class="dashboard-input"
                                    placeholder="Enter grade"
                                    required
                                >

                            </div>

                        </div>


                        <button
                            type="submit"
                            class="primary-button"
                        >
                            Submit Grade
                        </button>

                    </form>

                </div>


                <!-- FILE UPLOAD -->

                <div class="upload-section">

                    <h3 class="upload-title">
                        File Entry
                    </h3>

                    <p class="upload-description">
                        Upload a Word document containing grade records.
                    </p>


                    <form
                        method="POST"
                        action="{{ route('grades.upload') }}"
                        enctype="multipart/form-data"
                    >

                        @csrf


                        <div class="file-row">

                            <input
                                type="file"
                                name="grade_file"
                                class="file-input"
                                accept=".docx"
                                required
                            >

                            <button
                                type="submit"
                                class="primary-button"
                            >
                                Upload Grades
                            </button>

                        </div>

                    </form>

                </div>


                <!-- MESSAGES -->

                @if(session('success'))

                    <div class="alert success-alert">
                        {{ session('success') }}
                    </div>

                @endif


                @if(session('error'))

                    <div class="alert error-alert">
                        {{ session('error') }}
                    </div>

                @endif

            </div>

        </div>


        <!-- ========================================
             STUDENTS / EVALUATIONS
        ======================================== -->

        <div
            id="students"
            class="tab-content"
            style="display: none;"
        >

            <div class="dashboard-card">

                <div class="section-header">

                    <div>

                        <h2 class="section-title">
                            Add New Students
                        </h2>

                        <p class="section-description">
                            Add student records manually or upload a Word file.
                        </p>

                    </div>

                </div>


                <!-- MANUAL ENTRY -->

                <div>

                    <h3 class="upload-title">
                        Manual Entry
                    </h3>

                    <p class="upload-description">
                        Enter the student's basic information below.
                    </p>


                    <form
                        method="POST"
                        action="/new-student"
                    >

                        @csrf


                        <div class="form-grid">


                            <div class="form-group">

                                <label class="form-label">
                                    Student Name
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    class="dashboard-input"
                                    placeholder="Enter student name"
                                    required
                                >

                            </div>


                            <div class="form-group">

                                <label class="form-label">
                                    ID Number
                                </label>

                                <input
                                    type="text"
                                    name="id_number"
                                    class="dashboard-input"
                                    placeholder="2020-00-000"
                                    required
                                >

                            </div>


                            <div class="form-group">

                                <label class="form-label">
                                    Course
                                </label>

                                <input
                                    type="text"
                                    name="course"
                                    class="dashboard-input"
                                    placeholder="BSCS"
                                    required
                                >

                            </div>

                        </div>


                        <button
                            type="submit"
                            class="primary-button"
                        >
                            Add Student
                        </button>

                    </form>

                </div>


                <!-- FILE UPLOAD -->

                <div class="upload-section">

                    <h3 class="upload-title">
                        Upload Word File
                    </h3>

                    <p class="upload-description">
                        Upload a Word document containing student records.
                    </p>


                    <form
                        method="POST"
                        action="{{ route('students.upload') }}"
                        enctype="multipart/form-data"
                    >

                        @csrf


                        <div class="file-row">

                            <input
                                type="file"
                                name="student_file"
                                class="file-input"
                                accept=".docx"
                                required
                            >

                            <button
                                type="submit"
                                class="primary-button"
                            >
                                Upload Students
                            </button>

                        </div>

                    </form>

                </div>


                <!-- MESSAGES -->

                @if(session('error'))

                    <div class="alert error-alert">
                        {{ session('error') }}
                    </div>

                @endif


                @if(session('success'))

                    <div class="alert success-alert">
                        {{ session('success') }}
                    </div>

                @endif

            </div>

        </div>

    </div>


    <!-- ========================================
         TAB SCRIPT
    ======================================== -->
<script>

    function showTab(tabName, button) {

        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.style.display = 'none';
        });

        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active');
        });

        document.getElementById(tabName).style.display = 'block';

        button.classList.add('active');
    }

</script>

</x-layout>