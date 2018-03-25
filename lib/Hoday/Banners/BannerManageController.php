<?php

namespace Hoday\Banners;

class BannerManageController {

  const FORMAT_STRING = 'Y-m-d H:i:s';

  public function __construct() {
	}

  public static function do() {

    $ip = $_GET['ip'];
    $id = $_GET['id'];

    $banners = \Hoday\Banners\BannerService::registerIp($id, $ip);
	}

}
