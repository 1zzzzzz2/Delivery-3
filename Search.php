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
    <div style="display: flex; align-items: center; gap: 12px;">
        <img src="logo.png" alt="Car Sales Logo" class="logo">
        <?php if(isset($_SESSION['username'])): ?>
            <span style="color: #0066cc; font-weight: bold; font-size: 15px;">
                Welcome, <?= $_SESSION['username'] ?> <a href="logout.php" style="margin-left:8px;color:#0066cc;font-size:14px;text-decoration:none;">Logout</a>
            </span>
        <?php endif; ?>
    </div>

    <div class="nav-links">
        <a href="home.php">Home</a>
        <a href="registration.php">Registration</a>
        <a href="login.php">Login</a>
        <a href="addcar.php">Add Car</a>
        <a href="search.php">Search</a>
    </div>
</div>

    <div class="search-wrapper">
        <div class="search-container">
            <h2>Find Your Car</h2>
            <p class="subtitle">Search vehicles by model and year</p>

            <form id="searchForm" action="search.php" method="get">
                <div class="form-row">
                    <div class="form-group">
                        <label>Car Model</label>
                        <input type="text" name="model" placeholder="e.g. Toyota, BMW, Honda" required>
                    </div>
                    <div class="form-group">
                        <label>Year</label>
                        <input type="number" name="year" placeholder="e.g. 2020" min="2000" max="2026" required>
                    </div>
                </div>
                <button type="submit" class="search-btn">Search Cars</button>
            </form>

            <div class="results" id="results">
                <h3>Cars For Sale</h3>
                <div id="carList">
                    <?php foreach ($cars as $car): ?>
                    <div class="car-item">
                        <img src="uploads/<?= $car['image'] ?>" class="car-image">
                        <div class="car-detail">
                            <h4><?= $car['model'] ?></h4>
                            <div class="car-info">
                                Year: <?= $car['year'] ?><br>
                                Color: <?= $car['color'] ?><br>
                                Price: <?= $car['price'] ?><br>
                                Location: <?= $car['location'] ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <?php if (empty($cars)): ?>
                    <p>No cars found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <footer>
        © 2026 Premium Car Sales Platform | All Rights Reserved
    </footer>
</body>
</html>