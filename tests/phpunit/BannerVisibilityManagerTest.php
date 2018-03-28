<?php
/**
 * Defines BannerVisibilityManagerTest class
 *
 * PHP version 7
 *
 * @category Pear
 * @package  BannerVisibilityManagerTest
 * @author   Display Name <user@example.com>
 * @license  http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link     http://
 */

use PHPUnit\Framework\TestCase;

//require 'mockBannerVisibilityManager.php';

//use TestClasses\MockBannerVisibilityManager;

/**
 * PHPUnit test class for BannerVisibilityManager
 *
 * @category Categoy
 * @package  Package
 * @author   Display Name <user@example.com>
 * @license  http:// license
 * @link     http://
 */
class BannerVisibilityManagerTest extends TestCase
{
    /**
     * Tests BannerVisibilityManager::isVisible
     *
     * @test
     * @return [type] [description]
     */
    public function testPassesTrue()
    {

        $dateStringStart     = '2014-08-10T12:00:00+0900';
        $dateStringEnd         = '2014-08-12T12:00:00+0900';
        $allowedIps = array('10.0.0.1', '10.0.0.2');


        $dateStringBefore = '2014-08-09T12:00:00+0900';
        $dateStringDuring = '2014-08-11T12:00:00+0900';
        $dateStringAfter  = '2014-08-13T12:00:00+0900';

        $ipAllowed         = '10.0.0.1';
        $ipDisallowed      = '10.0.0.3';

        $mockBannerVisibilityManager = new TestClasses\MockBannerVisibilityManager();

        $mockBannerVisibilityManager->setCurrentDate($dateStringDuring);
        $mockBannerVisibilityManager->setCurrentIp($ipAllowed);
        $this->assertTrue(
            $mockBannerVisibilityManager->isVisible(
                $dateStringStart,
                $dateStringEnd,
                $allowedIps
            ),
            'banner is visible during period for all ips'
        );
        $mockBannerVisibilityManager->setCurrentDate($dateStringDuring);
        $mockBannerVisibilityManager->setCurrentIp($ipDisallowed);
        $this->assertTrue(
            $mockBannerVisibilityManager->isVisible(
                $dateStringStart,
                $dateStringEnd,
                $allowedIps
            ),
            'banner is visible during period for all ips, even disallowed ips'
        );

        $mockBannerVisibilityManager->setCurrentDate($dateStringAfter);
        $mockBannerVisibilityManager->setCurrentIp($ipAllowed);
        $this->assertFalse(
            $mockBannerVisibilityManager->isVisible(
                $dateStringStart,
                $dateStringEnd,
                $allowedIps
            ),
            'banner is not visible after period for all ips'
        );

        $mockBannerVisibilityManager->setCurrentDate($dateStringAfter);
        $mockBannerVisibilityManager->setCurrentIp($ipDisallowed);
        $this->assertFalse(
            $mockBannerVisibilityManager->isVisible(
                $dateStringStart,
                $dateStringEnd,
                $allowedIps
            ),
            'banner is not visible after period for all ips, even disallowed ips'
        );


        $mockBannerVisibilityManager->setCurrentDate($dateStringBefore);
        $mockBannerVisibilityManager->setCurrentIp($ipAllowed);
        $this->assertTrue(
            $mockBannerVisibilityManager->isVisible(
                $dateStringStart,
                $dateStringEnd,
                $allowedIps
            ),
            'banner is visible before period for allowed ips'
        );

        $mockBannerVisibilityManager->setCurrentDate($dateStringBefore);
        $mockBannerVisibilityManager->setCurrentIp($ipDisallowed);
        $this->assertFalse(
            $mockBannerVisibilityManager->isVisible(
                $dateStringStart,
                $dateStringEnd,
                $allowedIps
            ),
            'banner is not visible before period for disallowed ips'
        );

    }


}
