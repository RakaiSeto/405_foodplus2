{{-- resources/views/manajemendonasi.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FOOD+ | Manajemen Donasi</title>
    <!-- Import Google Font: Poppins -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* (Paste semua CSS kamu di sini, tetap sama) */
        /* CSS kamu dari <style> sampai </style> tetap seperti di atas */
        {
        margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: #ffffff;
        }
        
        .container {
            width: 100%;
            min-height: 100vh;
            display: flex;
        }
        
        /* Sidebar */
        .sidebar {
            width: 220px;
            background-color: #ffffff;
            border-right: 1px solid #e0e0e0;
            padding: 20px;
        }
        
        .logo {
            font-weight: bold;
            font-size: 24px;
            margin-bottom: 40px;
            color: #1a237e;
        }
        
        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .menu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #666;
            text-decoration: none;
            padding: 10px 0;
        }
        
        .menu-item.active {
            color: #1a237e;
            font-weight: 600;
        }
        
        .menu-icon {
            width: 24px;
            height: 24px;
            color: #666;
        }
        
        .logout {
            position: absolute;
            bottom: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #666;
            text-decoration: none;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            padding: 20px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .page-title {
            font-size: 22px;
            font-weight: 600;
            color: #333;
        }
        
        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .notification {
            position: relative;
            cursor: pointer;
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 6px;
            height: 6px;
            background-color: red;
            border-radius: 50%;
        }
        
        .language-selector {
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
        }
        
        .flag {
            width: 24px;
            height: 16px;
        }
        
        /* Content Area */
        .content {
            margin-top: 20px;
        }
        
        .restaurant-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        .search-bar {
            display: flex;
            margin-bottom: 20px;
            justify-content: space-between;
        }
        
        .search-input {
            flex: 1;
            padding: 12px 15px;
            border-radius: 8px;
            border: none;
            background-color: #f0f0f0;
            display: flex;
            align-items: center;
            margin-right: 20px;
        }
        
        .search-input input {
            flex: 1;
            border: none;
            background: transparent;
            margin-left: 10px;
            outline: none;
            font-size: 16px;
            font-family: 'Poppins', sans-serif;
        }
        
        .create-btn {
            background-color: #2d7d8a;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0 25px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
        }
        
        /* Table */
        .table-container {
            width: 100%;
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead {
            background-color: #2d7d8a;
            color: white;
        }
        
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        th {
            font-weight: 600;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .action-btn {
            color: #2d7d8a;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
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

        <div class="main-content">
            <div class="header">
                <div class="page-title">Manajemen Donasi</div>
                <div class="header-actions">
                    <div class="notification">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M13.73 21a1.999 1.999 0 0 1-3.46 0" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <div class="notification-badge"></div>
                    </div>
                    <div class="language-selector">
                        <img src="{{ asset('images/flag.png') }}" alt="USA Flag" class="flag">
                        <span>Eng (US)</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="restaurant-title">{{ Auth::user()->name ?? 'Restoran' }}</div>
                <div class="search-bar">
                    <div class="search-input">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2"/>
                            <path d="M21 21l-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <input type="text" placeholder="Search Donasi...">
                    </div>
                    <!-- <button class="create-btn" onclick="window.location.href='{{ route('donations.create') }}'">Create</button> -->
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Makanan & Minuman</th>
                                <th>Kategori</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($donations) && count($donations) > 0)
                                @foreach($donations as $donation)
                                <tr>
                                    <td>{{ $donation->id }}</td>
                                    <td>{{ $donation->food_name }}</td>
                                    <td>{{ $donation->category }}</td>
                                    <td>{{ $donation->quantity }}</td>
                                    <td>{{ $donation->status ?? 'Menunggu' }}</td>
                                    <td class="action-btn">
                                        <a href="{{ route('donations.edit', $donation->id) }}">Edit</a> |
                                        <form action="{{ route('donations.destroy', $donation->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn" style="background:none; border:none; cursor:pointer;">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" style="text-align:center;">Tidak ada data donasi.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    {{-- Jika tidak ada data --}}
                    @if(!isset($donations) || $donations->isEmpty())
                        <p style="text-align:center; margin-top:20px;">Tidak ada data donasi.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>
