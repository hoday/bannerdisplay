<?php
/**
 * Defines BannerDataMapper class
 *
 * PHP version 7
 *
 * @category Pear
 * @package  BannerDataMapper
 * @author   Display Name <user@example.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     http://
 */

namespace Hoday\Banners;

use \PDO;
/**
 * Maps banner data to the database
 *
 * @category Categoy
 * @package  Package
 * @author   Display Name <user@example.com>
 * @license  http:// license
 * @link     http://
 */
class BannerDataMapper
{
    /**
     * PDO database instance
     *
     * @var PDO
     */
    protected $pdo = null;

    /**
     * Singleton instance
     *
     * @var BannerDataMapper
     */
    static private $instance = null;

    /**
     * Creates intance
     *
     * @return void
     */
    private function __construct()
    {
        $this->pdo = \App\SQLiteConnection::getInstance();
    }

    /**
     * Gets instance
     *
     * @return BannerDataMapper Instance
     */
    public function getInstance() : BannerDataMapper
    {
        if (self::$instance == null) {
            self::$instance = new BannerDataMapper();
        }
        return self::$instance;
    }

    /**
     * Creates a new entry in the database for a banner
     *
     * @param string $bannerPath path to banner graphic
     * @param string $startDate  start date of period to display banner
     * @param string $endDate    end date of period to display banner
     * @param array  $allowedIps array of allowed IP addresses
     *
     * @return int                    id of banner that was created
     */
    public function create(
        string $bannerPath,
        string $startDate,
        string $endDate,
        array $allowedIps
    ) : int {
        $sql = 'INSERT INTO banners(banner_path, start_date, end_date)
                VALUES(:banner_path, :start_date, :end_date)';
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':banner_path', $bannerPath);
        $stmt->bindValue(':start_date', $startDate);
        $stmt->bindValue(':end_date', $endDate);

        $stmt->execute();

        $id = $this->pdo->lastInsertId();
        $id = intval($id);

        self::registerAllowedIps($id, $allowedIps);


        return $id;
    }

    /**
     * Gets banner info by id
     *
     * @param int $bannerId id of banner
     *
     * @return array info about banner
     */
    public function get(int $bannerId) : array
    {
        $sql = 'SELECT banners.banner_id, banner_path, start_date, end_date, ip
    FROM
    banners
    JOIN banner_allowed_ips
    ON banners.banner_id = banner_allowed_ips.banner_id
    JOIN allowed_ips
    ON allowed_ips.ip_id = banner_allowed_ips.ip_id
    WHERE banners.banner_id = :banner_id';
        $stmt = $this->pdo->prepare($sql);
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

    /**
     * Gets info about all banners
     *
     * @return array array of info about all banners
     */
    public function getAll() : array
    {
        $sql = 'SELECT banners.banner_id, banner_path, start_date, end_date, ip
    FROM
    banners
    JOIN banner_allowed_ips
    ON banners.banner_id = banner_allowed_ips.banner_id
    JOIN allowed_ips
    ON allowed_ips.ip_id = banner_allowed_ips.ip_id';
        $stmt = $this->pdo->prepare($sql);
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

    /**
     * Gets the path to the graphic of a banner
     *
     * @param int $bannerId id of the banner
     *
     * @return string                   path
     */
    public function getPath(int $bannerId) : string
    {
        $sql = 'SELECT banner_path from banners WHERE banner_id = :banner_id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':banner_id', $bannerId);
        $stmt->execute();

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row['banner_path'];

    }

    /**
     * Gets the start date of the banner display period
     *
     * @param int $bannerId id of the banner
     *
     * @return string               start date
     */
    public function getStartDate(int $bannerId) : string
    {
        $sql = 'SELECT start_date from banners WHERE banner_id = :banner_id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':banner_id', $bannerId);
        $stmt->execute();

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row['start_date'];
    }

    /**
     * Gets the end date of the banner display period
     *
     * @param int $bannerId id of the banner
     *
     * @return string               end date
     */
    public function getEndDate(int $bannerId) : string
    {
        $sql = 'SELECT end_date from banners WHERE banner_id = :banner_id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':banner_id', $bannerId);
        $stmt->execute();

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row['end_date'];
    }

    /**
     * Gets the IP addresses that are allowed to see a banner even before the
     * display period
     *
     * @param int $bannerId id of the banner
     *
     * @return array             array of IP addresses
     */
    public function getAllowedIps(int $bannerId) : array
    {
        $sql = 'SELECT ip
    FROM
    allowed_ips JOIN banner_allowed_ips
    ON allowed_ips.ip_id = banner_allowed_ips.ip_id
    WHERE banner_allowed_ips.banner_id = :banner_id';

        $stmt = $this->pdo->prepare($sql);
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

    /**
     * Sets the path for the graphic for a banner
     *
     * @param int    $bannerId   id of the banner
     * @param string $bannerPath path to the graphic for the banner
     *
     * @return void
     */
    public function setPath(int $bannerId, string $bannerPath)
    {
        $sql = "UPDATE banners "
              . "SET banner_path = :banner_path "
              . "WHERE banner_id = :banner_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':banner_path', $bannerPath);
        $stmt->bindValue(':banner_id', $bannerId);
        return $stmt->execute();
    }

    /**
     * Sets the start date for the display period for a banner
     *
     * @param int    $bannerId  id of the banner
     * @param string $startDate start date
     *
     * @return void
     */
    public function setStartDate(int $bannerId, string $startDate)
    {
        $sql = "UPDATE banners "
              . "SET start_date = :start_date "
              . "WHERE banner_id = :banner_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':start_date', $startDate);
        $stmt->bindValue(':banner_id', $bannerId);
        return $stmt->execute();
    }

    /**
     * Sets the end date for the display period for a banner
     *
     * @param int    $bannerId id of the banner
     * @param string $endDate  enddate
     *
     * @return void
     */
    public function setEndDate(int $bannerId, string $endDate)
    {
        $sql = "UPDATE banners "
              . "SET end_date = :end_date "
              . "WHERE banner_id = :banner_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':end_date', $endDate);
        $stmt->bindValue(':banner_id', $bannerId);
        return $stmt->execute();
    }

    /**
     * Sets the IP addresses that are allowed to see a banner before the display
     * period
     *
     * @param int   $bannerId   id of the banner
     * @param array $allowedIps array of allowed IP addresses
     *
     * @return void
     */
    public function setAllowedIps(int $bannerId, array $allowedIps)
    {



    }

    /**
     * Registers an IP address that is allowed to see a banner before the
     * display period
     *
     * @param int    $bannerId  id of the banner
     * @param string $allowedIp allowed IP address
     *
     * @return void
     */
    public function registerAllowedIp(int $bannerId, string $allowedIp)
    {

        $sql1 = 'INSERT INTO allowed_ips(ip)
    VALUES(:ip)';
        $sql2 = 'SELECT ip_id FROM allowed_ips
            WHERE allowed_ips.ip = :ip';
        $sql3 = 'INSERT INTO banner_allowed_ips(banner_id, ip_id)
    VALUES(:banner_id, :ip_id)';

        $stmt1 = $this->pdo->prepare($sql1);
        $stmt2 = $this->pdo->prepare($sql2);
        $stmt3 = $this->pdo->prepare($sql3);

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

    /**
     * Registers IP addresses that are allowed to see a banner before the
     * display period
     *
     * @param int   $bannerId   id of the banner
     * @param array $allowedIps allowed IP addresses
     *
     * @return void
     */
    public function registerAllowedIps(int $bannerId, array $allowedIps)
    {

        $sql1 = 'INSERT INTO allowed_ips(ip)
    VALUES(:ip)';
        $sql2 = 'SELECT ip_id FROM allowed_ips
    WHERE allowed_ips.ip = :ip';
        $sql3 = 'INSERT INTO banner_allowed_ips(banner_id, ip_id)
    VALUES(:banner_id, :ip_id)';

        $stmt1 = $this->pdo->prepare($sql1);
        $stmt2 = $this->pdo->prepare($sql2);
        $stmt3 = $this->pdo->prepare($sql3);

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


    /**
     * Deregisters an IP address that was allowed to see a banner before the
     * display period
     *
     * @param int    $bannerId  id of the banner
     * @param string $allowedIp allowed IP address
     *
     * @return void
     */
    public function deregisterAllowedIp(int $bannerId, string $allowedIp)
    {
    }

    /**
     * Deletes a banner
     *
     * @param int $bannerId id of the banner
     *
     * @return bool               true if a banner was deleted
     */
    public function delete(int $bannerId) : bool
    {
        $sql = 'DELETE FROM banners '
            . 'WHERE banner_id = :banner_id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':banner_id', $bannerId);
        $stmt->execute();
        return ($stmt->rowCount() > 0);
    }

}
