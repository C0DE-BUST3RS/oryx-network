<?php
/** API Thanks to Ivo Cazemier. */

use Jacwright\RestServer\RestServer;

require 'vendor/autoload.php';
require 'controller/APIController.php';
require 'service/DatabaseService.php';


$mode = 'debug'; // 'debug' or 'production'
$server = new RestServer($mode);
// $server->refreshCache(); // uncomment momentarily to clear the cache if classes change in production mode

// Bootstrap Controllers
$server->addClass('APIController');

$server->useCors = true;
$server->allowedOrigin = '*';

$server->handle();
