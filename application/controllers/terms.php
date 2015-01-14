<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class terms extends My_Controller {
	
	public function index()
	{
		$this->loadView('terms_conditions');
	}
	
}
