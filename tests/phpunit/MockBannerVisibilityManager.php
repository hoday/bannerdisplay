<?php


class MockBannerVisibilityManager extends \Hoday\Banners\BannerVisibilityManager {

  static $currentDate;
  static $currentIp;

  public static function setCurrentDate(string $currentDate) {
    self::$currentDate = new DateTime($currentDate);
  }

  public static function setCurrentIp(string $currentIp) {
    self::$currentIp = $currentIp;
  }

  	/**
  	 * getCurrentDate Gets current date
  	 * @return int Timestamp
  	 */
  	protected static function getCurrentDate() : \DateTime {
  		return self::$currentDate;
  	}

  	/**
  	 * getCurrentIp Returns current IP
  	 * @return String Current IP
  	 */
  	protected static function getCurrentIp() : string {
  		return self::$currentIp;
  	}



}
