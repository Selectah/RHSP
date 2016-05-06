<?php
	switch ($_GET['action']) {
		case '0':
				restart();
			break;

		case '1':
				shutdown();
			break;

		default:
			header('Location: ../index.php');
			break;
	}

	function restart(){

            system('sudo /sbin/shutdown -r now');

	}

	function shutdown(){

            system('sudo /sbin/shutdown -h now');
	}
?>