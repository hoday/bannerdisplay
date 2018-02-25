<?php

namespace Hoday\Banners;

/**
 * Provides a user interface to manage banners
 * @package BannerManager
 */
class BannerManager {

	protected $banners;

	public function __construct() {
		$this->banners = array();
	}

	/**
	 * Registers a banner using a unique name (used to identify the banner) and path of the graphic
	 * @param  String $banner_name Name of the banner
	 * @param  String $banner_path Path to the banner graphic
	 */
	public function registerBanner($banner_name, $banner_path) {
		$this->banners[$banner_name]['banner'] 											= new Banner($banner_path);
		$this->banners[$banner_name]['banner_display_controller'] 	= new BannerDisplayController();
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
	 * Prints the html for the banner of the specified name
	 * @param  String $banner_name Name of the banner
	 */
	public function printBanner($banner_name) {
		if ($this->banners[$banner_name]['banner_display_controller']->isShowing()) {
			$this->banners[$banner_name]['banner']->printBanner();

		}
	}

	/**
	 * Sets a start date and end date between which the banner of the specified name should be visible
	 * @param String $banner_name Name of the banner
	 * @param String $start_date Start date of the period
	 * @param String $end_date   End date of the period
	 */
	public function setBannerPeriod($banner_name, $start_date, $end_date) {
		$this->banners[$banner_name]['banner_display_controller']->setBannerPeriod($start_date, $end_date);
	}

	public function setBannerStartDate($banner_name, $start_date) {
		$this->banners[$banner_name]['banner_display_controller']->setBannerStartDate($start_date);
	}

	public function setBannerEndDate($banner_name, $end_date) {
		$this->banners[$banner_name]['banner_display_controller']->setBannerEndDate($end_date);
	}

	public function getBannerStartDate($banner_name) {
		return $this->banners[$banner_name]['banner_display_controller']->getBannerStartDate();
	}

	public function getBannerEndDate($banner_name) {
		return $this->banners[$banner_name]['banner_display_controller']->getBannerEndDate();
	}


	/**
	 * Registers an allowed IP address for a named banner
	 * @param  String $banner_name Name of the banner
	 * @param  String $ip IP address to register
	 */
	public function registerAllowedIp($banner_name, $ip) {
		$this->banners[$banner_name]['banner_display_controller']->registerAllowedIp($ip);
	}

	/**
	 * Deregisters an allowed IP address for a named banner
	 * @param  String $banner_name Name of the banner
	 * @param  String $ip IP address to deregister
	 */
	public function deregisterAllowedIp($banner_name, $ip) {
		$this->banners[$banner_name]['banner_display_controller']->deregisterAllowedIp($ip);
	}

/**
 * Gets allowed IPs
 * @param  String $banner_name Name of the banner
 * @return Array              Array of IPs
 */
	public function getAllowedIps($banner_name) {
		return $this->banners[$banner_name]['banner_display_controller']->getAllowedIps();
	}

}
