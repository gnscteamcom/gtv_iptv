<?php

# login script

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('inc/db.php');
include('inc/sessions.php');
$sess = new SessionManager();
session_start();

include('inc/error/error.php');
include('inc/global_vars.php');
include('inc/functions.php');

$ip 								= $_SERVER['REMOTE_ADDR'];
$user_agent     					= $_SERVER['HTTP_USER_AGENT'];
$now 								= time();
$username 							= post('username');
$password							= post('password');

$query = "SELECT `id` FROM `users` WHERE `email` = '".$username."' AND `password` = '".$password."' ";

$result = mysql_query($query) or die(mysql_error());
$found = mysql_num_rows($result);
if($found == 0){
	status_message('danger', 'Incorrect Login details');
	go($site['url']."");
}else{
	while($row = mysql_fetch_array($result)){
		$_SESSION['account']['id']				= $row['id'];
		$_SESSION['account']['type']			= $row['type'];
	}
	go($site['url']."/dashboard");
}