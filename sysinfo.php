<?php
    ob_start();

    define(LANGUAGE, "german");

    $processor = str_replace("-compatible processor", "", explode(": ", exec("cat /proc/cpuinfo | grep Processor"))[1]);

    $uptimedata = shell_exec('uptime');
    $uptime = explode(' up ', $uptimedata);
    $uptime = explode(',', $uptime[1]);
    $uptime = $uptime[0];

    // RX = Download
    $rxdata = shell_exec("/sbin/ifconfig eth0 | grep RX\ bytes | cut -d: -f2 | awk '{ print $1 }'");
    $rx = explode(" RX ", $rxdata);
    $rx = explode(',', $rx[0]);
    $rx = $rx[0] / 1024 / 1024;
    $rx = round($rx, 2);

    // TX = Upload
    $txdata = shell_exec("/sbin/ifconfig eth0 | grep TX\ bytes | cut -d: -f3 | awk '{ print $1 }'");
    $tx = explode(" TX ", $txdata);
    $tx = explode(',', $tx[0]);
    $tx = $tx[0] / 1024 / 1024;
    $tx = round($tx, 2);

    $space = shell_exec('df -T | grep -vE "tmpfs|rootfs|Filesystem"');


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
         <button class="btn btn-danger btn-small"><i class=icon-off></i> Shutdown</button>
         <button class="btn btn-warning btn-small"><i class=icon-refresh></i> Restart</button>
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

        <div id="container-hinfos">
        <img id="logo-custom" src="images/raspberry.png">
        <div id="title">RHS Panel</div>

                <div id="border">&nbsp;</div>

                <?php if(isset($processor)){ ?>
                    <br><div id="processor"><a class=" btn-lg btn-danger"><b><?php echo TXT_CPU_INFO; ?></a></b>&nbsp;&nbsp;&nbsp;&nbsp;<a class=" btn-lg btn-success"><?php echo $processor; ?><span STYLE="font-size: 8px;"></a></span></div></br>
                <?php } ?>

                <?php if(isset($uptime)){ ?>
                <div id="uptime"><a class=" btn-lg btn-danger"><b><?php echo TXT_RUNTIME; ?></a></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class=" btn-lg btn-success"><?php echo $uptime; ?><span STYLE="font-size: 8px;"></a></span></div>
                <?php } ?>

                <?php if(isset($tx)){ ?>
                <div id="txdata"><a class=" btn-lg btn-danger"><b><?php echo TXT_TXDATA; ?></a></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class=" btn-lg btn-success"><?php echo $tx; ?>&nbsp;MB<span STYLE="font-size: 8px;"></a></span></div>
                <?php } ?>

                <?php if(isset($rx)){ ?>
                <div id="rxdata"><a class=" btn-lg btn-danger"><b><?php echo TXT_RXDATA; ?></a></b>&nbsp;<a class=" btn-lg btn-success"><?php echo $rx; ?>&nbsp;MB<span STYLE="font-size: 8px;"></a></span></div>
                <?php } ?>

                <br><div id="border">&nbsp;</div></br>

        </div>
    </body>
</html>
