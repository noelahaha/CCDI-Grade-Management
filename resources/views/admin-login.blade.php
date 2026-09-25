<x-layout>


    form method="POST" action="{{ route('login-info') }}">
        @csrf
        <label>Enter your username: </label>
        <input type="text" name="username" placeholder="Username">

        <label>Enter your password: </label>
        <input type="password" name="password" placeholder="Password">

        <button type="submit">Login</button>



</x-layout>