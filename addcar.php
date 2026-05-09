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