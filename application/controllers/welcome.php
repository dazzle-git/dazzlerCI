<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		//$this->loadView('profile');
		//$this->loadView('home');
		//$this->loadView('home_loggedin');
		//$this->loadView('video');
		//$this->loadView('aboutus');
		//$this->loadView('feeds');
		
		//$this->loadView('notifications');
		//$this->loadView('faqs');
	 	$this->loadView('support');
		
//		$this->data["alertMessage"] = array (
//			"message" => "Hello Abdul", 
//			"type" => "error"
//		);
		//$this->loadView('account');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */