<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FOOD+ | Dashboard Donasi</title>
    <!-- Import Google Font: Poppins -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

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
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
                    <div class="notification relative cursor-pointer" id="notification-button">
                        <i class="fas fa-bell"></i>
                        @if(count($notificationsNotRead) > 0)
                            <div class="notification-badge"></div>
                        @endif
                    </div>
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" onclick="toggleDropdown()"
                            data-bs-toggle="dropdown">
                            {{-- {{ Auth::user()->name }} --}}
                            Name
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" id="userDropdown">
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

                <div class="welcome-banner">
                    <h2 id="banner">Selamat Datang!</h2>
                    <p>Terima kasih telah bergabung dengan platform Food+. Anda dapat mendonasikan makanan untuk
                        membantu mereka yang membutuhkan.</p>
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
                                                        <a href="{{ route('donations.show', $donation->id) }}"
                                                            class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('donations.edit', $donation->id) }}"
                                                            class="btn btn-sm btn-warning">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('donations.destroy', $donation->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus donasi ini?')">
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

    <div class="modal" aria-labelledby="dialog-title" role="dialog" id="notificationModal">
        <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 py-3 sm:p-6">

                        <div class="text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <div class="flex justify-between items-center">

                                <h3 class="text-base font-semibold text-gray-900" id="dialog-title">Notifikasi</h3>
                                <div class="flex items-center gap-2">
                                    <button type="button"
                                        class="cursor-pointer bg-blue-700 rounded-lg p-2 flex items-center justify-between max-w-md mx-auto text-white text-sm"
                                        id="read-all-notification" data-bs-dismiss="modal" aria-label="Close">Read
                                        All</button>
                                    <button type="button" class="cursor-pointer" id="close-notification-modal"
                                        data-bs-dismiss="modal" aria-label="Close">X</button>
                                </div>
                            </div>


                            <div class="mt-2">
                                {{-- card for every notification --}}
                                @if(isset($notificationsNotRead))
                                    <div class="flex flex-col gap-2">
                                        @foreach($notificationsNotRead as $notification)
                                            <div
                                                class="relative bg-gray-300 w-full rounded-lg p-4 flex items-center justify-between max-w-md mx-auto">
                                                <!-- Red badge for unread notifications -->
                                                <div class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"></div>

                                                <div class="flex items-center space-x-3">
                                                    <div class="flex flex-col items-start">
                                                        <h3 class="text-gray-900 font-medium text-sm">
                                                            {{ $notification->type }}
                                                        </h3>
                                                        <p class="text-gray-500 text-xs">
                                                            {{ $notification->data }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="text-gray-400 text-xs">
                                                    {{ $notification->created_at->format('d F Y') }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                @if(isset($notificationsRead))
                                    <div class="flex flex-col gap-2">
                                        @foreach($notificationsRead as $notification)
                                            <div
                                                class="bg-gray-100 w-full rounded-lg p-4 flex items-center justify-between max-w-md mx-auto">
                                                <div class="flex items-center space-x-3">
                                                    <div class="flex flex-col items-start">
                                                        <h3 class="text-gray-900 font-medium text-sm">
                                                            {{ $notification->type }}
                                                        </h3>
                                                        <p class="text-gray-500 text-xs">
                                                            {{ $notification->data }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="text-gray-400 text-xs">
                                                    {{ $notification->created_at->format('d F Y') }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>

        const notificationButton = document.getElementById("notification-button");
        notificationButton.addEventListener("click", () => {
            document.getElementById("notificationModal").classList.add("show");
            document.getElementById("notificationModal").style.display = "block";
        })

        const readAllNotification = document.getElementById("read-all-notification");
        readAllNotification.addEventListener("click", () => {
            fetch("/api/notifications/read-all", { method: "POST" }).then(response => response.json()).then(data => {
                console.log({ data })
                window.location.reload();
            })
        })

        const closeNotificationModal = document.getElementById("close-notification-modal");
        closeNotificationModal.addEventListener("click", () => {
            document.getElementById("notificationModal").classList.remove("show");
            document.getElementById("notificationModal").style.display = "none";
        })

        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        }

        const dropdownMenuButton = document.getElementById("dropdownMenuButton");
        const banner = document.getElementById("banner");
        fetch("/api/user", {
            headers: {
                "Authorization": `Bearer ${localStorage.getItem("accessToken")}`
            }
        }).then(response => response.json()).then(user => {
            dropdownMenuButton.textContent = user.name
            banner.innerHTML = `
            <h2>Selamat Datang, ${user.name}!</h2>
        `
        }).catch(err => {
            allert(err)
        })
        fetch('/api/donations/resto/all', {
            headers: {
                "Authorization": `Bearer ${localStorage.getItem("accessToken")}`
            }
        })
            .then(response => response.json())
            .then(({ data, status, message }) => {
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
        logoutButtonElement.addEventListener("click", async e => {
            e.preventDefault();
            try {
                const response = await fetch("/api/auth/logout", {
                    method: "POST", headers: {
                        Authorization: `Bearer ${localStorage.getItem("accessToken")}`,
                        "Content-Type": "application/json"
                    }
                });
                const json = await response.json();
                localStorage.removeItem("accessToken");
                window.location.href = "/"
            } catch (err) {
                console.log(err);
            }
        })
    </script>

</body>

</html>