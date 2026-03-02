<form method="POST" action="{{ route('post.reset') }}">
    @csrf

    <input type="password" name="password" placeholder="Password Baru" required>
    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>

    <button type="submit">Update Password</button>
</form>
