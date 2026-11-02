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

    <button class="tab-button active"
            id="tab-students"
            onclick="showTab('students', this)">
        Students
    </button>

    <button class="tab-button"
            id="tab-grades"
            onclick="showTab('grades', this)">
        Grades
    </button>

    <button class="tab-button"
            id="tab-requests"
            onclick="showTab('requests', this); markRequestsSeen()">

        Requests

        @if (($newRequestCount ?? 0) > 0)
            <span class="request-notification" id="requestNotification">
                {{ $newRequestCount }}
            </span>
        @endif

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

            <!-- FILTER -->

            <form method="GET" action="{{ url('/admin') }}"
                  class="request-filter-form">

                <input type="hidden" name="active_tab" value="requests">

                <select name="filter"
                        class="request-filter-select"
                        onchange="this.form.submit()">

                    <option value="">All Requests</option>

                    <option value="available"
                        {{ request('filter') === 'available' ? 'selected' : '' }}>
                        Available
                    </option>

                    <option value="not_available"
                        {{ request('filter') === 'not_available' ? 'selected' : '' }}>
                        Not Available
                    </option>

                    <option value="received"
                        {{ request('filter') === 'received' ? 'selected' : '' }}>
                        Received
                    </option>

                    <option value="today"
                        {{ request('filter') === 'today' ? 'selected' : '' }}>
                        Today
                    </option>

                    <option value="this_week"
                        {{ request('filter') === 'this_week' ? 'selected' : '' }}>
                        This Week
                    </option>

                    <option value="this_month"
                        {{ request('filter') === 'this_month' ? 'selected' : '' }}>
                        This Month
                    </option>

                </select>

            </form>

        </div>


        <div class="table-wrapper">

            <table class="request-table">

                <thead>

                    <tr>
                        <th>Name</th>
                        <th>ID Number</th>
                        <th>Course</th>
                        <th>Not Available</th>
                        <th>Available</th>
                        <th>Received</th>
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


                            <!-- NOT AVAILABLE -->

                            <td>

                                <form method="POST"
                                      action="{{ route('requests.availability', $request->id) }}"
                                      class="checkbox-form">

                                    @csrf
                                    @method('PATCH')

                                    <input type="hidden"
                                           name="available"
                                           value="{{ $request->available ? 1 : 0 }}">

                                    <input type="checkbox"
                                           class="status-checkbox"
                                           data-availability
                                           data-value="0"
                                           {{ !$request->available ? 'checked' : '' }}
                                           onchange="changeAvailability(this)">

                                </form>

                            </td>


                            <!-- AVAILABLE -->

                            <td>

                                <form method="POST"
                                      action="{{ route('requests.availability', $request->id) }}"
                                      class="checkbox-form">

                                    @csrf
                                    @method('PATCH')

                                    <input type="hidden"
                                           name="available"
                                           value="{{ $request->available ? 1 : 0 }}">

                                    <input type="checkbox"
                                           class="status-checkbox"
                                           data-availability
                                           data-value="1"
                                           {{ $request->available ? 'checked' : '' }}
                                           onchange="changeAvailability(this)">

                                </form>

                            </td>


                            <!-- RECEIVED -->

                            <td>

                                <form method="POST"
                                      action="{{ route('requests.received', $request->id) }}"
                                      class="checkbox-form">

                                    @csrf
                                    @method('PATCH')

                                    <input type="hidden"
                                           name="received"
                                           value="{{ $request->received ? 1 : 0 }}">

                                    <input type="checkbox"
                                           class="status-checkbox"
                                           {{ $request->received ? 'checked' : '' }}
                                           onchange="updateReceived(this)">

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="empty-message">
                                No grade requests found.
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

        
         <div class="form-group">
            <label class="form-label">Status</label>

            <input type="text"
                name="status"
                class="dashboard-input"
                placeholder="INC, PASSED, FAILED">
        </div>

         <div class="form-group">
            <label class="form-label">Reason</label>

            <input type="text"
                name="inc_reason"
                class="dashboard-input"
                placeholder="No Final Exam, etc.">
        </div>

    </div>

    <input type="hidden" name="active_tab" value="grades">

    <button type="submit" class="primary-button">
        Submit Grade
    </button>
</form>
                </div>

                <!-- WORD FILE UPLOAD -->

<div class="upload-divider"></div>

<div>
    <h3 class="upload-title">
        Upload Using Word File
    </h3>

    <p class="upload-description">
        Upload a .docx file containing the subject and student grades.
    </p>

    <form method="POST"
          action="{{ route('grades.upload') }}"
          enctype="multipart/form-data">

        @csrf

        <div class="form-group">
            <label class="form-label">Select Word File</label>

            <input type="file"
                   name="grade_file"
                   class="file-input"
                   accept=".docx"
                   required>
        </div>

        <input type="hidden" name="active_tab" value="grades">

        <button type="submit" class="primary-button">
            Upload Grades
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

       const activeTab = @json(request('active_tab', session('active_tab', 'requests')));

        const button = document.getElementById('tab-' + activeTab);

        if (button) {
            showTab(activeTab, button);
        }

    });


    // ========================================
// CHANGE AVAILABILITY
// ========================================

function changeAvailability(checkbox) {

    const form = checkbox.closest('form');

    // Set the availability value based on which checkbox was clicked
    form.querySelector('input[name="available"]').value =
        checkbox.dataset.value;

    form.submit();
}


// ========================================
// CHANGE RECEIVED STATUS
// ========================================

function updateReceived(checkbox) {

    const form = checkbox.closest('form');

    form.querySelector('input[name="received"]').value =
        checkbox.checked ? 1 : 0;

    form.submit();
}


// ========================================
// MARK NEW REQUESTS AS SEEN
// ========================================

async function markRequestsSeen() {

    const badge = document.getElementById('requestNotification');

    if (!badge) {
        return;
    }

    try {

        const response = await fetch(
            "{{ route('requests.mark-all-seen') }}",
            {
                method: 'PATCH',

                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }
        );

        if (!response.ok) {
            throw new Error('Could not update request notifications.');
        }

        // Remove the badge after the server confirms the update
        badge.remove();

    } catch (error) {

        console.error(error);

    }

}
    </script>
</x-layout>
