<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            margin: 0;
            padding: 2rem;
            background-color: #fff;
            color: #111;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 1rem;
            color: #1e2a47;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-box {
            background-color: #f5fafa;
            padding: 1rem;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
        }

        .stat-box i {
            font-size: 22px;
        }

        .donation-box {
            background-color: #4ba4a3;
            color: white;
            padding: 1.5rem;
            border-radius: 12px;
            width: 220px;
            float: right;
            margin-bottom: 3rem;
        }

        .donation-box h2 {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .donation-box p {
            font-size: 24px;
            font-weight: bold;
        }

        .donation-box small {
            font-size: 13px;
        }

        .search-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 1rem;
        }

        .search-bar input {
            flex: 1;
            padding: 10px 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .search-bar button {
            padding: 10px 20px;
            background-color: #1e7f7f;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th,
        td {
            text-align: left;
            padding: 12px;
        }

        th {
            background-color: #136b6b;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .aksi-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-icon {
            width: 30px;
            height: 30px;
            border: none;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 14px;
            color: white;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .btn-view {
            background-color: #3498db;
        }

        .btn-edit {
            background-color: #f1c40f;
        }

        .btn-delete {
            background-color: #e74c3c;
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
    </style>
</head>

<body>
    <div class="flex justify-between">
        <h1>Dashboard Admin</h1>
        <div class="header">
            <div class="relative">
                <!-- Notification dot -->
                {{-- <div class="absolute -top-1 -left-1 w-3 h-3 bg-red-500 rounded-full z-10"></div> --}}

                <!-- Profile dropdown button -->
                <div class="relative">
                    <button id="profileButton"
                        class="flex items-center space-x-2 bg-white border border-gray-300 rounded px-3 py-2 text-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span id="profile-name"></span>
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div id="dropdownMenu"
                        class="absolute right-0 mt-1 w-32 bg-white border border-gray-200 rounded-md shadow-lg z-20 hidden">
                        <div class="py-1">
                            <a href="/profile"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <a href="#" id="logout-button"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Log Out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="stats-container">
        <div class="stat-box"><i>👤</i><span>Total Donatur<br>13</span></div>
        <div class="stat-box"><i>🍽️</i><span>Total Restoran<br>16</span></div>
        <div class="stat-box"><i>📋</i><span>Total Penerima<br>0</span></div>
        <div class="stat-box"><i>🥘</i><span>Total Makanan Tersedia<br>13</span></div>
        <div class="stat-box"><i>💸</i><span>Total Pengeluaran<br>13</span></div>
        <div class="stat-box"><i>🚚</i><span>Total Pengiriman<br>13</span></div>
    </div>

    <div class="donation-box">
        <h2>Donasi Harian</h2>
        <p>90pcs</p>
        <small>9 February 2025</small>
    </div>

    <div style="clear: both;"></div>

    <h2 style="margin-top: 4rem;">Data Akun Donatur</h2>

    <div class="search-bar">
        <input type="text" placeholder="Search Akun Donatur...">

    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Donatur</th>
                <th>Alamat Donatur</th>
                <th>Tanggal Pembuatan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>01</td>
                <td>Adam</td>
                <td>GG.Karamat 1</td>
                <td>10-02-2024</td>
                <td>Aktif</td>
                <td>
                    <div class="aksi-buttons">
                        <button class="btn-icon btn-view">👁</button>
                        <button class="btn-icon btn-edit">✎</button>
                        <button class="btn-icon btn-delete">🗑</button>
                    </div>
                </td>
            </tr>
            <tr>
                <td>02</td>
                <td>Dani Hamdani</td>
                <td>Komp. Pesona Bali No 2</td>
                <td>12.03.2023</td>
                <td>Non Aktif</td>
                <td>
                    <div class="aksi-buttons">
                        <button class="btn-icon btn-view">👁</button>
                        <button class="btn-icon btn-edit">✎</button>
                        <button class="btn-icon btn-delete">🗑</button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <script>

        const user = JSON.parse(localStorage.getItem('user'));
        document.getElementById('profile-name').textContent = user.name;

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

        const profileButton = document.getElementById('profileButton');
        const dropdownMenu = document.getElementById('dropdownMenu');

        profileButton.addEventListener('click', function () {
            dropdownMenu.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function (event) {
            if (!profileButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });

    </script>
</body>

</html>