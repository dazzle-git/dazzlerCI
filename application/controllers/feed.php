<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feed extends MY_Controller {

	public function index()
	{
		$this->load->model("usermedia_m");
		$this->load->model("user_m");
                $this->load->model("userfollower_m");
                $rec = $this->userfolloer_m->getUserFollower($this->objSess->userId);
                $follow = array();
                foreach ($rec as $key=>$val){
                    $follow[] = $val->followerId;
                }
                $follow[] = $this->objSess->userId;
		$feeds  = $this->usermedia_m->getFeeds($follow);
		$feeds  = $this->user_m->addProfileImage($feeds);
		$this->data["feeds"] = $feeds;
		$this->loadView('feeds');
		
	}

}

