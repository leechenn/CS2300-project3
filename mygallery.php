<?php
include("includes/init.php");
$current_page_id="mygallery";
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

  <title>My Gallery</title>

</head>

<body>
  <?php include("includes/header.php");?>
  <div class="galleryContainerDescription"><p>View Your Gallery</p></div>
  <div id="galleryContainer">
    <section id="photos">
      <?php
      $params = array(':user_name' => $current_user);
      $records = exec_sql_query($db, "SELECT * FROM user INNER JOIN image ON user.user_id = image.user_id WHERE user.user_name =:user_name",$params)->fetchAll(PDO::FETCH_ASSOC);
      $idArray = array();
      foreach($records as $record){
        $id = $record["image_id"];
        array_push($idArray, $id);
        $name = $record["image_name"];
        $extention = $record["file_ext"];
        $link = BOX_UPLOADS_PATH.$id.".".$extention;
        echo "<a href='/mygallery.php?photo_id=$id'><div class='avatar'>
        <div class='c'>
        <div class='cover'>
        </div>
        <i class='fa fa-search'></i>
        <span>$name</span>
        </div>

        <div ><img src = $link alt='photo'/></div>
        </div></a>";
      }
      ?>
    </section>
  </div>

  <?php
  if(isset($_GET["photo_id"])){
    $lastOne = false;
    $firstOne = false;
    $image_id = intval($_GET["photo_id"]);
    $sql = "SELECT * FROM image WHERE image_id = :image_id";
    $sql2 = "SELECT tag.tag_name, tag.tag_id From tag INNER JOIN tag_image ON tag.tag_id = tag_image.tag_id WHERE tag_image.image_id = :image_id";
    $params = array(':image_id' => $image_id);
    $record = exec_sql_query($db, $sql, $params)->fetchAll();
    $recordTags = exec_sql_query($db, $sql2, $params)->fetchAll();
    $extention = $record[0]["file_ext"];
    $link = BOX_UPLOADS_PATH.$image_id.".".$extention;
    $photoName = $record[0]["image_name"];
    $photoDescription = $record[0]["image_description"];
    $uploadDate = $record[0]["upload_date"];
    $user_id = $record[0]["user_id"];
    $sql = "SELECT * FROM user WHERE user_id = :userId";
    $params = array(':userId' => $user_id);
    $record = exec_sql_query($db, $sql, $params)->fetchAll();
    $userUploaded = $record[0]["user_name"];
    $index = array_search($image_id,$idArray);

    if($index==count($idArray)-1){
      $last = $idArray[$index-1];
      $lastOne = true;

    }
    if($index==0){
      $next = $idArray[$index+1];
      $firstOne = true;
    }
    if($index!=0&&$index!=count($idArray)-1){
      $next = $idArray[$index+1];
      $last = $idArray[$index-1];
    }


    echo
    "<div id='myModal-photoview' class='modal'>
    <span class='close cursor' onclick='closePhotoView()'>&times;</span>
    <div class='modal-content-cover'></div>
    <div class='modal-content'>
    <div id='imageViewBox'>";
    if($firstOne){
      echo"
      <a id='rightArrow' href='/mygallery.php?photo_id=$next'><i class='fa fa-arrow-right'></i></a>";
    }
    else{
      if($lastOne){
        echo"
        <a id='leftArrow' href='/mygallery.php?photo_id=$last'><i class='fa fa-arrow-left'></i></a>";

      }
      else{
        echo"
        <a id='leftArrow' href='/mygallery.php?photo_id=$last'><i class='fa fa-arrow-left'></i></a>
        <a id='rightArrow' href='/mygallery.php?photo_id=$next'><i class='fa fa-arrow-right'></i></a>";
      }
    }echo"
    <div id='showImage'>
    <img id='imageView' src = $link/>
    </div>
    </div>
    <div id='imageDetails'>
    <ul>
    <li>
    <label>Photo Name</label>
    <p>$photoName</p>
    </li>
    <li>
    <label>Uploaded By</label>";
    if($current_user&&$current_user==$userUploaded){
      echo"
      <p>You</p>";
    }
    else{
      echo"
      <p>$userUploaded</p>";
    }
    echo"
    </li>
    <li>
    <label>Uploaded Date</label>
    <p>$uploadDate</p>
    </li>
    <li>
    <label>Description</label>
    <p>$photoDescription</p>
    </li>
    ";
    if(isset($recordTags)&&!empty($recordTags)){
      echo "  <li>
      <label>Tags</label>
      <div class='tagsContainer innerTag' >
      <ul id='innertagsList'>";
      foreach($recordTags as $recordTag){
        $tag = $recordTag['tag_name'];
        $tagId = $recordTag['tag_id'];
        echo"
        <li><a href='discover.php?tagId=$tagId'><i class='fa fa-tag'></i>$tag</a></li>
        ";
      }
      echo"
      </ul>
      </div>
      </li>
      ";
    }



    if($current_user&&$current_user==$userUploaded){

      echo" <li><label>Manage Tags</label>";
    }
    else{
      echo" <li><label>Add Tags</label>";
    }
    echo"

    <div id='manageTags'>
    <ul>";
    foreach($recordTags as $recordTag){
      $tag = $recordTag['tag_name'];
      if($current_user&&$current_user==$userUploaded){
        echo"
        <li class='canDelete'><i class='fa fa-tag'></i><span>$tag</span><span class='deleteTag' onclick='deleteTag(this)'>&times;</span></li>
        ";
      }
      else{
        echo"
        <li><i class='fa fa-tag'></i>$tag</li>
        ";
      }
    }
    echo"
    </ul>
    <input id='tagInput' placeholder='add tag'/>
    </div>
    <form id='tagsForm' action='/discover.php?photo_id=$image_id' method='post'>
    <input type='hidden' value='$image_id' name='tags_imageID'/>";

    foreach($recordTags as $recordTag){
      $tag = $recordTag['tag_name'];
      echo"
      <input type='hidden' class='hiddentagName' value='$tag' name='tags[]'/>
      ";
    }
    echo"
    <button id='tagSubmit' type='submit' name='tagSubmit'>Submit</button>
    </form>
    </li>
    ";


    if($current_user&&$current_user==$userUploaded){
      echo"
      <li>
      <form method = 'post' action='discover.php' onsubmit='return delete_sure()'>
      <input type='hidden' value='$image_id' name='delete_imageID'/>
      <input type='hidden' value='$link' name='delete_file'/>
      <button id='submit_delete' type='submit' name='submit_delete' >Delete Image</button>
      </form>
      </li>
      ";
    }
    echo
    "
    </ul>
    </div>
    </div>
    </div>";
  }
  ?>

  <?php include("includes/footer.php");?>
</body>

</html>
