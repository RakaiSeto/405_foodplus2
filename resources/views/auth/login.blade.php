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
      <form method="POST" id="login-form">
        @csrf
        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required id="email"/>
        <input type="password" name="password" placeholder="Password" required id="password"/>
        <button type="submit" class="btn-yellow">Login</button>
      </form>
      <p>Belum punya akun? <a href="{{ route('register') }}">Register</a></p>
    </div>

    <script>
        const emailElement = document.getElementById("email");
        const passwordElement = document.getElementById("password");
        const form = document.getElementById("login-form");

        form.addEventListener("submit", async (e) => {
            e.preventDefault();
            const email = emailElement.value;
            const password = passwordElement.value;
            try{

                const response = await fetch("/api/auth/login", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                body: JSON.stringify({
                    email,
                    password
                })
            });
            const json = await response.json();
            console.log({json});
            const accessToken = json.data.accessToken
            localStorage.setItem("accessToken", accessToken);
            if(json.data.role === "penyedia") {
                window.location.href = "http://localhost:8000/donate/dashboard"
            }else if(json.data.role === "penerima") {
                window.location.href = "http://localhost:8000/receive/dashboard"
            }else {
                window.location.href = "http://localhost:8000/admin/dashboard";
            }
            }catch(err) {
                console.log({err});
            }

        })

    </script>
  </div>
</body>
</html>
