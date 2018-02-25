<?php

ini_set('error_log', 'debug.log');

include "lib/testlib.php";
include "classes/TestBannerManager.php";

//
// Setup for tests
//

$banner_period_start 	= '2014-08-10T12:00:00+0900';
$banner_period_end 		= '2014-08-12T12:00:00+0900';

$test_banner_manager = new TestBannerManager();
$test_banner_manager->register_banner('test_banner', 'test_banner_img.jpg');
$test_banner_manager->register_allowed_IP('test_banner', '10.0.0.1');
$test_banner_manager->register_allowed_IP('test_banner', '10.0.0.2');
$test_banner_manager->set_banner_period('test_banner', $banner_period_start, $banner_period_end);

$date_string_before = '2014-08-09T12:00:00+0900';
$date_string_during = '2014-08-11T12:00:00+0900';
$date_string_after  = '2014-08-13T12:00:00+0900';

$ip_allowed         = '10.0.0.1';
$ip_disallowed      = '10.0.0.3';

//
// Run tests
//

assertTrue($test_banner_manager->is_banner_shown('test_banner', $date_string_during, $ip_allowed), "banner should be displayed during the display period");
assertTrue($test_banner_manager->is_banner_shown('test_banner', $date_string_during, $ip_disallowed), "banner should be displayed during the display period for IPs that are not in the allowed IP list");

assertFalse($test_banner_manager->is_banner_shown('test_banner', $date_string_after, $ip_allowed), "banner should not display after the display period even for allowed IPs");
assertFalse($test_banner_manager->is_banner_shown('test_banner', $date_string_after, $ip_disallowed), "banner should not display after the display period");

assertTrue($test_banner_manager->is_banner_shown('test_banner', $date_string_before, $ip_allowed), "banner should be displayed before the display period for IPs that are in the allowed IPs");
assertFalse($test_banner_manager->is_banner_shown('test_banner', $date_string_before, $ip_disallowed), "banner should not be displayed before the display period for IPs that are not in the allowed IP list");



