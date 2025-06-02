<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - FOOD+</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@800&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      display: flex;
      height: 100vh;
    }
    .left {
      flex: 1;
      background-color: #4a959b;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }
    .right {
      flex: 1;
      background-color: #f9f9f9;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .login-box {
      width: 70%;
    }
    h2 {
      text-align: center;
    }
    input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: none;
      border-radius: 10px;
      background-color: #eee;
    }
    .btn-yellow {
      background-color: #ffee00;
      color: black;
      font-weight: bold;
      padding: 10px;
      width: 100%;
      border: none;
      border-radius: 10px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="left">
    <h1>FOOD+</h1>
    <p>Sistem Informasi Pemesanan Makanan</p>
  </div>
  <div class="right">
    <div class="login-box">
      <h2>Login</h2>
      <form method="POST" id="login-form" action="javascript:void(0)">
        @csrf
        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required id="email"/>
        <input type="password" name="password" placeholder="Password" required id="password"/>
        <button type="submit" class="btn-yellow" id="login-button">Login</button>
      </form>
      <p>Belum punya akun? <a href="{{ route('register') }}">Register</a></p>
    </div>

    <script>
        const emailElement = document.getElementById("email");
        const passwordElement = document.getElementById("password");
        const form = document.getElementById("login-form");
        const loginButton = document.getElementById("login-button");

        form.addEventListener("submit", (e) => {
            e.preventDefault();
            const email = emailElement.value;
            const password = passwordElement.value;
                loginButton.textContent = "Logging in...";
                loginButton.disabled = true;
            const response = fetch("/api/auth/login", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify({email, password})
            }).then(async (res) => {
                const data = await res.json();
                if (!res.ok) {
                    throw new Error(data.message || "Something went wrong");
                }

                console.log("Login berhasil:", data);
                const accessToken = data.data.accessToken;
                localStorage.setItem("accessToken", accessToken);
                localStorage.setItem("user", JSON.stringify(data.data.user));

                if (data.data.role === "penyedia") {
                    window.location.href = "/donate/dashboard";
                } else if (data.data.role === "penerima") {
                    window.location.href = "/receive/dashboard";
                } else {
                    window.location.href = "/admin/dashboard";
                }
            })
            .catch(err => {
                alert(err.message);
                loginButton.textContent = "Login";
                loginButton.disabled = false;
            });
    })

    </script>
  </div>
</body>
</html>
