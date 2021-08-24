<?php
  require_once 'header.php';

  if (!$loggedin) die();

  if (isset($_GET['view'])) $view = sanitizeString($_GET['view']);
  else                      $view = $user;

  if ($view == $user)
  {
    $name1 = $name2 = "";
    $name3 =          "";
  }
  else
  {
    $name1 = "<a href='members.php?view=$view'>$view</a>'s";
    $name2 = "$view'ს";
    $name3 = "$view არის";
  }

  $followers = array();
  $following = array();

  $result = queryMysql("SELECT * FROM friends WHERE user='$view'");
  $num    = $result->num_rows;
  for ($j = 0 ; $j < $num ; ++$j)
  {
    $row           = $result->fetch_array(MYSQLI_ASSOC);
    $followers[$j] = $row['friend'];
  }

  $result = queryMysql("SELECT * FROM friends WHERE friend='$view'");
  $num    = $result->num_rows;

  for ($j = 0 ; $j < $num ; ++$j)
  {
      $row           = $result->fetch_array(MYSQLI_ASSOC);
      $following[$j] = $row['user'];
  }

  $mutual    = array_intersect($followers, $following);
  $followers = array_diff($followers, $mutual);
  $following = array_diff($following, $mutual);
  $friends   = FALSE;

  $sugestions = array();
  $list = "(";
  foreach ($following as $value) {
    $list.="'".$value."',";
  }
  if ($list[strlen($list)-1]==",") {
    $list = substr($list, 0, strlen($list)-1);
  }
  $list.=")";

  if($list!='()'){
    $result = queryMysql("SELECT * FROM friends WHERE friend in $list group by user");
    $num    = $result->num_rows;
    for ($j = 0 ; $j < $num ; ++$j)
    {
      $row           = $result->fetch_array(MYSQLI_ASSOC);
      $sugestions[$j] = $row['user'];
    }
  }
  

  include "banner-left.php";
  include "banner-right.php";
  include "banner-top.php";
  echo "<center><br><fieldset>
    <legend>კონტაქტები</legend>";
  if (sizeof($mutual))
  {
    echo "<br>$name2 მეგობრები<hr>";
    foreach($mutual as $friend)
      echo "<a href='members.php?view=$friend'>$friend</a><hr>";
    $friends = TRUE;
  }

  if (sizeof($followers))
  {
    echo "<br>$name2 მეგობრობის მოთხოვნა გამოგზავნილია<hr>";
    foreach($followers as $friend)
      echo "<a href='members.php?view=$friend'>$friend</a><hr>";
    $friends = TRUE;
  }

  if (sizeof($following))
  {
    echo "<br>$name3 მეგობრობის მოთხოვნა გაგზავნილია</hr>";
	echo "<hr>";
    foreach($following as $friend)
      echo "<a href='members.php?view=$friend'>$friend</a><hr>";
    $friends = TRUE;
  }

  if (!$friends) echo "<br>ჯერ მეგობრები არ გყავთ.<br>";

  if (sizeof($sugestions))
  {
    echo "ადამიანები რომლებსაც შესაძლოა იცნობდეთ<hr>";
    foreach($sugestions as $friend)
      echo "<a href='members.php?view=$friend'>$friend</a><hr>";
  }
    echo "</center></fieldset><br>";
?>
  <br><br><br></body>
</html>
