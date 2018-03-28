<?php
/**
 * Defines MockBannerVisibilityManager class
 *
 * PHP version 7
 *
 * @category Pear
 * @package  BannerVisibilityManagerTest
 * @author   Display Name <user@example.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     http://
 */

namespace TestClasses;

use \DateTime;

 /**
  * Mock class of Banner Visibility Manager for testing Banner Visibility Manager
  *
  * @category Categoy
  * @package  Package
  * @author   Display Name <user@example.com>
  * @license  http:// license
  * @link     http://
  */
class MockBannerVisibilityManager extends \Hoday\Banners\BannerVisibilityManager
{

    /**
     * Current date
     *
     * @var DateTime
     */
    private $currentDate = null;

    /**
     * Current IP
     *
     * @var string
     */
    private $currentIp = null;

    /**
     * Sets the current date to the date of your choice
     *
     * @param string $currentDate Current date
     *
     * @return void
     */
    public function setCurrentDate(string $currentDate)
    {
        $this->currentDate = new DateTime($currentDate);
    }

    /**
     * Sets the current IP address to the IP address of your choice
     *
     * @param string $currentIp Current IP
     *
     * @return void
     */
    public function setCurrentIp(string $currentIp)
    {
        $this->currentIp = $currentIp;
    }

    /**
     * Gets the current date
     *
     * @override
     * @return   DateTime Current Date
     */
    protected function getCurrentDate() : DateTime
    {
        return $this->currentDate;
    }

    /**
     * Gets the current IP
     *
     * @override
     *
     * @return string Current IP
     */
    protected function getCurrentIp() : string
    {
        return $this->currentIp;
    }



}
