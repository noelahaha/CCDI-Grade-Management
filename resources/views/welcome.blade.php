<x-layout>

<div>
<a href="{{ route('admin') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Admin</a>

</div>

<form method="POST" action="{{ route('student-info.store') }}">
    @csrf
    <label>Enter your name: </label>
    <input type="text" name="name" placeholder="Name">

    <label>Enter your ID number: </label>
    <input type="text" name="idNum" placeholder="2020-00-000">

    <button type="submit">Submit</button>

</form>

</x-layout>