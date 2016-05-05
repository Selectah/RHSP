<?php
    ob_start();

    define(LANGUAGE, "german");


    $temp = shell_exec('cat /sys/class/thermal/thermal_zone*/temp');
    $temp = round($temp / 1000, 1);

    $clock = shell_exec('cat /sys/devices/system/cpu/cpu0/cpufreq/scaling_cur_freq');
    $clock = round($clock / 1000);

    $voltage = floatval(shell_exec('vcgencmd measure_volts core | cut -d"=" -f2 | cut -d"V" -f1'));
    $voltage = round($voltage,2);

    $memfree = shell_exec("grep 'MemFree' /proc/meminfo | grep -E '[0-9.]{4,}' -o");
    $memfree = round($memfree / 1000);

    $cpuusage = explode(',', $cpuusage[0]);
    $cpuusage = $cpuusage[0] / 1024;

    function get_server_cpu_usage(){
 
    $cpuusage = sys_getloadavg();
    $cpuusage = $cpuusage[0] * 25;
       return $cpuusage;
 
    }

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

        <script>
            function checkAction(action){
                if (confirm('<?php echo TXT_CONFIRM; ?> ' + action + '?'))
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }

            window.onload = doLoad;

            function doLoad()
            {
            setTimeout( "refresh()", 30*1000 );
            }

            function refresh()
            {
            window.location.reload( false );
            }
        </script>
    </head>

    <body>
        <div id="container">
                <img id="logo" src="images/raspberry.png">
                <div id="title">RHS Panel</div>

                <?php if(isset($temp) && is_numeric($temp)){ ?>
                    <div id="tempgauge"></div>
                    <script>
                        var t = new JustGage({
                            id: "tempgauge",
                            value: <?php echo $temp; ?>,
                            min: 0,
                            max: 100,
                            title: "<?php echo TXT_TEMPERATURE; ?>",
                            label: "°C"
                        });
                    </script>
                <?php } ?>

                <?php if(isset($voltage) && is_numeric($voltage)){ ?>
                    <div id="voltgauge"></div>
                    <script>
                        var v = new JustGage({
                            id: "voltgauge",
                            value: <?php echo $voltage; ?>,
                            min: 0.8,
                            max: 1.4,
                            title: "<?php echo TXT_VOLTAGE; ?>",
                            label: "V"
                        });
                    </script>
                <?php } ?>

                <?php if(isset($memfree) && is_numeric($memfree)){ ?>
                    <div id="memfreegauge"></div>
                    <script>
                        var mf = new JustGage({
                            id: "memfreegauge",
                            value: <?php echo $memfree; ?>,
                            min: 0,
                            max: 1000,
                            title: "<?php echo TXT_MEMFREE; ?>",
                            label: "MB Frei",
                            levelColors: ["#FF0505", "#FFBF00", "#40FF00"]
                        });
                    </script>
                <?php } ?>

                <?php if(isset($cpuusage) && is_numeric($cpuusage)){ ?>
                    <div id="cpugauge"></div>
                    <script>
                        var u = new JustGage({
                            id: "cpugauge",
                            value: <?php echo get_server_cpu_usage() ?>,
                            min: .0,
                            max: 100,
                            title: "<?php echo TXT_USAGE; ?>",
                            label: "%"
                        });
                    </script>
                <?php } ?>

                <?php if(isset($clock) && is_numeric($clock)){ ?>
                    <div id="clockgauge"></div>
                    <script>
                        var c = new JustGage({
                            id: "clockgauge",
                            value: <?php echo $clock; ?>,
                            min: 0,
                            max: 1200,
                            title: "<?php echo TXT_CLOCK; ?>",
                            label: "MHz"
                        });
                    </script>
                <?php } ?>
        </div>
    </body>
</html>
