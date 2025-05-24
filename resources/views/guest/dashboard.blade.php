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
