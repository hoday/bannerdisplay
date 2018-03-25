<?php


class MockBannerVisibilityManager extends \Hoday\Banners\BannerVisibilityManager {

  static $currentDate;
  static $currentIp;

  public static function setCurrentDate($currentDate) {
    self::$currentDate = new DateTime($currentDate);
  }

  public static function setCurrentIp($currentIp) {
    self::$currentIp = $currentIp;
  }

  	/**
  	 * getCurrentDate Gets current date
  	 * @return int Timestamp
  	 */
  	protected static function getCurrentDate() {
  		return self::$currentDate;
  	}

  	/**
  	 * getCurrentIp Returns current IP
  	 * @return String Current IP
  	 */
  	protected static function getCurrentIp() {
  		return self::$currentIp;
  	}



}
