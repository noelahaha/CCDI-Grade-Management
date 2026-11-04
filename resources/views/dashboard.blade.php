<x-layout>

    <div class="request-page">

        <div class="request-card">

            <!-- ICON -->
            <div class="request-icon">
                📄
            </div>

            <!-- TITLE -->
            <h1 class="request-title">
                Request Your Grades
            </h1>

            <!-- DESCRIPTION -->
            <p class="request-description">
                Need a printed copy of your grades?
                Submit a request below and the administrator
                will process your request.
            </p>

            <!-- FORM -->
            <form
                method="POST"
                action="{{ route('grade-request.store') }}"
            >
                @csrf

                <button
                    type="submit"
                    class="request-button"
                >
                    Request Printed Copy
                </button>
            </form>

            <!-- SUCCESS MESSAGE -->
            @if (session('success'))
                <div class="request-success">
                    <span class="success-icon">✓</span>
                    {{ session('success') }}
                </div>
            @endif

            <!-- INFORMATION -->
            <div class="request-info">
                Your request will be sent to the
                Grade Management System administrator.
            </div>

        </div>

    </div>

</x-layout>