<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public $data = array();
    public $viewFolder = "desktop/";
    public $title = "vipcentre";
    public $objSess;
    protected $_ModuleName = "default";

    function __construct() {
        parent::__construct();

        $this->data["ajax_error"] = false;
        $this->data["ajax_redirect"] = null;
        $this->data["jscripts"] = array();
        $this->data["footerscripts"] = array();
        $this->data["styles"] = array();
        $this->data["footerstyles"] = array();
        $this->data["title"] = $this->title;
        $this->data["isloggedin"] = false;

        $users = $this->session->userdata("objSess");
        
        if(isset($users->isAdminLogin) && $users->isAdminLogin)
            $this->adminTheme();
        else {
            $this->frontTheme();
        }
        
    }

    function frontTheme(){
        $this->data["viewFolder"] = $this->viewFolder;
        if ($this->session->userdata("objSess")) {
            $this->load->model("notification_m");
            $this->objSess = $this->session->userdata("objSess");
            $this->data["UserSession"] = $this->objSess;
            $arr = $this->notification_m->getNotification($this->objSess->userId);
            //print_r($arr);
            $this->data["commentCnt"] = getCountArr($arr,"Comment");
            $this->data["timeComment"] = getLastTime($arr,"Comment");
            $this->data["dazzleCnt"] = getCountArr($arr,"Dazzle");
            $this->data["timeDazzle"] = getLastTime($arr,"Dazzle");
            $this->data["followCnt"] = getCountArr($arr,"Follow");
            $this->data["timeFollow"] = getLastTime($arr,"Follow");
            $this->data["likeCnt"] = getCountArr($arr,"Like");
            $this->data["timeLike"] = getLastTime($arr,"Like");
            $this->data["h_notification"] = count($arr);
            $this->data["isloggedin"] = true;
            unset($arr);
        }

        $this->enque_style("http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css");
        $this->enque_style("assets/css/bootstrap.css");
        $this->enque_style("/assets/css/jquery.videocontrols.css");
        $this->enque_style("assets/css/msgboxlight.css");
        $this->enque_style("assets/css/style.css");



        $this->enque_script("assets/js/jquery-1.11.2.min.js");
        $this->enque_script("assets/js/bootstrap.min.js");
        $this->enque_script("/assets/js/jquery.msgBox.js");
        $this->enque_script("/assets/js/jquery.videocontrols.js");
        $this->enque_script("/assets/js/tools.js");
    }
    
    
    function adminTheme(){
        $this->data["viewFolder"] = "cpanel/";
        if ($this->session->userdata("objSess")) {
            $this->objSess = $this->session->userdata("objSess");
            $this->data["UserSession"] = $this->objSess;            
            $this->data["isloggedin"] = true;            
        }
    }
    
    function enque_script($scriptname, $text = false, $last = true) {
        $scriptsArray = $this->data["jscripts"];

        if ($text) {
            $scriptname = "<script type=\"text/javascript\">$scriptname</script>";
        }

        if (!startsWith($scriptname, "http://"))
            $scriptname = site_url($scriptname);

        if ($last) {
            array_push($scriptsArray, $scriptname);
        } else {
            array_unshift($scriptsArray, $scriptname);
        }

        $this->data["jscripts"] = $scriptsArray;
    }

    function enque_script_footer($scriptname, $text = false, $last = true) {
        $scriptsArray = $this->data["footerscripts"];
        if ($text) {
            $scriptname = "<script type=\"text/javascript\">$scriptname</script>";
        }
        if (!startsWith($scriptname, "http://"))
            $scriptname = site_url($scriptname);
        if ($last) {
            array_push($scriptsArray, $scriptname);
        } else {
            array_unshift($scriptsArray, $scriptname);
        }

        $this->data["footerscripts"] = $scriptsArray;
    }

    function enque_style($scriptname, $text = false, $last = true) {
        $cssArray = $this->data["styles"];
        if ($text) {
            $scriptname = "<style>$scriptname</style>";
        }
        if (!startsWith($scriptname, "http://"))
            $scriptname = site_url($scriptname);
        if ($last) {
            array_push($cssArray, $scriptname);
        } else {
            array_unshift($cssArray, $scriptname);
        }

        $this->data["styles"] = $cssArray;
    }

    function enque_style_footer($scriptname, $text = false, $last = true) {
        $cssArray = $this->data["footerstyles"];
        if ($text) {
            $scriptname = "<style>$scriptname</style>";
        }
        if (!startsWith($scriptname, "http://"))
            $scriptname = site_url($scriptname);
        if ($last) {
            array_push($cssArray, $scriptname);
        } else {
            array_unshift($cssArray, $scriptname);
        }

        $this->data["footerstyles"] = $cssArray;
    }

    function loadview($viewname) {
        $this->load->view($this->viewFolder . $viewname, $this->data);
    }
    
    function loadAdminview($viewname) {
        $this->load->view('cpanel/' . $viewname, $this->data);
    }

    public function setSession($objUser, $isAdmin = 0) {

        $this->objSess = new stdClass();
        $this->objSess->userId = $objUser->userId;
        $this->objSess->username = $objUser->firstName . ' ' . $objUser->lastName;
        $this->objSess->userType = $objUser->userType;
        $this->objSess->subscriptionId = $objUser->subscriptionId;
        $this->objSess->verify = $objUser->verify;
        $this->objSess->createdDate = $objUser->createdDate;
        if ($isAdmin == 0)
            $this->objSess->isFrontLogin = true;
        else {
            $this->objSess->isAdminLogin = true;
        }
        $this->objSess->userBlockId = $this->user_m->getBlockUserId($objUser->userId);
        $this->objSess->userImage = $this->user_m->getProfileImg($objUser->userId);
        $this->session->set_userdata("objSess", $this->objSess);
        $this->user_m->updateLastLogin($objUser->userId);
        $this->user_m->setOnline($objUser->userId);
    }

    public function setadminSession($objUser) {

        $this->objSess = new stdClass();
        $this->objSess->userId = $objUser->adminId;
        $this->objSess->username = $objUser->firstName . ' ' . $objUser->lastName;
        $this->objSess->userType = $objUser->userType;
        $this->objSess->createdDate = $objUser->createdDate;       
        $this->objSess->isAdminLogin = true;        
        $this->session->set_userdata("objSess", $this->objSess);
        $this->admin_m->updateLastLogin($objUser->adminId);
        
    }
    
    function checkLoggedIn($mod = 'default') {
        $objSess = $this->objSess;
        if ($mod == 'admin') {
            if (isset($objSess->isAdminLogin) && $objSess->isAdminLogin == true) {
                return true;
            } else {
                return false;
            }
        } elseif ($mod == 'default') {
            if (!(isset($objSess->isFrontLogin) && $objSess->isFrontLogin == true)) {
                return false;
            } else {
                return true;
            }
        }
    }

    function _redirect($url) {
        redirect(site_url($url));
    }

    public function associateImage($message) {
        $mesArr = array();
        $mesArr = $message;
        $sess = $this->session->userdata("objSess");
        $userid = $sess->userId;
        $this->load->model("userprofileimage_m");
        $this->load->model("user_m");
        foreach ($message as $key => $val) {
            $pimages = $this->userprofileimage_m->getByUserId($val->fromUserId);
            //print_r($pimages);
            if ($userid == $val->fromUserId)
                $otherId = $val->toUserId;
            else {
                $otherId = $val->fromUserId;
            }
            $otherRec = $this->user_m->getUserData($otherId);
            $oemail = $otherRec->userEmail;
            $pimages = (count($pimages) > 0) ? $pimages->imageName : "noimage.jpg";
            $mesArr[$key]->pimage = $pimages;
            $mesArr[$key]->otherEmail = $oemail;
        }
        return $mesArr;
    }
}
