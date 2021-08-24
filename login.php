<?php
  require_once 'header.php';

  $_SESSION['message'] = $user = $pass = "";
  if (isset($_POST['user']))
  {
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);
    
    if ($user == "" || $pass == "")
        $_SESSION['message'] = "<span class='error'>ყველა ველი უნდა შეივსოს</span>";
    else
    {
      $hashedPW = hash('sha256', $pass);
      $result = queryMySQL("SELECT user,pass FROM members WHERE user='$user' AND pass='$hashedPW'");

      if ($result->num_rows == 0)
      {
        $_SESSION['message'] = "<span class='error'>მომხმარებელი/პაროლი არასწორია</span>";
      }
      else
      {
        $_SESSION['user'] = $user;
        $_SESSION['message'] = "<font color='#005f00'>თქვენ წარმატებით შემოხვედით.</font>";
        ob_clean();
        header("Location: home.php");
        
        die();
      }
    }
  }
  header("Location: index.php");
  die();
?>
  </body>
</html>
