<?php

namespace Hoday\Banners;

use DateTime;

/**
 * Manages whether a banner should be visible
 */
class BannerDisplayController {

	protected $start_date;
	protected $end_date;
	protected $allowed_ips;

	public function __construct() {

		$this->start_date = 0;
		$this->end_date 	= PHP_INT_MAX;
		$this->allowed_ips 	= array();
	}

	/**
	 * Sets a start date and end date between which the banner should be visible
	 * @param String $start_date Start date of the period
	 * @param String $end_date   End date of the period
	 */
	public function setBannerPeriod($start_date, $end_date) {
		$this->start_date = (new DateTime($start_date))->getTimestamp();
		$this->end_date 	= (new DateTime($end_date))->getTimestamp();
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
	 * Registers an allowed IP address
	 * @param  String $ip IP address to register
	 */
	public function registerAllowedIp($ip) {
		$this->allowed_ips[$ip] = true;
	}


	/**
	 * Deregisters a previously registered IP address
	 * @param  String $ip IP address to deregister
	 */
	public function deregisterAllowedIp($ip) {
		unset($this->allowed_ips[$ip]);
	}

	/**
	 * Gets allowed IPs
	 * @param  String $banner_name Name of the banner
	 * @return Array              Array of IPs
	 */
		public function getAllowedIps($banner_name) {
			return $this->banners[$banner_name]['banner_display_controller']->getAllowedIps();
		}	

	/**
	 * Returns true if the banner is visible
	 * @return boolean true if banner is visible
	 */
	 public function isShowing() {

		$date 	= $this->getCurrentDate();
		$ip 		= $this->getCurrentIp();

		$is_during_period = ($date >= $this->start_date) && ($date <= $this->end_date) ;
		$is_before_period = ($date < $this->start_date);
		$is_ip_allowed    = isset($this->allowed_ips[$ip]);

		if ($is_during_period) {
			$show_banner = true;
		} else {
			if ($is_before_period && $is_ip_allowed) {
				$show_banner = true;
			} else {
				$show_banner = false;
			}
		}

		return $show_banner;
	}

	/**
	 * getCurrentDate Gets current date
	 * @return int Timestamp
	 */
	protected function getCurrentDate() {
		return (new DateTime())->getTimestamp();
	}

	/**
	 * getCurrentIp Returns current IP
	 * @return String Current IP
	 */
	protected function getCurrentIp() {
		return $_SERVER['REMOTE_ADDR'];
	}

}
