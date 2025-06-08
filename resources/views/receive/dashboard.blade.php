<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Penerima - FOOD+</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
      align-items: flex-start;
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


    .notification-badge {
      position: absolute;
      top: -5px;
      right: -5px;
      width: 6px;
      height: 6px;
      background-color: red;
      border-radius: 50%;
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
      <div class="flex items-center gap-4">
        <div class="relative cursor-pointer" id="notification-button">
          <i class="fas fa-bell"></i>
          @if(count($notificationsNotRead) > 0)
        <div class="notification-badge"></div>
      @endif
        </div>

        <div style="position: relative;">
          <button onclick="toggleDropdown()"
            style="background-color: white; border: 1px solid #ccc; padding: 5px 10px; border-radius: 5px; cursor: pointer;">
            <span id="user-name"> ▼</span>
          </button>
          <div id="userDropdown"style="display: none; position: absolute; right: 0; background-color: white; border: 1px solid #ccc; border-radius: 5px; margin-top: 5px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); z-index: 10;">
            <a href="/profile"
              style="display: block; padding: 10px 20px; text-decoration: none; color: #0f172a;">Profile</a>
            <form method="POST" style="margin: 0;">
              @csrf
              <button type="submit"
                style="display: block; width: 100%; text-align: left; padding: 10px 20px; background: none; border: none; cursor: pointer; color: #0f172a;"
                id="logout-button">Log Out</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    {{-- @php
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
    @endphp --}}

    <div class="summary" id="summary">
      <div class="card" id="total-donatur">👤<div>Total Donatur<br><strong>{{ $totalDonatur ??= 0 }}</strong></div>
      </div>
      <div class="card" id="total-restoran">🍽<div>Total Restoran<br><strong>{{ $totalRestoran ??= 0 }}</strong></div>
      </div>
      <div class="card" id="total-penerima">⬇<div>Total Penerima<br><strong>{{ $totalPenerima ??= 0}}</strong></div>
      </div>
      <div class="card" id="total-makanan">🍱<div>Total Makanan
          Tersedia<br><strong>{{ $totalMakananTersedia ??= 0 }}</strong></div>
      </div>
      {{-- <div class="card">💸<div>Total Pengeluaran<br><strong>{{ $totalPengeluaran ??= 0 }}</strong></div>
      </div> --}}
      {{-- <div class="card">🚚<div>Total Pengiriman<br><strong>{{ $totalPengiriman ??= 0 }}</strong></div>
      </div> --}}
    </div>

    <div class="donasi-harian" id="donasi-harian">
      <h3>Donasi Harian</h3>
      <p style="font-size: 24px; font-weight: bold;">{{ $donasiHarian ??= 0 }}pcs</p>
      <p>{{ \Carbon\Carbon::now()->format('d F Y') }}</p>
    </div>

    <h3 style="margin-bottom: 20px;">Restoran</h3>
    <div class="restoran" id="restoran">
      {{-- @forelse($penyediaList as $penyedia)
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
          <a href="{{ route('receiver.request', ['restoId' => $penyedia->id]) }}" class="request-btn"
            style="display: inline-block; margin-top: 10px; background-color: #ffb703; color: #333; text-decoration: none; padding: 5px 10px; border-radius: 5px; font-weight: bold;">Request
            Donasi</a>
        </div>
      </div>
      @empty
      <div
        style="grid-column: span 3; text-align: center; padding: 20px; background-color: #f5f5f5; border-radius: 10px;">
        Tidak ada restoran yang tersedia saat ini.
      </div>
      @endforelse --}}
    </div>
    <p class="footer-note">See Details</p>
  </main>

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
                    id="read-all-notification" data-bs-dismiss="modal" aria-label="Close">Read All</button>
                  <button type="button" class="cursor-pointer" id="close-notification-modal" data-bs-dismiss="modal"
                    aria-label="Close">X</button>
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
            <div class="bg-gray-100 w-full rounded-lg p-4 flex items-center justify-between max-w-md mx-auto">
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

  <script>
    const userName = document.getElementById("user-name");
    userName.innerHTML = JSON.parse(localStorage.getItem("user")).name;
    const summaryComponent = document.getElementById("summary");
    const donasiHarian = document.getElementById("donasi-harian")
    const totalDonatur = document.getElementById("total-donatur")
    const totalRestoran = document.getElementById("total-restoran")
    const totalPenerima = document.getElementById("total-penerima")
    const totalMakanan = document.getElementById("total-makanan")

    const restoranCard = document.getElementById("restoran");

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

    fetch("/api/statistics/receiver/dashboard/summary", { method: "GET" }).then(response => response.json()).then(({ data }) => {
      const totalResto = data.total_resto;
      const totalDonation = data.total_donation;
      const todayDonation = data.today_donation;
      const totalReceiver = data.total_receiver;
      totalDonatur.innerHTML = `
        <div class='flex'>
            <span>👤</span>
            Total Donatur<br><strong>${totalResto}</strong></div>`
      totalRestoran.innerHTML = `
        <div class='flex'>
            <span>🍽</span>
            Total Restoran<br><strong>${totalResto}</strong></div>`
      totalPenerima.innerHTML = `
        <div class='flex'>
            <span>⬇</span>
            Total Penerima<br><strong>${totalReceiver}</strong></div>`
      totalMakanan.innerHTML = `
        <div class='flex'>
            <span>🍱</span>
            Total Donasi Makanan<br><strong>${totalDonation}</strong></div>`
      donasiHarian.innerHTML = `
             <h3>Donasi Harian</h3>
            <p style="font-size: 24px; font-weight: bold;">${todayDonation} pcs</p>
            <p>{{ \Carbon\Carbon::now()->format('d F Y') }}</p>
        `
    })

    fetch('/api/restos/all', {
      headers: {
        "Authorization": `Bearer ${localStorage.getItem("accessToken")}`
      }
    }).then(response => response.json()).then(({ data }) => {
      restoranCard.innerHTML = ``;
      console.log({ data });
      data.map(restos => {
        restoranCard.innerHTML += `
        <div class="restoran-card">
        <div class="restoran-info">
          <h4>${restos.name}</h4>
          <div class="flex flex-wrap gap-2 mt-1 text-xs">
                    <span class="bg-[#317873] px-2 py-1 rounded">Makanan</span>
                    <span class="bg-[#317873] px-2 py-1 rounded">Minuman</span>
                </div>
          <a style="text-decoration: none;" href="/resto/comment/${restos.id}">
          <div class="stats">
                <p class="mt-2 text-sm text-gray-200">${restos.likes_count} Likes · ${restos.comments_count} comments</p>
          </div>
          </a>
          <button type="button" id="request-donasi" class="request-btn" style="cursor: pointer; display: inline-block; margin-top: 10px; background-color: #ffb703; color: #333; padding: 5px 10px; border-radius: 5px; font-weight: bold;" onclick="requestDonation(${restos.id})">
            Request Donasi
        </button>
        </div>
      </div>
        `
      })
    })

    function requestDonation(id) {
      window.location.href = `http://localhost:8000/receiver/request/${id}`
    }

    fetch("/api/notifications", {
      headers: {
        Authorization: `Bearer ${localStorage.getItem("accessToken")}`
      }
    }).then(response => response.json())
      .then(notification => {
        console.log({ notification })
        console.log(localStorage.getItem("accessToken"))
      }).catch(err => console.log({ err }))

    function toggleDropdown() {
      const dropdown = document.getElementById('userDropdown');
      dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    document.addEventListener('click', function (event) {
      const dropdown = document.getElementById('userDropdown');
      const button = event.target.closest('button');
      if (!dropdown.contains(event.target) && !button) {
        dropdown.style.display = 'none';
      }
    });

    const logoutButtonElement = document.getElementById("logout-button");
    logoutButtonElement.addEventListener("click", async e => {
      e.preventDefault();
      console.log("clicked");
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
        alert(err.message);
      }
    })
  </script>
</body>

</html>