<?php
  require_once 'header.php';

  if (isset($_SESSION['user']))
  {
    logout();
    $_SESSION['message'] = "<font color='#ff0000'>თქვენ გამოხვედით.</font>";
    header("Location: index.php");
    die();
  }
  else echo "<div class='main'><br>გამოირთო.<br><br></div>";
?>
  </body>
</html>
