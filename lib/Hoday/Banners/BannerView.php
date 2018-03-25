<?php

namespace Hoday\Banners;

class BannerView {

  public function __construct() {
		//$this->bannerService =$bannerServiceo;
	}

  /**
   * prints html for displaying a banner
   * @param  int $bannerId    id of the banner
   */
  public static function show(int $bannerId) {

    $isVisible = \Hoday\Banners\BannerService::isVisible($bannerId);
    if ($isVisible) {
      $bannerPath = \Hoday\Banners\BannerService::getPath($bannerId);

  		ob_start();
      include('templates/banner_template.php');
  		echo ob_get_clean();
    }
	}

}
