<?php
session_start();

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'car_sales';

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) die("Connection failed");

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT * FROM sellers WHERE username='$username' OR email='$email'");

    if (mysqli_num_rows($check) > 0) {
        $msg = "Username or Email already exists";
    } else {
        $sql = "INSERT INTO sellers (name, address, phone, email, username, password) 
                VALUES ('$name','$address','$phone','$email','$username','$password')";

        if (mysqli_query($conn, $sql)) {
            $msg = "Registration successful! You can login now.";
        } else {
            $msg = "Registration failed";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="nav">
    <img src="logo.png" class="logo">

    <div class="nav-links">
        <a href="home.html">Home</a>
        <a href="login.html">Login</a>
        <a href="search.html">Search</a>
        <a href="addcar.html">Add Car</a>
    </div>
</nav>

<div class="container" id="card">
    <h2>Create Account</h2>

    <form id="form" method="POST" action="registration.php">

        <div class="form-group">
            <input type="text" name="name" required>
            <label>Name</label>
            <small class="error"></small>
        </div>

        <div class="form-group">
            <input type="text" name="address" required>
            <label>Address</label>
            <small class="error"></small>
        </div>

        <div class="form-group">
            <input type="tel" name="phone" required>
            <label>Phone</label>
            <small class="error"></small>
        </div>

        <div class="form-group">
            <input type="email" name="email" required>
            <label>Email</label>
            <small class="error"></small>
        </div>

        <div class="form-group">
            <input type="text" name="username" required>
            <label>Username</label>
            <small class="error"></small>
        </div>

        <div class="form-group password-group">
            <input type="password" name="password" id="password" required>
            <label>Password</label>
            <span id="toggle">👁</span>
            <div class="strength"></div>
            <small class="error"></small>
        </div>

        <button type="submit" id="btn">
            <span class="btn-text">Register</span>
            <div class="spinner"></div>
        </button>

        <p id="success" style="opacity: 1;">
            <?php echo $msg; ?>
        </p>

    </form>
</div>

<script src="script.js"></script>
</body>
</html>