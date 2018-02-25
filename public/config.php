<?php

$banner_settings = array(
	array(
		'name'				=> 'banner_active',
		'start_date' 	=> '2014-08-12T12:00:00+0900',
		'end_date' 		=> '2024-08-12T12:00:00+0900',
		'path'				=> 'assets/mercari_banner.png'
	),
	array(
		'name'				=> 'banner_inactive',
		'start_date' 	=> '2014-08-10T12:00:00+0900',
		'end_date' 		=> '2014-08-12T12:00:00+0900',
		'path'				=> 'assets/mercari_banner2.jpg'
	),
);

$allowed_IPs = array('10.0.0.1', '10.0.0.2');

//
// Set include path for all libraries
//
set_include_path(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'lib');


//
// Import the banner library
//
include '../lib/Hoday/Banners/bootstrap.php';

use Hoday\Banners\BannerManager;

$banner_manager = new BannerManager();

foreach($banner_settings as $banner_setting) {
	$banner_manager->registerBanner($banner_setting['name'], $banner_setting['path']);
	$banner_manager->setBannerPeriod($banner_setting['name'], $banner_setting['start_date'], $banner_setting['end_date']);

	foreach($allowed_IPs as $allowed_IP) {
		$banner_manager->registerAllowedIp($banner_setting['name'], $allowed_IP);
	}
}
