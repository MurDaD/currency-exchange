#!/usr/bin/env php
<?php
/**
 * Change ip address and port if needed
 * Don't forget to change port and address in socket.js
 */
require_once(dirname(__FILE__).'/server/Server.php');
$echo = new Server('0.0.0.0','8000');
try {
    $echo->run();
}
catch (Exception $e) {
    $echo->stdout($e->getMessage());
}
