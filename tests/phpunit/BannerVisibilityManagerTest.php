<?php
use PHPUnit\Framework\TestCase;

require 'MockBannerVisibilityManager.php';

class BannerVisibilityManagerTest extends TestCase
{
  /**
   * @test
   * @return [type] [description]
   */
  public function testPassesTrue()
  {

    $dateStringStart 	= '2014-08-10T12:00:00+0900';
    $dateStringEnd 		= '2014-08-12T12:00:00+0900';
    $allowedIps = array('10.0.0.1', '10.0.0.2');


    $dateStringBefore = '2014-08-09T12:00:00+0900';
    $dateStringDuring = '2014-08-11T12:00:00+0900';
    $dateStringAfter  = '2014-08-13T12:00:00+0900';

    $ipAllowed         = '10.0.0.1';
    $ipDisallowed      = '10.0.0.3';

    MockBannerVisibilityManager::setCurrentDate($dateStringDuring);
    MockBannerVisibilityManager::setCurrentIp($ipAllowed);
    $this->assertTrue(MockBannerVisibilityManager::isVisible($dateStringStart, $dateStringEnd, $allowedIps), 'banner is visible during period for all ips');
    MockBannerVisibilityManager::setCurrentDate($dateStringDuring);
    MockBannerVisibilityManager::setCurrentIp($ipDisallowed);
    $this->assertTrue(MockBannerVisibilityManager::isVisible($dateStringStart, $dateStringEnd, $allowedIps), 'banner is visible during period for all ips, even disallowed ips');

    MockBannerVisibilityManager::setCurrentDate($dateStringAfter);
    MockBannerVisibilityManager::setCurrentIp($ipAllowed);
    $this->assertFalse(MockBannerVisibilityManager::isVisible($dateStringStart, $dateStringEnd, $allowedIps), 'banner is not visible after period for all ips');
    MockBannerVisibilityManager::setCurrentDate($dateStringAfter);
    MockBannerVisibilityManager::setCurrentIp($ipDisallowed);
    $this->assertFalse(MockBannerVisibilityManager::isVisible($dateStringStart, $dateStringEnd, $allowedIps), 'banner is not visible after period for all ips, even disallowed ips');

    MockBannerVisibilityManager::setCurrentDate($dateStringBefore);
    MockBannerVisibilityManager::setCurrentIp($ipAllowed);
    $this->assertTrue(MockBannerVisibilityManager::isVisible($dateStringStart, $dateStringEnd, $allowedIps), 'banner is visible before period for allowed ips');
    MockBannerVisibilityManager::setCurrentDate($dateStringBefore);
    MockBannerVisibilityManager::setCurrentIp($ipDisallowed);
    $this->assertFalse(MockBannerVisibilityManager::isVisible($dateStringStart, $dateStringEnd, $allowedIps), 'banner is not visible before period for disallowed ips');

  }


}
