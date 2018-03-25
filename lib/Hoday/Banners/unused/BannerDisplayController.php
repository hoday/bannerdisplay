<?php

namespace Hoday\Banners;

use DateTime;

/**
 * Manages whether a banner should be visible
 */
class BannerDisplayController {

	private $startDate;
	private $endDate;
	private $allowedIps;

	public function __construct() {

		$this->startDate = 0;
		$this->endDate 	= PHP_INT_MAX;
		$this->allowedIps 	= array();
	}

	/**
	 * Sets a start date and end date between which the banner should be visible
	 * @param String $startDate Start date of the period
	 * @param String $endDate   End date of the period
	 */
	public function setBannerPeriod($startDate, $endDate) {
		$this->startDate = (new DateTime($startDate))->getTimestamp();
		$this->endDate 	= (new DateTime($endDate))->getTimestamp();
	}

	public function setBannerStartDate($startDate) {
		$this->startDate = (new DateTime($startDate))->getTimestamp();
	}

	public function setBannerEndDate($endDate) {
		$this->endDate 	= (new DateTime($endDate))->getTimestamp();
	}

	public function getBannerStartDate() {
		return $this->startDate;
	}

	public function getBannerEndDate() {
		return $this->endDate;
	}

	/**
	 * Registers an allowed IP address
	 * @param  String $ip IP address to register
	 */
	public function registerAllowedIp($ip) {
		$this->allowedIps[$ip] = true;
	}


	/**
	 * Deregisters a previously registered IP address
	 * @param  String $ip IP address to deregister
	 */
	public function deregisterAllowedIp($ip) {
		unset($this->allowedIps[$ip]);
	}

	/**
	 * Gets allowed IPs
	 * @param  String $bannerName Name of the banner
	 * @return Array              Array of IPs
	 */
		public function getAllowedIps() {
			return $this->allowedIps;
		}

	/**
	 * Returns true if the banner is visible
	 * @return boolean true if banner is visible
	 */
	 public function isShowing() {

		$date 	= $this->getCurrentDate();
		$ip 		= $this->getCurrentIp();

		echo $this->startDate."<br/>";
		echo $this->endDate."<br/>";
		print_r($this->allowedIps);
		echo "<br/>";

		echo $date."<br/>";
		echo $ip."<br/>";

		$isDuringPeriod = ($date >= $this->startDate) && ($date <= $this->endDate) ;
		$isBeforePeriod = ($date < $this->startDate);
		$isIpAllowed    = isset($this->allowedIps[$ip]);

		if ($isDuringPeriod) {
			$showBanner = true;
		} else {
			if ($isBeforePeriod && $isIpAllowed) {
				$showBanner = true;
			} else {
				$showBanner = false;
			}
		}

		return $showBanner;
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
