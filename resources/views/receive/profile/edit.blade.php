<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background-color: #f5f5f5;
        }
        .container {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 280px;
            padding: 20px;
            background: white;
        }
        .main-content {
            flex: 1;
            padding: 20px;
        }
        .profile-heading {
            font-size: 24px;
            margin-bottom: 30px;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
            color: #333;
        }
        .form-control {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 100%;
        }
        .btn-group {
            margin-top: 30px;
        }
        .btn-save {
            background: #60A5FA;
            color: white;
            padding: 10px 30px;
            border: none;
            border-radius: 5px;
            margin-right: 10px;
        }
        .btn-cancel {
            background: #9CA3AF;
            color: white;
            padding: 10px 30px;
            border: none;
            border-radius: 5px;
        }
        .required {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>FOOD+</h2>
            <ul style="list-style: none; padding: 0; margin-top: 30px;">
                <li><a href="{{ route('profile.edit') }}" style="text-decoration: none; color: #4B5563;">Profile</a></li>
                <li><a href="#" style="text-decoration: none; color: #4B5563;">Restoran</a></li>
                <li><a href="#" style="text-decoration: none; color: #4B5563;">Catalog</a></li>
                <li><a href="#" style="text-decoration: none; color: #4B5563;">Donasi</a></li>
                <li style="margin-top: 400px;"><a href="#" style="text-decoration: none; color: #4B5563;">LogOut</a></li>
            </ul>
        </div>

        <div class="main-content">
            <h1 class="profile-heading">Hi, {{ $user->name ?? 'User' }}!</h1>

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('POST')
                
                <div class="form-group">
                    <label class="form-label">Nama <span class="required">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Email <span class="required">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Number Telepon</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->profile->phone ?? '') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Alamat <span class="required">*</span></label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $user->profile->address ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Password <span class="required">*</span></label>
                    <input type="password" name="password" class="form-control" placeholder="Isi jika ingin mengubah">
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn-save">Simpan</button>
                    <a href="{{ route('dashboard.donate') }}" class="btn-cancel">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
