<?php

namespace Hoday\Banners;

/**
 * A banner with an image
 */
class Banner {

	protected $bannerPath;

	/**
	 * __construct Create Banner object
	 * @param String $bannerPath Path to the desired banner image
	 */
	public function __construct($bannerPath) {
		$this->bannerPath = $bannerPath;
	}

	/**
	* Deletes a registered banner
	* @param  String $bannerName Name of the banner
	*/
	public function deleteBanner($bannerName) {
	}

	/**
	* Gets the path of the graphic for the banner
	* @param  String $bannerName Name of the banner
	* @return  String             Path to the banner graphic
	*/
	public function getBannerPath() {
		return $this->bannerPath;
	}

	/**
	* Sets the path of the graphic for the banner
	* @param  String $bannerName Name of the banner
	* @param  String $bannerPath Path to the banner graphic
	*/
	public function setBannerPath($bannerPath) {
		$this->bannerPath = $bannerPath;
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
