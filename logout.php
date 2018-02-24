<?php
require_once('config.php');

header('Content-Type: application/json');

if (isset($_COOKIE['ttt-session'])){
	setcookie("ttt-session", "", (time() - 86400) , "/");
	success();
} else error();

?>