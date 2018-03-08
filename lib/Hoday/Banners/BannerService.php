<?php

namespace Hoday\Banners;

/**
 * Provides a user interface to manage banners
 * @package BannerManager
 */
class BannerService {

	private function __construct() {
	}

	/**
	 * Registers a banner using a unique name (used to identify the banner) and path of the graphic
	 * @param  String $bannerName Name of the banner
	 * @param  String $bannerPath Path to the banner graphic
	 */
	public static function create($bannerPath, $startDate, $endDate, $allowedIps) {
		BannerDataMapper::create($bannerPath, $startDate, $endDate, $allowedIps);
	}

  public static function get($id) {
    return BannerDataMapper::get($id);
  }

  public static function getAll() {
    return BannerDataMapper::getAll();
  }


  public static function getPath($id) {
    return BannerDataMapper::getPath($id);
  }

  public static function getStartDate($id) {
    return BannerDataMapper::getStartDate($id);
  }

  public static function getEndDate($id) {
    return BannerDataMapper::getEndDate($id);
  }

  public static function getAllowedIps($id) {
    return BannerDataMapper::getAllowedIps($id);
  }

  public static function setPath($id, $bannerPath) {
    BannerDataMapper::setPath($id, $bannerPath);
  }

  public static function setStartDate($id, $startDate) {
    BannerDataMapper::setStartDate($id, $startDate);
  }

  public static function setEndDate($id, $endDate) {
    BannerDataMapper::setEndDate($id, $endDate);
  }

  public static function setAllowedIps($id, $allowedIps) {
    BannerDataMapper::setAllowedIps($id, $allowedIps);
  }

  public static function registerAllowedIp($id, $allowedIp) {
    BannerDataMapper::registerAllowedIp($id, $allowedIp);
  }

  public static function deregisterAllowedIp($id, $allowedIp) {
    BannerDataMapper::deregisterAllowedIp($id, $allowedIp);
  }

  public static function delete($id) {
		BannerDataMapper::delete($id);
	}

  public static function isVisible($id) {

    $startDate  = BannerDataMapper::getStartDate($id);
    $endDate    = BannerDataMapper::getEndDate($id);
    $allowedIps = BannerDataMapper::getAllowedIps($id);

    return BannerVisibilityManager::isVisible($startDate, $endDate, $allowedIps);
  }

}
