<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {

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
		
		$this->load->library('form_validation');
		if($this->checkLoggedIn()) {
                    
			$this->load->model("user_m");
			$this->load->model("usermedia_m");
			$topUsers = $this->user_m->getTopFollowedUser(3);
			$topcontents = $this->usermedia_m->getTopContents();
			$this->data["topUsers"] = $topUsers ;
			$topcontents = $this->user_m->addProfileImage($topcontents);
			//print_r($topUsers);
			$this->data["topContents"] = $topcontents;
			$this->loadView('home_loggedin');
			
		} else {
			$this->load->model("user_m");
			$this->load->model("usermedia_m");
			$topcontents = $this->usermedia_m->getTopContents();
			$topcontents = $this->user_m->addProfileImage($topcontents);
			$this->data["topContents"] = $topcontents;
			$this->data['message'] = validation_errors();
			$this->loadView('home');
		}
		
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */