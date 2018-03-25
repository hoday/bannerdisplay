<?php

namespace Hoday\Banners;

/**
 * Provides a user interface to manage banners
 */
class BannerService {

	private function __construct() {
	}

	/**
	 * Creates a new banner
	 * @param  string $bannerPath path to banner graphic
	 * @param  string $startDate  start date of period to display banner
	 * @param  string $endDate    end date of period to display banner
	 * @param  array $allowedIps 	array of allowed IP addresses
	 * @return int		            id of banner that was created
	 */
	public static function create(string $bannerPath, string $startDate, string $endDate, array $allowedIps) : int {
		forEach($allowedIps as $allowedIp) {
			if (!filter_var($allowedIp, FILTER_VALIDATE_IP)) {
				throw new \InvalidArgumentException('not a valid IP address');
			}
		}

		if (!BannerService::isValidDate($startDate)) {
			throw new \InvalidArgumentException('not a valid date');
		}

		if (!BannerService::isValidDate($endDate)) {
			throw new \InvalidArgumentException('not a valid date');
		}

		if (!BannerService::isValidPath($bannerPath)) {
			throw new \InvalidArgumentException('not a valid path');
		}

		return BannerDataMapper::create($bannerPath, $startDate, $endDate, $allowedIps);
	}

	/**
	 * Get banner info by id
	 * @param  int $bannerId 			id of banner
	 * @return array     					info about banner
	 */
  public static function get(int $bannerId) : array {
    return BannerDataMapper::get($bannerId);
  }

	/**
	 * get info about all banners
	 * @return array array of info about all banners
	 */
  public static function getAll() : array {
    return BannerDataMapper::getAll();
  }

	/**
	 * gets the path to the graphic of a banner
	 * @param  int $bannerId 			id of the banner
	 * @return string          	 	path
	 */
  public static function getPath(int $bannerId) : string {
    return BannerDataMapper::getPath($bannerId);
  }

	/**
	 * gets the start date of the banner display period
	 * @param  int $bannerId 			id of the banner
	 * @return string           	start date
	 */
  public static function getStartDate(int $bannerId) : string {
    return BannerDataMapper::getStartDate($bannerId);
  }

	/**
	 * gets the end date of the banner display period
	 * @param  int $bannerId 			id of the banner
	 * @return string           	end date
	 */
  public static function getEndDate(int $bannerId) : string {
    return BannerDataMapper::getEndDate($bannerId);
  }

	/**
	 * gets the IP addresses that are allowed to see a banner even before the display period
	 * @param  int $bannerId 	id of the banner
	 * @return array         	array of IP addresses
	 */
  public static function getAllowedIps(int $bannerId) : array {
    return BannerDataMapper::getAllowedIps($bannerId);
  }

	/**
	 * sets the path for the graphic for a banner
	 * @param int $bannerId   		id of the banner
	 * @param string $bannerPath 	path to the graphic for the banner
	 */
  public static function setPath(int $bannerId, string $bannerPath) {
		if (!BannerService::isValidPath($bannerPath)) {
			throw new \InvalidArgumentException('not a valid path');
		}
    BannerDataMapper::setPath($bannerId, $bannerPath);
  }

	/**
	 * sets the start date for the display period for a banner
	 * @param int $bannerId  		id of the banner
	 * @param string $startDate start date
	 */
  public static function setStartDate(int $bannerId, string $startDate) {
		if (!BannerService::isValidDate($startDate)) {
			throw new \InvalidArgumentException('not a valid date');
		}
	  BannerDataMapper::setStartDate($bannerId, $startDate);
  }

	/**
	 * sets the end date for the display period for a banner
	 * @param int $bannerId  	id of the banner
	 * @param string $endDate enddate
	 */
  public static function setEndDate(int $bannerId, string $endDate) {
		if (!BannerService::isValidDate($endDate)) {
			throw new \InvalidArgumentException('not a valid date');
		}
    BannerDataMapper::setEndDate($bannerId, $endDate);
  }

	/**
	 * sets the IP addresses that are allowed to see a banner before the display period
	 * @param int   $bannerId   id of the banner
	 * @param array $allowedIps array of allowed IP addresses
	 */
  public static function setAllowedIps(int $bannerId, array $allowedIps) {
		forEach($allowedIps as $allowedIp) {
			if (!filter_var($allowedIp, FILTER_VALIDATE_IP)) {
				throw new InvalidArgumentException('not a valid IP address');
			}
		}
    BannerDataMapper::setAllowedIps($bannerId, $allowedIps);
  }

	/**
	 * registers an IP address that is allowed to see a banner before the display period
	 * @param int   $bannerId   id of the banner
	 * @param string $allowedIp allowed IP address
	 */
  public static function registerAllowedIp(int $bannerId, string $allowedIp) {

		if (filter_var($allowedIp, FILTER_VALIDATE_IP)) {
			BannerDataMapper::registerAllowedIp($bannerId, $allowedIp);
		} else {
			throw new InvalidArgumentException('not a valid IP address');
		}
  }

	/**
	 * registers IP addresses that are allowed to see a banner before the display period
	 * @param int   $bannerId   id of the banner
	 * @param array $allowedIps allowed IP addresses
	 */
	public static function registerAllowedIps(int $bannerId, array $allowedIps) {
		forEach($allowedIps as $allowedIp) {
			if (!filter_var($allowedIp, FILTER_VALIDATE_IP)) {
				throw new InvalidArgumentException('not a valid IP address');
			}
		}
		BannerDataMapper::registerAllowedIps($bannerId, $allowedIp);
	}

	/**
	 * deregisters an IP address that was allowed to see a banner before the display period
	 * @param int   $bannerId   	id of the banner
	 * @param string $allowedIp		 allowed IP address
	 */
  public static function deregisterAllowedIp(int $bannerId, string $allowedIp) {
		if (filter_var($allowedIp, FILTER_VALIDATE_IP)) {
			BannerDataMapper::deregisterAllowedIp($bannerId, $allowedIp);
		} else {
			throw new InvalidArgumentException('not a valid IP address');
		}
	}

	/**
	 * deletes a banner
	 * @param  int    $bannerId id of the banner
	 * @return bool           	true if a banner was deleted
	 */
  public static function delete(int $bannerId) : bool {
		return BannerDataMapper::delete($bannerId);
	}

	/**
	 * returns true if banner is currently visible
	 * @param  int  $bannerId id of the banner
	 * @return bool     true if banner is visible
	 */
  public static function isVisible(int $bannerId) : bool {

    $startDate  = BannerDataMapper::getStartDate($bannerId);
    $endDate    = BannerDataMapper::getEndDate($bannerId);
    $allowedIps = BannerDataMapper::getAllowedIps($bannerId);

    return BannerVisibilityManager::isVisible($startDate, $endDate, $allowedIps);
  }

	/**
	 * returns true if the string is a valid date
	 * @param  string $dateString date
	 * @param  string $format     date string fomat
	 * @return bool               true if the string is a valid date
	 */
	private static function isValidDate(string $dateString, string $format =  \DateTime::ISO8601) : bool {

	  $dateTime = \DateTime::createFromFormat($format, $dateString);
    return $dateTime && $dateTime->format($format) == $dateString;
	}

	/**
	 * returns true if the string is a valid path
	 * @param  string $path 			path
	 * @return bool               true if the string is a valid path
	 */
	private static function isValidPath(string $path) : bool {

		return realpath($path);
	}

}
