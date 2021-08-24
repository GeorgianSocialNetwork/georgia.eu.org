  <?php
  require_once 'header.php';

  if (!$loggedin) {
    header("Location: index.php");
    die();
  }
  include "banner-left.php";
  include "banner-right.php";
  include "banner-top.php";
  echo "<br><div class='main'><br>";
  echo " <div id='search-box' align='center'>
  <form action='search.php' method='post' name='search' id='search'>
  ძებნა: <input type='text' name='search' placeholder='მომხმარებელი..'><br>
  <input type='submit' value='ძებნა' />
  </form></div><br>";

    echo "<center><fieldset>
    <legend>ძებნის შედეგი</legend>";

  if (isset($_POST['search'])) {
    if (strpos($_POST['search'],'@') !== false) {
      $query = sanitizeString($_POST['search']);
      $result= queryMysql("SELECT * FROM members WHERE email LIKE '$query'");
      $num   = $result->num_rows;
      for ($j = 0 ; $j < $num ; ++$j){ 
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if ($row['user'] == $user) continue;
        $u = $row['user'];
        echo "<a href='members.php?view=".$u."'>".$u."</a>";
        }
      } else {
        $query = sanitizeString($_POST['search']);
        $result= queryMysql("SELECT * FROM members WHERE user LIKE '%$query%' or first_name LIKE '%$query%' or last_name LIKE '%$query%' or city LIKE '%$query%'");

        $num   = $result->num_rows;
        echo "<ul>";
        for ($j = 0 ; $j < $num ; ++$j){ 
          $row = $result->fetch_array(MYSQLI_ASSOC);
          if ($row['user'] == $user) continue;
          /**/
          $u = $row['user'];
          $pic_path = PROFILE_PICS_PATH.$u.'.jpg';
          if (file_exists($pic_path))
            echo "<img src='$pic_path' style='width:40px;height:40px'><a href='members.php?view=".$u."'>".$u."</a><hr>";
	else
		echo "<a href='members.php?view=".$u."'>".$row['first_name'].' '.$row['last_name'].' ('.$u.")</a><hr>";
        }

      }

    } 
    echo "</center></fieldset><br>";
    ?>
  <br><br><br></div>
  </body>
  </html>
