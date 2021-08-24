<?php
  require_once 'header.php';

  if (!$loggedin) {
    header("Location: index.php");
    die();
  }

  if (isset($_POST['text']) && strlen($_POST['text'])>0) {
    $time = time();
    $pm   = substr(sanitizeString($_POST['pm']),0,1);
    $text = sanitizeString($_POST['text']);
    $recip = $_POST['recip'];
    queryMysql("INSERT INTO messages VALUES(NULL, '$user','$recip', '$pm', $time, '$text')");
  }

  echo "<div class='main'>";
  if (isset($_GET['add']))
  {
    $add = sanitizeString($_GET['add']);

    $result = queryMysql("SELECT * FROM friends WHERE user='$add' AND friend='$user'");
    if (!$result->num_rows)
      queryMysql("INSERT INTO friends VALUES ('$add', '$user')");
  }
  elseif (isset($_GET['remove']))
  {
    $remove = sanitizeString($_GET['remove']);
    queryMysql("DELETE FROM friends WHERE user='$remove' AND friend='$user'");
  }

  if (isset($_GET['view']))
  {
    $view = sanitizeString($_GET['view']);
    
    if ($view == $user) $name = "თქვენი";
    else                $name = "$view'ს";
   include "banner-left.php";
  include "banner-right.php";
  include "banner-top.php";
    echo "<br>&nbsp;&nbsp;&nbsp; $name გვერდი";

    $follow = "მეგობრებში დამატება";

    $result1 = queryMysql("SELECT * FROM friends WHERE
      user='" . $view . "' AND friend='$user'");
    $t1      = $result1->num_rows;
    $result1 = queryMysql("SELECT * FROM friends WHERE
      user='$user' AND friend='" . $view . "'");
    $t2      = $result1->num_rows;

    if (($t1 + $t2) > 1) echo " &harr; მეგობარი";
    elseif ($t1)         echo " &larr; გამოიწერეთ";
    elseif ($t2)       { echo " &rarr; გამოგიწერათ";
      $follow = "მეგობრობის დადასტურება"; }
    
    if (!$t1) echo " [<a href='members.php?add="   .$view . "&view=".$view."'>$follow</a>]";
    else      echo " [<a href='members.php?remove=".$view . "&view=".$view."'>მეგობრებიდან წაშლა</a>]";
	
	showProfile($view);
	    echo "</br>&nbsp;&nbsp;&nbsp; <a class='button' href='messages.php?view=$view'>" .
         "მიწერეთ $view'ს პირადი შეტყობინება</a><br><br>";
    echo "<br><center>
    <form method='post' action='members.php?view=$view'>
      <br>განათავსეთ რაიმე $view'ს კედელზე<br>
      <textarea name='text' cols='20' rows='3' style='resize:none'></textarea><br>
	  <input type='submit' value='გამოქვეყნება'>
      <input type='hidden' name='pm' value='0' checked='checked'>
      <input type='hidden' name='recip' value='$view'>
      </form><br>
  </center>";

  echo "<center><fieldset>
    <legend>სიახლეები</legend>";
    $messages = getMessages($view,null,0);
    if ($messages->num_rows) {
      $num = $messages->num_rows;
      for ($j = 0 ; $j < $num ; ++$j)
      {
        $row = $messages->fetch_array(MYSQLI_ASSOC);
        echo date('M jS \'y g:ia:', $row['time']);
        echo " <a href='members.php?view=" . $row['auth'] . "'>" . $row['auth']. "</a> ";
        echo "დაწერა: &quot;" . $row['message'] . "&quot; <hr>";
      }
    }
	echo "</center></fieldset>";
    die("</div></body></html>");
  }

  
  $result = queryMysql("SELECT user FROM members ORDER BY user");
  $num    = $result->num_rows; 
  include "banner-left.php";
  include "banner-right.php";
  include "banner-top.php";
  echo " <br><div id='search-box' align='center'><br>
         <form action='search.php' method='post' name='search' id='search'> 
          ძებნა: <input type='text' name='search' placeholder='მომხმარებელი..'><br> 
          <input type='submit' value='ძებნა' /> 
          </form></div>";
	  echo "<center><br><fieldset>
    <legend>რეგისტრირებულები</legend>";
  echo "<br>მომხმარებლები<hr>";

  for ($j = 0 ; $j < $num ; ++$j)
  {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if ($row['user'] == $user) continue;
    
    echo "<a href='members.php?view=" .
      $row['user'] . "'>" . $row['user'] . "</a>";
    $follow = "მეგობრებში დამატება";

    $result1 = queryMysql("SELECT * FROM friends WHERE
      user='" . $row['user'] . "' AND friend='$user'");
    $t1      = $result1->num_rows;
    $result1 = queryMysql("SELECT * FROM friends WHERE
      user='$user' AND friend='" . $row['user'] . "'");
    $t2      = $result1->num_rows;

    if (($t1 + $t2) > 1) echo " &harr; მეგობარი";
    elseif ($t1)         echo " &larr; გამოიწერეთ";
    elseif ($t2)       { echo " &rarr; გამოგიწერათ";
      $follow = "მეგობრობის დადასტურება"; }
    
    if (!$t1) echo " [<a href='members.php?add="   .$row['user'] . "'>$follow</a>]<hr>";
    else      echo " [<a href='members.php?remove=".$row['user'] . "'>მეგობრებიდან წაშლა</a>]<hr>";
  }
      echo "</center></fieldset><br><br>";
?>
  </ul>
  </div>
  <br><br><br><br>
  </body>
</html>
