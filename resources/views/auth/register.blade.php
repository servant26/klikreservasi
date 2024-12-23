<form action="{{ route('register.post') }}" method="POST">
    @csrf
    <input type="text" name="nama" placeholder="Nama" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
    <button type="submit">Register</button>
</form>
<a href="{{ route('login') }}">Login</a>
