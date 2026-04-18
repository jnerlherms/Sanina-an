<?php
  session_start();
  $con = mysqli_connect("127.0.0.1:3306", "root", "", "sanina'an")
         or die("Connection Error");

    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
      }

  $displayName = isset($_SESSION['uname']) ? $_SESSION['uname'] : 'User';
?>
<!DOCTYPE html>
<html lang="ceb">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sanina'an - Sugboanon Thrift Marketplace</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,700;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="Indexstyle.css">
</head>
<body>
  <nav>
    <div class="nav-brand">Sanina<em>'</em>an</div>
    <div class="nav-links">
      <a href="add_new_record.php" class="nav-cta">My Cart</a>
      <a href="#" class="nav-cta">My Address</a>
      <a href="#" class="nav-cta">Order History</a>
      <a href="login.php" class="nav-cta">Log Out</a>
    </div>
  </nav>

  <section class="hero">
    <div class="hero-eyebrow">Cebu's #1 Thrift Marketplace</div>
    <h1>Welcome, <?php echo htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8'); ?>.</h1>
    <p>Sanina'an connects Sugboanons to unique, pre-loved finds. Every item is one-of-a-kind - once sold, it's locked forever.</p>
    <div class="hero-btns">
      <a href="#" class="btn-primary">Browse Products</a>
      <a href="vendor.php" class="btn-outline">Vendor Market</a>
    </div>
  </section>

  <footer>
    <div class="footer-brand">Sanina<em>'</em>an</div>
    <div class="footer-copy">&copy; 2026 Sanina'an · Sugboanon Thrift Marketplace · Cebu, PH</div>
  </footer>
</body>
</html>
