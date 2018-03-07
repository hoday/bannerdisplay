<?php

namespace Hoday\Banners;

class BannerView {

  public function __construct() {
		//$this->bannerService =$bannerServiceo;
	}

  public static function show($bannerId) {

    if (\Hoday\Banners\BannerService::isVisible($bannerId)) {
      $bannerPath = \Hoday\Banners\BannerService::getPath($bannerId);

  		ob_start();
      include('templates/banner_template.php');
  		echo ob_get_clean();
    }
	}

}
