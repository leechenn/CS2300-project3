<?php
include("includes/init.php");
$current_page_id="index";
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="css/mainpage.css"/>
  <link rel="stylesheet" type="text/css" href="css/header.css"/>
  <link rel="stylesheet" type="text/css" href="css/fontawesome-all.css"/>
  <link rel="stylesheet" type="text/css" href="css/font.css"/>
  <script src="scripts/mainpage.js"></script>
  <title>Gallery</title>
</head>

<body>
  <?php include("includes/header.php");?>
  <div id="mainIntro">
  <div id="mainTextBox"><p id="userWelcome"><?php if($current_user){echo "Hello, $current_user";} ?></p><p id="textDescription">Take a Photo, Express Yourself, Print Your Life</p></div>
  <img src="/images/photography.jpg">
  </div>
  <span class="citation">This photo is cited from: <a href="https://d2jv9003bew7ag.cloudfront.net/uploads/Vivian-Maier-Self-portrait-New-York-City-c.-1950s.jpg">https://d2jv9003bew7ag.cloudfront.net/uploads/Vivian-Maier-Self-portrait-New-York-City-c.-1950s.jpg</a></span>
  <?php include("includes/footer.php");?>
</body>

</html>
