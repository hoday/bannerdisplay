<?php

namespace Hoday\Banners;

use DateTime;

/**
 * Manages whether a banner should be visible
 */
class BannerVisibilityManager {

	private function __construct() {
	}

	/**
	 * Returns true if the banner is visible
	 * @return boolean true if banner is visible
	 */
	 public static function isVisible($startDate, $endDate, $allowedIps) {


		$date 	= static::getCurrentDate();
		$ip 		= static::getCurrentIp();

		$startDate 	= (new DateTime($startDate))->getTimestamp();
		$endDate 		= (new DateTime($endDate))->getTimestamp();
		$date 			= $date->getTimestamp();

		$isDuringPeriod = ($date >= $startDate) && ($date <= $endDate) ;
		$isBeforePeriod = ($date < $startDate);
		$isIpAllowed    = in_array($ip, $allowedIps);
		//$isIpAllowed    = isset($allowedIps[$ip]);

		return ($isDuringPeriod || ($isBeforePeriod && $isIpAllowed));
	}

	/**
	 * getCurrentDate Gets current date
	 * @return int Timestamp
	 */
	protected static function getCurrentDate() {
		return new DateTime();
	}

	/**
	 * getCurrentIp Returns current IP
	 * @return String Current IP
	 */
	protected static function getCurrentIp() {
		return $_SERVER['REMOTE_ADDR'];
	}

}
