<?php
session_start();

if (!isset($_SESSION['uname'])) {
    header("Location: register.php");
    exit();
}

$con = mysqli_connect("127.0.0.1:3306", "root", "", "sanina'an")
       or die("Connection Error");

$str = "";

if (isset($_POST['btn'])) {
    $Country    = mysqli_real_escape_string($con, $_POST['txtCountry']);
    $City       = mysqli_real_escape_string($con, $_POST['txtCity']);
    $Street     = mysqli_real_escape_string($con, $_POST['txtStreet']);
    $PostalCode = mysqli_real_escape_string($con, $_POST['txtPostalCode']);

    // Get the UserID of the newly registered user
    $usernameEsc = mysqli_real_escape_string($con, $_SESSION['uname']);
    $result = $con->query("SELECT UserID FROM user WHERE Username = '$usernameEsc' LIMIT 1");
    $row = $result->fetch_assoc();
    $UserID = $row['UserID'];

    $sql = "INSERT INTO location (UserID, Country, City, Street, PostalCode) VALUES (?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("issss", $UserID, $Country, $City, $Street, $PostalCode);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        $str = "Failed to save address: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="ceb">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sanina'an — Address</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,700;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="loginstyle.css">
</head>
<body>

  <div class="card">
    <div class="card-top">
      <div class="brand">Imong Adres</div>
      <div class="brand">Sanina<em>'</em>an</div>
      <div class="sub">Sugboanon Thrift Marketplace</div>
    </div>

    <div class="card-body">

      <?php if ($str): ?>
        <div class="toast show" style="position:relative;bottom:auto;left:auto;transform:none;margin-bottom:14px;opacity:1;">
          <?= htmlspecialchars($str) ?>
        </div>
      <?php endif; ?>

      <form method="post" action="">

        <div class="field">
          <label>Country</label>
          <input type="text" name="txtCountry" placeholder="Ex: Philippines"/>
        </div>

        <div class="field">
          <label>City</label>
          <input type="text" name="txtCity" placeholder="Ex: Cebu City"/>
        </div>

        <div class="field">
          <label>Street</label>
          <input type="text" name="txtStreet" placeholder="Ex: 123 Colon Street"/>
        </div>

        <div class="field">
          <label>Postal Code</label>
          <input type="text" name="txtPostalCode" placeholder="Ex: 6000"/>
        </div>

        <button type="submit" class="btn" name="btn">Isumite · Submit</button>
      </form>

      <div class="foot">
        Already have an account? <a href="login.php">Sign in</a>
      </div>

    </div>
  </div>

</body>
</html>