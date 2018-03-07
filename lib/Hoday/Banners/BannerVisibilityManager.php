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

		$date 	= self::getCurrentDate();
		$ip 		= self::getCurrentIp();

		$isDuringPeriod = ($date >= $startDate) && ($date <= $endDate) ;
		$isBeforePeriod = ($date < $startDate);
		$isIpAllowed    = isset($allowedIps[$ip]);

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
	protected static function getCurrentDate() {
		return (new DateTime())->getTimestamp();
	}

	/**
	 * getCurrentIp Returns current IP
	 * @return String Current IP
	 */
	protected static function getCurrentIp() {
		return $_SERVER['REMOTE_ADDR'];
	}

}
