<?php
/**
 * Defines BannerService class
 *
 * PHP version 7
 *
 * @category Pear
 * @package  BannerService
 * @author   Display Name <user@example.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     http://
 */

namespace Hoday\Banners;

 /**
  * Provides a user interface to manage banners
  *
  * @category Categoy
  * @package  Package
  * @author   Display Name <user@example.com>
  * @license  http:// license
  * @link     http://
  */
class BannerService
{

    /**
     * Singleton instance of BannerService
     *
     * @var BannerService
     */
    static private $instance = null;

    /**
     * Contructs BannerService object
     *
     * @return void
     */
    private function __construct()
    {
    }

    /**
     * Returns an instance of BannerService
     *
     * @return BannerService An instance of BannerService
     */
    public function getInstance() : BannerService
    {
        if (self::$instance == null) {
            self::$instance = new BannerService();
        }
        return self::$instance;
    }

    /**
     * Creates a new banner
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
        foreach ($allowedIps as $allowedIp) {
            if (!filter_var($allowedIp, FILTER_VALIDATE_IP)) {
                throw new \InvalidArgumentException('not a valid IP address');
            }
        }

        if (!$this->_isValidDate($startDate)) {
            throw new \InvalidArgumentException('not a valid date');
        }

        if (!$this->_isValidDate($endDate)) {
            throw new \InvalidArgumentException('not a valid date');
        }

        if (!$this->_isValidPath($bannerPath)) {
            throw new \InvalidArgumentException('not a valid path');
        }

        return BannerDataMapper::getInstance()->create(
            $bannerPath, $startDate, $endDate, $allowedIps
        );
    }

    /**
     * Gets banner info by id
     *
     * @param int $bannerId id of banner
     *
     * @return array                         info about banner
     */
    public function get(int $bannerId) : array
    {
        return BannerDataMapper::getInstance()->get($bannerId);
    }

    /**
     * Gets info about all banners
     *
     * @return array array of info about all banners
     */
    public function getAll() : array
    {
        return BannerDataMapper::getInstance()->getAll();
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
        return BannerDataMapper::getInstance()->getPath($bannerId);
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
        return BannerDataMapper::getInstance()->getStartDate($bannerId);
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
        return BannerDataMapper::getInstance()->getEndDate($bannerId);
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
        return BannerDataMapper::getInstance()->getAllowedIps($bannerId);
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
        if (!$this->_isValidPath($bannerPath)) {
            throw new \InvalidArgumentException('not a valid path');
        }
        BannerDataMapper::getInstance()->setPath($bannerId, $bannerPath);
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
        if (!$this->_isValidDate($startDate)) {
            throw new \InvalidArgumentException('not a valid date');
        }
        BannerDataMapper::getInstance()->setStartDate($bannerId, $startDate);
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
        if (!$this->_isValidDate($endDate)) {
            throw new \InvalidArgumentException('not a valid date');
        }
        BannerDataMapper::getInstance()->setEndDate($bannerId, $endDate);
    }

    /**
     * Sets the IP addresses that are allowed to see a banner before the
     * display period
     *
     * @param int   $bannerId   id of the banner
     * @param array $allowedIps array of allowed IP addresses
     *
     * @return void
     */
    public function setAllowedIps(int $bannerId, array $allowedIps)
    {
        forEach ($allowedIps as $allowedIp) {
            if (!filter_var($allowedIp, FILTER_VALIDATE_IP)) {
                throw new InvalidArgumentException('not a valid IP address');
            }
        }
        BannerDataMapper::getInstance()->setAllowedIps($bannerId, $allowedIps);
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

        if (filter_var($allowedIp, FILTER_VALIDATE_IP)) {
            BannerDataMapper::getInstance()->registerAllowedIp(
                $bannerId, $allowedIp
            );
        } else {
            throw new InvalidArgumentException('not a valid IP address');
        }
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
        forEach ($allowedIps as $allowedIp) {
            if (!filter_var($allowedIp, FILTER_VALIDATE_IP)) {
                throw new InvalidArgumentException('not a valid IP address');
            }
        }
        BannerDataMapper::getInstance()->registerAllowedIps(
            $bannerId, $allowedIp
        );
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
        if (filter_var($allowedIp, FILTER_VALIDATE_IP)) {
            BannerDataMapper::getInstance()->deregisterAllowedIp(
                $bannerId, $allowedIp
            );
        } else {
            throw new InvalidArgumentException('not a valid IP address');
        }
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
        return BannerDataMapper::getInstance()->delete($bannerId);
    }

    /**
     * Returns true if banner is currently visible
     *
     * @param int $bannerId id of the banner
     *
     * @return bool     true if banner is visible
     */
    public function isVisible(int $bannerId) : bool
    {

        $startDate  = BannerDataMapper::getInstance()->getStartDate($bannerId);
        $endDate    = BannerDataMapper::getInstance()->getEndDate($bannerId);
        $allowedIps = BannerDataMapper::getInstance()->getAllowedIps($bannerId);

        $bannerVisibilityManager = new BannerVisibilityManager();
        return $bannerVisibilityManager->isVisible(
            $startDate,
            $endDate,
            $allowedIps
        );
    }

    /**
     * Returns true if the string is a valid date
     *
     * @param string $dateString date
     * @param string $format     date string fomat
     *
     * @return bool               true if the string is a valid date
     */
    private function _isValidDate(string $dateString) : bool
    {
        $dateTime = \DateTime::createFromFormat(\DateTime::ISO8601, $dateString);
        return $dateTime && $dateTime->format(\DateTime::ISO8601) == $dateString;
    }

    /**
     * Returns true if the string is a valid path
     *
     * @param string $path path
     *
     * @return bool               true if the string is a valid path
     */
    private function _isValidPath(string $path) : bool
    {

        return realpath($path);
    }

}
