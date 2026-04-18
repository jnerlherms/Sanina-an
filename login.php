<?php
  session_start();
  $con = mysqli_connect("127.0.0.1:3306", "root", "", "projectsanina'an") 
       or die("Connection Error");

  $str="";
  if(isset($_POST['btn'])){
    $uname=mysqli_real_escape_string($con,$_POST['txtUsername']);
    $pwd=mysqli_real_escape_string($con,$_POST['txtPassword']);



    $sql="select * from user where username=? and password=?";
    //echo $sql;
    $stmt=$con->prepare($sql);
    $stmt->bind_param("ss",$uname,$pwd);
    $stmt->execute();
    $result=$stmt->get_result();
    $row=mysqli_num_rows($result);
    if ($result->num_rows === 1) {
        $val = $result->fetch_assoc();
        
        $_SESSION['user_id']      = $val['UserID'];      // primary key
        $_SESSION['uname']        = $val['Username'];    // or whatever column holds username
        $_SESSION['FirstName']    = $val['FirstName'];
        $_SESSION['LastName']     = $val['LastName'];
        $_SESSION['Email']        = $val['Email'];
        $_SESSION['PhoneNumber']  = $val['PhoneNumber'];

        header("Location: Index.php");
        exit();
    } else {
        $str = "Invalid credentials";
    }
  }

?>
<!DOCTYPE html>
<html lang="ceb">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sanina'an — Log In</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,700;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel = "stylesheet" href="loginstyle.css">
</head>
<body>

  <div class="card">
    <div class="card-top">
      <div class="brand">Sanina<em>'</em>an</div>
      <div class="sub">Sugboanon Thrift Marketplace</div>
    </div>

    <div class="card-body">
      <form method="POST">
          <div class="field">
            <label>Username</label>
            <input type="text" id="fn" name ="txtUsername" placeholder="Ex: DelaJuan2002"/>
          </div>
        <div class="field">
          <label>Password</label>
          <div class="pw-wrap">
            <input type="password" id="pw" name ="txtPassword" placeholder="••••••••"/>
            <span class="pw-toggle" onclick="togglePW()">Show</span>
          </div>
        </div>

        <button type="submit" class="btn" name="btn">Sulod · Log In</button>
        <?php echo $str; ?>
      </form>

      <div class="foot">
        Bag-o ka pa? <a href="register.php">Mag-register dinhi</a> · <a href="#">Forgot password?</a>
      </div>
    </div>
  </div>
</body>
</html>