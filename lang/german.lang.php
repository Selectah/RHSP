<?php
	define(TXT_RUNTIME, "Laufzeit:");
        define(TXT_CPU_INFO, "Prozessor:");
	define(TXT_TEMPERATURE, "CPU Temperatur");
	define(TXT_VOLTAGE, "Spannung");
	define(TXT_CLOCK, "Takt");
	define(TXT_USAGE, "Prozessorauslastung");
	define(TXT_MEMFREE, "Ram Frei");
        define(TXT_RXDATA, "Empfangen:");
        define(TXT_TXDATA, "Gesendet:");
	define(TXT_CONFIRM, "Willst du das System wirklich");
	define(TXT_RESTART_1, "neu starten");
	define(TXT_SHUTDOWN_1, "herunterfahren");

	$uptime = preg_replace('/day\b/i','Tag',$uptime);
	$uptime = preg_replace('/days\b/i','Tage',$uptime);

?>
