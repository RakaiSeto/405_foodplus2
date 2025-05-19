<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Donasi - FOOD+</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            padding: 20px;
            background: #f5f5f5;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .food-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .food-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .food-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
            background: #f5f5f5;
        }

        .input-quantity {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background: #f5f5f5;
            font-family: 'Poppins', sans-serif;
        }

        .food-name {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .available-text {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .items-text {
            font-size: 14px;
            color: #666;
            margin: 10px 0;
        }

        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 10px;
        }

        .btn {
            width: 35px;
            height: 35px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .btn-cancel {
            background: #FFE8E8;
            color: #FF4444;
            border: 1px solid #FFD1D1;
        }

        .btn-confirm {
            background: #E8F8F6;
            color: #70B9B0;
            border: 1px solid #D1F1ED;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Request Donasi - <span id="restoranNama">Restoran</span></h1>
        <div class="notification">🔔</div>
    </div>

    <div class="food-grid" id="foodContainer">
        <!-- Food cards will be generated here -->
    </div>

    @push('scripts')
    <script>
        const foodDatabase = {!! json_encode([
            "KFC" => [
                ["name" => "Paha Atas", "image" => asset("assets/images/food/paha-atas.jpg"), "available" => 13],
                ["name" => "Paha Bawah", "image" => asset("assets/images/food/paha-bawah.jpg"), "available" => 2],
                ["name" => "Dada", "image" => asset("assets/images/food/dada.jpg"), "available" => 4],
                ["name" => "Kentang Goreng", "image" => asset("assets/images/food/kentang.jpg"), "available" => 13],
                ["name" => "Cream Soup", "image" => asset("assets/images/food/soup.jpg"), "available" => 1],
                ["name" => "Chicken Wing", "image" => asset("assets/images/food/wing.jpg"), "available" => 10],
            ],
            // Tambahkan data restoran lain sesuai kebutuhan...
        ]) !!};

        let foodItems = [];

        function initializePage() {
            const container = document.getElementById('foodContainer');
            const urlParams = new URLSearchParams(window.location.search);
            const restoranNama = urlParams.get('restoran') || 'KFC';
            document.getElementById('restoranNama').textContent = restoranNama;

            foodItems = foodDatabase[restoranNama] || [];
            const foodCards = foodItems.map(food => createFoodCard(food)).join('');
            container.innerHTML = foodCards;
        }

        function createFoodCard(food) {
            return `
                <div class="food-card">
                    <img src="${food.image}" alt="${food.name}" class="food-image">
                    <h3 class="food-name">${food.name}</h3>
                    <p class="available-text">Jumlah yang tersedia: ${food.available}</p>
                    <input type="text" class="input-quantity" placeholder="Masukkan Jumlah Yang Kamu Mau" id="quantity-${food.name}">
                    <p class="items-text">X2 items</p>
                    <div class="action-buttons">
                        <button class="btn btn-cancel" onclick="cancelRequest('${food.name}')">×</button>
                        <button class="btn btn-confirm" onclick="confirmRequest('${food.name}')">✓</button>
                    </div>
                </div>
            `;
        }

        function cancelRequest(foodName) {
            const input = document.getElementById(`quantity-${foodName}`);
            input.value = '';
        }

        function confirmRequest(foodName) {
            const input = document.getElementById(`quantity-${foodName}`);
            const quantity = parseInt(input.value);
            const food = foodItems.find(f => f.name === foodName);

            if (!quantity || quantity < 1) {
                alert('Mohon masukkan jumlah yang valid');
                return;
            }

            if (quantity > food.available) {
                alert(`Jumlah melebihi stok yang tersedia (${food.available})`);
                return;
            }

            alert(`Request ${quantity} ${foodName} berhasil diproses!`);
            input.value = '';
        }

        window.onload = initializePage;
    </script>
    @endpush

    @stack('scripts')
</body>
</html>
