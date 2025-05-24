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

    <form method="POST" id="register-form">
      <input type="text" id="name" name="name" placeholder="Nama Lengkap" required />
      <input type="email" id="email" name="email" placeholder="Email" required />
      <select id="role" name="role" required>
        <option value="" disabled selected>Pilih Role</option>
        <option value="penyedia">Donatur</option>
        <option value="penerima">Penerima</option>
        <option value="admin">Admin</option>
      </select>
      <input type="password" id="password" name="password" placeholder="Password" required />
      <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Password" required />
      <button type="submit" class="btn-yellow">Register</button>
    </form>

    <p style="text-align: center; margin-top: 10px;">Sudah punya akun? <a href="/login">Login</a></p>
  </div>

  <script>
    const form = document.getElementById("register-form");
    const nameInput = document.getElementById("name");
    const emailInput = document.getElementById("email");
    const roleInput = document.getElementById("role");
    const passwordInput = document.getElementById("password");
    const confirmPasswordInput = document.getElementById("password_confirmation");

    form.addEventListener("submit", async (e) => {
      e.preventDefault();
      const name = nameInput.value;
      const email = emailInput.value;
      const role = roleInput.value;
      const password = passwordInput.value;
      const password_confirmation = confirmPasswordInput.value;

      console.log({name, email, role, password, password_confirmation})

      try {
        // 1. Kirim register
      console.log({name, email, role, password, password_confirmation})
        const registerResponse = await fetch("/api/auth/register", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            name,
            email,
            role,
            password,
          })
        });

        if (!registerResponse.ok) {
          const error = await registerResponse.json();
          alert("Gagal register: " + (error.message || JSON.stringify(error)));
          return;
        }

        // 2. Login otomatis
        const loginResponse = await fetch("/api/auth/login", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            email,
            password
          })
        });

        const loginJson = await loginResponse.json();

        const token = loginJson.data.accessToken;
        localStorage.setItem("accessToken", token);

        // 3. Ambil data user
        const userResponse = await fetch("/api/user", {
          headers: {
            "Authorization": `Bearer ${token}`
          }
        });
        const userJson = await userResponse.json();
        const userRole = userJson.role.toLowerCase();

        if (userRole === "penyedia") {
          window.location.href = "/donate/dashboard";
        } else if (userRole === "penerima") {
          window.location.href = "/receive/dashboard";
        } else {
          window.location.href = "/user/dashboard";
        }

      } catch (err) {
        console.error(err);
        alert("Terjadi kesalahan pada proses registrasi.");
      }
    });
  </script>
</body>
</html>
