<?php 
	session_start();
	require_once(dirname(__FILE__).'/db_connect.php');
	$connectionClass = new DB_CONNECT();
	$conn  = $connectionClass->connect();
	$_POST['changedTeam'] = 4;
	
	
	
	
?>