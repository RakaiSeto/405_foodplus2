<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Request Donasi - FOOD+</title>
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
    .food-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      margin-bottom: 30px;
    }
    .food-card {
      background-color: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .food-title {
      font-weight: 600;
      font-size: 18px;
      margin-bottom: 15px;
    }
    .food-image {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 8px;
      display: block;
      margin: 0 auto 15px;
    }
    .food-info {
      margin-bottom: 15px;
      font-size: 14px;
    }
    .input-field {
      width: 100%;
      padding: 8px;
      border-radius: 5px;
      border: 1px solid #ddd;
      background-color: #f0f0f0;
      margin-bottom: 15px;
    }
    .action-buttons {
      display: flex;
      justify-content: space-between;
    }
    .cancel-btn, .confirm-btn {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      border: none;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
    }
    .cancel-btn {
      background-color: #ffcdd2;
      color: #d32f2f;
    }
    .confirm-btn {
      background-color: #c8e6c9;
      color: #388e3c;
    }
    .notification {
      position: fixed;
      top: 20px;
      right: 20px;
      background-color: #4caf50;
      color: white;
      padding: 15px 20px;
      border-radius: 5px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.2);
      display: none;
    }
    .notification-icon {
      margin-right: 10px;
    }
  </style>
</head>
<body>
  <aside>
    <div>
      <h1>FOOD+</h1>
      <div class="nav-item">
        <a href="{{ route('receiver.dashboard') }}" style="text-decoration: none; color: inherit;">
          <i>📊</i> Dashboard
        </a>
      </div>
      <div class="nav-item">
        <a href="{{ route('receiver.requests') }}" style="text-decoration: none; color: inherit;">
          <i>📋</i> Permintaan Saya
        </a>
      </div>
      <div class="nav-item">
        <a href="{{ route('receiver.history') }}" style="text-decoration: none; color: inherit;">
          <i>📝</i> Riwayat
        </a>
      </div>
    </div>
  </aside>
  <main>
    <div class="topbar">
      <h2>Request Donasi</h2>
      <div style="position: relative;">
        <button onclick="toggleDropdown()" style="background-color: white; border: 1px solid #ccc; padding: 5px 10px; border-radius: 5px; cursor: pointer;">
          <span style="margin-right: 5px;">🔔</span>
          <span>{{ Auth::user()->name ?? 'penerima' }} ▼</span>
        </button>
        <div id="userDropdown" style="display: none; position: absolute; right: 0; background-color: white; border: 1px solid #ccc; border-radius: 5px; margin-top: 5px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); z-index: 10;">
          <a href="{{ route('profile.edit') }}" style="display: block; padding: 10px 20px; text-decoration: none; color: #0f172a;">Profile</a>
          <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
            @csrf
            <button type="submit" style="display: block; width: 100%; text-align: left; padding: 10px 20px; background: none; border: none; cursor: pointer; color: #0f172a;">Log Out</button>
          </form>
        </div>
      </div>
    </div>

    <h3 style="margin-bottom: 20px;">{{ $location->name ?? 'Restoran' }}</h3>
    
    <div class="food-grid">
      @foreach($foods as $food)
      <div class="food-card">
        <h4 class="food-title">{{ $food->name }}</h4>
        <img src="{{ $food->image_url ?? asset('images/food-placeholder.png') }}" alt="{{ $food->name }}" class="food-image">
        <div class="food-info">
          <p>Jumlah yang tersedia: {{ $food->quantity }}</p>
          <p>Kategori: {{ $food->category ?? 'Umum' }}</p>
          <p>Tanggal Kadaluarsa: {{ $food->expiry_date ?? 'Tidak diketahui' }}</p>
        </div>
        <input type="number" class="input-field" placeholder="Masukkan Jumlah Yang Kamu Mau" min="1" max="{{ $food->quantity }}" id="quantity-{{ $food->id }}">
        <div class="action-buttons">
          <span>X{{ $food->quantity }} items</span>
          <div>
          <button class="cancel-btn" onclick="cancelRequest('{{ $food->id }}')">✕</button>
          <button class="confirm-btn" onclick="confirmRequest('{{ $food->id }}', '{{ $food->name }}', '{{ $location->id ?? 1 }}')">✓</button>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </main>

  <div class="notification" id="notification">
    <span class="notification-icon">✓</span>
    <span id="notification-message">Permintaan berhasil dikirim!</span>
  </div>

  <script>
    // Toggle dropdown
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

    // Fungsi untuk mengkonfirmasi permintaan
function confirmRequest(foodId, foodName, restoId) {
  const quantity = document.getElementById(`quantity-${foodId}`).value;
  
  if (!quantity || quantity < 1) {
    alert('Silakan masukkan jumlah yang valid');
    return;
  }

  // Kirim permintaan ke server
  fetch('{{ route("receiver.request.store") }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({
      food_id: foodId,
      location: restoId,  // Diubah dari restaurant_id menjadi location
      quantity: quantity
    })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      showNotification(`Permintaan untuk ${quantity} ${foodName} berhasil dikirim!`);
      document.getElementById(`quantity-${foodId}`).value = '';
    } else {
      alert(data.message || 'Terjadi kesalahan. Silakan coba lagi.');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Terjadi kesalahan. Silakan coba lagi.');
  });
}
  </script>
</body>
</html>