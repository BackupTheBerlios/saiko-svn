<?php
/* Saiko Global File */
require 'config.php';
//ini_set('include_path', '/usr/lib/php5/share/pear');
ini_set('include_path', PEAR_PATH);
error_reporting(E_ALL ^ E_NOTICE);

define('SK_VERSION', '0-4a');
define('PATH', (dirname($_SERVER['PHP_SELF']) == '/') ? '' : dirname($_SERVER['PHP_SELF']));

require 'DB.php'; // PEAR
require 'functions.php';
require 'templating.php';

// General settings, might have DB-based array later.
$settings = array(
            'theme'             => 'forest',
            'session_expire'    => 86400,
            'foo'   => 'bar');

$dsn = 'mysql://'.DB_USER.':'.DB_PASS.'@'.DB_HOST.'/'.DB_NAME;
$pearOptions = array('debug' => 2);
$db = DB::connect($dsn, $pearOptions);
if(DB::isError($db))
{
    error('Error Connecting to Database ('.$db->getMessage().')', __LINE__, __FILE__);
    die();
}

require 'session.php';
?>
