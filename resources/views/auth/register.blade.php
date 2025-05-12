<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register - FOOD+</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@800&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #4a959b;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .register-box {
      background-color: white;
      padding: 30px;
      border-radius: 8px;
      width: 90%;
      max-width: 600px;
    }
    h2 {
      text-align: center;
    }
    input, select {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: none;
      border-radius: 5px;
      background-color: #eee;
    }
    .btn-yellow {
      background-color: #ffee00;
      color: black;
      font-weight: bold;
      padding: 10px;
      width: 100%;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .error {
      color: red;
      font-size: 14px;
      margin-top: -5px;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <div class="register-box">
    <h2>Register</h2>

    @if ($errors->any())
      <div class="error">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('register.submit') }}">
      @csrf
      <input type="text" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required />

      <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required />

      <select name="role" required>
        <option value="" disabled selected>Pilih Role</option>
        <option value="Penyedia" {{ old('role') == 'Penyedia' ? 'selected' : '' }}>Donatur</option>
        <option value="penerima" {{ old('role') == 'penerima' ? 'selected' : '' }}>Penerima</option>
        <option value="penerima" {{ old('role') == 'penerima' ? 'selected' : '' }}>Admin</option>
      </select>

      <input type="password" name="password" placeholder="Password" required />

      <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required />

      <button type="submit" class="btn-yellow">Register</button>
    </form>

    <p style="text-align: center; margin-top: 10px;">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
  </div>
</body>
</html>