<?php
/* Saiko Configuration File */
define('DEBUG', 1);

/*define('DB_USER', 'saiko');	// Your MySQL username
define('DB_PASS', 'password');		// And the password for it
define('DB_NAME', 'saiko');	// The database itself
define('DB_HOST', 'localhost');// And the host, 99% chance you dont need to change this.

define('PEAR_PATH', '/usr/lib/php5/share/pear'); // Linux ravensky setup
define('PEAR_PATH', '/usr/lib/php'); // OS X - ashanks setup */

define('DB_USER', 'ashanks_saiko');	// Your MySQL username
define('DB_PASS',  'omgwtfbbq');		// And the password for it
define('DB_NAME', 'ashanks_saiko');	// The database itself
define('DB_HOST', 'ashanks.ctsquare.net');// And the host, 99% chance you dont need to change this.

define('PEAR_PATH', '/usr/lib/php');

$pathOffset = 1; // 0 for root domain, 1 more for each /sub/ - default
?>
