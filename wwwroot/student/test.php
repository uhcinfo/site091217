<?php

	error_reporting(-1);
	ini_set('display_errors', '0');
	
	function testConnection($fm_path, $webapi_password)
	{
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, 'http://' . $fm_path . '/fmi/xml/version.xml');
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch,CURLOPT_VERBOSE, false);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$page = curl_exec($ch);
		//echo curl_error($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		
		if($httpcode>=200 && $httpcode<300)
		{
			$timestamp = time();
			
			/* Call Connectivity Test from FM */
			$kamar = new kamar();
			$kamar->setFMPath($fm_path);
			$kamar->OpenWebFileEdit($webapi_password);
			$kamar->Go_To_Layout('KCI_Connectivity');
			$kamar->Perform_Script('KCI_Return_Connectivity', $timestamp);
			$records = $kamar->get("FoundCount");
			$last_error = $kamar->Get('lasterror');
			
			if (!$last_error != 0 && $records > 0 && $kamar->field('zg_ConnectionID') == $timestamp)
				return true;
			
			return false;
		}
		else
		{
			return false;
		}
	}
	
	function testIDMAPlugin($fm_path, $webapi_password)
	{
		$kamar = new kamar();
		$kamar->setFMPath($fm_path);
		$kamar->OpenWebFileEdit($webapi_password);
		$kamar->Go_To_Layout('Script_ReturnTimetable');
		$kamar->Show_All_Records();
		$records = $kamar->get("FoundCount");
		$last_error = $kamar->Get('lasterror');
			
		if (!$last_error != 0 && $records > 0)
			return $kamar->field('zc_IDMAVersion');
			
		return -1;
	}

	require_once('../basic-config.php');
	global $G_common_settings, $config;
	$student_portal_config_path = $G_common_settings->config_path . '/student-portal-config.php';
	$common_config_path = $G_common_settings->config_path . '/common-config.php';
	$technical_config_path = $G_common_settings->config_path . '/technical-config.php';
	$security_config_path = $G_common_settings->config_path . '/security-config.php';

	@include_once($technical_config_path);
	if (isset($config['fm_path']) && !empty($config['fm_path']))
	{
		echo('<p style="color: green;">Technical settings file found.</p>');
	}
	else
	{
		echo('<p style="color: red;">There does not appear to be a correctly built technical settings file. <strong>Please run the web configuration builder to address this.</strong> [' . $technical_config_path . ']</p>');
		exit();
	}
	@include_once($common_config_path);
	if (isset($config['show_assessment_types']))
	{
		echo('<p style="color: green;">Common settings file found.</p>');
	}
	else
	{
		echo('<p style="color: red;">There does not appear to be a correctly built common settings file. <strong>Please run the web configuration builder to address this.</strong> [' . $common_config_path . ']</p>');
	}
	@include_once($security_config_path);
	if (isset($config['security_admin_password']) && !empty($config['security_admin_password']))
	{
		echo('<p style="color: green;">Security settings file found.</p>');
	}
	else
	{
		echo('<p style="color: red;">There does not appear to be a correctly built security settings file. <strong>Please run the web configuration builder to address this.</strong> [' . $security_config_path . ']</p>');
	}
	@include_once($student_portal_config_path);
	if (isset($config['post_login_page']) || !empty($config['post_login_page']))
	{
		echo('<p style="color: green;">Portal settings file found.</p>');
	}
	else
	{
		echo('<p style="color: red;">There does not appear to be a correctly built portal settings file. <strong>Please run the web configuration builder to address this.</strong> [' . $student_portal_config_path . ']</p>');
	}

	require_once($G_common_settings->kamar_common_interface_path . '/kamar.php');
	$fm_path = $config['fm_path'];
	$webapi_password = $config['security_webapi_password'];
	if (testConnection($fm_path, $webapi_password))
	{
		echo('<p style="color: green;">Connection to Web Publishing Engine was successful. [' . $fm_path . ']</p>');
	}
	else
	{
		echo('<p style="color: red;">No connection to Web Publishing Engine. <strong>Please ensure the Web Publishing Engine is running and that the web server is it attached to is serving pages.</strong> [' . $fm_path . ']</p>');
		exit();
	}
	
	$idma_version = testIDMAPlugin($fm_path, $webapi_password);
	if ($idma_version > 0)
	{
		echo('<p style="color: green;">The IDMA plugin appears to be loaded. [' . $idma_version . ']</p>');
		exit();
	}
	else
	{
		echo('<p style="color: red;">There was a problem getting the IDMA plugin version via the Web Publishing Engine. <strong>Please ensure the IDMA plugin is available to the Web Publishing Engine.</strong></p>');
		exit();
	}
