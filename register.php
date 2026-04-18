<?php
session_start();
$con = mysqli_connect("127.0.0.1:3306", "root", "", "sanina'an")
       or die("Connection Error");

$str = "";

if (isset($_POST['btn'])) {
    $FirstName   = mysqli_real_escape_string($con, $_POST['txtFirstName']);
    $LastName    = mysqli_real_escape_string($con, $_POST['txtLastName']);
    $Username    = mysqli_real_escape_string($con, $_POST['txtUsername']);
    $Email       = mysqli_real_escape_string($con, $_POST['txtEmail']);
    $Password    = mysqli_real_escape_string($con, $_POST['txtPassword']);
    $PhoneNumber = mysqli_real_escape_string($con, $_POST['txtPhoneNumber']);

    
    if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        $str = "Invalid email format.";
    } else {
    
        $sql = "INSERT INTO user (FirstName, LastName, Username, Email, Password, PhoneNumber) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssss", $FirstName, $LastName, $Username, $Email, $Password, $PhoneNumber);

        if ($stmt->execute()) {
            $_SESSION['uname'] = $Username;
            $_SESSION['pwd'] = $Password;
            header("Location: location.php");
            exit();
        } else {
            $str = "Registration failed: " . $stmt->error;
        }
    }
}
?>



<!DOCTYPE html>
<html lang="ceb">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sanina'an — Registration</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,700;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel = "stylesheet" href="loginstyle.css">
</head>
<body>

  <div class="card">
    <div class="card-top">
      <div class="brand">Pag Rigister Dri</div>
      <div class="brand">Sanina<em>'</em>an</div>
      <div class="sub">Sugboanon Thrift Marketplace</div>
    </div>

    <div class="card-body">
      <form onsubmit method="post" action="">
          <div class="row">
          <div class="field">
            <label>First Name</label>
            <input type="text" id="fn" name ="txtFirstName" placeholder="Ex: Juan"/>
          </div>
          <div class="field">
            <label>Last Name</label>
            <input type="text" id="ln" name ="txtLastName" placeholder="Ex: De la Cruz"/>
          </div>
        </div>

        <div class="field">
          <label>Username</label>
          <input type="text" id="us" name ="txtUsername"placeholder="Ex: DelaJuan1222"/>
        </div>

        <div class="field">
          <label>Email</label>
          <input type="email" id="em" name ="txtEmail"placeholder="Ex: juan@gmail.com"/>
        </div>

        <div class="field">
          <label>Password</label>
          <div class="pw-wrap">
            <input type="password" id="pw" name ="txtPassword" placeholder="••••••••"/>
            <span class="pw-toggle" onclick="togglePW()">Show</span>
          </div>
        </div>

        <div class="field">
          <label>Phone Number</label>
          <div class="pw-wrap">
            <input type="tel" name="txtPhoneNumber" placeholder="Ex: 0912-123-1234" />
          </div>
        </div>

        <button type="submit" class="btn" name="btn" onclick="showNotification()">Sulod · Register</button>
      </form>
    </div>
  </div>
  <script>
        function showNotification() {
            alert("Successfully submitted!");
        }
    </script>
</body>
</html>