<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	//$url=parse_url($_SERVER['REQUEST_METHOD']);
	exec('nslookup '.$_SERVER['SERVER_NAME'], $output);	
	//exec('nslookup www.albastini.com', $output);
	print_r($output);
	//print_r($_REQUEST);
	