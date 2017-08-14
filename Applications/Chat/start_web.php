<?php


use \Workerman\Worker;
use \Workerman\WebServer;
use \GatewayWorker\Gateway;
use \GatewayWorker\BusinessWorker;
use \Workerman\Autoloader;

require_once __DIR__ . '/../../vendor/autoload.php';

$web = new WebServer("http://0.0.0.0:55151");

$web->count = 2;

$web->addRoot('www.chattest.com', __DIR__.'/Web');

if(!defined('GLOBAL_START')){
	Worker::runAll();
}


?>