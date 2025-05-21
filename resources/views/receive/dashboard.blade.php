<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Penerima - FOOD+</title>
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
          <span>{{ Auth::user()->name ?? 'penerima' }} ▼</span>
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

    @php
      // Mengambil data statistik dari database
      $totalDonatur = \App\Models\User::where('role', 'penyedia')->count();
      $totalRestoran = \App\Models\User::where('role', 'penyedia')->count();
      $totalPenerima = \App\Models\User::where('role', 'penerima')->count();
      $totalMakananTersedia = \App\Models\Donation::where('status', 'available')->count();
      $totalPengeluaran = \App\Models\Donation::count();
      $totalPengiriman = \App\Models\Donation::where('status', 'claimed')->count();
      
      // Menghitung total donasi hari ini
      $donasiHarian = \App\Models\Donation::whereDate('created_at', \Carbon\Carbon::today())->sum('quantity');
      
      // Mengambil data restoran (penyedia)
      $penyediaList = \App\Models\User::where('role', 'penyedia')
        ->with(['donations' => function($query) {
            $query->where('status', 'available');
        }])
        ->take(6)
        ->get();
    @endphp

    <div class="summary">
      <div class="card">👤<div>Total Donatur<br><strong>{{ $totalDonatur }}</strong></div></div>
      <div class="card">🍽<div>Total Restoran<br><strong>{{ $totalRestoran }}</strong></div></div>
      <div class="card">⬇<div>Total Penerima<br><strong>{{ $totalPenerima }}</strong></div></div>
      <div class="card">🍱<div>Total Makanan Tersedia<br><strong>{{ $totalMakananTersedia }}</strong></div></div>
      <div class="card">💸<div>Total Pengeluaran<br><strong>{{ $totalPengeluaran }}</strong></div></div>
      <div class="card">🚚<div>Total Pengiriman<br><strong>{{ $totalPengiriman }}</strong></div></div>
    </div>

    <div class="donasi-harian">
      <h3>Donasi Harian</h3>
      <p style="font-size: 24px; font-weight: bold;">{{ $donasiHarian }}pcs</p>
      <p>{{ \Carbon\Carbon::now()->format('d F Y') }}</p>
    </div>

    <h3 style="margin-bottom: 20px;">Restoran</h3>
    <div class="restoran">
      @forelse($penyediaList as $penyedia)
      <div class="restoran-card">
        <img src="https://via.placeholder.com/50" alt="Logo">
        <div class="restoran-info">
          <h4>{{ $penyedia->name }}</h4>
          <div class="tags">
            @php
              $kategori = $penyedia->donations->pluck('category')->unique()->implode(', ');
              echo $kategori ?: 'Belum ada kategori';
            @endphp
          </div>
          <div class="stats">
            {{ rand(100000, 500000) }} Views · {{ rand(10000, 50000) }} Likes · {{ rand(10, 300) }} comments
          </div>
          <a href="{{ route('receiver.request', ['restoId' => $penyedia->id]) }}" class="request-btn" style="display: inline-block; margin-top: 10px; background-color: #ffb703; color: #333; text-decoration: none; padding: 5px 10px; border-radius: 5px; font-weight: bold;">Request Donasi</a>
        </div>
      </div>
      @empty
      <div style="grid-column: span 3; text-align: center; padding: 20px; background-color: #f5f5f5; border-radius: 10px;">
        Tidak ada restoran yang tersedia saat ini.
      </div>
      @endforelse
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
