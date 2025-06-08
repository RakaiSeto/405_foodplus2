<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Donasi - FOOD+</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
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
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
        <div class="flex items-center gap-2">
            <div class="notification">🔔</div>
            <form method="POST" action="/logout">
                @csrf
                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md cursor-pointer hover:bg-blue-700"
                    id="logout-button">Log Out</button>
            </form>
        </div>
    </div>

    <button class="bg-blue-500 text-white px-4 py-2 rounded-md cursor-pointer hover:bg-blue-700 mb-4 hidden"
        id="subscribe-button" onclick="subscribe(event)">Subscribe</button>
    <div class="food-grid" id="foodContainer">
    </div>

    @push('scripts')
        <script>
            let restoId = window.location.pathname.split("/")[3];

            let foodItems = [];

            fetch(`http://localhost:8000/api/subscriptions/${restoId}`, {
                method: "GET",
                headers: {
                    Authorization: `Bearer ${localStorage.getItem("accessToken")}`,
                }
            }).then(response => response.json()).then(val => {
                if (val.data == true) {
                    document.getElementById("subscribe-button").innerHTML = "Unsubscribe";
                    document.getElementById("subscribe-button").classList.add("bg-red-500");
                    document.getElementById("subscribe-button").classList.add("hover:bg-red-700");
                    document.getElementById("subscribe-button").classList.remove("bg-blue-500");
                    document.getElementById("subscribe-button").classList.remove("hover:bg-blue-700");
                } else {
                    document.getElementById("subscribe-button").innerHTML = "Subscribe";
                    document.getElementById("subscribe-button").classList.remove("bg-red-500");
                    document.getElementById("subscribe-button").classList.remove("hover:bg-red-700");
                    document.getElementById("subscribe-button").classList.add("bg-blue-500");
                    document.getElementById("subscribe-button").classList.add("hover:bg-blue-700");
                }
                document.getElementById("subscribe-button").classList.remove("hidden");
            })

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
                                            <img src="${food.image_url}" alt="${food.name}" class="food-image">
                                            <h3 class="food-name">${food.name}</h3>
                                            <p class="available-text">Jumlah yang tersedia: ${food.available}</p>
                                            <input type="text" class="input-quantity" placeholder="Masukkan Jumlah Yang Kamu Mau" id="quantity-${food.name}">
                                            <p class="items-text">X1 items</p>
                                            <div class="action-buttons">
                                                <a class="btn btn-cancel" href="/receive/dashboard">×</a>
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


            async function subscribe() {
                console.log("subscribe ke resto", restoId)
                await fetch(`http://localhost:8000/api/donations/${restoId}/subscribe`, {
                    method: "GET",
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem("accessToken")}`,
                    }
                }).then(response => response.json()).then(val => {
                    alert(val.status)
                })
                    .catch(err => console.log({ err }))

                window.location.reload();
            }

            function confirmRequest(donationId) {
                const input = document.getElementById(`quantity-${donationId}`);
                const quantity = parseInt(input.value);
                console.log({ quantity });

                if (!quantity || quantity < 1) {
                    alert('Mohon masukkan jumlah yang valid');
                    return;
                }

                if (quantity > document.getElementById(`available-${donationId}`).value) {
                    alert(`Jumlah melebihi stok yang tersedia (${document.getElementById(`available-${donationId}`).value})`);
                    return;
                }

                fetch(`http://localhost:8000/api/donations/${donationId}/requests`, {
                    method: "POST",
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem("accessToken")}`,
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        quantity: input.value,
                        donation_id: donationId,
                        donor_id: document.getElementById(`donor-id-${donationId}`).value
                    })
                }).then(response => response.json()).then(val => {
                    alert(val.message)
                    window.location.reload();
                })
                    .catch(err => console.log({ err }))
            }

            const path = window.location.pathname;
            const segments = path.split("/");
            const foodContainer = document.getElementById("foodContainer");

            fetch(`http://localhost:8000/api/donations/${+segments[3]}`).then(response => response.json()).then(({ data: donation }) => {
                donation.forEach(element => {
                    console.log({ element })
                    foodContainer.innerHTML += `
                                     <div class="food-card">
                                            <img src="/storage/${element.image_url}" alt="${element.food_name}" class="food-image">
                                            <h3 class="food-name">${element.food_name}</h3>
                                            <input type="hidden" id="donor-id-${element.id}" value="${element.user_id}">
                                            <input type="hidden" id="available-${element.id}" value="${element.quantity}">
                                            <p class="available-text">Jumlah yang tersedia: ${element.quantity}</p>
                                            <input type="text" class="input-quantity" placeholder="Masukkan Jumlah Yang Kamu Mau" id="quantity-${element.id}">
                                            <p class="items-text" id="item-text">X1 items</p>
                                            <div class="action-buttons">
                                                <a class="btn btn-cancel" href="/receive/dashboard">×</a>
                                                <button class="btn btn-confirm" onclick="confirmRequest(${element.id})">✓</button>
                                            </div>
                                        </div>
                                    `
                    const quantityButton = document.getElementById(`quantity-${element.id}`);
                    const itemText = document.getElementById("item-text");
                    quantityButton.addEventListener("input", (event) => {
                        const value = event.target.value;
                        itemText.textContent = `X${value} items`;
                    })
                });
                console.log({ donation })
            })
        </script>
    @endpush

    @stack('scripts')
</body>

</html>