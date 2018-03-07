<?php

namespace Hoday\Banners;

/**
 * Provides a user interface to manage banners
 * @package BannerManager
 */
class BannerDataMapper {

	protected $pdo;

	private function __construct($pdo) {
		// = \App\SQLiteConnection::getInstance();
	}

	public static function create($bannerPath, $startDate, $endDate, $allowedIps) {
		$sql = 'INSERT INTO banners(banner_path, start_date, end_date) VALUES(:banner_path, :start_date, :end_date)';
    $stmt = \App\SQLiteConnection::getInstance()->prepare($sql);

		$stmt->bindValue(':banner_path', $bannerPath);
		$stmt->startDate(':start_date', $start_date);
		$stmt->endDate(':end_date', $end_date);

    $stmt->execute();
		return \App\SQLiteConnection::getInstance()->lastInsertId();
	}

	public static function get($id) {
		$sql = 'SELECT banner_path, start_date, end_date, allowed_ip from banners, allowed_ips, banner_allowed_ips WHERE banners.banner_id = :banner_id, banners.banner_id = banner_allowed_ips.banner_id, banner_allowed_ips.ip_id = allowed_ips.ip_id';
		$stmt = \App\SQLiteConnection::getInstance()->prepare($sql);
		$stmt->bindValue(':banner_id', $bannerId);
		$stmt->execute();

		$row = $stmt->fetch(\PDO::FETCH_ASSOC);
		return $row;

	}

	public static function getAll() {

	}

  public static function getPath($bannerId) {
		$sql = 'SELECT banner_path from banners WHERE banner_id = :banner_id';
		$stmt = \App\SQLiteConnection::getInstance()->prepare($sql);
		$stmt->bindValue(':banner_id', $bannerId);
		$stmt->execute();

		$row = $stmt->fetch(\PDO::FETCH_ASSOC);
		return $row['banner_path'];

  }

  public static function getStartDate($bannerId) {
		$sql = 'SELECT start_date from banners WHERE banner_id = :banner_id';
		$stmt = \App\SQLiteConnection::getInstance()->prepare($sql);
		$stmt->bindValue(':banner_id', $bannerId);
		$stmt->execute();

		$row = $stmt->fetch(\PDO::FETCH_ASSOC);
		return $row['start_date'];
	}

  public static function getEndDate($bannerId) {
		$sql = 'SELECT end_date from banners WHERE banner_id = :banner_id';
		$stmt = \App\SQLiteConnection::getInstance()->prepare($sql);
		$stmt->bindValue(':banner_id', $bannerId);
		$stmt->execute();

		$row = $stmt->fetch(\PDO::FETCH_ASSOC);
		return $row['end_date'];
  }

  public static function getAllowedIps($bannerId) {
		$sql = 'SELECT ip
						FROM
						allowed_ips JOIN banner_allowed_ips
						ON allowed_ips.ip_id = banner_allowed_ips.ip_id
						WHERE banner_allowed_ips.banner_id = :banner_id';

		$stmt = \App\SQLiteConnection::getInstance()->prepare($sql);
		$stmt->bindValue(':banner_id', $bannerId);
		$stmt->execute();
		$allowedIps = [];
		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
				$allowedIps[] = [
						$row['ip']
				];
		}
		return $allowedIps;
  }

  public static function setPath($bannerId, $bannerPath) {
		$sql = "UPDATE banners "
	          . "SET banner_path = :banner_path "
	          . "WHERE banner_id = :banner_id";
	  $stmt = \App\SQLiteConnection::getInstance()->prepare($sql);
	  $stmt->bindValue(':banner_path', $bannerPath);
	  $stmt->bindValue(':banner_id', $bannerId);
	  return $stmt->execute();
  }

  public static function setStartDate($bannerId, $startDate) {
		$sql = "UPDATE banners "
	          . "SET start_date = :start_date "
	          . "WHERE banner_id = :banner_id";
	  $stmt = \App\SQLiteConnection::getInstance()->prepare($sql);
	  $stmt->bindValue(':start_date', $startDate);
	  $stmt->bindValue(':banner_id', $bannerId);
	  return $stmt->execute();
  }

  public static function setEndDate($bannerId, $endDate) {
		$sql = "UPDATE banners "
	          . "SET end_date = :end_date "
	          . "WHERE banner_id = :banner_id";
	  $stmt = \App\SQLiteConnection::getInstance()->prepare($sql);
	  $stmt->bindValue(':end_date', $endDate);
	  $stmt->bindValue(':banner_id', $bannerId);
	  return $stmt->execute();
  }

  public static function setAllowedIps($bannerId, $allowedIps) {



  }

  public static function registerAllowedIp($bannerId, $allowedIp) {

				$sql = 'INSERT INTO allowed_ips(allowed_ip)
								VALUES(:allowed_ip);
								INSERT INTO banner_allowed_ips(banner_id, ip_id)
								VALUES(:banner_id, LAST_INSERT_ID())';

				$stmt = \App\SQLiteConnection::getInstance()->prepare($sql);
				$stmt->bindValue(':banner_id', $bannerId);
				$stmt->bindValue(':allowed_ip', $allowedIp);
				return $stmt->execute();

  }

  public static function deregisterAllowedIp($bannerId, $allowedIp) {
    BannerDataMapper::deregisterAllowedIp($bannerId, $allowedIp);
  }

  public static function delete($bannerId) {
		$sql = 'DELETE FROM banners '
            . 'WHERE banner_id = :banner_id';
    $stmt = \App\SQLiteConnection::getInstance()->prepare($sql);
    $stmt->bindValue(':banner_id', $bannerId);
    $stmt->execute();
    return $stmt->rowCount();
	}

}