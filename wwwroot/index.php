<?php

	// hide errors
	error_reporting(0);
	ini_set('display_errors', '0');
	
	// load the moveable folder paths
	require_once('basic-config.php');
	global $G_common_settings;
	$student_portal_config_path = $G_common_settings->config_path . '/student-portal-config.php';
	$common_config_path = $G_common_settings->config_path . '/common-config.php';
	$technical_config_path = $G_common_settings->config_path . '/technical-config.php';
	$security_config_path = $G_common_settings->config_path . '/security-config.php';
	
	// check for each file in turn, if it hasn't been made yet, send the user to the right part of the admin
	@include_once($technical_config_path);
	if (!isset($config['fm_path']) || empty($config['fm_path']))
	{
		header('Location: ' . $G_common_settings->base_path . 'configure/index.php/technical');
		exit();
	}
	@include_once($common_config_path);
	if (!isset($config['show_assessment_types']))
	{
		header('Location: ' . $G_common_settings->base_path . 'configure/index.php/common');
		exit();
	}
	@include_once($security_config_path);
	if (!isset($config['security_admin_password']) || empty($config['security_admin_password']))
	{
		header('Location: ' . $G_common_settings->base_path . 'configure/index.php/security');
		exit();
	}
	@include_once($student_portal_config_path);
	if (!isset($config['post_login_page']) || empty($config['post_login_page']))
	{
		header('Location: ' . $G_common_settings->base_path . 'configure/index.php/student-portal');
		exit();
	}
	

	header('Location: ' . $G_common_settings->base_path . 'student/index.php');
	exit();