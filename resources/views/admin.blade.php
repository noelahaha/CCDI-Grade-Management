<x-layout>




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

            <button class="tab-button active" id="tab-students" onclick="showTab('students', this)">
                Students
            </button>

            <button class="tab-button" id="tab-grades" onclick="showTab('grades', this)">
                Grades
            </button>

            <button class="tab-button" id="tab-requests" onclick="showTab('requests', this)">
                Requests
            </button>

        </div>

        <!-- ========================================
             REQUESTS
        ======================================== -->

        <div id="requests" class="tab-content">

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

                                        <form method="POST" action="{{ route('requests.seen', $request->id) }}"
                                            class="checkbox-form">
                                            @csrf
                                            @method('PATCH')

                                            <input type="hidden" name="active_tab" value="requests">

                                            <input type="checkbox" class="status-checkbox" onchange="this.form.submit()"
                                                {{ $request->seen ? 'checked' : '' }}>
                                        </form>

                                    </td>


                                    <td>

                                        <form method="POST" action="{{ route('requests.printed', $request->id) }}"
                                            class="checkbox-form">
                                            @csrf
                                            @method('PATCH')

                                            <input type="hidden" name="active_tab" value="requests">

                                            <input type="checkbox" class="status-checkbox" onchange="this.form.submit()"
                                                {{ $request->printed ? 'checked' : '' }}>
                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="5" class="empty-message">
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

        <div id="grades" class="tab-content" style="display: none;">

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

<form method="POST" action="/grade-upload">
    @csrf

    <div class="form-grid">

        <div class="form-group">
            <label class="form-label">ID Number</label>

            <input type="text"
                name="id_number"
                class="dashboard-input"
                placeholder="2020-00-000"
                required>
        </div>

        <div class="form-group">
            <label class="form-label">Subject</label>

            <select name="subject" required>
                <option value="">Select Subject</option>

                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}">
                        {{ $subject->subject }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Grade</label>

            <input type="text"
                name="grade"
                class="dashboard-input"
                placeholder="Enter grade"
                required>
        </div>

    </div>

    <input type="hidden" name="active_tab" value="grades">

    <button type="submit" class="primary-button">
        Submit Grade
    </button>
</form>
                </div>


                <!-- MESSAGES -->

                @if (session('success'))
                    <div class="alert success-alert">
                        {{ session('success') }}
                    </div>
                @endif


                @if (session('error'))
                    <div class="alert error-alert">
                        {{ session('error') }}
                    </div>
                @endif

            </div>

        </div>


        <!-- ========================================
             STUDENTS / EVALUATIONS
        ======================================== -->

        <div id="students" class="tab-content" style="display: none;">

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


                    <form method="POST" action="/new-student">

                        @csrf


                        <div class="form-grid">


                            <div class="form-group">

                                <label class="form-label">
                                    Student Name
                                </label>

                                <input type="text" name="name" class="dashboard-input"
                                    placeholder="Enter student name" required>

                            </div>


                            <div class="form-group">

                                <label class="form-label">
                                    ID Number
                                </label>

                                <input type="text" name="id_number" class="dashboard-input"
                                    placeholder="2020-00-000" required>

                            </div>

                            <div class="form-group">

                                <label class="form-label">
                                    Course
                                </label>

                                <input type="text" name="course" class="dashboard-input" placeholder="BSCS"
                                    required>

                            </div>

                            <div class="form-group">

                                <label class="form-label">
                                    Year Level
                                </label>

                                <input type="text" name="year" class="dashboard-input" placeholder="1st"
                                    required>

                            </div>

                            <div class="form-group">

                                <label class="form-label">
                                    Semester
                                </label>

                                <input type="text" name="semester" class="dashboard-input" placeholder="1st"
                                    required>

                            </div>



                        </div>

                        <input type="hidden" name="active_tab" value="students">

                        <button type="submit" class="primary-button">
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


                    <form method="POST" action="{{ route('students.upload') }}" enctype="multipart/form-data">

                        @csrf


                        <div class="file-row">

                            <input type="file" name="student_file" class="file-input" accept=".docx" required>

                            <button type="submit" class="primary-button">
                                Upload Students
                            </button>

                        </div>

                    </form>

                </div>


                <!-- MESSAGES -->

                @if (session('error'))
                    <div class="alert error-alert">
                        {{ session('error') }}
                    </div>
                @endif


                @if (session('success'))
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

    // Restore the tab after form submission
    document.addEventListener('DOMContentLoaded', function() {

        const activeTab = @json(session('active_tab', 'requests'));

        const button = document.getElementById('tab-' + activeTab);

        if (button) {
            showTab(activeTab, button);
        }

    });
    </script>
</x-layout>
