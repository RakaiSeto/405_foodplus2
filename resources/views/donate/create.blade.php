<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FOOD+ | Tambah Donasi</title>

    <!-- Import Google Font: Poppins -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
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
        .cancel-btn { background-color: #b4b4b4; color: white; border: none; border-radius: 8px; padding: 15px 30px; cursor: pointer; font-size: 16px; font-weight: 500; font-family: 'Poppins', sans-serif; text-decoration: none; display: inline-block; text-align: center; }
    </style>
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">FOOD+</div>
            <div class="sidebar-menu">
                <a href="#" class="menu-item">
                    <svg class="menu-icon" viewBox="0 0 24 24" fill="currentColor">
                        <circle cx="12" cy="8" r="5" />
                        <path d="M3,21 L21,21 C21,16.0294373 16.9705627,12 12,12 C7.02943725,12 3,16.0294373 3,21 Z" />
                    </svg>
                    Profile
                </a>
                <a href="{{ route('donations.index') }}" class="menu-item active">
                    <svg class="menu-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M3,13 L12,4 L21,13 L21,21 L3,21 L3,13 Z M7,13 L7,17 L11,17 L11,13 L7,13 Z M13,13 L13,17 L17,17 L17,13 L13,13 Z" />
                    </svg>
                    Donasi
                </a>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="logout">
                @csrf
                <button type="submit" style="background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 10px; color: #666;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M9 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M16 17L21 12L16 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M21 12H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    LogOut
                </button>
            </form>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <div class="page-title">Tambah Donasi</div>
                <div class="header-actions">
                    <div class="notification">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M13.73 21a1.999 1.999 0 0 1-3.46 0" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <div class="notification-badge"></div>
                    </div>
                    <div class="language-selector">
                        <img src="{{ asset('images/flag-id.png') }}" alt="Indonesia Flag" class="flag">
                        <span>ID</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="form-container">
                    @if ($errors->any())
                        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                            <ul style="margin: 0; padding-left: 20px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ route('donations.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Nama Makanan</label>
                            <input type="text" name="food_name" class="form-input" value="{{ old('food_name') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kategori Makanan</label>
                            <input type="text" name="category" class="form-input" value="{{ old('category') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Jumlah</label>
                            <input type="number" name="quantity" class="form-input" value="{{ old('quantity') }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="location" class="form-input" value="{{ old('location') }}" required>
                        </div>
                        <div class="form-actions">
                            <a href="{{ route('donations.index') }}" class="cancel-btn">Batal</a>
                            <button type="submit" class="save-btn">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
