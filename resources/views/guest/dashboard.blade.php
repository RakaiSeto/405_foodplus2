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
            <p class="text-xl font-bold">18</p>
          </div>
        </div>
        <div class="bg-[#C5F0EA] p-4 rounded flex items-center space-x-4">
          <img src="https://img.icons8.com/ios-filled/50/000000/meal.png" class="w-8 h-8" />
          <div>
            <p class="font-bold text-sm">Total Makanan Tersedia</p>
            <p class="text-xl font-bold">13</p>
          </div>
        </div>
      </div>

 <!-- Grid Restoran -->
 @php
        $restoranData = [
          ['nama' => 'Gacoan', 'tags' => ['Makanan', 'Cepat Saji', 'Mie'], 'views' => '302,624', 'likes' => '30,208', 'comments' => '33'],
          ['nama' => 'Wings O Wings', 'tags' => ['Makanan', 'Ayam', 'Aneka Ragam'], 'views' => '431,204', 'likes' => '36,650', 'comments' => '38'],
          ['nama' => 'KFC', 'tags' => ['Restoran', 'Ayam', 'Legend'], 'views' => '511,624', 'likes' => '56,650', 'comments' => '50'],
          ['nama' => 'Hokben', 'tags' => ['Makanan', 'Jepang', 'Cepat Saji'], 'views' => '204,504', 'likes' => '10,023', 'comments' => '101'],
          ['nama' => 'Martabak Pecenongan', 'tags' => ['Enak', 'Martabak', 'Manis & Asin'], 'views' => '243,504', 'likes' => '20,120', 'comments' => '108'],
          ['nama' => 'Ayam Koplo', 'tags' => ['Ayam', 'Murah', 'Cepat Saji'], 'views' => '341,624', 'likes' => '23,340', 'comments' => '244'],
          ['nama' => 'Solaria', 'tags' => ['Makanan', 'Restoran', 'Terjamin'], 'views' => '101,650', 'likes' => '26,743', 'comments' => '209'],
          ['nama' => 'Ayam Crisbar', 'tags' => ['Ayam', 'Cepat Saji', 'Murah'], 'views' => '401,956', 'likes' => '24,753', 'comments' => '269'],
          ['nama' => 'Mang Katsu', 'tags' => ['Ayam', 'Cepat Saji', 'Murah'], 'views' => '601,956', 'likes' => '34,753', 'comments' => '350'],
          ['nama' => 'Pizza Hut', 'tags' => ['Makanan', 'Cepat Saji', 'Pizza'], 'views' => '324,568', 'likes' => '34,856', 'comments' => '56'],
          ['nama' => 'Taco Bell', 'tags' => ['Makanan', 'Cepat Saji', 'Aneka Ragam'], 'views' => '423,234', 'likes' => '130,456', 'comments' => '22'],
          ['nama' => 'Sushi TEI', 'tags' => ['Restoran', 'Jepang', 'Fresh'], 'views' => '451,234', 'likes' => '45,200', 'comments' => '56'],
          ['nama' => 'Kopi Kenangan', 'tags' => ['Minuman', 'Kopi', 'Cepat Saji'], 'views' => '234,504', 'likes' => '13,301', 'comments' => '184'],
          ['nama' => 'Burger King', 'tags' => ['Makanan', 'Cepat Saji', 'Restoran'], 'views' => '242,634', 'likes' => '23,450', 'comments' => '134'],
          ['nama' => 'Starbucks', 'tags' => ['Minuman', 'Enak', 'Culture'], 'views' => '242,634', 'likes' => '15,920', 'comments' => '158'],
          ['nama' => 'Tuku', 'tags' => ['Minuman', 'Kopi', 'Enak'], 'views' => '473,956', 'likes' => '24,753', 'comments' => '295'],
          ['nama' => 'Point Coffee', 'tags' => ['Minuman', 'Aneka Ragam', 'Murah'], 'views' => '333,956', 'likes' => '24,753', 'comments' => '203'],
          ['nama' => 'J.CO', 'tags' => ['Donat', 'Manis & Asin', 'Makanan'], 'views' => '357,845', 'likes' => '24,753', 'comments' => '195'],
        ];

        // Bagi data menjadi 3 kolom
        $chunk = ceil(count($restoranData) / 3);
        $column1 = array_slice($restoranData, 0, $chunk);
        $column2 = array_slice($restoranData, $chunk, $chunk);
        $column3 = array_slice($restoranData, $chunk * 2);
      @endphp

      <!-- Grid layout -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="donation-container">
        <!-- Kolom 1 -->
        {{-- <div class="space-y-4">
          @foreach ($column1 as $resto)
            <div class="bg-[#4E9A9A] p-4 rounded text-white flex items-start space-x-4">
              <img src="{{ asset('images/restaurant-logo.png') }}" onerror="this.src='https://via.placeholder.com/50'" class="w-12 h-12 rounded" />
              <div>
                <h4 class="font-bold text-lg">{{ $resto['nama'] }}</h4>
                <div class="flex flex-wrap gap-2 mt-1 text-xs">
                  @foreach ($resto['tags'] as $tag)
                    <span class="bg-[#317873] px-2 py-1 rounded">{{ $tag }}</span>
                  @endforeach
                </div>
                <p class="mt-2 text-sm text-gray-200">{{ $resto['views'] }} Views · {{ $resto['likes'] }} Likes · {{ $resto['comments'] }} comments</p>
              </div>
            </div>
          @endforeach
        </div> --}}

        <!-- Kolom 2 -->
        {{-- <div class="space-y-4">
          @foreach ($column2 as $resto)
            <div class="bg-[#4E9A9A] p-4 rounded text-white flex items-start space-x-4">
              <img src="{{ asset('images/restaurant-logo.png') }}" onerror="this.src='https://via.placeholder.com/50'" class="w-12 h-12 rounded" />
              <div>
                <h4 class="font-bold text-lg">{{ $resto['nama'] }}</h4>
                <div class="flex flex-wrap gap-2 mt-1 text-xs">
                  @foreach ($resto['tags'] as $tag)
                    <span class="bg-[#317873] px-2 py-1 rounded">{{ $tag }}</span>
                  @endforeach
                </div>
                <p class="mt-2 text-sm text-gray-200">{{ $resto['views'] }} Views · {{ $resto['likes'] }} Likes · {{ $resto['comments'] }} comments</p>
              </div>
            </div>
          @endforeach
        </div> --}}

        <!-- Kolom 3 -->
        {{-- <div class="space-y-4">
          @foreach ($column3 as $resto)
            <div class="bg-[#4E9A9A] p-4 rounded text-white flex items-start space-x-4">
              <img src="{{ asset('images/restaurant-logo.png') }}" onerror="this.src='https://via.placeholder.com/50'" class="w-12 h-12 rounded" />
              <div>
                <h4 class="font-bold text-lg">{{ $resto['nama'] }}</h4>
                <div class="flex flex-wrap gap-2 mt-1 text-xs">
                  @foreach ($resto['tags'] as $tag)
                    <span class="bg-[#317873] px-2 py-1 rounded">{{ $tag }}</span>
                  @endforeach
                </div>
                <p class="mt-2 text-sm text-gray-200">{{ $resto['views'] }} Views · {{ $resto['likes'] }} Likes · {{ $resto['comments'] }} comments</p>
              </div>
            </div>
          @endforeach
        </div> --}}
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
        data.forEach(resto => {
            console.log({resto});
            const item = `
            <div class="bg-[#4E9A9A] p-4 rounded text-white flex items-start space-x-4">
              <img src="data:image/png;base64,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"  class="w-12 h-12 rounded" />
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
