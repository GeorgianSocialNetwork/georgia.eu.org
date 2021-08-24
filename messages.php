<?php
  require_once 'header.php';
  include "banner-left.php";
  include "banner-right.php";
  include "banner-top.php";
  if (!$loggedin) die();

  if (isset($_GET['view'])) $view = sanitizeString($_GET['view']);
  else                      $view = $user;

  if (isset($_POST['text']))
  {
    $text = sanitizeString($_POST['text']);

    if ($text != "")
    {
      $pm   = substr(sanitizeString($_POST['pm']),0,1);
      $time = time();
      queryMysql("INSERT INTO messages VALUES(NULL, '$user',
        '$view', '$pm', $time, '$text')");
    }
  }

  if ($view != "")
  {
    if ($view == $user) $name1 = $name2 = "შემოსული";
    else
    {
      $name1 = "<a href='members.php?view=$view'>$view</a>'ს";
      $name2 = "$view'ს";

echo "<br>&nbsp;&nbsp;&nbsp; $name1 წერილები";
showProfile($view);
echo <<<_END
      <br><center><form method='post' action='messages.php?view=$view'>
      <br>წერილი:<br>
      <textarea name='text' cols='20' rows='3'></textarea><br>
	  <input type='submit' value='მიწერა'>
      <input type='hidden' name='pm' value='1' checked='checked'>
      </form></center><br>
_END;
    }
	echo "<br><center><br><a class='button' href='messages.php?view=$view'>წერილების განახლება</a><br></center><br>";
	echo "<center><fieldset>
    <legend>შეტყობინებები</legend>";
	echo "<div class='main'>";
    if (isset($_GET['erase']))
    {
      $erase = sanitizeString($_GET['erase']);
      queryMysql("DELETE FROM messages WHERE id=$erase AND recip='$user'");
    }
    
    $query  = "SELECT * FROM messages WHERE recip='$view' ORDER BY time DESC LIMIT 500";
    $result = queryMysql($query);
    $num    = $result->num_rows;
    
    for ($j = 0 ; $j < $num ; ++$j)
    {
      $row = $result->fetch_array(MYSQLI_ASSOC);

      if ($row['pm'] == 0 || $row['auth'] == $user || $row['recip'] == $user)
      {
        echo date('M jS \'y g:ia:', $row['time']);
        echo " <a href='messages.php?view=" . $row['auth'] . "'>" . $row['auth']. "</a>'ს ";

        if ($row['pm'] == 0)
          echo "";
        else
          echo "წერილი: <span class='whisper'>&quot;" .
            $row['message']. "&quot;</span> ";

        if ($row['recip'] == $user)
          echo "[<a href='messages.php?view=$view" .
               "&erase=" . $row['id'] . "'>წაშლა</a>]";

        echo "<hr>";
      }
    }
  }

  if (!$num) echo "<br><span class='info'>წერილები არაა";
echo "</center></fieldset><br>";
?>

    </div><br><br>
  </body>
</html>
