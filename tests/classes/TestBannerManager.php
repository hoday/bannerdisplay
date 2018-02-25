<?php

require_once('../src/classes/Banner.php');
require_once('../src/classes/BannerManager.php');
require_once('TestBannerDisplayController.php');

/*
 * TestBannerManager is for testing the class BannerManager
 */	
class TestBannerManager extends BannerManager {
	
	
	/*
	 * New method created for testing - allows user to test whether the banner will be shown at the specified date and ip
	 */
	public function is_banner_shown($banner_name, $date_string, $ip) {
		
		$date = (new DateTime($date_string))->getTimestamp();
		
		$this->banners[$banner_name]['banner_display_controller']->set_current_date($date);
		$this->banners[$banner_name]['banner_display_controller']->set_current_IP($ip);
		
		return $this->banners[$banner_name]['banner_display_controller']->is_showing();

	}
	
	// override
	public function register_banner($banner_name, $banner_path) {		
		$this->banners[$banner_name]['banner'] 											= new Banner($banner_path);
		$this->banners[$banner_name]['banner_display_controller'] 	= new TestBannerDisplayController();		
	}
	
	
}