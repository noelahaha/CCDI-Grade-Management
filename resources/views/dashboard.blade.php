<x-layout>

   <form method="POST" action="{{ route('grade-request.store') }}">
    @csrf

    <button type="submit">
        Request Printed Copy of Grades
    </button>
    </form>




</x-layout>