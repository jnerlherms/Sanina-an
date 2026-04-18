<?php
    session_start();
    $con = mysqli_connect("127.0.0.1:3306", "root", "", "sanina'an")
           or die("Connection Error");

    if (!isset($_SESSION['uname'])) {
        header('Location: login.php');
        exit();
    }

    $userID = $_SESSION['user_id'] ?? 0;
    $displayName        = $_SESSION['uname'] ?? 'User';
    $displayFName       = $_SESSION['FirstName'] ?? '—';
    $displayLName       = $_SESSION['LastName'] ?? '—';
    $displayPhoneNumber = $_SESSION['PhoneNumber'] ?? '—';
    $displayEmail       = $_SESSION['Email'] ?? '—';

    // Fetch vendor/store info if exists
    $vstmt = $con->prepare("SELECT StoreName FROM vendor WHERE UserID = ?");
    $vstmt->bind_param("i", $userID);
    $vstmt->execute();
    $vendor = $vstmt->get_result()->fetch_assoc();
    $storeName = $vendor['StoreName'] ?? '';

    $success = "";
    $error = "";

      if (isset($_POST['btn-submit'])) {
          $storeName = $_POST['store_name'];

          // Check if vendor already exists
          $checkStmt = $con->prepare("SELECT StoreName FROM vendor WHERE UserID = ?");
          $checkStmt->bind_param("i", $userID);
          $checkStmt->execute();
          $existingVendor = $checkStmt->get_result()->fetch_assoc();

          if ($existingVendor) {
              // Store already exists → show error
              $error = "You already have a registered store: " . htmlspecialchars($existingVendor['StoreName']);
          } else {
              // Insert new store
              $sql = "INSERT INTO vendor (UserID, StoreName) VALUES (?, ?)";
              $stmt = $con->prepare($sql);
              $stmt->bind_param("is", $userID, $storeName);

              if ($stmt->execute()) {
                  $_SESSION['StoreName'] = $storeName;
                  header("Location: Index.php");
                  exit();
              } else {
                  $error = "Store Registration Failed: " . $stmt->error;
              }
          }
      }

?>

<!DOCTYPE html>
<html lang="ceb">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sanina'an - Vendor Profile</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,700;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="Indexstyle.css">
  <link rel="stylesheet" href="vendorprofile.css">
</head>
<body>
  <nav>
    <div class="nav-brand">Sanina<em>'</em>an</div>
    <div class="nav-links">
      <a href="#" class="nav-cta">Add to Cart</a>
      <a href="#" class="nav-cta">Location</a>
      <a href="orders.php" class="nav-cta">Orders</a>
      <a href="#" class="nav-cta">Log Out</a>
    </div>
  </nav>
  <section class="profile-section">
    <div class="profile-header">
      <h1>Welcome Vendor, <?php echo htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8'); ?>.</h1>
      <p><?php echo htmlspecialchars($displayEmail, ENT_QUOTES, 'UTF-8'); ?></p>
    </div>
    <div class="profile-grid">
      <!-- Account Info (read-only) -->
      <div class="profile-card">
        <div class="card-label">Account Info</div>
        <div class="info-row">
          <span class="info-key">First Name</span>
          <span class="info-val"><?php echo htmlspecialchars($displayFName, ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <div class="info-row">
          <span class="info-key">Last Name</span>
          <span class="info-val"><?php echo htmlspecialchars($displayLName, ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <div class="info-row">
          <span class="info-key">Email</span>
          <span class="info-val"><?php echo htmlspecialchars($displayEmail, ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
        <div class="info-row">
          <span class="info-key">Phone</span>
          <span class="info-val"><?php echo htmlspecialchars($displayPhoneNumber ?? '—', ENT_QUOTES, 'UTF-8'); ?></span>
        </div>
      </div>

      <!-- Store Name Form -->
    <div class="profile-card">
      <div class="card-label">Store Details</div>

      <?php if ($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
      <?php endif; ?>
      <?php if ($error): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>

      <form method="POST" action="">
        <div class="form-group">
          <label for="store_name">Store Name</label>
          <input type="text" id="store_name" name="store_name"
                 value="<?php echo htmlspecialchars($storeName, ENT_QUOTES, 'UTF-8'); ?>"
                 placeholder="e.g. Juan's Thrift Corner" maxlength="100" required />
        </div>
        <button type="submit" class="btn-primary" name="btn-submit">Register Store</button>
      </form>
    </div>

  </section>
  <footer>
    <div class="footer-brand">Sanina<em>'</em>an</div>
    <div class="footer-copy">&copy; 2026 Sanina'an · Sugboanon Thrift Marketplace · Cebu, PH</div>
  </footer>
</body>
</html>