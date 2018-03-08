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
		$stmt->bindValue(':start_date', $startDate);
		$stmt->bindValue(':end_date', $endDate);

    $stmt->execute();

		$id = \App\SQLiteConnection::getInstance()->lastInsertId();
		self::registerAllowedIps($id, $allowedIps);

		return $id;
	}

	public static function get($id) {
		$sql = 'SELECT banners.banner_id, banner_path, start_date, end_date, ip
						FROM
						banners
						JOIN banner_allowed_ips
						ON banners.banner_id = banner_allowed_ips.banner_id
						JOIN allowed_ips
						ON allowed_ips.ip_id = banner_allowed_ips.ip_id
						WHERE banners.banner_id = :banner_id';
		$stmt = \App\SQLiteConnection::getInstance()->prepare($sql);
		$stmt->bindValue(':banner_id', $bannerId);
		$stmt->execute();


				$banners = [];
				$banner_id_prev = 0;
				while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
					$banner_id = $row['banner_id'];
					if ($banner_id != $banner_id_prev) {
						$banners[] = array(
							'banner_id' => $row['banner_id'],
							'banner_path' => $row['banner_path'],
							'start_date' => new \DateTime($row['start_date']),
							'end_date' => new \DateTime($row['end_date']),
							'allowed_ips' => array()
						);
					}
					$banner_id_prev = $banner_id;
					array_push($banners[count($banners) - 1]['allowed_ips'], $row['ip']);
				}
				return $banners;

	}

	public static function getAll() {
		$sql = 'SELECT banners.banner_id, banner_path, start_date, end_date, ip
						FROM
						banners
						JOIN banner_allowed_ips
						ON banners.banner_id = banner_allowed_ips.banner_id
						JOIN allowed_ips
						ON allowed_ips.ip_id = banner_allowed_ips.ip_id';
		$stmt = \App\SQLiteConnection::getInstance()->prepare($sql);
		$stmt->execute();

		$banners = [];
		$banner_id_prev = 0;
		while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
			$banner_id = $row['banner_id'];
			if ($banner_id != $banner_id_prev) {
				$banners[] = array(
					'banner_id' => $row['banner_id'],
					'banner_path' => $row['banner_path'],
					'start_date' => new \DateTime($row['start_date']),
					'end_date' => new \DateTime($row['end_date']),
					'allowed_ips' => array()
				);
			}
			$banner_id_prev = $banner_id;
			array_push($banners[count($banners) - 1]['allowed_ips'], $row['ip']);
		}
		return $banners;
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

				$sql1 = 'INSERT INTO allowed_ips(ip)
								VALUES(:ip)';
				$sql2 = 'SELECT ip_id FROM allowed_ips
				        WHERE allowed_ips.ip = :ip';
				$sql3 = 'INSERT INTO banner_allowed_ips(banner_id, ip_id)
								VALUES(:banner_id, :ip_id)';

				$stmt1 = \App\SQLiteConnection::getInstance()->prepare($sql1);
				$stmt2 = \App\SQLiteConnection::getInstance()->prepare($sql2);
				$stmt3 = \App\SQLiteConnection::getInstance()->prepare($sql3);

				$stmt1->bindValue(':ip', $allowedIp);
				$stmt1->execute();

				$stmt2->bindValue(':ip', $allowedIp);
				$stmt2->execute();
				$row = $stmt2->fetch(\PDO::FETCH_ASSOC);

				$ipId = $row['ip_id'];

				$stmt3->bindValue(':banner_id', $bannerId);
				$stmt3->bindValue(':ip_id', $ipId);
				$stmt3->execute();

				return ;

  }

	public static function registerAllowedIps($bannerId, $allowedIps) {

		$sql1 = 'INSERT INTO allowed_ips(ip)
						VALUES(:ip)';
		$sql2 = 'SELECT ip_id FROM allowed_ips
						WHERE allowed_ips.ip = :ip';
		$sql3 = 'INSERT INTO banner_allowed_ips(banner_id, ip_id)
						VALUES(:banner_id, :ip_id)';

		$stmt1 = \App\SQLiteConnection::getInstance()->prepare($sql1);
		$stmt2 = \App\SQLiteConnection::getInstance()->prepare($sql2);
		$stmt3 = \App\SQLiteConnection::getInstance()->prepare($sql3);

		forEach ($allowedIps as  $allowedIp) {
			$stmt1->bindValue(':ip', $allowedIp);
			$stmt1->execute();

			$stmt2->bindValue(':ip', $allowedIp);
			$stmt2->execute();
			$row = $stmt2->fetch(\PDO::FETCH_ASSOC);

			$ipId = $row['ip_id'];

			$stmt3->bindValue(':banner_id', $bannerId);
			$stmt3->bindValue(':ip_id', $ipId);
			$stmt3->execute();
		}
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
