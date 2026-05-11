<?php
session_start();

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'car_sales';

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM sellers WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['seller_id'] = $user['seller_id'];
        $_SESSION['username'] = $user['username'];
        header("Location: addcar.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Sales - Seller Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Roboto, Arial, sans-serif;
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

        .page-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .login-container {
            max-width: 460px;
            width: 100%;
            background: rgba(255, 255, 255, 0.205);
            backdrop-filter: blur(12px);
            padding: 50px 45px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.3);
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 8px;
            color: #000000;
            font-size: 26px;
        }

        .subtitle {
            text-align: center;
            color: #1a1a1a;
            margin-bottom: 35px;
            font-size: 15px;
            line-height: 1.5;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 24px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 500;
            color: #000;
        }

        input {
            width: 100%;
            padding: 14px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 15px;
            background: rgba(255,255,255,0.9);
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #0066cc;
            box-shadow: 0 0 0 3px rgba(0,102,204,0.15);
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 25px;
            font-size: 14px;
            color: #000;
        }
        .remember-me input {
            width: auto;
        }
        .remember-me label {
            margin: 0;
            font-weight: normal;
            color: #000;
        }

        button {
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

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0,102,204,0.3);
        }

        button:active {
            transform: translateY(0);
        }

        .register-prompt {
            text-align: center;
            margin-top: 25px;
            font-size: 15px;
            color: #000;
            font-weight: 500;
        }

        .register-prompt a {
            color: #0066cc;
            text-decoration: none;
            font-weight: 600;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
            color: #222;
            font-size: 13px;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #333;
        }

        .divider span {
            padding: 0 10px;
        }

        .tips {
            text-align: center;
            font-size: 13px;
            color: #000;
            font-weight: 500;
            margin-top: 10px;
            line-height: 1.5;
        }

        .error {
            color: #e53935;
            font-size: 12px;
            margin-top: 6px;
            height: 15px;
        }

        footer {
            text-align: center;
            padding: 22px;
            color: #000;
            font-weight: 500;
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
            .login-container {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>

<div class="navbar">
    <div style="display:flex; align-items:center; gap:10px;">
        <img src="logo.png" alt="Car Sales Logo" class="logo">
        <?php if(isset($_SESSION['username'])): ?>
            <span style="color:#0066cc; font-weight:bold; font-size:16px;">
                Welcome, <?= $_SESSION['username'] ?> <a href="logout.php" style="color:#0066cc; margin-left:8px; font-size:14px; text-decoration:none;">Logout</a>
            </span>
        <?php endif; ?>
    </div>
    <div class="nav-links">
        <a href="home.php">Home</a>
        <a href="registration.php">Registration</a>
        <a href="addcar.php">Add Car</a>
        <a href="search.php">Search</a>
    </div>
</div>

    <div class="page-wrapper">
        <div class="login-container">
            <h2>Seller Login</h2>
            <p class="subtitle">Welcome back to Car Sales Platform<br>Manage your vehicles safely and easily</p>

            <?php if ($error): ?>
                <p style="color:red; text-align:center; margin-bottom:15px;"><?= $error ?></p>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" required placeholder="Enter your username">
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="Enter your password">
                </div>

                <div class="remember-me">
                    <input type="checkbox" id="remember">
                    <label for="remember">Remember Me</label>
                </div>

                <button type="submit">Login Now</button>

                <div class="register-prompt">
                    Don’t have an account? <a href="registration.php">Register as Seller</a>
                </div>

                <div class="divider">
                    <span>Secure Login</span>
                </div>

                <p class="tips">
                    Your data is encrypted and protected.<br>
                    We ensure 100% security for seller accounts.
                </p>
            </form>
        </div>
    </div>

    <footer>
        © 2026 Premium Car Sales Platform | All Rights Reserved<br>
        A safe and professional place to buy and sell vehicles online
    </footer>

</body>
</html>