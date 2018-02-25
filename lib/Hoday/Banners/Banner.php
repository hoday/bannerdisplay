<?php

namespace Hoday\Banners;

/**
 * A banner with an image
 */
class Banner {

	protected $banner_path;

	/**
	 * __construct Create Banner object
	 * @param String $banner_path Path to the desired banner image
	 */
	public function __construct($banner_path) {
		$this->banner_path = $banner_path;
	}

	/**
	* Deletes a registered banner
	* @param  String $banner_name Name of the banner
	*/
	public function deleteBanner($banner_name) {
	unset($this->banners, $banner_name);
	}

	/**
	* Gets the path of the graphic for the banner
	* @param  String $banner_name Name of the banner
	* @return  String             Path to the banner graphic
	*/
	public function getBannerPath($banner_name) {
	return $this->banners[$banner_name]['banner'];
	}

	/**
	* Sets the path of the graphic for the banner
	* @param  String $banner_name Name of the banner
	* @param  String $banner_path Path to the banner graphic
	*/
	public function setBannerPath($banner_name, $banner_path) {
	$this->banners[$banner_name]['banner'] = new Banner($banner_path);
	}

	/**
	 * printBanner Prints html for Banner
	 */
	public function printBanner() {
		ob_start();
    include('templates/banner_template.php');
		echo ob_get_clean();
	}
}
