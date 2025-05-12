
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0 2rem;
            background-color: #fff;
            color: #111;
        }
        h1 {
            font-size: 24px;
            margin-top: 1rem;
            color: #1e2a47;
        }
        .stats-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-top: 2rem;
        }
        .stat-box {
            display: flex;
            align-items: center;
            background-color: #f5fafa;
            padding: 1rem;
            border-radius: 10px;
            width: 230px;
        }
        .stat-box i {
            font-size: 24px;
            margin-right: 12px;
            color: #319795;
        }
        .stat-box span {
            font-weight: 600;
        }
        .donation-box {
            background-color: #4ba4a3;
            color: white;
            padding: 1.2rem;
            border-radius: 10px;
            margin-top: 1.5rem;
            width: 250px;
            float: right;
        }
        .donation-box h2 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .donation-box p {
            font-size: 20px;
            font-weight: bold;
        }
        .donation-box small {
            display: block;
            margin-top: 5px;
        }
        .search-bar {
            margin-top: 3rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .search-bar input {
            width: 80%;
            padding: 0.5rem;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        .search-bar button {
            padding: 0.5rem 1.5rem;
            background-color: #1e7f7f;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        table {
            width: 100%;
            margin-top: 1rem;
            border-collapse: collapse;
        }
        th, td {
            text-align: left;
            padding: 12px;
        }
        th {
            background-color: #136b6b;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .table-container {
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <h1>Dashboard Admin</h1>

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
        <button>Edit</button>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Donatur</th>
                    <th>Alamat Donatur</th>
                    <th>Tanggal Pembuatan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < 5; $i++)
                    <tr>
                        <td>ID</td>
                        <td>Nama Donatur</td>
                        <td>Alamat Donatur</td>
                        <td>Tanggal Pembuatan</td>
                        <td>Status</td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
</body>
</html>
