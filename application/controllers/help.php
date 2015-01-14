<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class help extends My_Controller {
	
	public function index()
	{
		$this->loadView('faq');
	}
		
	public function faq()
	{
		$this->loadView('faqs');
	}
	
}
