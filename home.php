<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Online Car Sale | Premium Auto Marketplace</title>
<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

html{
    scroll-behavior:smooth;
}

body{
    font-family: Arial, Helvetica, sans-serif;
    background: linear-gradient(rgba(0,0,0,0.55),rgba(0,0,0,0.55)), url("background.jpg") center/cover no-repeat;
    min-height:100vh;
    color:white;
}

.nav{
    position:fixed;
    top:0;
    width:100%;
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:18px 60px;
    background:rgba(0,0,0,0.72);
    backdrop-filter:blur(8px);
    z-index:1000;
}

.brand{
    display:flex;
    align-items:center;
    gap:12px;
}

.logo{
    height:42px;
}

.brand h2{
    font-size:24px;
    letter-spacing:1px;
}

.menu{
    display:flex;
    gap:22px;
    flex-wrap:wrap;
}

.menu a{
    color:white;
    text-decoration:none;
    font-size:17px;
    transition:0.3s;
    position:relative;
}

.menu a::after{
    content:"";
    position:absolute;
    left:0;
    bottom:-5px;
    width:0%;
    height:2px;
    background:#ffd700;
    transition:0.3s;
}

.menu a:hover::after{
    width:100%;
}

.menu a:hover{
    color:#ffd700;
}

.hero{
    min-height:100vh;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    text-align:center;
    padding:120px 20px 60px;
}

.hero h1{
    font-size:62px;
    margin-bottom:20px;
    animation:fadeDown 1.2s ease;
}

.hero p{
    font-size:24px;
    margin-bottom:35px;
    max-width:700px;
    animation:fadeUp 1.2s ease;
}

.btn-group{
    display:flex;
    gap:18px;
    flex-wrap:wrap;
}

.btn{
    padding:14px 30px;
    border:none;
    border-radius:6px;
    font-size:17px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

.primary{
    background:#ffd700;
    color:black;
}

.secondary{
    background:transparent;
    border:2px solid white;
    color:white;
}

.btn:hover{
    transform:translateY(-4px);
}

.stats{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    padding:0 60px 70px;
}

.stat-box{
    background:rgba(255,255,255,0.12);
    padding:25px;
    border-radius:10px;
    text-align:center;
    backdrop-filter:blur(6px);
}

.stat-box h2{
    color:#ffd700;
    font-size:34px;
    margin-bottom:10px;
}

.features{
    padding:30px 60px 80px;
}

.title{
    text-align:center;
    font-size:38px;
    margin-bottom:40px;
}

.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:25px;
}

.box{
    background:rgba(255,255,255,0.1);
    padding:30px;
    border-radius:12px;
    transition:0.35s;
}

.box:hover{
    transform:translateY(-8px);
    background:rgba(255,255,255,0.18);
}

.box h3{
    margin-bottom:15px;
    color:#ffd700;
}

footer{
    text-align:center;
    padding:25px;
    background:rgba(0,0,0,0.72);
}

@keyframes fadeDown{
    from{opacity:0; transform:translateY(-30px);}
    to{opacity:1; transform:translateY(0);}
}

@keyframes fadeUp{
    from{opacity:0; transform:translateY(30px);}
    to{opacity:1; transform:translateY(0);}
}

@media(max-width:768px){
.nav{
    flex-direction:column;
    gap:15px;
    padding:18px 20px;
}
.hero h1{
    font-size:40px;
}
.hero p{
    font-size:19px;
}
.stats,.features{
    padding-left:20px;
    padding-right:20px;
}
}
</style>
</head>
<body>

<div class="nav">
    <div class="brand">
        <img src="logo.png" class="logo" alt="Logo">
        <h2>AutoHub</h2>
        <?php if(isset($_SESSION['username'])): ?>
            <span style="color:#ffd700; font-weight:bold; margin-left:10px;">
                Welcome, <?= $_SESSION['username'] ?> <a href="logout.php" style="color:#fff; margin-left:8px; font-size:14px;">Logout</a>
            </span>
        <?php endif; ?>
    </div>

    <div class="menu">
        <a href="home.php">Home</a>
        <a href="search.php">Search</a>
        <?php if(!isset($_SESSION['username'])): ?>
        <a href="login.php">Login</a>
        <a href="registration.php">Register</a>
        <?php endif; ?>
        <?php if(isset($_SESSION['username'])): ?>
        <a href="addcar.php">Add Car</a>
        <?php endif; ?>
    </div>
</div>

<section class="hero">
    <h1>Premium Auto Marketplace</h1>
    <p>Buy and sell quality vehicles with trusted sellers, secure deals, and the best market prices.</p>
    <div class="btn-group">
        <button class="btn primary" onclick="location.href='search.php'">Explore Cars</button>
        <button class="btn secondary" onclick="location.href='registration.php'">Become Seller</button>
    </div>
</section>

<section class="stats">
    <div class="stat-box">
        <h2>5000+</h2>
        <p>Cars Listed</p>
    </div>
    <div class="stat-box">
        <h2>3000+</h2>
        <p>Happy Buyers</p>
    </div>
    <div class="stat-box">
        <h2>99%</h2>
        <p>Trusted Deals</p>
    </div>
</section>

<section class="features">
    <h2 class="title">Why Choose Us</h2>
    <div class="grid">
        <div class="box">
            <h3>Wide Selection</h3>
            <p>Choose from luxury, family, electric, and second-hand vehicles.</p>
        </div>
        <div class="box">
            <h3>Secure Trading</h3>
            <p>Safe communication and verified sellers for reliable transactions.</p>
        </div>
        <div class="box">
            <h3>Best Price</h3>
            <p>Compare listings instantly and get the most competitive offers.</p>
        </div>
    </div>
</section>

<footer>
    <p>© 2026 Online Car Sale | AI Enhanced Homepage</p>
</footer>

</body>
</html>