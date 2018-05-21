<!-- The logo on the left of the header is cited from Nike, I display the citation below the main header picture -->

<header >
  <nav class="navbar fixed-top" >
    <div class="collapse navbar-collapse" id="navbarContent">
      <ul id="navbar-nav">
        <?php
        if("index" == $current_page_id){
          echo "<li class='nav-item' id='mainpage'><a id='current_page' class='nav-link'  href='index.php'>Gallery</a></li>";
        }
        else{
          echo "<li class='nav-item' id='mainpage'><a class='nav-link'  href='index.php'>Gallery</a></li>";
        }
        if ($current_user) {
          foreach($pages as $page_id => $page_name){
            if($page_id == $current_page_id){
              echo "<li class='nav-item' ><a class='nav-link' id='current_page' href='$page_id.php'>$page_name</a></li>";
            }
            else{
              echo "<li class='nav-item' ><a class='nav-link' href='$page_id.php'>$page_name</a></li>";
            }

          }
          echo"<li class='userMessage'>";
          print_messages();
          echo"</li>";
          echo "<li id='userName'>Logged as $current_user </li>";
          echo "<li><form id='logout_form' method='post' action='index.php'><input id='log_out' type='submit' name='log_out' value='Log Out'/></form></li>";
          echo "<li><button id='uploadBtn' type='button' onclick='openModal()'><i class='fa fa-cloud-upload-alt'></i>Upload</button></li>";
        }
        else{

          if("discover" == $current_page_id){
            echo "<li class='nav-item' ><a class='nav-link' id='current_page' href='discover.php'>Discover</a></li>";
          }
          else{
            echo "<li class='nav-item' ><a class='nav-link' href='discover.php'>Discover</a></li>";
          }
          echo"<li class='userMessage'>";
          print_messages();
          echo"</li>";

          if($current_page_id!="login"){
            echo "<li id='loginBtn'><a class='userlog' href='login.php'>Log in</a></li>";
          }
        }

        ?>
      </ul>

    </div>
</nav>
<?php
if($current_page_id=="discover"){
  echo"
  <div id='discocverIntro'>";
  if($current_user){
    echo"
    <div id='discoverTextBox'><p class='textDescription'>Hello $current_user, Discover More Photos, Discover The World Around You</p></div>";}
    else{
      echo"
      <div id='discoverTextBox'><p class='textDescription'>Hello, Discover More Photos, Discover The World Around You</p></div>";}
      echo"
      <img src='/images/discover.jpg' alt='discover'>
      <span class='citation'>This picture is cited from: <a href='https://cdn.lynda.com/course/542431/542431-636251707678601607-16x9.jpg'>https://cdn.lynda.com/course/542431/542431-636251707678601607-16x9.jpg</a></span>
      </div>";
    }
    if($current_page_id=="mygallery"){
      echo"
      <div id='myGalleryIntro'>
      <div id='myGalleryTextBox'><p class='textDescription'>Hello $current_user, Welcome Home, Preview and Manage Your Photos</p></div>
      <img src='/images/myGallery.jpg' alt='myGalleryPicture'>
      <span class='citation'>This picture is cited from: <a href='https://fhm.nl/wp-content/uploads/2017/01/Fotografie_Cursus_Harvard.jpg'>https://fhm.nl/wp-content/uploads/2017/01/Fotografie_Cursus_Harvard.jpg'</a></span>
      </div>";
    }
    if($current_page_id!="login"){
      echo"
      <div id='myModal' class='modal'>
      <span class='close cursor' onclick='closeModal()'>&times;</span>
      <div id='modal-content-cover'></div>
      <div class='modal-content'>
      <div id='imageChosen'>
      <div id='imageChosenHint'><p>Your Photo</p></div>
      <div id='imageDisplay'>
      <img id='output' src='' alt=''/>
      </div>
      </div>
      <div id='uploadForm'>
      <form id='uploadFile' action='discover.php' method='post' enctype='multipart/form-data'>
      <ul>
      <li>
      <button name='submit_upload' type='submit'>Sumbit</button>
      </li>
      <li>
      <input type='hidden' name='MAX_FILE_SIZE'  value='10485760' />
      <input type='file' id='fileChoseBtn' name='photo_upload[]' onchange='loadFile(event)' required>
      <input type='button' id='replaceBtn' value='Choose Your Photo'>
      </li>
      <li>
      <label>Photo Name</label>
      <input type='text' name='photo_name'>
      </li>
      <li>
      <label>Photo Description</label>
      <textarea id='photoDescription' name = 'description' ></textarea>
      </li>
      <li>
      <input type='reset' id='clearBtn' value='Clear' onclick='clearForm()'>
      </li>

      </ul>
      </form>

      </div>
      </div>
      </div>

      ";

    }
    ?>





  </header>
