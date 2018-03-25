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
		return BannerDataMapper::create($bannerPath, $startDate, $endDate, $allowedIps);
	}

	/**
	 * Get banner info by id
	 * @param  int $bannerId 			id of banner
	 * @return array     					info about banner
	 */
  public static function get(int $id) : array {
    return BannerDataMapper::get($id);
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
  public static function getPath(int $id) : string {
    return BannerDataMapper::getPath($id);
  }

	/**
	 * gets the start date of the banner display period
	 * @param  int $bannerId 			id of the banner
	 * @return string           	start date
	 */
  public static function getStartDate(int $id) : string {
    return BannerDataMapper::getStartDate($id);
  }

	/**
	 * gets the end date of the banner display period
	 * @param  int $bannerId 			id of the banner
	 * @return string           	end date
	 */
  public static function getEndDate(int $id) : string {
    return BannerDataMapper::getEndDate($id);
  }

	/**
	 * gets the IP addresses that are allowed to see a banner even before the display period
	 * @param  int $bannerId 	id of the banner
	 * @return array         	array of IP addresses
	 */
  public static function getAllowedIps(int $id) : array {
    return BannerDataMapper::getAllowedIps($id);
  }

	/**
	 * sets the path for the graphic for a banner
	 * @param int $bannerId   		id of the banner
	 * @param string $bannerPath 	path to the graphic for the banner
	 */
  public static function setPath(int $id, string $bannerPath) {
    BannerDataMapper::setPath($id, $bannerPath);
  }

	/**
	 * sets the start date for the display period for a banner
	 * @param int $bannerId  		id of the banner
	 * @param string $startDate start date
	 */
  public static function setStartDate(int $id, string $startDate) {
    BannerDataMapper::setStartDate($id, $startDate);
  }

	/**
	 * sets the end date for the display period for a banner
	 * @param int $bannerId  	id of the banner
	 * @param string $endDate enddate
	 */
  public static function setEndDate(int $id, string $endDate) {
    BannerDataMapper::setEndDate($id, $endDate);
  }

	/**
	 * sets the IP addresses that are allowed to see a banner before the display period
	 * @param int   $bannerId   id of the banner
	 * @param array $allowedIps array of allowed IP addresses
	 */
  public static function setAllowedIps(int $id, array $allowedIps) {
    BannerDataMapper::setAllowedIps($id, $allowedIps);
  }

	/**
	 * registers an IP address that is allowed to see a banner before the display period
	 * @param int   $bannerId   id of the banner
	 * @param string $allowedIp allowed IP address
	 */
  public static function registerAllowedIp(int $id, string $allowedIp) {
    BannerDataMapper::registerAllowedIp($id, $allowedIp);
  }

	/**
	 * registers IP addresses that are allowed to see a banner before the display period
	 * @param int   $bannerId   id of the banner
	 * @param array $allowedIps allowed IP addresses
	 */
	public static function registerAllowedIps(int $id, array $allowedIps) {
		BannerDataMapper::registerAllowedIps($id, $allowedIp);
  }

	/**
	 * deregisters an IP address that was allowed to see a banner before the display period
	 * @param int   $bannerId   	id of the banner
	 * @param string $allowedIp		 allowed IP address
	 */
  public static function deregisterAllowedIp(int $id, string $allowedIp) {
    BannerDataMapper::deregisterAllowedIp($id, $allowedIp);
  }

	/**
	 * deletes a banner
	 * @param  int    $bannerId id of the banner
	 * @return bool           	true if a banner was deleted
	 */
  public static function delete(int $id) : bool {
		return BannerDataMapper::delete($id);
	}

	/**
	 * returns true if banner is currently visible
	 * @param  int  $id id of the banner
	 * @return bool     true if banner is visible
	 */
  public static function isVisible(int $id) : bool {

    $startDate  = BannerDataMapper::getStartDate($id);
    $endDate    = BannerDataMapper::getEndDate($id);
    $allowedIps = BannerDataMapper::getAllowedIps($id);

    return BannerVisibilityManager::isVisible($startDate, $endDate, $allowedIps);
  }

}
