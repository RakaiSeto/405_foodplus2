<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - FOOD+</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body class="bg-white font-sans text-gray-800">
  <div class="flex min-h-screen flex-col">
    <!-- Header -->
    <header class="bg-white p-4 flex justify-between items-center border-b">

      <div>
        <h2 class="text-xl font-semibold">FOOD+</h2>
      </div>
      <a href="{{ route('login') }}" class="bg-[#317873] text-white px-4 py-2 rounded">Login</a>
    </header>

    <!-- Main Content -->
    <div class="flex-1 p-6 max-w-[1200px] mx-auto w-full">

      <!-- Welcome Section -->
      <div class="bg-[#4E9A9A] text-white rounded-xl p-6 mb-6">
        <h1 class="text-3xl font-bold mb-2">Selamat Datang!</h1>
        <p class="text-lg mb-4">
          Terima kasih telah melihat platform Food+. Anda dapat mendonasikan makanan untuk membantu mereka yang membutuhkan loh. yukk ikut serta!
        </p>
        <a href="{{ route('login') }}" class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold py-2 px-4 rounded">
        Donasi Sekarang
        </a>
      </div>

      <!-- Sub Heading -->
      <h3 class="text-xl font-semibold mb-4">Restoran</h3>

      <!-- Stat Boxes -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
      <div class="bg-[#4E9A9A] p-4 rounded flex items-center space-x-4 text-white">
          <img src="https://img.icons8.com/ios-filled/50/ffffff/restaurant.png" class="w-8 h-8" />
          <div>
            <p class="font-bold text-sm">Total Restoran</p>
            <p class="text-xl font-bold" id="total-restoran">0</p>
          </div>
        </div>
        <div class="bg-[#C5F0EA] p-4 rounded flex items-center space-x-4">
          <img src="https://img.icons8.com/ios-filled/50/000000/meal.png" class="w-8 h-8" />
          <div>
            <p class="font-bold text-sm">Total Makanan Tersedia</p>
            <p class="text-xl font-bold" id="total-makanan">0</p>
          </div>
        </div>
      </div>

 <!-- Grid Restoran -->

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="donation-container">
      </div>
    </div>
  </div>

  <script>
    const donationContainer = document.getElementById("donation-container");
    const donations =fetch("http://localhost:8000/api/donations", {method: "GET"}).then(value => value.json()).then(({data}) => {
        console.log({data});
        donationContainer.innerHTML = "";
        if(!data.length){
            donationContainer.innerHTML = `
                <h1>Data belum ada</h1>
            `
            return;
        }

        const totalMakanan = document.getElementById("total-makanan");
        const totalRestoran= document.getElementById("total-restoran");
            fetch("/api/statistics/receiver/dashboard/summary", {method: "GET"}).then(response => response.json()).then(({data}) => {
        const totalResto = data.total_resto;
        const totalDonation = data.total_donation;
        totalMakanan.textContent = totalDonation;
        totalRestoran.textContent = totalResto;
    })


        data.forEach(resto => {
            console.log({resto});
            const imageUrl = `http://localhost:8000/storage/${resto.image_url}`;
            const item = `
            <div class="bg-[#4E9A9A] p-4 rounded text-white flex items-start space-x-4">
              <img src="${imageUrl}"  class="w-12 h-12 rounded" />
              <div>
                <h4 class="font-bold text-lg">${resto.food_name} - ${resto.user.name}</h4>

                <div class="flex flex-wrap gap-2 mt-1 text-xs">
                    <span class="bg-[#317873] px-2 py-1 rounded">${resto.category}</span>
                </div>
                    <p class="mt-2 text-sm text-gray-200">302,624 Views ·  3000 Likes · 400 comments</p>
              </div>
            </div>
            `
            donationContainer.innerHTML += item;
        })
    })
  </script>
</body>
</html>
