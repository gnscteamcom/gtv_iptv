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

header("Content-Type:application/json; charset=utf-8");

$raw = $_POST;

$input = mysql_query("INSERT INTO dump 
	(`raw`)
	VALUE
	('".$raw."')") or die(mysql_error());

die();

$c = addslashes($_GET['c']);
switch ($c){
		
	// site info
	case "site_info":
		site_info();
		break;
		
	// add new miner
	case "miner_add":
		miner_add($site);
		break;
		
	// accept stats of a miner from local controller
	case "miner_update":
		miner_update();
		break;
		
	// list all miners inside a site
	case "site_miners":
		site_miners();
		break;

	// get one miner from a site
	case "site_miner":
		site_miner();
		break;
		
	// list all miners inside a site (lite version)
	case "site_miners_lite":
		site_miners_lite();
		break;

	// update site details from local controller
	case "site_update":
		site_update();
		break;
		
	// get list of known IP ranges for this site
	case "site_ip_ranges":
		site_ip_ranges();
		break;
		
	// get list of jobs for current site
	case "site_jobs":
		site_jobs();
		break;

	case "site_job":
		site_job();
		break;
		
	// mark site job as complete
	case "site_job_complete":
		site_job_complete();
		break;

	// site power usage
	case "site_power_usage":
		site_power_usage();
		break;
		
	// build miner config file
	case "build_config_file":
		build_config_file();
		break;

	// the remote controller is checking in
	case "controller_checkin":
		controller_checkin();
		break;

	// check system status
	case "system_status":
		system_status();
		break;

	// get config for gpu miners
	case "miner_gpu_get_config":
		miner_gpu_get_config();
		break;

	// home
	default:
		home();
		break;
}
       
function home()
{
	global $site;
	$data['status']				= 'success';
	$data['message']			= 'you have successfully connected to the MCP API. now try a few other commands to pull additional data.';
	$data['site']['id']			= $site['id'];
	$data['site']['name']		= $site['name'];
	json_output($data);
}

function site_miners()
{
	global $site;
	$data['status']				= 'success';
	$data['site']['id']			= $site['id'];
	$data['site']['name']		= $site['name'];
	
	$query 			= "SELECT * FROM `site_miners` WHERE `site_id` = '".$site['id']."' AND `type` = 'asic' ";
	$data['query'] 	= $query;
	$result 		= mysql_query($query) or die(mysql_error());
	$count = 0;
	while($row = mysql_fetch_array($result)){
		$data['miners'][$count]['id']						= $row['id'];
		$data['miners'][$count]['site_id']					= $row['site_id'];
		$data['miners'][$count]['group_id']					= $row['group_id'];
		$data['miners'][$count]['name']						= stripslashes($row['name']);
		$data['miners'][$count]['ip_address']				= $row['ip_address'];
		$data['miners'][$count]['type']						= $row['type'];
		$data['miners'][$count]['hardware']					= $row['hardware'];
		$data['miners'][$count]['username']					= stripslashes($row['username']);
		$data['miners'][$count]['password']					= stripslashes($row['password']);

		$data['miners'][$count]['pools'][0]['user']			= stripslashes($row['pool_0_user']);
		$data['miners'][$count]['pools'][1]['user']			= stripslashes($row['pool_1_user']);
		$data['miners'][$count]['pools'][2]['user']			= stripslashes($row['pool_2_user']);

		if (
			strpos($data['miners'][$count]['pools'][0]['user'], 'antminer') !== false ||
			strpos($data['miners'][$count]['pools'][1]['user'], 'antminer') !== false ||
			strpos($data['miners'][$count]['pools'][2]['user'], 'antminer') !== false
		)
		{
			$data['miners'][$count]['warning']				= 'default_config_found';
		}

		if (strpos($data['miners'][$count]['hardware'], 'antminer') !== false)
		{
			$data['miners'][$count]['default_username']		= 'root';
			$data['miners'][$count]['default_password']		= 'admin';
		}

		$count++;
	}
	
	json_output($data);
}

function site_miner()
{
	global $site;
	$data['status']						= 'success';
	$data['site']['id']					= $site['id'];
	$data['site']['name']				= $site['name'];
	$data['site']['user_id']			= $site['user_id'];
	$data['site']['controller_ip']		= $site['controller_ip'];
	$data['site']['controller_status']	= $site['controller_status'];
	
	// sanity check
	if(isset($_GET['key']))
	{
		$data['miner_id']				= $_GET['miner_id'];
	}else{
		$data['status'] 		= 'error';
		$data['message']		= 'miner_id not given.';
		json_output($data);
	}

	if(isset($_GET['miner_id']))
	{
		$query 								= "SELECT * FROM `site_miners` WHERE `site_id` = '".$data['site']['id']."' AND `id` = '".$data['miner_id']."' ";
	}

	if(isset($_GET['miner_mac_address']))
	{
		$data['miner_mac_address']			= $_GET['miner_mac_address'];
		$query 								= "SELECT * FROM `site_miners` WHERE `site_id` = '".$data['site']['id']."' AND `mac_address` = '".$data['miner_mac_address']."' ";
	}

	if(isset($_GET['miner_ip_address']))
	{
		$data['miner_ip_address']			= $_GET['miner_ip_address'];
		$query 								= "SELECT * FROM `site_miners` WHERE `site_id` = '".$data['site']['id']."' AND `ip_address` = '".$data['miner_mac_address']."' ";
	}
	
	$result 		= mysql_query($query) or die(mysql_error());	
	$count = 0;
	while($row = mysql_fetch_array($result)){
		$data['miners'][$count]['id']						= $row['id'];
		$data['miners'][$count]['site_id']					= $row['site_id'];
		$data['miners'][$count]['group_id']					= $row['group_id'];
		$data['miners'][$count]['name']						= stripslashes($row['name']);
		$data['miners'][$count]['ip_address']				= $row['ip_address'];
		$data['miners'][$count]['hardware']					= $row['hardware'];
		$data['miners'][$count]['username']					= stripslashes($row['username']);
		$data['miners'][$count]['password']					= stripslashes($row['password']);

		$data['miners'][$count]['location']['row']			= stripslashes($row['location_row']);
		$data['miners'][$count]['location']['rack']			= stripslashes($row['location_rack']);
		$data['miners'][$count]['location']['shelf']		= stripslashes($row['location_shelf']);
		$data['miners'][$count]['location']['position']		= stripslashes($row['location_position']);

		$data['miners'][$count]['pools'][0]['user']			= stripslashes($row['pool_0_user']);
		$data['miners'][$count]['pools'][1]['user']			= stripslashes($row['pool_1_user']);
		$data['miners'][$count]['pools'][2]['user']			= stripslashes($row['pool_2_user']);

		if (
			strpos($data['miners'][$count]['pools'][0]['user'], 'antminer') !== false ||
			strpos($data['miners'][$count]['pools'][1]['user'], 'antminer') !== false ||
			strpos($data['miners'][$count]['pools'][2]['user'], 'antminer') !== false
		)
		{
			$data['miners'][$count]['warning']				= 'default_config_found';

			// assume default password needs to be used
			mysql_query("UPDATE `site_miners` SET `password` = 'admin' WHERE `id` = '".$data['miner_id']."' ") or die(mysql_error());

			// look for default pools to configure this new miner
			$query_1 = "SELECT * FROM `site_default_pools` WHERE `user_id` = '".$site['user_id']."' " ;
			$result_1 = mysql_query($query_1) or die(mysql_error());	
			while($row_1 = mysql_fetch_array($result_1)){
				if($row_1['pool_0'] != 0)
				{
					$data['miners'][$count]['default_pools'][0]['id']		= $row_1['pool_0'];

					$query_2 = "SELECT * FROM `pools` WHERE `id` = '".$row_1['pool_0']."' " ;
					$result_2 = mysql_query($query_2) or die(mysql_error());	
					while($row_2 = mysql_fetch_array($result_2)){
						if(strpos($row_2['url'], 'nicehash') !== false)
						{
							$data['miners'][$count]['default_pools'][0]['url']	= $row_2['url'].':'.$row_2['port'].'#nxsub';
						}else{
							$data['miners'][$count]['default_pools'][0]['url']	= $row_2['url'].':'.$row_2['port'];
						}
						$data['miners'][$count]['default_pools'][0]['user']	= $row_2['username'];
						$data['miners'][$count]['default_pools'][0]['pass']	= $row_2['password'];
					}
				}
				
			}
		}

		if(strpos($data['miners'][$count]['hardware'], 'antminer') !== false)
		{
			$data['miners'][$count]['default_username']		= 'root';
			$data['miners'][$count]['default_password']		= 'admin';
		}

		$count++;
	}
	
	json_output($data);
}

function site_miners_lite()
{
	global $site;
	$data['status']				= 'success';
	$data['site']['id']			= $site['id'];
	$data['site']['name']		= $site['name'];
	$data['site']['user_id']	= $site['user_id'];
	
	$query 			= "SELECT `id`,`group_id`,`name`,`ip_address` FROM `site_miners` WHERE `site_id` = '".$site['id']."' " ;
	$result 		= mysql_query($query) or die(mysql_error());
	$count = 0;
	while($row = mysql_fetch_array($result)){
		$data['miners'][$count]['id']						= $row['id'];
		$data['miners'][$count]['group_id']					= $row['group_id'];
		$data['miners'][$count]['name']						= stripslashes($row['name']);
		$data['miners'][$count]['ip_address']				= $row['ip_address'];
		
		$count++;
	}
	
	json_output($data);
}

function site_info()
{
	global $site;

	$site['status']					= 'success';
	
	$site['monthly_revenue']		= show_monthly_revenue($site['id']);
		
	$site['monthly_profit']			= show_monthly_profit($site['id']);

	// $data['monthly_revenue']		= calc_day_to_month($data['daily_revenue']);
	// $data['monthly_profit']		= calc_day_to_month($data['daily_profit']);

	$site['power']					= show_total_power($site['id'], $site['voltage']);

	$site['power']['power_cost']	= $site['power_cost'];
	$site['power']['max_kilowatts']	= $site['max_kilowatts'];
	$site['power']['max_amps']		= $site['max_amps'];

	// $data['daily_power_cost']		= $data['power']['kilowatts'] * 24 * $data['power']['power_cost'];
	// $data['monthly_power_cost']		= $data['daily_power_cost'];

	$site['monthly_power_cost']		= show_monthly_power_cost($site['id']);

	$site['miners']					= get_miners($site['id'], $site['user_id'], '');

	$site['total_miners']			= count($site['miners']);

	$site['total_online_miners'] = 0;
	$site['total_offline_miners'] = 0;
	$site['average_temps'] = array();
	$site['average_temps']['total_pcb'] = 0;
	foreach($site['miners'] as $miner){
		if(isset($miner['status_raw']))
		{
			if($miner['status_raw'] == 'mining'){$site['total_online_miners']++;}
			if($miner['status_raw'] != 'mining'){$site['total_offline_miners']++;}

			$site['average_temps']['pcb'] 			= $miner['pcb_temp'];
			$site['average_temps']['total_pcb'] 	= $site['average_temps']['total_pcb'] + $miner['pcb_temp'];

			$site['average_temps']['chip'] = $miner['chip_temp'];
			/*
			if($miner['temp']['average_pcb_temp'] != 0){
				$data['average_temps']['pcb'][] = $miner['temp']['average_pcb_temp'];
				$data['average_temps']['total_pcb'] = $data['average_temps']['total_pcb'] + $miner['temp']['average_pcb_temp'];
			}
			if($miner['temp']['average_chip_temp'] != 0){
				$data['average_temps']['chip'][] = $miner['temp']['average_chip_temp'];
				$data['average_temps']['total_chip'] = $data['average_temps']['total_chip'] + $miner['temp']['average_chip_temp'];
			}
			*/
		}
	}

	if($site['total_online_miners'] == 0)
	{
		$site['average_temps']['average_pcb'] = 0;
	}else{
		$site['average_temps']['average_pcb'] = number_format($site['average_temps']['total_pcb'] / $site['total_online_miners']);
	}			
	
	json_output($site);
}

function site_jobs()
{
	global $site;
	$data['status']				= 'success';
	$data['site']['id']			= $site['id'];
	$data['site']['name']		= $site['name'];
	$data['site']['user_id']	= $site['user_id'];

	if(isset($_GET['miner_id'])){
		$query 			= "SELECT * FROM `site_jobs` WHERE `site_id` = '".$site['id']."' AND `status` = 'pending' AND `miner_id` = '".$_GET['miner_id']."' " ;
		$result 		= mysql_query($query) or die(mysql_error());
		$count = 0;
		while($row = mysql_fetch_array($result)){
			$data['jobs'][$count]['id']								= $row['id'];
			$query_2 			= "SELECT * FROM `site_miners` WHERE `id` = '".$row['miner_id']."' " ;
			$result_2 			= mysql_query($query_2) or die(mysql_error());
			while($row_2 = mysql_fetch_array($result_2)){
				
				$data['jobs'][$count]['miner']['id']				= $row_2['id'];
				$data['jobs'][$count]['miner']['ip_address']		= $row_2['ip_address'];
				if(empty($row_2['name'])){
					$data['jobs'][$count]['miner']['name']			= stripslashes($row_2['ip_address']);
				}else{
					$data['jobs'][$count]['miner']['name']			= stripslashes($row_2['name']);
				}
				$data['jobs'][$count]['miner']['username']			= stripslashes($row_2['username']);
				$data['jobs'][$count]['miner']['password']			= stripslashes($row_2['password']);
				$data['jobs'][$count]['miner']['hardware']			= $row_2['hardware'];
			}
			$data['jobs'][$count]['job']					= $row['job'];
			$data['jobs'][$count]['notes']					= stripslashes($row['notes']);
			$data['jobs'][$count]['status']					= $row['status'];
			
			$count++;
		}
	}else{
		$query 			= "SELECT * FROM `site_jobs` WHERE `site_id` = '".$site['id']."' AND `status` = 'pending' " ;
		$result 		= mysql_query($query) or die(mysql_error());
		$count = 0;
		while($row = mysql_fetch_array($result)){
			$data['jobs'][$count]['id']							= $row['id'];
			$data['jobs'][$count]['job']						= $row['job'];
			$data['jobs'][$count]['notes']						= stripslashes($row['notes']);
			$data['jobs'][$count]['status']						= $row['status'];

			$query_2 			= "SELECT * FROM `site_miners` WHERE `id` = '".$row['miner_id']."' AND `type` = 'asic' " ;
			$result_2 			= mysql_query($query_2) or die(mysql_error());
			while($row_2 = mysql_fetch_array($result_2)){
				$data['jobs'][$count]['miner']['id']				= $row_2['id'];
				$data['jobs'][$count]['miner']['ip_address']		= $row_2['ip_address'];
				if(empty($row_2['name'])){
					$data['jobs'][$count]['miner']['name']			= stripslashes($row_2['ip_address']);
				}else{
					$data['jobs'][$count]['miner']['name']			= stripslashes($row_2['name']);
				}
				$data['jobs'][$count]['miner']['username']			= stripslashes($row_2['username']);
				$data['jobs'][$count]['miner']['password']			= stripslashes($row_2['password']);
				$data['jobs'][$count]['miner']['hardware']			= $row_2['hardware'];
			}
			
			
			$count++;
		}
	}
	
	json_output($data);
}

function site_job()
{
	global $site;
	$data['status']					= 'success';
	$data['site']['id']				= $site['id'];
	$data['site']['name']			= $site['name'];
	$data['site']['user_id']		= $site['user_id'];

	// sanity check
	// sanity check
	if(isset($_GET['job_id']))
	{
		$data['job_id']				= $_GET['job_id'];
	}else{
		$data['status'] 			= 'error';
		$data['message']			= 'job_id not given.';
		json_output($data);
	}

	
	$query 			= "SELECT * FROM `site_jobs` WHERE `site_id` = '".$site['id']."' AND `id` = '".$data['job_id']."' AND `status` = 'pending' " ;
	$result 		= mysql_query($query) or die(mysql_error());
	$count = 0;
	$job_found		= mysql_num_rows($result);
	if($job_found == 0)
	{
		$data['message']		= 'pending job not found.';
	}else{
		while($row = mysql_fetch_array($result)){
			$data['jobs'][$count]['id']								= $row['id'];
			$query_2 			= "SELECT * FROM `site_miners` WHERE `id` = '".$row['miner_id']."' " ;
			$result_2 			= mysql_query($query_2) or die(mysql_error());
			while($row_2 = mysql_fetch_array($result_2)){
				
				$data['jobs'][$count]['miner']['id']				= $row_2['id'];
				$data['jobs'][$count]['miner']['ip_address']		= $row_2['ip_address'];
				if(empty($row_2['name'])){
					$data['jobs'][$count]['miner']['name']			= stripslashes($row_2['ip_address']);
				}else{
					$data['jobs'][$count]['miner']['name']			= stripslashes($row_2['name']);
				}
				$data['jobs'][$count]['miner']['username']			= stripslashes($row_2['username']);
				$data['jobs'][$count]['miner']['password']			= stripslashes($row_2['password']);
				$data['jobs'][$count]['miner']['hardware']			= $row_2['hardware'];
			}
			$data['jobs'][$count]['job']					= $row['job'];
			$data['jobs'][$count]['notes']					= stripslashes($row['notes']);
			$data['jobs'][$count]['status']					= $row['status'];
			
			$count++;
		}
	}
	
	json_output($data);
}

function site_job_complete()
{
	global $site;

	$data 						= '';
	
	$job_data					= json_decode(file_get_contents('php://input'), true);

	if(is_array($job_data)){
		$job_data = $job_data['id'];
	}
	
	$query 			= "SELECT * FROM `site_jobs` WHERE `id` = '".$job_data."' ";

	$result 		= mysql_query($query) or die(mysql_error());
	while($row = mysql_fetch_array($result)){
		$data['miner_id']			= $row['miner_id'];
		$data['job']				= $row['job'];
	}

	if($data['job'] == 'pause_miner'){
		mysql_query("UPDATE `site_miners` SET `paused` = 'yes' WHERE `id` = '".$data['miner_id']."' ") or die(mysql_error());
	}

	mysql_query("UPDATE `site_jobs` SET `status` = 'complete' WHERE `id` = '".$job_data."' ");
		
	$data['status']				= 'success';
	json_output($data);
}

function miner_add()
{
	global $site;
	
	$miner_data					= json_decode(file_get_contents('php://input'), true);
	
	if(empty($miner_data['ip_address']))
	{
		$data['status']				= 'error';
		$data['message']			= 'missing ip address.';
		json_output($data);
		die();
	}

	if($miner_data['site_id'] == 0)
	{
		$data['status']				= 'error';
		$data['message']			= 'cannot use this site_id.';
		json_output($data);
		die();
	}

	$query = "SELECT * FROM `site_miners` WHERE `id` = '".$miner_data['miner_id']."' ";
	$result = mysql_query($query) or die(mysql_error());
	$miner_found = mysql_num_rows($result);
	if($miner_found == 0){

		if($miner_data['type'] == 'gpu'){
			$username 				= 'mcp';
			$password 				= 'mcp';
		}elseif($miner_data['type'] == 'asic'){
			$username 				= 'root';
			$password 				= 'admin';
		}

		// add new miner
		$input = mysql_query("INSERT IGNORE INTO `site_miners` 
			(`time`, `site_id`, `ip_address`, `type`, `username`, `password`, `mac_address`)
			VALUE
			('".time()."', '".$miner_data['site_id']."', '".$miner_data['ip_address']."', '".$miner_data['type']."', '".$username."', '".$password."', '".$miner_data['mac_address']."')") or die(mysql_error());
			
		$miner_data['id'] 			= mysql_insert_id();
		if($miner_data['id'] == 0){
			$query = "SELECT `id` FROM `site_miners` WHERE `site_id` = '".$miner_data['site_id']."' AND `ip_address` = '".$miner_data['ip_address']."' ";
			$result = mysql_query($query) or die(mysql_error());
			while($row = mysql_fetch_array($result)){
				$miner_data['id']		= $row['id'];
			}
		}
		$data['status']				= 'success';
		$data['message']			= 'miner has been added.';
	}else{
		// error_log(print_r($miner_data, TRUE));

		$miner_data['id'] = $miner_data['miner_id'];
		mysql_query("UPDATE `site_miners` SET `raw_data` = '".json_encode($miner_data)."' WHERE `id` = '".$miner_data['miner_id']."' ");
		mysql_query("UPDATE `site_miners` SET `hardware` = '".$miner_data['hardware']."' WHERE `id` = '".$miner_data['miner_id']."' ");
		mysql_query("UPDATE `site_miners` SET `time` = '".time()."' WHERE `id` = '".$miner_data['miner_id']."' ");
		mysql_query("UPDATE `site_miners` SET `ip_address` = '".$miner_data['ip_address']."' WHERE `id` = '".$miner_data['miner_id']."' ");
		mysql_query("UPDATE `site_miners` SET `hash` = '".$miner_data['hashrate']."' WHERE `id` = '".$miner_data['miner_id']."' ");

		if(!empty($miner_data['hashrate'])){
			mysql_query("UPDATE `site_miners` SET `status` = 'mining' WHERE `id` = '".$miner_data['miner_id']."' ");
		}

		mysql_query("UPDATE `site_miners` SET `gpus` = '".count($miner_data['gpu_info'])."' WHERE `id` = '".$miner_data['miner_id']."' ");
		mysql_query("UPDATE `site_miners` SET `uptime` = '".$miner_data['uptime']."' WHERE `id` = '".$miner_data['miner_id']."' ");

		$gpu_temps 				= '';
		$gpu_fan_speeds 		= '';

		foreach($miner_data['gpu_info'] as $gpu){
			$gpu_temps .= $gpu['temp'] . ' ';
		}

		foreach($miner_data['gpu_info'] as $gpu){
			$gpu_fan_speeds .= $gpu['fan_speed'] . ' ';
		}

		mysql_query("UPDATE `site_miners` SET `status` = '".$miner_data['miner_status']."' WHERE `id` = '".$miner_data['miner_id']."' ");

		if($miner_data['miner_status'] != 'mining'){
			mysql_query("UPDATE `site_miners` SET `hash` = '' WHERE `id` = '".$miner_data['miner_id']."' ");
		}

		if($miner_data['miner_status'] == 'mining'){
			mysql_query("UPDATE `site_miners` SET `paused` = 'no' WHERE `id` = '".$miner_data['miner_id']."' ");
		}

		mysql_query("UPDATE `site_miners` SET `temp` = '".$gpu_temps."' WHERE `id` = '".$miner_data['miner_id']."' ");
		mysql_query("UPDATE `site_miners` SET `fanrpm` = '".$gpu_fan_speeds."' WHERE `id` = '".$miner_data['miner_id']."' ");

		$data['status']				= 'success';
		$data['message']			= 'miner has been updated.';
	}
	
	$data['miner_data']			= $miner_data;
	json_output($data);
}

function miner_update()
{
	global $site;
	
	$miner_data_raw				= file_get_contents('php://input');
	$miner_data					= json_decode($miner_data_raw, true);

	// if($miner_data['id'] == '28439'){
	// 	$ch = curl_init('https://putsreq.com/gabeV4MLN0AzzbvMhwaz');
	// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//	curl_setopt($ch, CURLOPT_POSTFIELDS, $miner_data['update']);
	//	$response = curl_exec($ch);
	// }

	if($miner_data['ip_address'] == '192.168.1.229'){
		$input = mysql_query("INSERT INTO `dump` 
		(`data`)
		VALUE
		('".$miner_data_raw."')") or die(mysql_error());
	}
	
	if($miner_data['site_id'] == 0 || $miner_data['ip_address'] == ''){
		$data['status']				= 'error';
		$data['message']			= 'missing data. site_id = 0 or missing ip_address';
		json_output($data);
		die();
	}

	// check if miner already exists
	$query = "SELECT * FROM `site_miners` WHERE `id` = '".$miner_data['id']."' ";
	$result = mysql_query($query) or die(mysql_error());
	$miner_found = mysql_num_rows($result);
	if($miner_found == 0 && $miner_data['site_id'] != 0)
	{
		// new miner, lets add it
		$input = mysql_query("INSERT INTO `site_miners` 
		(`time`, `site_id`, `ip_address`)
		VALUE
		('".time()."', '".$miner_data['site_id']."', '".$miner_data['ip_address']."')") or die(mysql_error());
	
		$miner_data['id'] = mysql_insert_id();
	}

	// check for reset due to setting up brand new miner
	if(isset($miner_data['update']['reset']) && $miner_data['update']['reset'] == 'yes')
	{
		mysql_query("UPDATE `site_miners` SET `pool_0_url` = '' WHERE `id` = '".$miner_data['id']."' ");
		mysql_query("UPDATE `site_miners` SET `pool_0_user` = '' WHERE `id` = '".$miner_data['id']."' ");
		mysql_query("UPDATE `site_miners` SET `pool_0_status` = '' WHERE `id` = '".$miner_data['id']."' ");
		mysql_query("UPDATE `site_miners` SET `pool_0_priority` = '' WHERE `id` = '".$miner_data['id']."' ");

		mysql_query("UPDATE `site_miners` SET `pool_1_url` = '' WHERE `id` = '".$miner_data['id']."' ");
		mysql_query("UPDATE `site_miners` SET `pool_1_user` = '' WHERE `id` = '".$miner_data['id']."' ");
		mysql_query("UPDATE `site_miners` SET `pool_1_status` = '' WHERE `id` = '".$miner_data['id']."' ");
		mysql_query("UPDATE `site_miners` SET `pool_1_priority` = '' WHERE `id` = '".$miner_data['id']."' ");

		mysql_query("UPDATE `site_miners` SET `pool_2_url` = '' WHERE `id` = '".$miner_data['id']."' ");
		mysql_query("UPDATE `site_miners` SET `pool_2_user` = '' WHERE `id` = '".$miner_data['id']."' ");
		mysql_query("UPDATE `site_miners` SET `pool_2_status` = '' WHERE `id` = '".$miner_data['id']."' ");
		mysql_query("UPDATE `site_miners` SET `pool_2_priority` = '' WHERE `id` = '".$miner_data['id']."' ");
	}

	while($row = mysql_fetch_array($result)){
		$info['manual_fan_speed']		= $row['manual_fan_speed'];
	}

	mysql_query("UPDATE `site_miners` SET `raw_data` = '".serialize($miner_data)."' WHERE `id` = '".$miner_data['id']."' ");
	
	if(isset($miner_data['update']['kernel_log'])){
		mysql_query("UPDATE `site_miners` SET `kernel_log` = '".base64_encode($miner_data['update']['kernel_log'])."' WHERE `id` = '".$miner_data['id']."' ");
	}
	
	// lets update the miner details
	if($miner_data['update']['status'] == 'mining'){
		mysql_query("UPDATE `site_miners` SET `paused` = 'no' WHERE `id` = '".$miner_data['id']."' ");
	}

	if(!empty($miner_data['update']['status'])){
		mysql_query("UPDATE `site_miners` SET `status` = '".$miner_data['update']['status']."' WHERE `id` = '".$miner_data['id']."' ");
	}
	
	if($miner_data['update']['status'] == 'mining')
	{
		if(!empty($miner_data['update']['software_version'])){
			mysql_query("UPDATE `site_miners` SET `software_version` = '".$miner_data['update']['software_version']."' WHERE `id` = '".$miner_data['id']."' ");
		}
		if(!empty($miner_data['update']['accepted'])){
			mysql_query("UPDATE `site_miners` SET `accepted` = '".$miner_data['update']['accepted']."' WHERE `id` = '".$miner_data['id']."' ");
		}
		if(!empty($miner_data['update']['rejected'])){
			mysql_query("UPDATE `site_miners` SET `rejected` = '".$miner_data['update']['rejected']."' WHERE `id` = '".$miner_data['id']."' ");
		}

		if(!empty($miner_data['update']['hardware'])){
			$miner_data['update']['hardware'] = strtolower($miner_data['update']['hardware']);
						
			if(strpos($miner_data['update']['hardware'], 'l3+') !== false) {
				$miner_data['update']['hardware']		= 'antminer-l3+';
			}

			if(strpos($miner_data['update']['hardware'], 'd3') !== false) {
				$miner_data['update']['hardware']		= 'antminer-d3';
			}

			if(strpos($miner_data['update']['hardware'], 'S9J') !== false || strpos($miner_data['update']['hardware'], 's9j') !== false) {
				$miner_data['update']['hardware']		= 'antminer-s9j';
			} 
			
			$miner_data['update']['hardware'] = str_replace(" ", "-", $miner_data['update']['hardware']);
			
			mysql_query("UPDATE `site_miners` SET `hardware` = '".strtolower($miner_data['update']['hardware'])."' WHERE `id` = '".$miner_data['id']."' ");
		}
		
		if(isset($miner_data['update']['hashrate_1']) && !empty($miner_data['update']['hashrate_1'])){
			if($miner_data['update']['hardware'] == 'spondoolies'){$miner_data['update']['hashrate_1'] = substr($miner_data['update']['hashrate_1'], 0, -3);}
			mysql_query("UPDATE `site_miners` SET `hashrate_1` = '".$miner_data['update']['hashrate_1']."' WHERE `id` = '".$miner_data['id']."' ");
		}
		if(isset($miner_data['update']['hashrate_2']) && !empty($miner_data['update']['hashrate_2'])){
			mysql_query("UPDATE `site_miners` SET `hashrate_2` = '".$miner_data['update']['hashrate_2']."' WHERE `id` = '".$miner_data['id']."' ");
		}
		if(isset($miner_data['update']['hashrate_3']) && !empty($miner_data['update']['hashrate_3'])){
			mysql_query("UPDATE `site_miners` SET `hashrate_3` = '".$miner_data['update']['hashrate_3']."' WHERE `id` = '".$miner_data['id']."' ");
		}
		if(isset($miner_data['update']['hashrate_4']) && !empty($miner_data['update']['hashrate_4'])){
			mysql_query("UPDATE `site_miners` SET `hashrate_4` = '".$miner_data['update']['hashrate_4']."' WHERE `id` = '".$miner_data['id']."' ");
		}
		
		$miner_data['total_hashrate'] = $miner_data['update']['hashrate_1'] + $miner_data['update']['hashrate_2'] + $miner_data['update']['hashrate_3'] + $miner_data['update']['hashrate_4'];
		
		$query = "SELECT * FROM `miner_defaults` WHERE `hardware` = '".$miner_data['update']['hardware']."' ";
		$result = mysql_query($query) or die(mysql_error());
		$miner_found = mysql_num_rows($result);
		if($miner_found == 0){
			// error_log("Unsupported Hardware: " . $miner_data['update']['hardware']);
			$data['status']				= 'error';
			$data['message']			= 'unsupported hardware: '.$miner_data['update']['hardware'];
			json_output($data);
		}else{
			// error_log("Miner Hardware Identified: " . $miner_data['update']['hardware']);
			while($row = mysql_fetch_array($result)){
				$miner_data['update']['power'] 		= $row['power'];
				$miner_data['update']['algorithm'] 	= $row['algorithm'];
			}
		}

		// calc power for antminer s9 range
		if(strpos($miner_data['update']['hardware'], 's9') !== false) {
			$miner_data['update']['power'] 		= 1380 / 13.5 * $miner_data['total_hashrate'];
			$miner_data['update']['power'] 		= $miner_data['update']['power'] / 1000;
			$miner_data['update']['algorithm'] 	= 'sha256';
		}
		if(strpos($miner_data['update']['hardware'], 's9i') !== false) {
			$miner_data['update']['power'] 		= 1368 / 14.2 * $miner_data['total_hashrate'];
			$miner_data['update']['power'] 		= $miner_data['update']['power'] / 1000;
			$miner_data['update']['algorithm'] 	= 'sha256';
		}
		if(strpos($miner_data['update']['hardware'], 's9j') !== false) {
			$miner_data['update']['power'] 		= 1358 / 14 * $miner_data['total_hashrate'];
			$miner_data['update']['power'] 		= $miner_data['update']['power'] / 1000;
			$miner_data['update']['algorithm'] 	= 'sha256';
		}

		/*
		if($miner_data['update']['hardware'] == 'antminer-e3') {
			$miner_data['update']['power'] 		= 900;
			$miner_data['update']['algorithm'] 	= 'ethereum';
		}
		if($miner_data['update']['hardware'] == 'antminer-a3') {
			$miner_data['update']['power'] 		= 1000;
			$miner_data['update']['algorithm'] 	= 'blake2b';
		}
		if($miner_data['update']['hardware'] == 'antminer-d3') {
			$miner_data['update']['power'] 		= 1050 / 19 * $miner_data['total_hashrate'];
			$miner_data['update']['power'] 		= $miner_data['update']['power'] / 1000;
			$miner_data['update']['algorithm'] 	= 'x11';
		}
		if($miner_data['update']['hardware'] == 'antminer-d3-(blissz)') {
			$miner_data['update']['power'] 		= 1050 / 19 * $miner_data['total_hashrate'];
			$miner_data['update']['power'] 		= $miner_data['update']['power'] / 1000;
			$miner_data['update']['algorithm'] 	= 'x11';
		}
		if($miner_data['update']['hardware'] == 'antminer-s4') {
			$miner_data['update']['power'] 		= 1200;
			$miner_data['update']['algorithm'] 	= 'sha256';
		}
		if($miner_data['update']['hardware'] == 'antminer-s4+') {
			$miner_data['update']['power'] 		= 1250;
			$miner_data['update']['algorithm'] 	= 'sha256';
		}
		if($miner_data['update']['hardware'] == 'antminer-s5') {
			$miner_data['update']['power'] 		= 600;
			$miner_data['update']['algorithm'] 	= 'sha256';
		}
		if($miner_data['update']['hardware'] == 'antminer-s7') {
			$miner_data['update']['power'] 		= 1350 / 4.7 * $miner_data['total_hashrate'];
			$miner_data['update']['power'] 		= $miner_data['update']['power'] / 1000;
			$miner_data['update']['algorithm'] 	= 'sha256';
		}
		if($miner_data['update']['hardware'] == 'antminer-s9')
		{
			if($info['manual_fan_speed'] >= 30){
				$miner_data['update']['power'] 		= 1445 / 13.5 * $miner_data['total_hashrate'];
			}

			if($info['manual_fan_speed'] >= 40){
				$miner_data['update']['power'] 		= 1445 / 13.5 * $miner_data['total_hashrate'];
			}

			if($info['manual_fan_speed'] >= 50){
				$miner_data['update']['power'] 		= 1445 / 13.5 * $miner_data['total_hashrate'];
			}

			if($info['manual_fan_speed'] >= 60){
				$miner_data['update']['power'] 		= 1445 / 13.5 * $miner_data['total_hashrate'];
			}

			if($info['manual_fan_speed'] >= 70){
				$miner_data['update']['power'] 		= 1445 / 13.5 * $miner_data['total_hashrate'];
			}

			if($info['manual_fan_speed'] >= 80){
				$miner_data['update']['power'] 		= 1445 / 13.5 * $miner_data['total_hashrate'];
			}

			if($info['manual_fan_speed'] >= 90){
				$miner_data['update']['power'] 		= 1445 / 13.5 * $miner_data['total_hashrate'];
			}

			if($info['manual_fan_speed'] >= 100){
				$miner_data['update']['power'] 		= 1445 / 13.5 * $miner_data['total_hashrate'];
			}

			$miner_data['update']['power'] 		= $miner_data['update']['power'] / 1000;
			$miner_data['update']['algorithm'] 	= 'sha256';
		}

		if($miner_data['update']['hardware'] == 'antminer-l3+') {
			$miner_data['update']['power'] 		= 880;
			$miner_data['update']['algorithm'] 	= 'scrypt';
		}
		if($miner_data['update']['hardware'] == 'antminer-a3') {
			$miner_data['update']['power'] 		= 1350;
			$miner_data['update']['algorithm'] 	= 'blake2b';
		}

		if($miner_data['update']['hardware'] == 'spondoolies') {
			$miner_data['update']['power'] 		= 2800;
			$miner_data['update']['algorithm'] 	= 'sha256';
		}
		if($miner_data['update']['hardware'] == 'ebite9plus') {
			$miner_data['update']['power'] 		= 1400;
			$miner_data['update']['algorithm'] 	= 'sha256';
		}
		*/
		
		if(!empty($miner_data['update']['mac_address'])){
			$miner_data['update']['mac_address'] = explode(' ', $miner_data['update']['mac_address']);
			$miner_data['update']['mac_address'] = $miner_data['update']['mac_address'][2];
			mysql_query("UPDATE `site_miners` SET `mac_address` = '".$miner_data['update']['mac_address']."' WHERE `id` = '".$miner_data['id']."' ");
		}
		
		if(isset($miner_data['update']['pools'][0]['user'])){
			$pool_user_bits = explode('.', $miner_data['update']['pools'][0]['user']);
			if(is_array($pool_user_bits)){
				$pool_user = $pool_user_bits[0];
				if(isset($pool_user_bits[1])){
					$pool_worker = $pool_user_bits[1];
					mysql_query("UPDATE `site_miners` SET `worker_name` = '".$pool_worker."' WHERE `id` = '".$miner_data['id']."' ");
				}
			}
		}

		mysql_query("UPDATE `site_miners` SET `pool_0_url` = '".$miner_data['update']['pools'][0]['url']."' WHERE `id` = '".$miner_data['id']."' ");
		mysql_query("UPDATE `site_miners` SET `pool_0_user` = '".$pool_user."' WHERE `id` = '".$miner_data['id']."' ");
		mysql_query("UPDATE `site_miners` SET `pool_0_status` = '".$miner_data['update']['pools'][0]['status']."' WHERE `id` = '".$miner_data['id']."' ");
		mysql_query("UPDATE `site_miners` SET `pool_0_priority` = '".$miner_data['update']['pools'][0]['priority']."' WHERE `id` = '".$miner_data['id']."' ");
		unset($pool_user);

		if(isset($miner_data['update']['pools'][1]))
		{
			$pool_user_bits = explode('.', $miner_data['update']['pools'][1]['user']);
			$pool_user = $pool_user_bits[0];
			mysql_query("UPDATE `site_miners` SET `pool_1_url` = '".$miner_data['update']['pools'][1]['url']."' WHERE `id` = '".$miner_data['id']."' ");
			mysql_query("UPDATE `site_miners` SET `pool_1_user` = '".$pool_user."' WHERE `id` = '".$miner_data['id']."' ");
			mysql_query("UPDATE `site_miners` SET `pool_1_status` = '".$miner_data['update']['pools'][1]['status']."' WHERE `id` = '".$miner_data['id']."' ");
			mysql_query("UPDATE `site_miners` SET `pool_1_priority` = '".$miner_data['update']['pools'][1]['priority']."' WHERE `id` = '".$miner_data['id']."' ");
			unset($pool_user);
		}

		if(isset($miner_data['update']['pools'][2]))
		{
			$pool_user_bits = explode('.', $miner_data['update']['pools'][2]['user']);
			$pool_user = $pool_user_bits[0];
			mysql_query("UPDATE `site_miners` SET `pool_2_url` = '".$miner_data['update']['pools'][2]['url']."' WHERE `id` = '".$miner_data['id']."' ");
			mysql_query("UPDATE `site_miners` SET `pool_2_user` = '".$pool_user."' WHERE `id` = '".$miner_data['id']."' ");
			mysql_query("UPDATE `site_miners` SET `pool_2_status` = '".$miner_data['update']['pools'][2]['status']."' WHERE `id` = '".$miner_data['id']."' ");
			mysql_query("UPDATE `site_miners` SET `pool_2_priority` = '".$miner_data['update']['pools'][2]['priority']."' WHERE `id` = '".$miner_data['id']."' ");
			unset($pool_user);
		}
		
		if(!empty($miner_data['update']['hardware_errors'])){
			mysql_query("UPDATE `site_miners` SET `hardware_errors` = '".$miner_data['update']['hardware_errors']."' WHERE `id` = '".$miner_data['id']."' ");
		}
		
		if(!empty($miner_data['update']['frequency'])){
			mysql_query("UPDATE `site_miners` SET `frequency` = '".$miner_data['update']['frequency']."' WHERE `id` = '".$miner_data['id']."' ");
		}
		
		// error_log("Miner ID: " . $miner_data['id']);
		
		// if(!empty($miner_data['update']['algorithm'])){
			mysql_query("UPDATE `site_miners` SET `algorithm` = '".$miner_data['update']['algorithm']."' WHERE `id` = '".$miner_data['id']."' ");
		// }
		
		if(!empty($miner_data['update']['pcb_temp_1'])){
			mysql_query("UPDATE `site_miners` SET `pcb_temp_1` = '".$miner_data['update']['pcb_temp_1']."' WHERE `id` = '".$miner_data['id']."' ");
		}
		if(!empty($miner_data['update']['pcb_temp_2'])){
			mysql_query("UPDATE `site_miners` SET `pcb_temp_2` = '".$miner_data['update']['pcb_temp_2']."' WHERE `id` = '".$miner_data['id']."' ");
		}
		if(!empty($miner_data['update']['pcb_temp_3'])){
			mysql_query("UPDATE `site_miners` SET `pcb_temp_3` = '".$miner_data['update']['pcb_temp_3']."' WHERE `id` = '".$miner_data['id']."' ");
		}
		if(!empty($miner_data['update']['pcb_temp_4'])){
			mysql_query("UPDATE `site_miners` SET `pcb_temp_4` = '".$miner_data['update']['pcb_temp_4']."' WHERE `id` = '".$miner_data['id']."' ");
		}
		if(!empty($miner_data['update']['chip_temp_1'])){
			mysql_query("UPDATE `site_miners` SET `chip_temp_1` = '".$miner_data['update']['chip_temp_1']."' WHERE `id` = '".$miner_data['id']."' ");
		}
		if(!empty($miner_data['update']['chip_temp_2'])){
			mysql_query("UPDATE `site_miners` SET `chip_temp_2` = '".$miner_data['update']['chip_temp_2']."' WHERE `id` = '".$miner_data['id']."' ");
		}
		if(!empty($miner_data['update']['chip_temp_3'])){
			mysql_query("UPDATE `site_miners` SET `chip_temp_3` = '".$miner_data['update']['chip_temp_3']."' WHERE `id` = '".$miner_data['id']."' ");
		}
		// if(!empty($miner_data['update']['chip_temp_4'])){
			mysql_query("UPDATE `site_miners` SET `chip_temp_4` = '".$miner_data['update']['chip_temp_4']."' WHERE `id` = '".$miner_data['id']."' ");
		// }
		// if(!empty($miner_data['update']['asics_1'])){
			mysql_query("UPDATE `site_miners` SET `asics_1` = '".$miner_data['update']['asics_1']."' WHERE `id` = '".$miner_data['id']."' ");
		// }
		// if(!empty($miner_data['update']['asics_2'])){
			mysql_query("UPDATE `site_miners` SET `asics_2` = '".$miner_data['update']['asics_2']."' WHERE `id` = '".$miner_data['id']."' ");
		// }
		// if(!empty($miner_data['update']['asics_3'])){
			mysql_query("UPDATE `site_miners` SET `asics_3` = '".$miner_data['update']['asics_3']."' WHERE `id` = '".$miner_data['id']."' ");
		// }
		// if(!empty($miner_data['update']['asics_4'])){
			mysql_query("UPDATE `site_miners` SET `asics_4` = '".$miner_data['update']['asics_4']."' WHERE `id` = '".$miner_data['id']."' ");
		// }
		
		if(isset($miner_data['update']['power']) && !empty($miner_data['update']['power'])){
			mysql_query("UPDATE `site_miners` SET `power` = '".$miner_data['update']['power']."' WHERE `id` = '".$miner_data['id']."' ");
		}

		if(isset($miner_data['update']['fan_1_speed']) && !empty($miner_data['update']['fan_1_speed'])){
			mysql_query("UPDATE `site_miners` SET `fan_2_speed` = '".$miner_data['update']['fan_1_speed']."' WHERE `id` = '".$miner_data['id']."' ");
		}

		if(isset($miner_data['update']['fan_2_speed']) && !empty($miner_data['update']['fan_2_speed'])){
			mysql_query("UPDATE `site_miners` SET `fan_1_speed` = '".$miner_data['update']['fan_2_speed']."' WHERE `id` = '".$miner_data['id']."' ");
		}
		
		if(isset($miner_data['update']['chain_asic_1'])){
			mysql_query("UPDATE `site_miners` SET `chain_asic_1` = '".$miner_data['update']['chain_asic_1']."' WHERE `id` = '".$miner_data['id']."' ");
		}

		if(isset($miner_data['update']['chain_asic_2'])){
		mysql_query("UPDATE `site_miners` SET `chain_asic_2` = '".$miner_data['update']['chain_asic_2']."' WHERE `id` = '".$miner_data['id']."' ");
		}

		if(isset($miner_data['update']['chain_asic_3'])){
			mysql_query("UPDATE `site_miners` SET `chain_asic_3` = '".$miner_data['update']['chain_asic_3']."' WHERE `id` = '".$miner_data['id']."' ");
		}

		if(isset($miner_data['update']['chain_asic_4'])){
			mysql_query("UPDATE `site_miners` SET `chain_asic_4` = '".$miner_data['update']['chain_asic_4']."' WHERE `id` = '".$miner_data['id']."' ");
		}

		mysql_query("UPDATE `site_miners` SET `time` = '".time()."' WHERE `id` = '".$miner_data['id']."' ");
		// store the data in stats table as well
		
		$input = mysql_query("INSERT INTO `site_miners_stats` 
			(`added`, `miner_id`, 
			`hashrate_1`, `hashrate_2`, `hashrate_3`, 
			`power`, 
			`pcb_temp_1`, `pcb_temp_2`, `pcb_temp_3`, 
			`chip_temp_1`, `chip_temp_2`, `chip_temp_3`)
			VALUE
			('".time()."', '".$miner_data['id']."', 
			'".$miner_data['update']['hashrate_1']."', '".$miner_data['update']['hashrate_2']."', '".$miner_data['update']['hashrate_3']."', 
			'".number_format($miner_data['update']['power'], 0)."', 
			'".$miner_data['update']['pcb_temp_1']."', '".$miner_data['update']['pcb_temp_2']."', '".$miner_data['update']['pcb_temp_3']."', 
			'".$miner_data['update']['chip_temp_1']."', '".$miner_data['update']['chip_temp_2']."', '".$miner_data['update']['chip_temp_3']."')") or die(mysql_error());
		/*
		$input = mysql_query("INSERT INTO `site_miners_stats` 
			(`added`, `miner_id`, `hashrate_1`, `hashrate_2`, `hashrate_3`, `power`, `pcb_temp_1`, `pcb_temp_2`, `pcb_temp_3`, `chip_temp_1`, `chip_temp_2`, `chip_temp_3`)
			VALUE
			('".time()."', '".$miner_data['id']."', '".$miner_data['update']['hashrate_1']."', '".$miner_data['update']['hashrate_2']."', '".$miner_data['update']['hashrate_3']."', '".$miner_data['update']['power']."', '".$miner_data['update']['chip_temp_1']."', '".$miner_data['update']['chip_temp_2']."', '".$miner_data['update']['chip_temp_3']."' )") or die(mysql_error());
		*/
		// $insert_id = mysql_insert_id();
	}

	
	$data['status']				= 'success';
	$data['message']			= 'data has been updated for miner: '.$miner_data['id'];
	json_output($data);
}

function site_ip_ranges()
{
	global $site;
	$data['status']				= 'success';
	$data['site']['id']			= $site['id'];
	$data['site']['name']		= $site['name'];
	
	$query 			= "SELECT * FROM `site_ip_ranges` WHERE `site_id` = '".$site['id']."' " ;
	$result 		= mysql_query($query) or die(mysql_error());
	$count = 0;
	while($row = mysql_fetch_array($result)){
		$data['ip_ranges'][$count]['id']						= $row['id'];
		$data['ip_ranges'][$count]['name']						= stripslashes($row['name']);
		$ip_bits												= explode(".", $row['ip_range']);
		$data['ip_ranges'][$count]['ip_range']					= $ip_bits[0].'.'.$ip_bits[1].'.'.$ip_bits[2].'.';
		$count++;
	}
	
	json_output($data);
}

function site_power_usage()
{
	global $site;
	$data['status']				= 'success';

	$data['power_usage']		= show_total_power($site['id']);

	json_output($data);
}

function build_config_file()
{
	global $site;
	
	$miner['id']				= get('miner_id');
	
	$query 			= "SELECT * FROM `site_miners` WHERE `id` = '".$miner['id']."' ";
	$result 		= mysql_query($query) or die(mysql_error());
	$count = 0;
	while($row = mysql_fetch_array($result)){	
		$data['pool_profile_id']			= $row['pool_profile_id'];
		$temp['bitmain-freq']				= $row['frequency'];
		$temp['hardware']					= $row['hardware'];
		
		if($row['pool_0_id'] != 0){
			$temp['pools'][0]['bits']				= get_pool($row['pool_0_id']);
			$config['pools'][0]['url']				= $temp['pools'][0]['bits']['url'].':'.$temp['pools'][0]['bits']['port'] . ($temp['pools'][0]['bits']['xnsub']=='yes' ? '#xnsub' : '');
			$config['pools'][0]['user']				= $temp['pools'][0]['bits']['username'] . (!empty($row['worker_name']) ? '.'.$row['worker_name']:'');
			$config['pools'][0]['pass']				= $temp['pools'][0]['bits']['password'];
		}else{
			$config['pools'][0]['url']				= '';
			$config['pools'][0]['user']				= '';
			$config['pools'][0]['pass']				= '';
		}
		
		if($row['pool_1_id'] != 0){
			$temp['pools'][1]['bits']				= get_pool($row['pool_1_id']);
			$config['pools'][1]['url']				= $temp['pools'][1]['bits']['url'].':'.$temp['pools'][1]['bits']['port'] . ($temp['pools'][1]['bits']['xnsub']=='yes' ? '#xnsub' : '');
			$config['pools'][1]['user']				= $temp['pools'][1]['bits']['username'] . (!empty($row['worker_name']) ? '.'.$row['worker_name']:'');
			$config['pools'][1]['pass']				= $temp['pools'][1]['bits']['password'];
		}else{
			$config['pools'][1]['url']				= '';
			$config['pools'][1]['user']				= '';
			$config['pools'][1]['pass']				= '';
		}
		
		if($row['pool_2_id'] != 0){
			$temp['pools'][2]['bits']				= get_pool($row['pool_2_id']);
			$config['pools'][2]['url']				= $temp['pools'][2]['bits']['url'].':'.$temp['pools'][2]['bits']['port'] . ($temp['pools'][2]['bits']['xnsub']=='yes' ? '#xnsub' : '');
			$config['pools'][2]['user']				= $temp['pools'][2]['bits']['username'] . (!empty($row['worker_name']) ? '.'.$row['worker_name']:'');
			$config['pools'][2]['pass']				= $temp['pools'][2]['bits']['password'];
		}
		else{
			$config['pools'][2]['url']				= '';
			$config['pools'][2]['user']				= '';
			$config['pools'][2]['pass']				= '';
		}
		
		$config['api-listen'] 					= 'true';
		$config['api-network']					= 'true';
		$config['api-groups']					= 'A:stats:pools:devs:summary:version';
		$config['api-allow']					= 'A:0/0,W:*';
		$config['bitmain-use-vil']				= 'true';
		$config['bitmain-freq']					= $temp['bitmain-freq'];

		if($temp['hardware'] == 'antminer-s9')
		{
			$config['bitmain-voltage']	= '0706';
		}
		$config['multi-version']	= '1';
	}
	
	if(isset($config))
	{
		// $config_to_save = json_encode($config, JSON_PRETTY_PRINT);
		// $config_to_save = str_replace('\\', '', $config_to_save);
		// $config_to_save = $config_to_save."\n\n";
		
		$file  = '{'."\n";
		$file .= '"pools" : ['."\n";
		$file .= '{'."\n";
		$file .= '"url" : "'.$config['pools'][0]['url'].'",'."\n";
		$file .= '"user" : "'.$config['pools'][0]['user'].'",'."\n";
		$file .= '"pass" : "'.$config['pools'][0]['pass'].'"'."\n";
		$file .= '},'."\n";
		$file .= '{'."\n";
		$file .= '"url" : "'.$config['pools'][1]['url'].'",'."\n";
		$file .= '"user" : "'.$config['pools'][1]['user'].'",'."\n";
		$file .= '"pass" : "'.$config['pools'][1]['pass'].'"'."\n";
		$file .= '},'."\n";
		$file .= '{'."\n";
		$file .= '"url" : "'.$config['pools'][2]['url'].'",'."\n";
		$file .= '"user" : "'.$config['pools'][2]['user'].'",'."\n";
		$file .= '"pass" : "'.$config['pools'][2]['pass'].'"'."\n";
		$file .= '}'."\n";
		$file .= ']'."\n";
		$file .= ','."\n";
		$file .= '"api-listen" : true,'."\n";
		$file .= '"api-network" : true,'."\n";
		$file .= '"api-groups" : "A:stats:pools:devs:summary:version",'."\n";
		$file .= '"api-allow" : "A:0/0,W:*",'."\n";
		$file .= '"bitmain-use-vil" : true,'."\n";
		$file .= '"bitmain-freq" : "550",'."\n";
		if($temp['hardware'] == 'antminer-s9')
		{
			$file .= '"bitmain-voltage" : "0706",'."\n";
		}
		$file .= '"multi-version" : "1"'."\n";
		$file .= '}'."\n";
		$file .= ''."\n";
		
		file_put_contents('/home2/deltacolo/public_html/zeus/miner_config_files/'.$miner['id'].'.conf', $file);
		
		// $filename = 'cgminer.conf';
		// header("Content-Type: text/plain");
		// header('Content-Disposition: attachment; filename="'.$filename.'"');
		// header("Content-Length: " . strlen($config_json));
		// echo $config_json;
		// exit;
		
		json_output($config);
	}else{
		json_output($data);
	}	
}

function controller_checkin()
{
	global $site;

	$controller_data_raw		= file_get_contents('php://input');
	$controller_data			= json_decode($controller_data_raw, true);

	// error_log(print_r($controller_data, true));

	$data['status']				= 'success';
	$data['site']['id']			= $site['id'];
	$data['site']['name']		= $site['name'];
	$data['mac_address']		= $controller_data['mac_address'];
	$data['lan_ip_address']		= $controller_data['ip_address'];
	$data['wan_ip_address']		= $_SERVER['REMOTE_ADDR'];
	$data['version']			= $controller_data['version'];
	$data['cpu_temp']			= $controller_data['cpu_temp'];
	$data['hardware']			= $controller_data['hardware'];
	$data['cluster_details']	= $controller_data['cluster_details'];

	mysql_query("UPDATE `sites` SET `ip_address` = '".$data['wan_ip_address']."' WHERE `id` = '".$site['id']."' ") or die(mysql_error());
	mysql_query("UPDATE `sites` SET `controller_ip` = '".$data['lan_ip_address']."' WHERE `id` = '".$site['id']."' ") or die(mysql_error());
	mysql_query("UPDATE `sites` SET `controller_mac` = '".$data['mac_address']."' WHERE `id` = '".$site['id']."' ") or die(mysql_error());
	mysql_query("UPDATE `sites` SET `controller_last_checkin` = '".time()."' WHERE `id` = '".$site['id']."' ") or die(mysql_error());
	mysql_query("UPDATE `sites` SET `controller_cpu_temp` = '".$data['cpu_temp']."' WHERE `id` = '".$site['id']."' ") or die(mysql_error());
	mysql_query("UPDATE `sites` SET `controller_version` = '".$data['version']."' WHERE `id` = '".$site['id']."' ") or die(mysql_error());
	mysql_query("UPDATE `sites` SET `controller_pi_hardware` = '".$data['hardware']."' WHERE `id` = '".$site['id']."' ") or die(mysql_error());
	mysql_query("UPDATE `sites` SET `cluster_details` = '".$data['cluster_details']."' WHERE `id` = '".$site['id']."' ") or die(mysql_error());

	json_output($data);
}

function miner_gpu_get_config()
{
	global $site;

	if(isset($_GET['miner_id']))
	{
		$miner_id = addslashes($_GET['miner_id']);
	}else{
		$data['status'] 		= 'error';
		$data['message']		= 'miner_id is missing.';
		json_output($data);
	}
	
	$query 			= "SELECT * FROM `site_miners` WHERE `id` = '".$miner_id."' ";
	$data['query'] 	= $query;
	$result 		= mysql_query($query) or die(mysql_error());
	$miner_found	= mysql_num_rows($result);

	if($miner_found == 0){
		$data['status']				= 'miner not found';
	}else{
		$data['status']				= 'success';
	}

	while($row = mysql_fetch_array($result)){
		// $data['raw']								= $row;
		$data['name']								= stripslashes($row['name']);

		$data['gpu_miner_software_folder']			= $row['gpu_miner_software_folder'];
		$data['gpu_miner_software_binary']			= $row['gpu_miner_software_binary'];
		$data['gpu_miner_vars']						= $row['gpu_miner_vars'];

		$data['pool_address']						= $row['pool_0_url'];
		$data['pool_username']						= $row['pool_0_user'];
		$data['worker_name']						= $row['worker_name'];

		$data['gpu_miner_vars']						= str_replace('[SERVER]', $data['pool_address'], $data['gpu_miner_vars']);
		$data['gpu_miner_vars']						= str_replace('[USERNAME]', $data['pool_username'], $data['gpu_miner_vars']);

		if(empty($row['worker_name'])){
			$data['gpu_miner_vars']					= str_replace('[WORKER_NAME]', '', $data['gpu_miner_vars']);
		}else{
			$data['gpu_miner_vars']					= str_replace('[WORKER_NAME]', $data['worker_name'], $data['gpu_miner_vars']);
		}

		$data['gpu_miner_cmd']						= '/mcp/miners/'.$data['gpu_miner_software_folder'] . '/' . $data['gpu_miner_software_binary'] . ' ' . $data['gpu_miner_vars'];

		$data['paused']								= $row['paused'];
	}

	json_output($data);
}
