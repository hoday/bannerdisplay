<?php

require_once('../src/classes/BannerDisplayController.php');

/*
 * TestBannerDisplayController is for testing the class BannerDisplayController
 */	
class TestBannerDisplayController extends BannerDisplayController {
	
	private $current_date;
	private $current_IP;
	
	/*
	 * New method created for testing - set "current date" for testing purposes
	 */	
	public function set_current_date($current_date) {
		$this->current_date = $current_date;
	}
	
	/*
	 * New method created for testing - set "current IP" for testing purposes
	 */	
	 public function set_current_IP($current_IP) {
		$this->current_IP = $current_IP;
	}		
	
	// override
	protected function get_current_date() {
		return $this->current_date;
	}
	
	// override
	protected function get_current_IP() {
		return $this->current_IP;
	}
}




