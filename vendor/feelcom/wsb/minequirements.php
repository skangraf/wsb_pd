<?php

// get PHP Version
$php = phpversion();

//We need min PHP 7.0, so we just compare first digit of PHP version
if ($php[0] < 7) {

	//display message about PHP version is smaller than required.
	echo "Minimalna wymagana wersja PHP to 7.0 - System nie spełnia tego warunku - skontaktuj się z administratorem Twojego serwera";

	// Die - end of execute script
	die();
}

DEFINE ('BASE','D:/www/carobd.pl/');
?>