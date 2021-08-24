<?php
require_once 'header.php';


  $error = $user = $pass = "";
  if ($loggedin) {
    header('Location: home.php');
    die();
  }

  $first_name = "";
  $last_name = "";

  if (isset($_POST['user']))
  {
    $first_name = sanitizeString($_POST['first_name']);
    $last_name = sanitizeString($_POST['last_name']);
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);
    $passConf = sanitizeString($_POST['passConf']);
    $city  = sanitizeString($_POST['city']);

    if ($user == "" || $pass == "")
      $error = "ყველა ველი არაა შვსებული.<br><br>";
    else if($pass != $passConf){
      $error = "პაროლები არ ემთხვევა.<br><br>";
    }
    else
    {
      $result = queryMysql("SELECT * FROM members WHERE user='$user'");

      if ($result->num_rows)
        $error = "მომხმარებელი უკვე არსებობს<br><br>";
      else
      {
        $hashedPW = hash('sha256', $pass);
        if(queryMysql("INSERT INTO members VALUES('$user', '$hashedPW','$first_name','$last_name','$city')")){
          queryMysql("INSERT INTO profiles VALUES('$user', '')");
          $_SESSION['user'] = $user;
          
          $_SESSION['message'] = "<font color='#005f00'>თქვენ წარმატებით დარეგისტრირდით! შემოხვედით საიტზე.</font>";
          ob_clean();
          header("Location: home.php");
          die("<h4>თქვენ წარმატებით დარეგისტრირდით</h4>გთხოვთ გაიაროთ ავტორიზაცია და შეხვიდეთ სისტემაში.<br><br>");
        }
        else
          $error = "ბოდიშით, რეგისტრაცია ვერ მოხერხდა. გთხოვთ, ხელახლა სცადეთ მოგვიანებით.";
      }
    }
  }
include "banner-left.php";
include "banner-right.php";
include "banner-top.php";
  echo <<<_END
  <center><br><br><b><font color="#0000ff">GEORGIA.EU.ORG</font></b>-ი <font color="#005f00">გეხმარებათ დაუკავშირდეთ და ეკონტაქტოთ სანაცნობო წრეს</font><br><br></center><br><br><div class="c">
  <form method='post' action='index.php'>$error
  <span class='fieldname'><h3><font color="#cccccc">რეგისტრაცია</font></h3></span><br>
    <span class='fieldname'>სახელი</span><br>
    <input id='formFirst_Name' type='text' maxlength='16' name='first_name' value='$first_name' placeholder="მინ. 4 მაქს. 16 სიმბოლო"
    ><br>
    <span class='fieldname'>გვარი</span><br>
    <input id='formLast_Name' type='text' maxlength='16' name='last_name' value='$last_name' placeholder="მინ. 4 მაქს. 16 სიმბოლო"
    ><br>
    <span class='fieldname'><font color="#ff0000">მომხმარებელი <b>*</font></b></span><br>
    <input id='formUser' type='text' maxlength='16' required="required" name='user' value='$user' placeholder="მინ. 4 მაქს. 16 სიმბოლო"
    ><br>
    <span class='fieldname'<font color="#ff0000">>პაროლი <b>*</font></b></span><br>
    <input id='formPass' type='password' maxlength='16' required="required" name='pass' placeholder="მინიმუმ 8 სიმბოლო"
    value='$pass'>
    <br>
    <span class='fieldname'><font color="#ff0000">გაიმეორეთ პაროლი <b>*</font></b></span><br>
    <input id='formPassConf' type='password' maxlength='16' required="required" name='passConf' placeholder="იგივე პაროლი"
    value='$pass'>
    <br>
    <span class='fieldname'>ქალაქი</span><br>
    <input id='city' type='text' name='city' placeholder="მდებარეობა"><br>
    <input id='formSubmit' type='submit' value='რეგისტრაცია'><br>
  <br></form><br>
</div><br></div>
_END;
echo "<br><br><br>";
?>
<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>

</body>
</html>
<?php include "banner.php"; ?>