<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FOOD+ | Dashboard Donasi</title>
    <!-- Import Google Font: Poppins -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            min-width: 100%;
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

        .content {
            margin-top: 20px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #eee;
            padding: 15px 20px;
        }

        .btn-primary {
            background-color: #2d7d8a;
            border: none;
        }

        .btn-primary:hover {
            background-color: #236570;
        }

        .table th {
            font-weight: 600;
            color: #555;
        }

        .badge {
            padding: 6px 10px;
        }

        .welcome-banner {
            background-color: #4a959b;
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container p-0">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">FOOD+</div>
                </button>
            </form>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <div class="page-title">Dashboard Donasi</div>
                <div class="header-actions">
                    <div class="notification">
                        <i class="fas fa-bell"></i>
                        <div class="notification-badge"></div>
                    </div>
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                            {{-- {{ Auth::user()->name }} --}}
                            Name
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form method="POST">
                                    @csrf
                                    <a class="dropdown-item" href="/profile">Profile</a>
                                    <button type="submit" class="dropdown-item" id="logout-button">Log Out</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="content">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="welcome-banner" >
                    <h2 id="banner">Selamat Datang!</h2>
                    <p>Terima kasih telah bergabung dengan platform Food+. Anda dapat mendonasikan makanan untuk membantu mereka yang membutuhkan.</p>
                    <a href="{{ route('donations.create') }}" class="btn btn-warning">Donasi Sekarang</a>
                </div>

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Donasi Saya</h5>
                        <a href="{{ route('donations.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Donasi
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama Makanan</th>
                                        <th>Kategori</th>
                                        <th>Jumlah</th>
                                        <th>Lokasi</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="donation-table-body">
                                    @if(isset($donations))
                                        @forelse($donations as $donation)
                                        <tr>
                                            <td>{{ $donation->food_name }}</td>
                                            <td>{{ $donation->category }}</td>
                                            <td>{{ $donation->quantity }}</td>
                                            <td>{{ $donation->location }}</td>
                                            <td>
                                                <span class="badge bg-success">{{ $donation->status ?? 'Tersedia' }}</span>
                                            </td>
                                            <td>{{ $donation->created_at->format('d M Y') }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('donations.show', $donation->id) }}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('donations.edit', $donation->id) }}" class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('donations.destroy', $donation->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus donasi ini?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Belum ada donasi</td>
                                        </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center">Data donasi tidak tersedia</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        
        const dropdownMenuButton = document.getElementById("dropdownMenuButton");
        const banner = document.getElementById("banner");
        fetch("/api/user", {headers: {
             "Authorization": `Bearer ${localStorage.getItem("accessToken")}`
        }}).then(response => response.json()).then(user => {
            dropdownMenuButton.textContent = user.name
            banner.innerHTML = `
            <h2>Selamat Datang, ${user.name}!</h2>
        `
        }).catch(err => {
            allert(err)
        })
        fetch('/api/donations/resto/all', {headers: {
            "Authorization": `Bearer ${localStorage.getItem("accessToken")}`
        }})
            .then(response => response.json())
            .then(({data, status, message}) => {
                const tbody = document.getElementById('donation-table-body');
                tbody.innerHTML = '';

                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="7" class="text-center">Belum ada donasi</td></tr>';
                    return;
                }

                data.forEach(donation => {
                    const row = `
                        <tr>
                            <td>${donation.food_name}</td>
                            <td>${donation.category}</td>
                            <td>${donation.quantity}</td>
                            <td>${donation.location}</td>
                            <td><span class="badge bg-success">${donation.status ?? 'Tersedia'}</span></td>
                            <td>${new Date(donation.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="/donations/${donation.id}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                    <a href="/donations/${donation.id}/edit" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                    <form action="/donations/${donation.id}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus donasi ini?')">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                });
            })
            .catch(error => {
                console.error('Gagal mengambil data:', error.message);
                document.getElementById('donation-table-body').innerHTML = '<tr><td colspan="7" class="text-center">Terjadi kesalahan saat memuat data</td></tr>';
            });

            const logoutButtonElement = document.getElementById("logout-button");
            logoutButtonElement.addEventListener("click",  async e => {
                e.preventDefault();
                try{
                const response = await fetch("/api/auth/logout", {method: "POST", headers: {
                    Authorization: `Bearer ${localStorage.getItem("accessToken")}`,
                    "Content-Type": "application/json"
                }});
                const json = await response.json();
                localStorage.removeItem("accessToken");
                window.location.href = "/"
                }catch(err){
                    console.log(err);
                }
            })
    </script>

</body>
</html>
