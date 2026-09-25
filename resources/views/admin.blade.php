<x-layout>

<div class="flex gap-5">
    <button onclick="showTab('requests')">Students</button>
    <button onclick="showTab('grades')">Grades</button>
    <button onclick="showTab('students')">Evaluations</button>
</div>

<div id="requests">
    <h2>Grade Requests</h2>
    
</div>

<div id="grades" style="display: none;">
    <h2>Upload Grades</h2>

    <label> Manual Entry</label>

    <form method="POST" action="/grade-upload">
        @csrf
        <label>Enter name: </label>
        <input type="text" name="name" placeholder="Name">

        <label>Enter ID number: </label>
        <input type="text" name="id_number" placeholder="2020-00-000">

        <label>Enter Subject:</label>
        <input type="text" name="subject" placeholder="Subject">

        <label>Enter Grade:</label>
        <input type="text" name="grade" placeholder="Grade">

        <button type="submit">Submit</button>
    </form>
    
</div>

<div id="students" style="display: none;">
    <h2>Add New Students</h2>

    <label> Manual Entry</label>

    <form method="POST" action="/new-student">
        @csrf
        <label>Enter name: </label>
        <input type="text" name="name" placeholder="Name">

        <label>Enter ID number: </label>
        <input type="text" name="id_number" placeholder="2020-00-000">

        <label>Enter Course:</label>
        <input type="text" name="course" placeholder="Course">

        <button type="submit">Submit</button>
    </form>
    
    @if (session('error'))
    <p>{{ session('error') }}</p>
    @endif

    @if (session('success'))
    <p>{{ session('success') }}</p>
    @endif


</div>

<script>
    function showTab(tabName) {
        document.getElementById('requests').style.display = 'none';
        document.getElementById('grades').style.display = 'none';
        document.getElementById('students').style.display = 'none';

        document.getElementById(tabName).style.display = 'block';
    }
</script>


<x-layout>