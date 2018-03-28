<?php
/**
 * Defines BannerVisibilityManager class
 *
 * PHP version 7
 *
 * @category Pear
 * @package  BannerVisibilityManager
 * @author   Display Name <user@example.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     http://
 */

namespace Hoday\Banners;

use DateTime;

/**
 * Manages whether a banner should be visible
 *
 * @category Categoy
 * @package  Package
 * @author   Display Name <user@example.com>
 * @license  http:// license
 * @link     http://
 */
class BannerVisibilityManager
{

    /**
     * Creates instance
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Returns true if the banner is visible
     *
     * @param string $startDate  start date of the display period
     * @param string $endDate    end date of the display period
     * @param array  $allowedIps array of IP addresses that are allowed to see
     *                           the banner
     *
     * @return bool true if banner is visible
     */
    public function isVisible(
        string $startDate,
        string $endDate,
        array $allowedIps
    ) : bool {

        $date           = $this->getCurrentDate();
        $ip             = $this->getCurrentIp();

        $startDate      = (new DateTime($startDate))->getTimestamp();
        $endDate        = (new DateTime($endDate))->getTimestamp();
        $date           = $date->getTimestamp();

        $isDuringPeriod = ($date >= $startDate) && ($date <= $endDate);
        $isBeforePeriod = ($date < $startDate);
        $isIpAllowed    = in_array($ip, $allowedIps);

        return ($isDuringPeriod || ($isBeforePeriod && $isIpAllowed));
    }

    /**
     * Gets the current date
     *
     * @return DateTime Current date
     */
    protected function getCurrentDate() : DateTime
    {
        return new DateTime();
    }

    /**
     * Gets current IP
     *
     * @return string Current IP
     */
    protected function getCurrentIp() : string
    {
        return $_SERVER['REMOTE_ADDR'];
    }

}
