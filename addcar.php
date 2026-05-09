<?php
session_start();
if (!isset($_SESSION['seller_id'])) {
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "car_sales");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $model = $_POST['model'];
    $year = $_POST['year'];
    $color = $_POST['color'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $seller_id = $_SESSION['seller_id'];

    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    $sql = "INSERT INTO cars (model, year, color, location, price, image, seller_id)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sissssi", $model, $year, $color, $location, $price, $image, $seller_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Published successfully！'); location.href='addcar.php';</script>";
    } else {
        echo "<script>alert('Release failed');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Car - Online Car Sale</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('porsche.png.png') no-repeat center center fixed;
            background-size: cover;
            color: #333;
            min-height: 100vh;
        }

        .site-header {
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 1rem 0;
            backdrop-filter: blur(5px);
        }
        
        .site-logo {
             height: 80px;
             width: auto;
             display: block;
        }

        .header-container {
            max-width: 95%;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between; 
            align-items: center;
        }

        .logo-container {
             margin-left: 10;
        }

        .container {
            max-width: 95%;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: flex-start; 
            align-items: center;
            min-height: calc(100vh - 80px);
        }

        .form-wrapper {
            background: rgba(255, 255, 255, 0.15); 
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            padding: 40px;
            border-radius: 15px;
            width: 100%;
            max-width: 500px;
            margin: 20px 0;
        }
        
        h2 { 
            margin-bottom: 10px; 
            color: #ffffff;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .subtitle { 
            margin-bottom: 30px; 
            color: #e0e0e0;
        }
        
        label { 
            margin-bottom: 8px; 
            font-weight: 600; 
            font-size: 0.85rem; 
            color: #ffffff; 
        }
        
        input {
            padding: 12px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.8);
            outline: none;
            transition: all 0.3s;
        }

        h2 { margin-bottom: 10px; color: #1a1a1a; }
        .subtitle { margin-bottom: 30px; color: #666; font-size: 0.9rem; }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group { display: flex; flex-direction: column; }
        .full-width { grid-column: span 2; }

        label { margin-bottom: 8px; font-weight: 600; font-size: 0.85rem; }
        input {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            outline: none;
            transition: border-color 0.3s;
        }
        input:focus { border-color: #007bff; }

        .file-upload-box {
            border: 2px dashed #bbb;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            background: #f9f9f9;
            cursor: pointer;
        }

        .form-actions {
            margin-top: 30px;
            display: flex;
            gap: 15px;
        }

        .btn-primary {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            flex: 2;
        }

        .btn-secondary {
            background: #eee;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            flex: 1;
        }

        nav a { 
            color: #fff; 
            text-decoration: none; 
            font-size: 2rem; 
            font-weight: 800;
            margin-left: 40px; 
            transition: color 0.3s;
            text-transform: uppercase;
        }
        nav a:hover { text-decoration: underline; }
        
        @media (max-width: 768px) {
            .container { justify-content: center; }
            .form-grid { grid-template-columns: 1fr; }
            .full-width { grid-column: span 1; }
        }
    </style>
</head>
<script>
    const form = document.getElementById('addCarForm');
    const imageInput = document.getElementById('image');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const previewBox = document.querySelector('.file-upload-box');
                previewBox.style.backgroundImage = `url(${event.target.result})`;
                previewBox.style.backgroundSize = 'cover';
                previewBox.querySelector('.upload-hint').style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    });

    form.addEventListener('submit', function(e) {
        const year = document.getElementById('year').value;
        const currentYear = new Date().getFullYear();
        if (year > currentYear + 1) {
            alert('Please enter a valid manufacturing year.');
            e.preventDefault();
        }
    });
</script>
<body>
<header class="site-header">
    <div class="header-container">
        <div style="display: flex; align-items: center; gap: 12px;">
            <a href="home.html" class="logo-container">
                <img src="logo.png" alt="RedCar Logo" class="site-logo">
            </a>
            <?php if(isset($_SESSION['username'])): ?>
                <span style="color:#fff; font-weight:bold; font-size:16px;">
                    Welcome, <?= $_SESSION['username'] ?> <a href="logout.php" style="color:#fff; margin-left:8px; font-size:14px; text-decoration:none;">Logout</a>
                </span>
            <?php endif; ?>
        </div>

        <nav class="nav-menu">
            <a href="home.php">Home</a>
            <a href="search.php">Search</a>
            <a href="registration.php">Register</a>
            <a href="login.php">Login</a>
        </nav>
    </div>
</header>

    <main class="container" style="min-height: auto; justify-content: space-between;" >
        <section class="form-wrapper">
            <h2>List Your Vehicle</h2>
            <p class="subtitle">Provide details to help buyers find your car quickly.</p>
            
            <form id="addCarForm" action="#" method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="model">Car Model</label>
                        <input type="text" id="model" name="model" placeholder="e.g. Porsche 718" required>
                    </div>

                    <div class="form-group">
                        <label for="year">Manufacturing Year</label>
                        <input type="number" id="year" name="year" placeholder="2024" min="1900" max="2026" required>
                    </div>

                    <div class="form-group">
                        <label for="color">Exterior Colour</label>
                        <input type="text" id="color" name="color" placeholder="Racing Yellow" required>
                    </div>

                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" id="location" name="location" placeholder="Beijing" required>
                    </div>

                    <div class="form-group full-width">
                        <label for="price">Price (¥)</label>
                        <input type="number" id="price" name="price" placeholder="Enter amount" min="0" required>
                    </div>

                    <div class="form-group full-width upload-group">
                        <label for="image">Car Image</label>
                        <div class="file-upload-box">
                            <input type="file" id="image" name="image" accept="image/png, image/jpeg" required>
                            <p class="upload-hint" style="font-size: 0.8rem; color: #777; margin-top: 5px;">Click to upload (JPG/PNG)</p>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">Confirm & Publish</button>
                    <button type="reset" class="btn-secondary">Reset</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>