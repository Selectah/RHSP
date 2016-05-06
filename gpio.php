<?php
    ob_start();

    define(LANGUAGE, "german");

    include 'lang/'.LANGUAGE.'.lang.php';

?>

<!DOCTYPE html>
<html>

<nav class="navbar-nav navbar-default navbar-static-top">
   <div class="container">
      <center>
         <a href="index.php" class="btn btn-info btn-small"><i class=icon-home></i> Home</a>
         <a href="cp.php" class="btn btn-info btn-small"><i class=icon-user></i> UserCP</a>
         <a href="temp.php" class="btn btn-info btn-small"><i class=icon-fire></i> Tempstatus</a>
         <a href="sysinfo.php" class="btn btn-info btn-small"><i class=icon-leaf></i> Systeminfos</a>
         <a href="gpio.php" class="btn btn-info btn-small"><i class=icon-eye-open></i> GPIO Watch</a>
         <a href="services.php" class="btn btn-info btn-small"><i class=icon-signal></i> Running Services</a>
      </center>
   </div>
</nav>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Raspberry Pi Control Panel</title>
        <link rel="stylesheet" href="stylesheets/main.css">
        <link rel="stylesheet" href="stylesheets/button.css">
        <link rel="stylesheet" href="stylesheets/flat-ui.css">

        <link rel="stylesheet" href="stylesheets/bootstrap.css">
        <link rel="stylesheet" href="stylesheets/bootstrap.min.css">
        <link rel="stylesheet" href="stylesheets/bootstrap-responsive.css">
        <link rel="stylesheet" href="stylesheets/bootstrap-responsive.min.css">

        <script src="javascript/bootstrap.js"></script>
        <script src="javascript/bootstrap.min.js"></script>
        <script src="javascript/raphael.2.1.0.min.js"></script>
        <script src="javascript/justgage.1.0.1.min.js"></script>
    </head>

    <body>
        <div id="container">
        <img id="logo-custom" src="images/raspberry.png">
        <div id="title">RHS Panel</div>
        <br><b> GPIO Panel coming  soon...</b></br>
        </div>
    </body>
</html>
