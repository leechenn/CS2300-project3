<?php
include("includes/init.php");
$current_page_id= "login";
if ($current_user) {
  header('Location:index.php');
  exit;
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="css/login.css"/>
  <link rel="stylesheet" type="text/css" href="css/header.css"/>
  <link rel="stylesheet" type="text/css" href="css/mainpage.css"/>
  <link rel="stylesheet" type="text/css" href="css/fontawesome-all.css"/>
  <link rel="stylesheet" type="text/css" href="css/font.css"/>
  <script src="scripts/mainpage.js"></script>

  <title>Log in</title>
</head>

<body>
  <?php include("includes/header.php");?>

  <div id="logcontain">
    <div id="logwindow">
      <h1>Log In to Gallery</h1>
      <form id="loginForm" action="login.php" method="post">
        <div>
          <label>Username</label>
          <input type="text" name="username" required/>
        </div>
        <div>
          <label>Password</label>
          <input type="password" name="password" required/>
        </div>
        <div>
          <button name="login" type="submit">Log In</button>
        </div>
      </form>
    </div>
    <div id="loginReminder">
      <?php
      print_messages();
      ?>
    </div>

  </div>
  <?php include("includes/footer.php");?>
</body>
</html>
