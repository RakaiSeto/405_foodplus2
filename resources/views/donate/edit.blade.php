
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FOOD+ | Edit Donasi</title>

    <!-- Import Google Font: Poppins -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #ffffff; }
        .container { width: 100%; min-height: 100vh; display: flex; }
        .sidebar { width: 220px; background-color: #ffffff; border-right: 1px solid #e0e0e0; padding: 20px; }
        .logo { font-weight: bold; font-size: 24px; margin-bottom: 40px; color: #1a237e; }
        .sidebar-menu { display: flex; flex-direction: column; gap: 20px; }
        .menu-item { display: flex; align-items: center; gap: 10px; color: #666; text-decoration: none; padding: 10px 0; }
        .menu-item.active { color: #1a237e; font-weight: 600; }
        .menu-icon { width: 24px; height: 24px; color: #666; }
        .logout { position: absolute; bottom: 30px; display: flex; align-items: center; gap: 10px; color: #666; text-decoration: none; }
        .main-content { flex: 1; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .page-title { font-size: 22px; font-weight: 600; color: #333; }
        .header-actions { display: flex; align-items: center; gap: 15px; }
        .notification { position: relative; cursor: pointer; }
        .notification-badge { position: absolute; top: -5px; right: -5px; width: 6px; height: 6px; background-color: red; border-radius: 50%; }
        .language-selector { display: flex; align-items: center; gap: 5px; cursor: pointer; }
        .flag { width: 24px; height: 16px; }
        .content { margin-top: 20px; }
        .form-container { padding: 20px 0; }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-weight: 500; margin-bottom: 10px; color: #333; }
        .form-input { width: 100%; padding: 15px; border-radius: 8px; border: none; background-color: #f0f0f0; font-size: 16px; font-family: 'Poppins', sans-serif; }
        .form-actions { display: flex; justify-content: flex-end; gap: 15px; margin-top: 30px; }
        .save-btn { background-color: #2d7d8a; color: white; border: none; border-radius: 8px; padding: 15px 30px; cursor: pointer; font-size: 16px; font-weight: 500; font-family: 'Poppins', sans-serif; }
        .cancel-btn { background-color: #b4b4b4; color: white; border: none; border-radius: 8px; padding: 15px 30px; cursor: pointer; font-size: 16px; font-weight: 500; font-family: 'Poppins', sans-serif; }
    </style>
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">FOOD+</div>
            <div class="sidebar-menu">
                <a href="#" class="menu-item">
                    <i class="fas fa-user menu-icon"></i>
                    Profile
                </a>
                <a href="{{ route('donations.index') }}" class="menu-item active">
                    <i class="fas fa-gift menu-icon"></i>
                    Donasi
                </a>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout border-0 bg-transparent">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </button>
            </form>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <div class="page-title">Edit Donasi</div>
                <div class="header-actions">
                    <div class="notification">
                        <i class="fas fa-bell"></i>
                        <div class="notification-badge"></div>
                    </div>
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="form-container">
                    <form action="{{ route('donations.update', $donation->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="form-label">Nama Makanan</label>
                            <input type="text" name="food_name" class="form-input" value="{{ $donation->food_name }}" required>
                            @error('food_name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kategori Makanan</label>
                            <input type="text" name="category" class="form-input" value="{{ $donation->category }}" required>
                            @error('category')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jumlah</label>
                            <input type="number" name="quantity" class="form-input" value="{{ $donation->quantity }}" required>
                            @error('quantity')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="location" class="form-input" value="{{ $donation->location }}" required>
                            @error('location')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="save-btn">Perbarui</button>
                            <a href="{{ route('donations.index') }}" class="cancel-btn text-decoration-none text-center pt-3">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
