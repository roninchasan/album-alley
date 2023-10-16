<?php include("includes/init.php");
 $db = open_or_init_sqlite_db('secure/gallery.sqlite', 'secure/init.sql');

const MAX_FILE_SIZE = 10000000;
$name_feedback = "";
$artist_feedback = "";
$file_feedback = "";
$year_feedback = "";
$success_message = "";

if (isset($_POST["submit_form"])){
  $valid_form = TRUE;
  $upload_info = $_FILES["album"];

  $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
  $artist = filter_input(INPUT_POST, 'artist', FILTER_SANITIZE_STRING);

  $year = filter_input(INPUT_POST, 'year', FILTER_SANITIZE_STRING);

  if (($name == "")||($name==NULL)){
    $valid_form=FALSE;
    $name_feedback = "Please enter a valid album name.";
  }
  if (($artist == "")||($artist==NULL)){
    $valid_form=FALSE;
    $artist_feedback = "Please enter a valid artist name.";
  }
  $years_array = array("2015","2016","2017","2018","2019","2020") ;

  if (!in_array($year,$years_array)&&($year != "")){
    $valid_form=FALSE;
    $year == NULL;
    $year_feedback = "Please select a year from below or don't select any.";
  }

  if (($upload_info['error'] =="UPLOAD_ERR_OK")||($upload_info==NULL)){
    $basename = basename($upload_info["name"]);
    $file_ext = "." . strtolower(pathinfo($basename, PATHINFO_EXTENSION));
  }else{
    $valid_form=FALSE;
    $file_feedback = "There was an error uploading file. Please try another file.";
  }

  $melodic = filter_input(INPUT_POST, 'melodic', FILTER_SANITIZE_STRING);
  $lyrical = filter_input(INPUT_POST, 'lyrical', FILTER_SANITIZE_STRING);
  $trap = filter_input(INPUT_POST, 'trap', FILTER_SANITIZE_STRING);
  $pop = filter_input(INPUT_POST, 'pop', FILTER_SANITIZE_STRING);
  $award = filter_input(INPUT_POST, 'award', FILTER_SANITIZE_STRING);
  $top = filter_input(INPUT_POST, 'top', FILTER_SANITIZE_STRING);

  if (($melodic != "Melodic rap")&&($melodic != NULL)){
    $valid_form=FALSE;
  }
  if (($lyrical != "Lyrical rap")&&($lyrical != NULL)){
    $valid_form=FALSE;
  }
  if (($trap != "Trap")&&($trap != NULL)){
    $valid_form=FALSE;
  }
  if (($pop != "Pop rap")&&($pop != NULL)){
    $valid_form=FALSE;
  }
  if (($award != "Award winning")&&($award != NULL)){
    $valid_form=FALSE;
  }
  if (($top != "#1 Debut")&&($top != NULL)){
    $valid_form=FALSE;
  }
  $tags_array = array($year,$melodic,$lyrical,$trap,$pop,$award,$top);

  if ($valid_form==TRUE){
    $sql = "INSERT INTO images (file_name, file_ext, album_name, artist) VALUES (:basename, :file_ext, :name, :artist)";
    $params = array(
      ':basename' => $basename,
      ':file_ext' => $file_ext,
      ':name' => $name,
      ':artist' => $artist
    );

    $inserted = exec_sql_query($db, $sql, $params);
    $id = $db->lastInsertId("id");
    $path_id = $id;

    //Applying tags

    foreach ($tags_array as $tag){
      if ($tag != NULL){
        $sql = "SELECT id FROM tags WHERE name = :tag";
        $params = array(':tag' => $tag);
        $tag_id_array = exec_sql_query($db, $sql, $params)->fetchAll();

        foreach ($tag_id_array as $id)
          $tag_id = $id["id"];

        $sql = "INSERT INTO image_tags (image_id, tag_id) VALUES (:image_id, :tag_id)";
        $params = array(
          ':image_id' => $path_id,
          ':tag_id' => $tag_id
        );
        exec_sql_query($db, $sql, $params);
      }
    }
  }

  if ($inserted){

    $new_path = "uploads/images/".$path_id."".$file_ext."";

    move_uploaded_file($_FILES["album"]["tmp_name"], $new_path);
    $success_message = "<p>Your album has successfully been added to our collection! Click the button below to return to the gallery and view it!</p>";
  }


}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css">
  <title>Album Alley</title>
</head>

<body>

  <?php include "includes/header.php" ?>




  <form id = "add_form" action = "add.php" method="post" enctype="multipart/form-data" novalidate>
        <?php echo $success_message; ?>
        <input type="hidden" name = "MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE ?>" />

        <div class="group_form_element">
          <p class = "feedback"><?php echo $file_feedback ?></p>
          <label for="album">Upload album cover:</label>
          <input name = "album" id="album" type="file">
        </div>

        <div class="group_form_element">
          <p class = "feedback"><?php echo $name_feedback ?></p>
          <label for="name">Name of album:</label>
          <input name = "name" id="name" type="text">
        </div>

        <div class="group_form_element">
          <p class = "feedback"><?php echo $artist_feedback ?></p>
          <label for="artist">Artist:</label>
          <input name = "artist" id="artist" type="text">
        </div>

        <div class="group_form_element">
          <p class = "feedback"><?php echo $year_feedback ?></p>
          <label for="year">Year released:</label>
          <select name = "year" id="year">
              <option value = "">Select year</option>
              <option value = "2015">2015</option>
              <option value = "2016">2016</option>
              <option value = "2017">2017</option>
              <option value = "2018">2018</option>
              <option value = "2019">2019</option>
              <option value = "2020">2020</option>
          </select>
        </div>

        <div class="group_form_element">
          <label>Style of rap:</label>
          <div class="checkbox-list">
            <div>
              <input class = "check" type="checkbox" name = "melodic" id="melodic" value="Melodic rap">
              <label for="melodic">Melodic rap</label>
            </div>

            <div>
              <input class = "check" type="checkbox" name = "lyrical" id="lyrical" value="Lyrical rap">
              <label for="lyrical">Lyrical rap</label>
            </div>

            <div>
              <input class = "check" type="checkbox" name = "trap" id="trap" value="Trap">
              <label for="trap">Trap</label>
            </div>

            <div>
              <input class = "check" type="checkbox" name = "pop" id="pop" value="Pop rap">
              <label for="pop">Pop rap</label>
            </div>
          </div>
        </div>

        <div class="group_form_element">
          <label>Acclaim:</label>
          <div class="checkbox-list">
            <div>
              <input class = "check" type="checkbox" name = "award" id="award" value="Award winning">
              <label for="award">Award winning album</label>
            </div>
            <div>
              <input class = "check" type="checkbox" name = "top" id="top" value="#1 Debut">
              <label for="top">Achieved a #1 position on charts at debut</label>
            </div>
          </div>
        </div>

      <div class="button_container">
        <input id = 'submit_button' name="submit_form" type="submit" value="Add album to gallery">
      </div>
      </form>
      <div class="button_container">
        <a href="index.php"><div id="return_button"><img src='images/back.png' id='plus_icon' alt='plus icon'>Return to gallery</div></a>
              <!-- back arrow icon from flaticon.com -->
      </div>

</body >

</html>
