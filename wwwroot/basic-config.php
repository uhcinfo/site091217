<?php
// Created : 16 December 2009,  Adam Lynam
// 27/05/2012 - Set up primary config path file

global $G_common_settings;

if(!is_object($G_common_settings))
	$G_common_settings = new stdClass();

$G_common_settings->webbuild_version_number = '3.4.2';

$G_common_settings->school_assets_path = dirname(__FILE__) . '/school-assets';										// read-only

/* moveable directories */
$G_common_settings->moveable = dirname(__FILE__) . '/../moveable';
$G_common_settings->kamar_common_path = $G_common_settings->moveable . '/kamar-common';								// read-only
$G_common_settings->kamar_common_interface_path = $G_common_settings->kamar_common_path . '/kamarcommoninterface';	// read-only
$G_common_settings->kamar_common_display_path = $G_common_settings->kamar_common_path . '/kamarcommondisplay';		// read-only
$G_common_settings->phpmailer_path = $G_common_settings->kamar_common_path . '/PHPMailer';							// read-only
$G_common_settings->tcpdf_path = $G_common_settings->kamar_common_path . '/tcpdf';
$G_common_settings->Auth_path = $G_common_settings->kamar_common_path . '/Auth';								// read-only
$G_common_settings->config_path = $G_common_settings->moveable . '/config';											// read-only
$G_common_settings->api_path = $G_common_settings->moveable . '/api';												// read-only
$G_common_settings->student_portal_path = $G_common_settings->moveable . '/student-portal';							// read-only
$G_common_settings->cache_path = $G_common_settings->moveable . '/cache';											// write-access needed
$G_common_settings->reports_path = $G_common_settings->moveable . '/reports';										// read-only, write-access needed for uploading reports
	
$G_common_settings->base_path = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . str_replace('\\', '', str_replace('//','/',dirname($_SERVER['SCRIPT_NAME']) . '/'));
$G_common_settings->school_assets_url = dirname($G_common_settings->base_path) . '/school-assets/';
$G_common_settings->logo_path = dirname($G_common_settings->base_path) . '/school-assets/logo.png';

?>
