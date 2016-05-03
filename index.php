<?php
    ob_start();

    define(LANGUAGE, "german");


    $temp = shell_exec('cat /sys/class/thermal/thermal_zone*/temp');
    $temp = round($temp / 1000, 1);

    $clock = shell_exec('cat /sys/devices/system/cpu/cpu0/cpufreq/scaling_cur_freq');
    $clock = round($clock / 1000);

    $voltage = floatval(shell_exec('vcgencmd measure_volts core | cut -d"=" -f2 | cut -d"V" -f1'));
    //$voltage = explode("=", $voltage);
    //$voltage = $voltage[1];
    //$voltage = substr($voltage,0,-2);
    //$voltage = round($voltage / 1000);
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

    $processor = str_replace("-compatible processor", "", explode(": ", exec("cat /proc/cpuinfo | grep Processor"))[1]);

    $uptimedata = shell_exec('uptime');
    $uptime = explode(' up ', $uptimedata);
    $uptime = explode(',', $uptime[1]);
    $uptime = $uptime[0];

    // RX = Download
    $rxdata = shell_exec("/sbin/ifconfig wlan0 | grep RX\ bytes | cut -d: -f2 | awk '{ print $1 }'");
    $rx = explode(" RX ", $rxdata);
    $rx = explode(',', $rx[0]);
    $rx = $rx[0] / 1024 / 1024;
    $rx = round($rx, 2);

    // TX = Upload
    $txdata = shell_exec("/sbin/ifconfig wlan0 | grep TX\ bytes | cut -d: -f3 | awk '{ print $1 }'");
    $tx = explode(" TX ", $txdata);
    $tx = explode(',', $tx[0]);
    $tx = $tx[0] / 1024 / 1024;
    $tx = round($tx, 2);

    $space = shell_exec('df -T | grep -vE "tmpfs|rootfs|Filesystem"');
    

    include 'lang/'.LANGUAGE.'.lang.php';

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Raspberry Pi Control Panel</title>
        <link rel="stylesheet" href="stylesheets/main.css">
        <link rel="stylesheet" href="stylesheets/button.css">
        <link rel="stylesheet" href="stylesheets/flat-ui.css">
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

        <div id="container-hinfos">

                <div id="border">&nbsp;</div>

                <?php if(isset($processor)){ ?>
                    <br><div id="processor"><a class=" btn-lg btn-danger"><b><?php echo TXT_CPU_INFO; ?></a></b>&nbsp;&nbsp;&nbsp;&nbsp;<a class=" btn-lg btn-success"><?php echo $processor; ?><span STYLE="font-size: 8px;"></a></span></div></br>
                <?php } ?>

                <?php if(isset($uptime)){ ?>
                <div id="uptime"><a class=" btn-lg btn-danger"><b><?php echo TXT_RUNTIME; ?></a></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class=" btn-lg btn-success"><?php echo $uptime; ?><span STYLE="font-size: 8px;"></a></span></div>
                <?php } ?>

                <?php if(isset($tx)){ ?>
                <div id="txdata"><a class=" btn-lg btn-danger"><b><?php echo TXT_TXDATA; ?></a></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class=" btn-lg btn-success"><?php echo $tx; ?>&nbsp;MB<span STYLE="font-size: 8px;"></a></span></div>
                <?php } ?>

                <?php if(isset($rx)){ ?>
                <div id="rxdata"><a class=" btn-lg btn-danger"><b><?php echo TXT_RXDATA; ?></a></b>&nbsp;<a class=" btn-lg btn-success"><?php echo $rx; ?>&nbsp;MB<span STYLE="font-size: 8px;"></a></span></div>
                <?php } ?>

                <div id="border">&nbsp;</div>

        </div>
    </body>
</html>
