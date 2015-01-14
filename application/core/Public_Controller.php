<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
 
class Public_Controller extends MY_Controller
{
	public $data = array();
	public $viewFolder = "desktop/";
	protected $_ModuleName = "default";
	    
    function __construct()
    {
        parent::__construct();
        
        $this->data["ajax_error"] = false;
        $this->data["ajax_redirect"] = null;
        $this->data["jscripts"] = array();
        $this->data["footerscripts"] = array();
        $this->data["styles"] = array();
        $this->data["footerstyles"] = array();
        $this->data["viewFolder"] = $this->viewFolder;
        $this->data["title"] = $this->title;
        
        
        $this->enque_style("http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css");
        $this->enque_style("assets/css/bootstrap.css");
        $this->enque_style("/assets/css/jquery.videocontrols.css");
        $this->enque_style("assets/css/msgboxlight.css");
        $this->enque_style("assets/css/style.css"); 
        
        
        
		$this->enque_script("assets/js/jquery-1.8.2.min.js");
		$this->enque_script("assets/js/bootstrap.min.js");
		$this->enque_script("/assets/js/jquery.msgBox.js");
		$this->enque_script("/assets/js/jquery.videocontrols.js");
		$this->enque_script("/assets/js/tools.js");
		
   }  
       
   function enque_script($scriptname, $text = false, $last = true) {
		$scriptsArray = $this->data["jscripts"];
		
		if($text) { $scriptname = "<script type=\"text/javascript\">$scriptname</script>"; }
		
		if(!startsWith($scriptname,"http://"))  $scriptname = site_url($scriptname); 
		
		if($last) {
			array_push($scriptsArray, $scriptname);
		} else {
			array_unshift($scriptsArray, $scriptname);			
		} 
		
		$this->data["jscripts"] = $scriptsArray;		
	}
	
	
	function enque_script_footer($scriptname, $text= false, $last = true) {
		$scriptsArray = $this->data["footerscripts"];
		if($text) { $scriptname = "<script type=\"text/javascript\">$scriptname</script>"; }
		if(!startsWith($scriptname,"http://"))  $scriptname = site_url($scriptname);
		if($last) {
			array_push($scriptsArray, $scriptname);
		} else {
			array_unshift($scriptsArray, $scriptname);			
		}
		
		$this->data["footerscripts"] = $scriptsArray; 
	}
	
	
	function enque_style($scriptname, $text= false, $last = true) {
		$cssArray = $this->data["styles"];
		if($text) { $scriptname = "<style>$scriptname</style>"; }
		if(!startsWith($scriptname,"http://"))  $scriptname = site_url($scriptname);
		if($last) {
			array_push($cssArray , $scriptname);
		} else {
			array_unshift($cssArray, $scriptname);			
		} 
		
		$this->data["styles"] = $cssArray;		
	}
	
	
	function enque_style_footer($scriptname, $text= false, $last = true) {
		$cssArray = $this->data["footerstyles"];
		if($text) { $scriptname = "<style>$scriptname</style>"; }
		if(!startsWith($scriptname,"http://"))  $scriptname = site_url($scriptname);
		if($last) {
			array_push($cssArray , $scriptname);
		} else {
			array_unshift($cssArray , $scriptname);			
		}
		
		$this->data["footerstyles"] = $cssArray ; 
	}
	
	
	function loadview($viewname) {
		$this->load->view($this->viewFolder . $viewname, $this->data);		
	}
      
	
	
	 public function setSession ($objUser) {
	 	
		$this->objSess = new stdClass();
    	$this->objSess->userId = $objUser->userId;
        $this->objSess->username = $objUser->firstName . ' ' . $objUser->lastName;
        $this->objSess->userType = $objUser->userType;
        $this->objSess->subscriptionId = $objUser->subscriptionId;
        $this->objSess->verify = $objUser->verify;
        $this->objSess->createdDate = $objUser->createdDate;
        $this->objSess->isFrontLogin = true;
        $this->objSess->userBlockId = $this->user_m->getBlockUserId($objUser->userId);

        $img = $this->user_m->getProfileImageLatest($objUser->userId);
        if(!empty($img)){
            $this->objSess->userImage = $img['imageName'];
        } else {
            $this->objSess->userImage = '';
        }

        $this->user_m->updateLastLogin($objUser->userId);
        $this->user_m->setOnline($objUser->userId);
    }
    
    function checkLoggedIn() {
        if($this->_ModuleName=='admin'){
        	if(isset($objSess->isAdminLogin) && $objSess->isAdminLogin == true){
           		$this->_redirect("/admin/dashboard");
        	}
        }elseif($this->_ModuleName=='default'){
        	if(isset($objSess->isFrontLogin) && $objSess->isFrontLogin == true){
	            $this->_redirect("/");
	        }
        }
    }

    
}
