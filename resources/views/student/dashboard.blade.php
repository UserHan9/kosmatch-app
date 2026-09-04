<h1>Student Dashboard</h1>

<p>
    Selamat datang, {{ auth()->user()->name }}
</p>

<p>
    Role: {{ auth()->user()->role }}
</p>

<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>