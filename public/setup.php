<?php

$bannerSettings = array(
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

$allowedIPs = array('10.0.0.1', '10.0.0.2');

/*
$bannerManager = new Hoday\Banners\BannerManagerDb();
*/
//$pdo = (new App\SQLiteConnection())->connect();
$pdo = App\SQLiteConnection::getInstance();

if ($pdo != null) {
	echo 'Sccessfully connect to the SQLite database!';

} else {
		echo 'Whoops, could not connect to the SQLite database!';
}


(new App\SQLiteCreateTable($pdo))->createTables();



//$bannerManager = new Hoday\Banners\BannerManagerDb($pdo);



foreach($bannerSettings as $bannerSetting) {
	\Hoday\Banners\BannerService::getInstance()->create($bannerSetting['path'],  $bannerSetting['start_date'], $bannerSetting['end_date'], $allowedIPs);

/*
	foreach($allowedIPs as $allowedIP) {
		\Hoday\Banners\BannerService::registerAllowedIp($allowedIP);
	}
	*/
}
