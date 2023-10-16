<?php include("includes/init.php");
  $db = open_or_init_sqlite_db('secure/gallery.sqlite', 'secure/init.sql');

  $tag_name = filter_input(INPUT_GET, 'tag_name', FILTER_SANITIZE_STRING);
  $image_id = filter_input(INPUT_GET, 'image_id', FILTER_SANITIZE_STRING);
  $delete = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_BOOLEAN);
  $delete_tag = filter_input(INPUT_GET, 'delete_tag', FILTER_VALIDATE_INT);
  $add_tag = filter_input(INPUT_GET, 'add_tag', FILTER_VALIDATE_BOOLEAN);


  function print_tags($tags){
    global $tag_name;
    foreach ($tags as $tag)

      if ($tag_name == $tag){
        echo"<a href ='index.php'><div id = 'selected_tag'><p>". $tag ."</p></div></a>";
      } else{
        echo"<a href ='index.php?". http_build_query(array('tag_name' => $tag))."'><div class = 'tag'><p>". $tag ."</p></div></a>";
      }
  }

  function tag_filter($db, $tag_name){
    $sql = "SELECT id FROM tags WHERE name = :tag_name";
    $params = array(':tag_name' => $tag_name);
    $tag_id_array = exec_sql_query($db, $sql, $params)->fetchAll();

    foreach ($tag_id_array as $id)
      $tag_id = $id["id"];

    $sql = "SELECT * FROM image_tags INNER JOIN images ON images.id = image_tags.image_id WHERE image_tags.tag_id = :tag_id";
    $params = array(':tag_id' => $tag_id);
    $filtered_results = exec_sql_query($db, $sql, $params);

    return $filtered_results;
  }

  if ($delete==TRUE){
    $sql = "SELECT file_ext FROM images WHERE id = :image_id";
    $params = array(':image_id' => $image_id);
    $file_exts = exec_sql_query($db, $sql, $params);
    foreach($file_exts as $ext)
      $file_ext = $ext["file_ext"];

    $file = "uploads/images/".$image_id . $file_ext;
    $deleted = unlink($file);

    $sql = "DELETE FROM images WHERE id = :image_id";
    exec_sql_query($db, $sql, $params);

    $sql = "DELETE FROM image_tags WHERE image_id = :image_id";
    exec_sql_query($db, $sql, $params);

    if ($deleted){
      $message = "<p id='message'>This album has successfully been deleted from the collection. Click <a href='index.php'>here</a> to return to the gallery.</p>";
    } else{
      $message = "<p id='message'>Failed to delete image. Click <a href='index.php'>here</a> to return to the gallery.</p>";
    }
  }

  if ($delete_tag != NULL){
    $sql = "DELETE FROM image_tags WHERE image_id = :image_id AND tag_id = :delete_tag_id";
    $params = array(':image_id' => $image_id, ':delete_tag_id' => $delete_tag);
    exec_sql_query($db, $sql, $params);
  }

  if (!empty($_POST)){
    $twentyfifteen = $_POST['1'];
    $twentysixteen = $_POST['2'];
    $twentyseventeen = $_POST['3'];
    $twentyeighteen = $_POST['4'];
    $twentynineteen = $_POST['5'];
    $twentytwenty = $_POST['6'];

    $melodic = $_POST['7'];
    $lyrical = $_POST['8'];
    $trap = $_POST['9'];
    $pop = $_POST['10'];
    $award = $_POST['11'];
    $top = $_POST['12'];

    $thirteen = $_POST['13'];
    $fourteen = $_POST['14'];
    $fifteen = $_POST['15'];
    $sixteen = $_POST['16'];
    $seventeen = $_POST['17'];


    $new_tag = filter_input(INPUT_POST, 'new_tag', FILTER_SANITIZE_STRING);

    $tags_array = array($twentyfifteen,$twentysixteen,$twentyseventeen,$twentyeighteen,$twentynineteen,$twentytwenty,$melodic,$lyrical,$trap,$pop,$award,$top, $thirteen, $fourteen, $fifteen, $sixteen, $seventeen);

    $sql = "SELECT id FROM tags";
    $tags_id_table = exec_sql_query($db, $sql, $params);

    $tags_id_array = array();
    foreach ($tags_id_table as $tag_id){
      $tag_id_array[] = $tag_id['id'];
    }

    foreach ($tags_array as $tag){
      if (($tag != NULL)&&(!is_int($tag)&&(!in_array($tag,$tags_id_array)))){
        $tag = NULL;
      }
    }

    if ($new_tag != NULL) {
      $valid_entry = TRUE;
      $sql = "SELECT name FROM tags";
      $names_array = exec_sql_query($db, $sql, $params);

      foreach($names_array as $name)
        if ($name['name']==$new_tag){
          $valid_entry = FALSE;
        }

      if ($valid_entry){
        $sql = "INSERT INTO tags (name) VALUES (:name)";
        $params = array(
            ':name' => $new_tag,
          );
        exec_sql_query($db, $sql, $params);

        $sql = "SELECT id FROM tags WHERE name = :name";
        $params = array(
            ':name' => $new_tag,
          );
        $id_array = exec_sql_query($db, $sql, $params);

        foreach($id_array as $new_tag_id)
          $tags_array[] = $new_tag_id['id'];
      }
    }

    foreach ($tags_array as $tag){
      if ($tag != NULL){
        $sql = "INSERT INTO image_tags (image_id, tag_id) VALUES (:image_id, :tag_id)";
        $params = array(
        ':image_id' => $image_id,
        ':tag_id' => $tag
          );
        exec_sql_query($db, $sql, $params);
      }
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
  <div id = "sidebar">
    <a href="add.php">
      <div id="add_button">
      <img src='images/plus.png' id='plus_icon' alt='plus icon'>
      <!-- plus icon from flaticon.com -->
      <p>Add Album</p>
      </div>
    </a>

    <h2 id="filter_header">Filters</h2>

    <h3 class="tag_header">Year</h3>
    <div class = "tags_container">
      <?php $tags = array("2015","2016","2017","2018","2019","2020") ;
        print_tags($tags);
      ?>
    </div>

    <h3 class="tag_header">Type of rap</h3>
    <div class = "tags_container">
      <?php $tags = array("Melodic rap","Lyrical rap","Trap","Pop rap") ;
        print_tags($tags);
      ?>
    </div>

    <h3 class="tag_header">Acclaim</h3>
    <div class = "tags_container">
      <?php $tags = array("Award winning","#1 Debut") ;
        print_tags($tags);
      ?>
    </div>

    <h3 class="tag_header">User Tags</h3>
    <div class = "tags_container">
      <?php
        $sql = "SELECT * FROM tags WHERE id>12";
        $tags_array = exec_sql_query($db, $sql)->fetchAll();
        $tags = array();
        foreach($tags_array as $tag){
          $tags[] = $tag['name'];
        }
        print_tags($tags);
      ?>
    </div>
    <div id = "spacer"></div>

  </div>

  <div id = "container">
    <?php

      if (!$image_id){
        if ($tag_name){
          $grid = tag_filter($db, $tag_name)->fetchAll(PDO::FETCH_ASSOC);;
        } else{
          $grid = exec_sql_query($db, "SELECT * FROM images")->fetchAll(PDO::FETCH_ASSOC);
        }

        foreach ($grid as $image) {
          echo "<div class = 'grid_image_container'><a href='index.php?". http_build_query(array('image_id' => $image["id"]))."'><img src=\"uploads/images/" . $image["id"] . "" . $image["file_ext"] . "\" class = 'grid_image' alt= '".$image['album_name']."'></a><cite class='grid_citation'>".$image['source']."</cite></div>";
        }

      } else if ($delete==TRUE){
        echo $message;

      }else {
        $display_footer = TRUE;
        $sql = "SELECT * FROM images WHERE id = :image_id";
        $params = array(':image_id' => $image_id);
        $image_details_array = exec_sql_query($db, $sql, $params)->fetchAll();
        foreach ($image_details_array as $image_details) {
          echo "<img src=\"uploads/images/" . $image_details["id"] . "" . $image_details["file_ext"] . "\" class = \"large_image\" alt= '".$image_details["album_name"]."'>";

          echo "<div id='details_container'><div id='icon_container'><a href='index.php'><img src='images/letter-x.png' class='icon' alt='x icon'></a><a href='index.php?".http_build_query(array('delete'=>TRUE, 'image_id'=>$image_details["id"]))."'><img src='images/delete.png' class='icon' alt='delete icon'></a><a href='index.php?".http_build_query(array('add_tag'=>TRUE, 'image_id'=>$image_details["id"]))."'><img src='images/plus.png' class='icon' alt='plus icon'></a></div><h2>".$image_details["album_name"]."</h2><h3>".$image_details['artist']."</h3>";

          //x icon from flaticon.com
          //delete icon from flaticon.com

          $sql = "SELECT tags.name, tags.id FROM image_tags INNER JOIN tags ON image_tags.tag_id = tags.id WHERE image_tags.image_id = :image_id";
          $tags_array = exec_sql_query($db, $sql, $params)->fetchAll();
          $used_tags_array = array();
          echo "<div class='inner_container'><div class='inner_tags'>";
          foreach ($tags_array as $tag) {
            echo "<div class = 'tag'><p>".$tag['name']."</p><a href='index.php?".http_build_query(array('image_id' => $image_details["id"], 'delete_tag'=>$tag['id']))."'><img src='images/letter-x.png' class='delete_tag' alt='x icon'></a></div>";
            $used_tags_array[] = $tag['id'];
          }
          echo "</div>";

          if ($add_tag){
            $sql = "SELECT * FROM tags";
            $full_tags_array = exec_sql_query($db, $sql)->fetchAll();
            $new_tags = array();
            echo "<form id = 'add_new_tags' name = 'add_new_tags' method='post' action='/index.php?".http_build_query(array('image_id' => $image_details["id"]))."' novalidate><h4>Select new tags to add</h4>";
            foreach($full_tags_array as $tag){
              if (!in_array($tag['id'], $used_tags_array)){
                echo "<div class='tags_form_element'><input type='checkbox' name = ".$tag['id']." id = '".$tag['id']."' value = '".$tag['id']."'><label for = '".$tag['id']."'>".$tag['name']."</label></div>";
              }
            }
            echo "<div class='tags_form_element'><label for = 'new_tag'>Add a new tag:</label><input type='text' name='new_tag' id='new_tag'></div>";
            echo "<div class='add_tags_button'><input type='submit' name='submit' value = 'Submit new tags'></div></form>";
          }
          echo "</div>";
          echo "</div>";
        }
      }
        ?>
    </div>
        <?php
        if ($display_footer){
          if ($image_details['source'] != NULL){
            echo "<footer><cite>Image from ". $image_details['source'].". Icons from flaticon.com.</cite></footer>";
          }else{
            echo "<footer><cite>Icons from flaticon.com.</cite></footer>";

          }
        }

        ?>

  <!-- Seeded image citations:
    -- To Pimp a Butterfly: https://pitchfork.com/reviews/albums/20390-to-pimp-a-butterfly/
    -- Rodeo: https://www.amazon.com/Rodeo-Travis-Scott/dp/B013LTUKBU
    -- Coloring Book: https://pitchfork.com/reviews/albums/21909-coloring-book/
    -- The Life of Pablo: https://en.wikipedia.org/wiki/The_Life_of_Pablo
    -- Culture: https://genius.com/albums/Migos/Culture
    -- LUV is Rage 2: https://genius.com/albums/Lil-uzi-vert/Luv-is-rage-2
    -- Astroworld: https://genius.com/albums/Travis-scott/Astroworld
    -- Scorpion: https://genius.com/albums/Drake/Scorpion
    -- Death Race for Love: https://genius.com/albums/Juice-wrld/Death-race-for-love
    -- So Much Fun: https://genius.com/albums/Young-thug/So-much-fun
    -- Eternal Atake: https://genius.com/albums/Lil-uzi-vert/Eternal-atake
    -- Music to be Murdered By: https://genius.com/albums/Eminem/Music-to-be-murdered-by
    -->
</body>

</html>
