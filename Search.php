<?php
session_start(); 
$conn = mysqli_connect("localhost", "root", "", "car_sales");

$model = $_GET['model'] ?? '';
$year = $_GET['year'] ?? '';

$sql = "SELECT * FROM cars WHERE 1=1";
if ($model) $sql .= " AND model LIKE '%$model%'";
if ($year) $sql .= " AND year = '$year'";

$result = mysqli_query($conn, $sql);
$cars = [];
while ($row = mysqli_fetch_assoc($result)) $cars[] = $row;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Sales - Search</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            background-image: url('background1.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 18px 40px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .logo {
            height: 45px;
        }

        .nav-links a {
            margin: 0 18px;
            text-decoration: none;
            color: #222;
            font-weight: 500;
            font-size: 15px;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: #0066cc;
        }

        .search-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .search-container {
            max-width: 600px;
            width: 100%;
            background: rgba(255, 255, 255, 0.221);
            backdrop-filter: blur(12px);
            padding: 50px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.3);
        }

        .search-container h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #1a1a1a;
            font-size: 28px;
        }

        .subtitle {
            text-align: center;
            color: #222;
            font-weight: 500;
            margin-bottom: 40px;
            font-size: 16px;
        }

        .form-row {
            display: flex;
            gap: 16px;
            margin-bottom: 24px;
        }

        .form-group {
            flex: 1;
            margin-bottom: 24px;
        }

        .form-row .form-group {
            margin-bottom: 0;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 500;
            color: #222;
        }

        input, select {
            width: 100%;
            padding: 14px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 15px;
            background: rgba(255,255,255,0.8);
            transition: all 0.3s ease;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #0066cc;
            box-shadow: 0 0 0 3px rgba(0,102,204,0.15);
        }

        .search-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #0066cc, #0088ff);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0,102,204,0.2);
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0,102,204,0.3);
        }

        .search-btn:active {
            transform: translateY(0);
        }

        .results {
            margin-top: 40px;
        }

        .results h3 {
            font-size: 20px;
            margin-bottom: 20px;
            color: #222;
        }

        .car-item {
            background: rgba(255,255,255,0.8);
            backdrop-filter: blur(4px);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .car-image {
            width: 120px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }

        .car-detail {
            flex: 1;
        }

        .car-detail h4 {
            color: #0066cc;
            margin-bottom: 8px;
        }

        .car-info {
            color: #333;
            font-size: 14px;
            line-height: 1.4;
        }

        footer {
            text-align: center;
            padding: 22px;
            color: #222;
            font-size: 14px;
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(10px);
        }

        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 12px;
                padding: 18px 20px;
            }
            .nav-links a {
                margin: 0 10px;
                font-size: 14px;
            }
            .form-row {
                flex-direction: column;
                gap: 20px;
            }
            .search-container {
                padding: 35px 25px;
            }
            .car-item {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <img src="logo.png" alt="Car Sales Logo" class="logo">
        <div class="nav-links">
            <a href="home.html">Home</a>
            <a href="registration.html">Registration</a>
            <a href="login.html">Login</a>
            <a href="addcar.html">Add Car</a>
            <a href="search.html">Search</a>
        </div>
    </div>

    <div class="search-wrapper">
        <div class="search-container">
            <h2>Find Your Car</h2>
            <p class="subtitle">Search vehicles by model and year</p>

            <form id="searchForm">
                <div class="form-row">
                    <div class="form-group">
                        <label>Car Model</label>
                        <input type="text" id="model" placeholder="e.g. Toyota, BMW, Honda" required>
                    </div>
                    <div class="form-group">
                        <label>Year</label>
                        <input type="number" id="year" placeholder="e.g. 2020" min="2000" max="2026" required>
                    </div>
                </div>
                <button type="submit" class="search-btn">Search Cars</button>
            </form>

            <div class="results" id="results">
                <h3>Cars For Sale</h3>
                <div id="carList"></div>
            </div>
        </div>
    </div>

    <footer>
        © 2026 Premium Car Sales Platform | All Rights Reserved
    </footer>

    <script>
        const cars = [
            {
                model: "Mercedes-Benz S-Class",
                year: 2023,
                color: "Silver",
                price: "$110,000",
                location: "Beijing",
                image: "Mercedes-Benz S-Class.jpg"
            },
            {
                model: "Porsche 911",
                year: 2022,
                color: "White",
                price: "$120,000",
                location: "Shanghai",
                image: "Porsche 911.jpg"
            },
            {
                model: "Audi A4",
                year: 2023,
                color: "White",
                price: "$38,000",
                location: "Guangzhou",
                image: "Audi A4.jpg"
            },
            {
                model: "Audi A6",
                year: 2022,
                color: "Black",
                price: "$55,000",
                location: "Shenzhen",
                image: "Audi A6.jpg"
            },
            {
                model: "Toyota Camry",
                year: 2024,
                color: "Silver",
                price: "$30,000",
                location: "Hangzhou",
                image: "Camry.jpg"
            },
            {
                model: "Honda Civic",
                year: 2021,
                color: "Yellow",
                price: "$25,000",
                location: "Chengdu",
                image: "Civic.jpg"
            }
        ];

        const carList = document.getElementById("carList");
        const form = document.getElementById("searchForm");

        window.addEventListener("load", function() {
            showCars(cars);
        });

        form.addEventListener("submit", function (e) {
            e.preventDefault();
            const model = document.getElementById("model").value.toLowerCase();
            const year = parseInt(document.getElementById("year").value);

            const filtered = cars.filter(car =>
                car.model.toLowerCase().includes(model) && car.year === year
            );
            showCars(filtered);
        });

        function showCars(carArray) {
            carList.innerHTML = "";
            if (carArray.length === 0) {
                carList.innerHTML = `<p style="color:#333;">No cars found for your search.</p>`;
            } else {
                carArray.forEach(car => {
                    const div = document.createElement("div");
                    div.className = "car-item";
                    div.innerHTML = `
                        <img src="${car.image}" class="car-image" alt="${car.model}">
                        <div class="car-detail">
                            <h4>${car.model}</h4>
                            <div class="car-info">
                                Year: ${car.year}<br>
                                Color: ${car.color}<br>
                                Price: ${car.price}<br>
                                Location: ${car.location}
                            </div>
                        </div>
                    `;
                    carList.appendChild(div);
                });
            }
        }
    </script>
</body>
</html>