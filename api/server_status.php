<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL); 

$data['version']			= '1.1.9';

include('../inc/db.php');
include('../inc/sessions.php');
$sess = new SessionManager();
session_start();

include('../inc/global_vars.php');
include('../inc/functions.php');

// header("Content-Type:application/json; charset=utf-8");

$raw = file_get_contents("php://input");

$server = json_decode($raw, true);

$query 			= "SELECT * FROM `servers` WHERE `uuid` = '".$server['uuid']."' ";
$result 		= mysql_query($query) or die(mysql_error());
$server_found	= mysql_num_rows($result);
if($server_found == 0){
	$input = mysql_query("INSERT IGNORE INTO `servers` 
		(`last_updated`, `uuid`, `user_id`, `status`, `ip_address`, `cpu`, `cpu_usage`, `ram_usage`, `disk_usage`, `bandwidth_up`, `bandwidth_down`, `uptime`)
		VALUE
		('".time()."', '".$server['uuid']."', 'online', '0', '".$server['ip_address']."', '".$server['cpu']."', '".$server['cpu_usage']."', '".$server['ram_usage']."', '".$server['disk_usage']."', '".$server['bandwidth_up']."', '".$server['bandwidth_down']."', '".$server['uptime']."')") or die(mysql_error());
}else{
	mysql_query("UPDATE `servers` SET `status` = 'online' WHERE `uuid` = '".$server['uuid']."' ") or die(mysql_error());
	mysql_query("UPDATE `servers` SET `ip_address` = '".$server['ip_address']."' WHERE `uuid` = '".$server['uuid']."' ") or die(mysql_error());
	mysql_query("UPDATE `servers` SET `cpu` = '".$server['cpu']."' WHERE `uuid` = '".$server['uuid']."' ") or die(mysql_error());
	mysql_query("UPDATE `servers` SET `cpu_usage` = '".$server['cpu_usage']."' WHERE `uuid` = '".$server['uuid']."' ") or die(mysql_error());
	mysql_query("UPDATE `servers` SET `ram_usage` = '".$server['ram_usage']."' WHERE `uuid` = '".$server['uuid']."' ") or die(mysql_error());
	mysql_query("UPDATE `servers` SET `disk_usage` = '".$server['disk_usage']."' WHERE `uuid` = '".$server['uuid']."' ") or die(mysql_error());
	mysql_query("UPDATE `servers` SET `bandwidth_up` = '".$server['bandwidth_up']."' WHERE `uuid` = '".$server['uuid']."' ") or die(mysql_error());
	mysql_query("UPDATE `servers` SET `bandwidth_down` = '".$server['bandwidth_down']."' WHERE `uuid` = '".$server['uuid']."' ") or die(mysql_error());
	mysql_query("UPDATE `servers` SET `uptime` = '".$server['uptime']."' WHERE `uuid` = '".$server['uuid']."' ") or die(mysql_error());
}
