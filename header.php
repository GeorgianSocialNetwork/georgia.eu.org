<?php
  ob_start();
  ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <script src='js/javascript.js'></script>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="ქართული მინი სოციალური ქსელი">
        <meta name="viewport" content="width=device-width">


		
		 <style>
      	body { background-image: url(/img/background.png); padding-top: 60px; }
		div.c { display: flex; align-items: center; justify-content: center; }
}
#myad{
    display: block;
}

@media (max-width: 1300px) 
{
    #myad
    {
        display: none;
    }
}
fieldset{
	display: block; align-items: center; max-width: 600px; border-radius: 8px 16px 8px; background-color: #fefefe; -webkit-filter: opacity(.9);
}
		</style>
<?php
  date_default_timezone_set('GMT');

  session_start();

  require_once 'functions.php';

  $userstr = '';

  if (isset($_SESSION['user']))
  {
    $user     = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr  = " ($user)";
  }
  else $loggedin = FALSE;
  echo "<title>$appname$userstr</title>";
?>
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-responsive.min.css">
		<link rel="stylesheet" href="css/bpg-nino-mtavruli.min.css">
		<link rel="stylesheet" href="css/bpg-nino-mtavruli.css">
    </head>
<body>



     <div id="navbar" class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="/">GEORGIA.EU.ORG</a>
          <div class="nav-collapse collapse">
            <ul class="nav" width="100%">
			<?php if($loggedin): ?>
              <li class="active"><a href="index.php">სიახლეები</a></li>
			  <li>
			  <li class="active"><a href='members.php'>მომხმარებლები</a></li>
			  <li>
			  <li class="active"><a href='friends.php'>მეგობრები</a></li>
			  <li>
			  <li class="active"><a href='messages.php'>საფოსტო ყუთი</a></li>
			  <li>
			  <li class="active"><a href='profile.php'>პროფილი</a></li>
			  <li>
			  <li class="active"><a href='logout.php'>გასვლა</a></li>
			  <li>
			  <?php else: ?>
				<form class="navbar-form pull-right" action="login.php" method="POST" novalidate="novalidate" id="login">
				  <input name="user" class="span2" type="text" placeholder="მომხმარებელი">
                  <input name="pass" class="span2" type="password" placeholder="პაროლი">
                  <button name="signin" type="submit" id="signin" class="btn">შესვლა</button>
                </form>
				<?php endif;?>
			  </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
<div id="messageBox">
  <p>
      <?php
      if (isset($_SESSION['message'])) {
        echo "<center><span class=''>".$_SESSION['message']."</span></center>";
        $_SESSION['message'] = NULL;  
      }
      ?>
    </p>  
</div>
		<script>window.jQuery || document.write('<script src="js/jquery-1.8.2.min.js"><\/script>')</script>
        <script>document.write('<script src="js/bootstrap.min.js"><\/script>')</script>
    <div class="container-fluid">
