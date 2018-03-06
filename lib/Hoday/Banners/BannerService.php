<?php

namespace Hoday\Banners;

/**
 * Provides a user interface to manage banners
 * @package BannerManager
 */
class BannerService {

  protected $bannerDataMapper;
  protected $bannerVisibilityManager;

	private function __construct() {
	}

	/**
	 * Registers a banner using a unique name (used to identify the banner) and path of the graphic
	 * @param  String $bannerName Name of the banner
	 * @param  String $bannerPath Path to the banner graphic
	 */
	public static function create($bannerPath, $startDate, $endDate, $allowedIps) {
		$this->bannerDataMapper->registerBanner($bannerName, $bannerPath);
	}

  public static function getPath($id) {
    return $this->bannerDataMapper->getPath($id);
  }

  public static function getStartDate($id) {
    return $this->bannerDataMapper->getStartDate($id);
  }

  public static function getEndDate($id) {
    return $this->bannerDataMapper->getEndDate($id);
  }

  public static function getAllowedIps($id) {
    return $this->bannerDataMapper->getAllowedIps($id);
  }

  public static function setPath($id, $bannerPath) {
    $this->bannerDataMapper->setPath($id, $bannerPath);
  }

  public static function setStartDate($id, $startDate) {
    $this->bannerDataMapper->setStartDate($id, $startDate);
  }

  public static function setEndDate($id, $endDate) {
    $this->bannerDataMapper->setEndDate($id, $endDate);
  }

  public static function setAllowedIps($id, $allowedIps) {
    $this->bannerDataMapper->setAllowedIps($id, $allowedIps);
  }

  public static function registerAllowedIp($id, $allowedIp) {
    $this->bannerDataMapper->registerAllowedIp($id, $allowedIp);
  }

  public static function deregisterAllowedIp($id, $allowedIp) {
    $this->bannerDataMapper->deregisterAllowedIp($id, $allowedIp);
  }

  public static function delete($id) {
		$this->bannerDataMapper->delete($id);
	}

  public static function isVisible($id) {
    return $this->bannerVisibilityManager->isVisible($startDate, $endDate, $allowedIps);
  }

}
