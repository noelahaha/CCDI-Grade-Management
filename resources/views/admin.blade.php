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

<!-- ========================================
     GRADES
======================================== -->

<div id="grades" class="tab-content" style="display: none;">

    <div class="dashboard-card">

        <div class="section-header">
            <div>
                <h2 class="section-title">Upload Grades</h2>
                <p class="section-description">
                    Manage student grades manually or upload them using a Word file.
                </p>
            </div>
        </div>


        <!-- ========================================
             MANUAL GRADE ENTRY
        ======================================== -->

        <div>

            <h3 class="upload-title">Manual Grade Entry</h3>

            <p class="upload-description">
                Search for a student and select the academic period to enter grades.
            </p>


            <!-- STUDENT SEARCH AND FILTERS -->

      <form method="GET"
      action="{{ url('/admin') }}"
      class="grade-search-form">

                <div class="grade-search-grid">

                    <!-- STUDENT NAME OR ID -->

                    <div class="form-group">
                        <label class="form-label">
                            Student Name or ID Number
                        </label>

                        <input
                            type="text"
                            name="student_lookup"
                            class="dashboard-input"
                            value="{{ request('student_lookup') }}"
                            placeholder="Enter student name or ID number"
                            required
                        >
                    </div>


                    <!-- OPTIONAL SCHOOL YEAR -->

                    <div class="form-group">
                        <label class="form-label">
                            School Year (Optional)
                        </label>

                        <input
                            type="text"
                            name="school_year"
                            class="dashboard-input"
                            value="{{ request('school_year') }}"
                            placeholder="2026-2027"
                            pattern="[0-9]{4}-[0-9]{4}"
                        >
                    </div>


                    <!-- YEAR LEVEL -->

                    <div class="form-group">
                        <label class="form-label">
                            Year Level
                        </label>

                        <select name="grade_year" class="dashboard-input" required>
                            <option value="">Select Year</option>

                            <option value="1st"
                                {{ request('grade_year') == '1st' ? 'selected' : '' }}>
                                1st Year
                            </option>

                            <option value="2nd"
                                {{ request('grade_year') == '2nd' ? 'selected' : '' }}>
                                2nd Year
                            </option>

                            <option value="3rd"
                                {{ request('grade_year') == '3rd' ? 'selected' : '' }}>
                                3rd Year
                            </option>

                            <option value="4th"
                                {{ request('grade_year') == '4th' ? 'selected' : '' }}>
                                4th Year
                            </option>
                        </select>
                    </div>


                    <!-- SEMESTER -->

                    <div class="form-group">
                        <label class="form-label">
                            Semester
                        </label>

                        <select name="grade_semester" class="dashboard-input" required>
                            <option value="">Select Semester</option>

                            <option value="1st"
                                {{ request('grade_semester') == '1st' ? 'selected' : '' }}>
                                1st Semester
                            </option>

                            <option value="2nd"
                                {{ request('grade_semester') == '2nd' ? 'selected' : '' }}>
                                2nd Semester
                            </option>
                        </select>
                    </div>

                </div>

                <input type="hidden" name="active_tab" value="grades">

                <button type="submit" class="primary-button">
                    Search Student
                </button>

            </form>


            <!-- ========================================
                 SELECTED STUDENT INFORMATION
            ======================================== -->

            @if(isset($selectedStudent) && $selectedStudent)

                


                <!-- ========================================
                     SUBJECT GRADES TABLE
                ======================================== -->

                <form method="POST" action="{{ url('/grade-upload') }}">

                    @csrf

                    <input type="hidden"
                           name="student_id"
                           value="{{ $selectedStudent->id }}">

                    <input type="hidden"
                           name="id_number"
                           value="{{ $selectedStudent->id_number }}">

                    <input type="hidden"
                           name="school_year"
                           value="{{ $selectedSchoolYear }}">

                    <input type="hidden"
                           name="year"
                           value="{{ request('grade_year') }}">

                    <input type="hidden"
                           name="semester"
                           value="{{ request('grade_semester') }}">


                    <div class="grade-table-wrapper">

                        <table class="grade-entry-table">

                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Grade</th>
                                    <th>Status</th>
                                    <th>Reason</th>
                                </tr>
                            </thead>

                            <tbody>

                               @forelse($gradeSubjects as $subject)

                                    @php
    $existingGrade = $existingGrades->get($subject->id);
@endphp

                                    <tr>

                                        <!-- SUBJECT -->

                                        <td>
                                            <strong>{{ $subject->subject }}</strong>

                                            <input
                                                type="hidden"
                                                name="grades[{{ $subject->id }}][subject_id]"
                                                value="{{ $subject->id }}"
                                            >
                                        </td>


                                        <!-- GRADE -->

                                        <td>
                                           <input
    type="number"
    step="0.01"
    name="grades[{{ $subject->id }}][grade]"
    class="dashboard-input"
    value="{{ old('grades.' . $subject->id . '.grade', $existingGrade->grade ?? '') }}"
    placeholder="Enter grade">
                                        </td>


                                        <!-- STATUS -->

                                        <td>
                                           <input
    type="text"
    name="grades[{{ $subject->id }}][status]"
    class="dashboard-input"
    value="{{ old('grades.' . $subject->id . '.status', $existingGrade->status ?? '') }}"
    placeholder="PASSED, FAILED, INC">
                                        </td>


                                        <!-- REASON -->

                                        <td>
                                            <input
    type="text"
    name="grades[{{ $subject->id }}][inc_reason]"
    class="dashboard-input"
    value="{{ old('grades.' . $subject->id . '.inc_reason', $existingGrade->inc_reason ?? '') }}"
    placeholder="Enter reason">
                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="4" class="empty-grade-message">
                                            No subjects found for the selected year and semester.
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>


                    @if($gradeSubjects->count() > 0)

                        <input type="hidden" name="active_tab" value="grades">

                        <button type="submit" class="primary-button grade-submit-button">
                            Save Grades
                        </button>

                    @endif

                </form>

            @elseif(request()->filled('student_lookup'))

                <div class="alert error-alert">
                    No matching student was found. Please check the name, ID number, or school year.
                </div>

            @endif

        </div>


        <!-- ========================================
             WORD FILE UPLOAD
        ======================================== -->

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
                  enctype="multipart/form-data"
                  onsubmit="return confirm('Are you sure you want to upload this grade document?')">

                @csrf

                <div class="form-group">

                    <label class="form-label">
                        Select Word File
                    </label>

                    <input
                        type="file"
                        name="grade_file"
                        class="file-input"
                        accept=".docx"
                        required
                    >

                </div>

                <input type="hidden" name="active_tab" value="grades">

                <button type="submit" class="primary-button">
                    Upload Grades
                </button>

            </form>

        </div>


        <!-- ========================================
             MESSAGES
        ======================================== -->

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
        Manual Student Entry
    </h3>

    <p class="upload-description">
        Enter multiple student records using the table below.
    </p>

    <form method="POST" action="{{ route('new-student.store') }}">

        @csrf

        <div class="student-table-wrapper">

            <table class="student-entry-table">

                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Course</th>
                        <th>Year</th>
                        <th>Semester</th>
                        <th>ID Number</th>
                        <th>School Year</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody id="manualStudentRows">

                    <tr>
                        <td>
                            <input type="text"
                                   name="students[0][first_name]"
                                   class="dashboard-input"
                                   placeholder="First Name"
                                   required>
                        </td>

                        <td>
                            <input type="text"
                                   name="students[0][last_name]"
                                   class="dashboard-input"
                                   placeholder="Last Name"
                                   required>
                        </td>

                        <td>
                            <input type="text"
                                   name="students[0][course]"
                                   class="dashboard-input"
                                   placeholder="BSCS"
                                   required>
                        </td>

                        <td>
                            <select name="students[0][year]"
                                    class="dashboard-input"
                                    required>
                                <option value="">Select</option>
                                <option value="1st">1st</option>
                                <option value="2nd">2nd</option>
                                <option value="3rd">3rd</option>
                                <option value="4th">4th</option>
                            </select>
                        </td>

                        <td>
                            <select name="students[0][semester]"
                                    class="dashboard-input"
                                    required>
                                <option value="">Select</option>
                                <option value="1st">1st</option>
                                <option value="2nd">2nd</option>
                            </select>
                        </td>

                        <td>
                            <input type="text"
                                   name="students[0][id_number]"
                                   class="dashboard-input"
                                   placeholder="2026-02-222"
                                   pattern="[0-9]{4}-[0-9]{2}-[0-9]{3}"
                                   required>
                        </td>

                        <td>
                            <input type="text"
                                   name="students[0][school_year]"
                                   class="dashboard-input"
                                   value="2026-2027"
                                   pattern="[0-9]{4}-[0-9]{4}"
                                   required>
                        </td>

                        <td>
                            <button type="button"
                                    class="remove-row-button"
                                    onclick="removeManualStudentRow(this)">
                                Remove
                            </button>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

        <div class="manual-entry-actions">

            <button type="button"
                    class="secondary-button"
                    onclick="addManualStudentRow()">
                + Add Row
            </button>

            <button type="submit" class="primary-button">
                Add Students
            </button>

        </div>

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




<script>

    let manualStudentRowIndex = 1;

    // ADD NEW STUDENT ROW
    function addManualStudentRow() {

        const tbody = document.getElementById('manualStudentRows');

        const row = document.createElement('tr');

        row.innerHTML = `
            <td>
                <input type="text"
                       name="students[${manualStudentRowIndex}][first_name]"
                       class="dashboard-input"
                       placeholder="First Name"
                       required>
            </td>

            <td>
                <input type="text"
                       name="students[${manualStudentRowIndex}][last_name]"
                       class="dashboard-input"
                       placeholder="Last Name"
                       required>
            </td>

            <td>
                <input type="text"
                       name="students[${manualStudentRowIndex}][course]"
                       class="dashboard-input"
                       placeholder="BSCS"
                       required>
            </td>

            <td>
                <select name="students[${manualStudentRowIndex}][year]"
                        class="dashboard-input"
                        required>
                    <option value="">Select</option>
                    <option value="1st">1st</option>
                    <option value="2nd">2nd</option>
                    <option value="3rd">3rd</option>
                    <option value="4th">4th</option>
                </select>
            </td>

            <td>
                <select name="students[${manualStudentRowIndex}][semester]"
                        class="dashboard-input"
                        required>
                    <option value="">Select</option>
                    <option value="1st">1st</option>
                    <option value="2nd">2nd</option>
                </select>
            </td>

            <td>
                <input type="text"
                       name="students[${manualStudentRowIndex}][id_number]"
                       class="dashboard-input"
                       placeholder="2026-02-222"
                       pattern="[0-9]{4}-[0-9]{2}-[0-9]{3}"
                       required>
            </td>

            <td>
                <input type="text"
                       name="students[${manualStudentRowIndex}][school_year]"
                       class="dashboard-input"
                       value="2026-2027"
                       pattern="[0-9]{4}-[0-9]{4}"
                       required>
            </td>

            <td>
                <button type="button"
                        class="remove-row-button"
                        onclick="removeManualStudentRow(this)">
                    Remove
                </button>
            </td>
        `;

        tbody.appendChild(row);

        manualStudentRowIndex++;
    }


    // REMOVE STUDENT ROW
    function removeManualStudentRow(button) {

        const tbody = document.getElementById('manualStudentRows');

        if (tbody.rows.length <= 1) {
            alert('At least one student row is required.');
            return;
        }

        button.closest('tr').remove();
    }

</script>

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
