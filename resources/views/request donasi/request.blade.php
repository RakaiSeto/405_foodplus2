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

        let foodItems = [];

        // function initializePage() {
        //     const container = document.getElementById('foodContainer');
        //     const urlParams = new URLSearchParams(window.location.search);
        //     const restoranNama = urlParams.get('restoran') || 'KFC';
        //     document.getElementById('restoranNama').textContent = restoranNama;

        //     foodItems = foodDatabase[restoranNama] || [];
        //     const foodCards = foodItems.map(food => createFoodCard(food)).join('');
        //     container.innerHTML = foodCards;
        // }

        function createFoodCard(food) {
            return `
                <div class="food-card">
                    <img src="${food.image}" alt="${food.name}" class="food-image">
                    <h3 class="food-name">${food.name}</h3>
                    <p class="available-text">Jumlah yang tersedia: ${food.available}</p>
                    <input type="text" class="input-quantity" placeholder="Masukkan Jumlah Yang Kamu Mau" id="quantity-${food.name}">
                    <p class="items-text">X1 items</p>
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

        let fetchedDonation = null;

        function confirmRequest(donation) {
            console.log({fetchedDonation})
            const input = document.getElementById(`quantity-${fetchedDonation.food_name}`);
            const quantity = parseInt(input.value);
            console.log({quantity});

            if (!quantity || quantity < 1) {
                alert('Mohon masukkan jumlah yang valid');
                return;
            }

            if (quantity > fetchedDonation.quantity) {
                alert(`Jumlah melebihi stok yang tersedia (${fetchedDonation.quantity})`);
                return;
            }

            fetch(`http://localhost:8000/api/donations/${fetchedDonation.id}/requests`, {
                method: "POST",
                headers: {
                    Authorization: `Bearer ${localStorage.getItem("accessToken")}`,
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    quantity: input.value
                })
            }).then(response => response.json()).then(val => {alert(val.message)
                window.location.href = "http://localhost:8000/receive/dashboard"
            })
            .catch(err => console.log({err}))
        }

        const path = window.location.pathname;
        const segments = path.split("/");
        const foodContainer = document.getElementById("foodContainer");

        fetch(`http://localhost:8000/api/donations/${+segments[3]}`).then(response => response.json()).then(({data: donation}) => {
            fetchedDonation = donation
            const jsonDonation = JSON.stringify(donation)
            foodContainer.innerHTML += `
             <div class="food-card">
                    <img src="" alt="" class="food-image">
                    <h3 class="food-name">${donation.food_name}</h3>
                    <p class="available-text">Jumlah yang tersedia: ${donation.quantity}</p>
                    <input type="text" class="input-quantity" placeholder="Masukkan Jumlah Yang Kamu Mau" id="quantity-${donation.food_name}">
                    <p class="items-text" id="item-text">X1 items</p>
                    <div class="action-buttons">
                        <button class="btn btn-cancel" onclick="cancelRequest(${donation.id})">×</button>
                        <button class="btn btn-confirm" onclick="confirmRequest(${donation.id})">✓</button>
                    </div>
                </div>
            `
            const quantityButton = document.getElementById(`quantity-${donation.food_name}`);
            const itemText = document.getElementById("item-text");
            quantityButton.addEventListener("input", (event) => {
                const value = event.target.value;
                itemText.textContent = `X${value} items`;
            })
            console.log({donation})
        });
    </script>
    @endpush

    @stack('scripts')
</body>
</html>
