<?php
$messages = array();
$pages = array(
  "discover" =>"Discover",
  "mygallery" =>"My Gallery"
);


// Record a message to display to the user.
function record_message($message) {
  global $messages;
  array_push($messages, $message);
}

// Write out any messages to the user.
function print_messages() {
  global $messages;
  foreach ($messages as $message) {
    echo "<p><strong>" . htmlspecialchars($message) . "</strong></p>\n";
  }
}


function exec_sql_query($db, $sql, $params = array()) {
  $query = $db->prepare($sql);
  if ($query and $query->execute($params)) {
    return $query;
  }
  return NULL;
}

// YOU MAY COPY & PASTE THIS FUNCTION WITHOUT ATTRIBUTION.
// open connection to database
function open_or_init_sqlite_db($db_filename, $init_sql_filename) {
  if (!file_exists($db_filename)) {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db_init_sql = file_get_contents($init_sql_filename);
    if ($db_init_sql) {
      try {
        $result = $db->exec($db_init_sql);
        if ($result) {
          return $db;
        }
      } catch (PDOException $exception) {
        // If we had an error, then the DB did not initialize properly,
        // so let's delete it!
        unlink($db_filename);
        throw $exception;
      }
    }
  } else {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
  }
  return NULL;
}

// open connection to database


function check_login() {
  global $db;
  if (isset($_COOKIE["session"])) {
    $session = $_COOKIE["session"];

    $sql = "SELECT * FROM user WHERE user_session = :session_id;";
    $params = array (
      ":session_id" => $session,
    );
    $records = exec_sql_query($db, $sql, $params)->fetchAll();
    if ($records) {
      $account = $records[0];
      return $account["user_name"];
    }
  }
  return NULL;
}

function log_in($username, $password) {
  global $db;

  if ($username && $password) {
    $sql = "SELECT * FROM user WHERE user_name = :username;";
    $params = array(
      ':username' => $username
    );
    $records = exec_sql_query($db, $sql, $params)->fetchAll();
    if ($records) {
      // Username is UNIQUE, so there should only be 1 record.
      $account = $records[0];
      if (password_verify($password, $account['user_password'])) {

        $session = uniqid();
        $sql = "UPDATE user SET user_session = :session WHERE user_id = :user_id;";
        $params = array (
          ":user_id" => $account['user_id'],
          ":session" => $session
        );
        $result = exec_sql_query($db, $sql, $params);
        if ($result) {
          // Success, session stored in DB

          // Send this back to the client
          setcookie("session", $session, time()+3600);


          record_message("Logged in as $username");
          return $username;
        }
      } else {
        record_message("Invalid username or password.");
      }
    } else {
      record_message("Invalid username or password.");
    }
  } else {
    record_message("No username or password given.");
  }
  return NULL;
}

function log_out() {
  global $current_user;
  global $db;
  if ($current_user) {

    $sql = "UPDATE user SET user_session = :session WHERE user_name = :username;";
    $params = array (
      ":username" => $current_user,
      ":session" => NULL
    );
    if (!exec_sql_query($db, $sql, $params)) {
      record_message("log out failed.");
    }

    //
    setcookie("session", "", time()-3600);
    $current_user = NULL;
  }
}
$db = open_or_init_sqlite_db('gallery.sqlite', 'init/init.sql');
const BOX_UPLOADS_PATH = "uploads/image/";

// Check if we should login the user
if (isset($_POST['login'])) {
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
  $username = trim($username);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

  $current_user = log_in($username, $password);
}
else{
  $current_user = check_login();
}


if (isset($_POST['log_out'])) {
  log_out();
  if (!$current_user) {
    record_message("You've been successfully logged out.");
  }
}

if(isset($_POST["submit_upload"])){
  $sql ="SELECT * FROM user WHERE user_name = :currentUser";
  $params = array(
    ":currentUser" => $current_user
  );
  $records = exec_sql_query($db, $sql, $params)->fetchAll();
  $user_id = $records[0]["user_id"];

  $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
  $photo_upload = $_FILES["photo_upload"];

  foreach($photo_upload["error"] as $key => $error){
    if($error == UPLOAD_ERR_OK){
      $name = basename($photo_upload["name"][$key]);
      $tmp_name = $photo_upload["tmp_name"][$key];
      $extension = strtolower(pathinfo($name)["extension"]);
      $imageName = filter_input(INPUT_POST, 'photo_name', FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
      $todayh = getdate();
      $d = $todayh['mday'];
      $m = $todayh['mon'];
      $y = $todayh['year'];
      $upload_date = "$y-$m-$d";
      $sql = "INSERT INTO image (user_id,upload_date,image_name, file_name, file_ext, image_description) VALUES (:user_id,:upload_date,:image_name,:fileName, :fileExt, :fileDescription)";
      $params = array(
        ':user_id' =>$user_id,
        ':upload_date' =>$upload_date,
        ':image_name' =>$imageName,
        ':fileName' => $name,
        ':fileExt' => $extension,
        ':fileDescription' => $description,
      );

      exec_sql_query($db, $sql, $params);
      $id = $db->lastInsertId("id");
      $newName = BOX_UPLOADS_PATH.$id.".".$extension;
      move_uploaded_file($tmp_name, $newName);
      array_push($messages,"successfully uploaded");

    }
    else{
      array_push($messages,"failured to upload, the photo size might too large");
    }

  }
};
if (isset($_POST['submit_delete'])) {
  $filename = $_POST['delete_file'];
  $image_id = $_POST['delete_imageID'];
  if (file_exists($filename)) {
    $sql = "DELETE FROM image WHERE image_id = :image_id";
    $params = array(':image_id' => $image_id);
    exec_sql_query($db, $sql, $params);
    $sql = "DELETE FROM tag_image WHERE image_id = :image_id";
    $params = array(':image_id' => $image_id);
    exec_sql_query($db, $sql, $params);
    $sql = "SELECT tag.tag_id FROM tag LEFT JOIN tag_image ON tag.tag_id = tag_image.tag_id WHERE tag_image.tag_id is NULL";
    $uselessTags = exec_sql_query($db, $sql)->fetchAll();
    if(isset($uselessTags)&&!empty($uselessTags)){
      foreach($uselessTags as $uselessTag){
        exec_sql_query($db, "DELETE FROM tag WHERE tag_id = :uselessTag", array(':uselessTag'=>$uselessTag["tag_id"]));
      }
    }
    unlink($filename);
    array_push($messages,"successfully deleted");
  } else {
    array_push($messages,"failured to delete");
  }
}


?>
