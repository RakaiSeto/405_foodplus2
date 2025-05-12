<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Donatur - FOOD+</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }
    body {
      display: flex;
      background-color: #f5f5f5;
      color: #0f172a;
    }
    aside {
      width: 250px;
      background-color: #fff;
      padding: 40px 20px;
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      border-right: 1px solid #e5e7eb;
    }
    aside h1 {
      font-weight: 700;
      font-size: 24px;
      color: #0f172a;
      margin-bottom: 40px;
    }
    aside .nav-item {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
      color: #64748b;
      font-size: 16px;
      cursor: pointer;
    }
    aside .nav-item i {
      margin-right: 10px;
    }
    main {
      flex: 1;
      padding: 30px;
    }
    .topbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }
    .summary {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      margin-bottom: 30px;
    }
    .summary .card {
      background-color: #3db4a1;
      padding: 20px;
      color: white;
      border-radius: 10px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
    .summary .card i {
      font-size: 24px;
      margin-bottom: 10px;
    }
    .donasi-harian {
      background-color: #3db4a1;
      color: white;
      padding: 20px;
      border-radius: 10px;
      width: 250px;
      margin-left: auto;
      margin-bottom: 30px;
    }
    .donasi-harian h3 {
      font-size: 20px;
      margin-bottom: 10px;
    }
    .restoran {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
    }
    .restoran-card {
      background-color: #3db4a1;
      padding: 15px;
      border-radius: 10px;
      color: white;
      display: flex;
      align-items: center;
    }
    .restoran-card img {
      width: 50px;
      height: 50px;
      object-fit: cover;
      border-radius: 8px;
      margin-right: 15px;
    }
    .restoran-info {
      flex: 1;
    }
    .restoran-info h4 {
      margin-bottom: 5px;
    }
    .restoran-info .tags {
      font-size: 12px;
      margin-bottom: 5px;
    }
    .restoran-info .stats {
      font-size: 10px;
    }
    .footer-note {
      text-align: right;
      margin-top: 10px;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <aside>
    <div>
      <h1>FOOD+</h1>
    </div>
  </aside>
  <main>
    <div class="topbar">
      <h2>Dashboard</h2>
      <div style="position: relative;">
        <button onclick="toggleDropdown()" style="background-color: white; border: 1px solid #ccc; padding: 5px 10px; border-radius: 5px; cursor: pointer;">
          <span style="margin-right: 5px;">🔔</span>
          <span>{{ Auth::user()->name ?? 'donatur' }} ▼</span>
        </button>
        <div id="userDropdown" style="display: none; position: absolute; right: 0; background-color: white; border: 1px solid #ccc; border-radius: 5px; margin-top: 5px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); z-index: 10;">
          <a href="#" style="display: block; padding: 10px 20px; text-decoration: none; color: #0f172a;">Profile</a>
          <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
            @csrf
            <button type="submit" style="display: block; width: 100%; text-align: left; padding: 10px 20px; background: none; border: none; cursor: pointer; color: #0f172a;">Log Out</button>
          </form>
        </div>
      </div>
    </div>

    <div class="summary">
      <div class="card">👤<div>Total Donatur<br><strong>13</strong></div></div>
      <div class="card">🍽<div>Total Restoran<br><strong>16</strong></div></div>
      <div class="card">⬇<div>Total Penerima<br><strong>0</strong></div></div>
      <div class="card">🍱<div>Total Makanan Tersedia<br><strong>13</strong></div></div>
      <div class="card">💸<div>Total Pengeluaran<br><strong>13</strong></div></div>
      <div class="card">🚚<div>Total Pengiriman<br><strong>13</strong></div></div>
    </div>

    <div class="donasi-harian">
      <h3>Donasi Harian</h3>
      <p style="font-size: 24px; font-weight: bold;">90pcs</p>
      <p>9 February 2025</p>
    </div>

    <h3 style="margin-bottom: 20px;">Restoran</h3>
    <div class="restoran">
      @php
        $restorans = [
          (object)[ 'nama' => 'Gacoan', 'logo_url' => 'https://via.placeholder.com/50', 'kategori' => 'Makanan, Cepat Saji, Mie', 'views' => '302,624', 'likes' => '30,908', 'comments' => '33' ],
          (object)[ 'nama' => 'Solaria', 'logo_url' => 'https://via.placeholder.com/50', 'kategori' => 'Makanan, Restoran, Terjamin', 'views' => '101,650', 'likes' => '26,743', 'comments' => '209' ],
          (object)[ 'nama' => 'Kopi Kenangan', 'logo_url' => 'https://via.placeholder.com/50', 'kategori' => 'Minuman, Kopi, Cepat Saji', 'views' => '234,504', 'likes' => '13,301', 'comments' => '184' ],
          (object)[ 'nama' => 'Wings O Wings', 'logo_url' => 'https://via.placeholder.com/50', 'kategori' => 'Makanan, Ayam, Aneka Ragam', 'views' => '433,204', 'likes' => '36,050', 'comments' => '38' ],
          (object)[ 'nama' => 'Ayam Crisbar', 'logo_url' => 'https://via.placeholder.com/50', 'kategori' => 'Ayam, Cepat Saji, Murah', 'views' => '401,456', 'likes' => '24,753', 'comments' => '260' ],
          (object)[ 'nama' => 'Burger King', 'logo_url' => 'https://via.placeholder.com/50', 'kategori' => 'Makanan, Cepat Saji, Restoran', 'views' => '242,634', 'likes' => '23,430', 'comments' => '134' ],
        ];
      @endphp

      @foreach($restorans as $resto)
      <div class="restoran-card">
        <img src="{{ $resto->logo_url }}" alt="Logo">
        <div class="restoran-info">
          <h4>{{ $resto->nama }}</h4>
          <div class="tags">{{ $resto->kategori }}</div>
          <div class="stats">{{ $resto->views }} Views · {{ $resto->likes }} Likes · {{ $resto->comments }} comments</div>
        </div>
      </div>
      @endforeach
    </div>
    <p class="footer-note">See Details</p>
  </main>

  <script>
    function toggleDropdown() {
      const dropdown = document.getElementById('userDropdown');
      dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    document.addEventListener('click', function(event) {
      const dropdown = document.getElementById('userDropdown');
      const button = event.target.closest('button');
      if (!dropdown.contains(event.target) && !button) {
        dropdown.style.display = 'none';
      }
    });
  </script>
</body>
</html>
