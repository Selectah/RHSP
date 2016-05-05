<?php
    ob_start();

    define(LANGUAGE, "german");


    include 'lang/'.LANGUAGE.'.lang.php';

function getStatus($ip, $port)
{
	$socket = @fsockopen($ip, $port, $errorNo, $errorStr, 2);
	if (!$socket) return false;
	else return true;
}

function parser()
{
	$file = "modules/servers.xml";
	if(file_exists($file))
	{
		$servers = file_get_contents("modules/servers.xml");
		if (trim($servers) == '')
		{	
			$content = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><servers></servers>";
			file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
		}
		else
		{
			$servers = simplexml_load_file("modules/servers.xml");
			foreach ($servers as $server)
			{
				echo "<tr>";
				echo "<td>".$server->name."</td>";
				if(filter_var($server->host, FILTER_VALIDATE_IP))
				{
					echo "<td class=\"text-center\">N/A</td><td class=\"text-center\">".$server->host."</td>";	
				}
				else
				{
					echo "<td class=\"text-center\">".$server->host."</td><td class=\"text-center\">".gethostbyname($server->host)."</td>";
				}

				echo "<td class=\"text-center\">".$server->port."</td>";

				if (getStatus((string)$server->host, (string)$server->port))
				{
					echo "<td class=\"text-center\"><center><button type=\"button\" class=\"btn btn-success btn-lg btn-round\"><span class=\"glyphicon icon-play\"></span></button></center>";
				}
				else 
				{
					echo "<td class=\"text-center\"><center><button type=\"button\" class=\"btn btn-danger btn-lg btn-round\"><span class=\"glyphicon icon-off\"></span></button></center>";
				}

			}
		}
	}
	else
	{
		$content = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><servers></servers>";
		file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
	}
}

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
        <link rel="stylesheet" href="stylesheets/bootstrap-theme.css">

        <script src="javascript/bootstrap.js"></script>
        <script src="javascript/bootstrap.min.js"></script>
        <script src="javascript/raphael.2.1.0.min.js"></script>
        <script src="javascript/justgage.1.0.1.min.js"></script>
        <script src="javascript/jquery.js"></script>

    </head>

    <body>

        <div id="container">
        <img id="logo-custom" src="images/raspberry.png">
        <div id="title">RHS Panel</div>

    	<table class="table table-bordered">
	<tr>
	<th class="text-center">Name</th>
	<th class="text-center">Domain</th>
	<th class="text-center">IP</th>
	<th class="text-center">Port</th>
	<th class="text-center"><center>Status</center></th>
	</tr>
        <?php parser(); ?>
	</table>
        </div>
    </body>
</html>
