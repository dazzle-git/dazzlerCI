<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends My_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index() {
        $this->load->model("user_m");
        //print_r($_SESSION);
        $this->loadView('login');
    }

    public function login() {

        $this->load->model("user_m");
        $this->load->library("form_validation");
        $rules = array(
            "userEmail" => array(
                "field" => "userEmail",
                "label" => "Email Address",
                "rules" => "trim|required|xss_clean"
            ),
            "password" => array(
                "field" => "password",
                "label" => "Password",
                "rules" => "trim|required|xss_clean"
            )
        );
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == TRUE) {
            $useremail = $this->input->post("userEmail");
            $password = $this->input->post("password");
            if ($this->user_m->verifyLoginInfo($useremail, $password, false)) {
                $userrec = $this->user_m->getUserDataByEmail($useremail);
                $this->setsession($userrec);
                redirect(site_url("/home"));
            } else {
                $data = $this->fblogin();
                $this->data = array_merge($this->data, $data);
                $this->data["alertMessage"] = array(
                    "message" => "Invalid UserName/Password",
                    "type" => "error"
                );
                $this->loadView('login');
            }
        } else {
            $data = $this->fblogin();
            //$googledata = $this->googleLogin();
            //$twitterdata = $this->twitterLogin();
            //print_r($data);, $googledata
            //$data1 = array_merge($this->data, $data);
            //$data['stat'] = '';
            $data1 = array_merge($this->data, $data);
            $code = isset($_REQUEST['code']) ? $_REQUEST['code'] : '';
            //print_r($data);
            if ($data['stat'] == "success")
                redirect(site_url("/home"));
            elseif ($code != "")
                redirect(site_url("/home"));
            else
                $this->load->view('desktop/login', $data1);
        }
    }

    public function notification() {
        if (!$this->checkLoggedIn())
            redirect(site_url("/user/login"));
        $this->load->model("notification_m");
        $userid = $this->objSess->userId;
        $notifs = $this->notification_m->getNotification($userid);
        $notifs = $this->notification_m->completeNotification($notifs, $userid);
        $this->data["notifs"] = $notifs;
        $this->loadView('notifications');
    }

    public function account() {


        $this->loadView('account');
    }

    public function registration() {
        $this->load->model("user_m");
        $this->load->library('form_validation');
        $postemail = $this->input->post('user_email');
        // field name, error message, validation rules including duplication check
        $this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|is_unique[user.userEmail]');
        $this->form_validation->set_rules('pass', 'Password', 'trim|required|min_length[4]|max_length[32]');


        if ($this->form_validation->run() == FALSE) {
            $message = 'Email duplication not allowed';
            $this->form_validation->set_message('Email', 'Email duplication not allowed');
            $this->data["alertMessage"] = array(
                "message" => "Email duplication not allowed",
                "type" => "error"
            );
            //$this->loadView('/home');
            redirect(site_url("/register"));
        } else {
            $this->user_m->add_user();
            $userrec = $this->user_m->getUserDataByEmail($postemail);
            $this->setsession($userrec);
            redirect(site_url("/home"));
        }
    }

    public function registrationIndividual() {
        $this->load->model("user_m");
        $this->load->library('form_validation');
        $postemail = $this->input->post('user_email');
        // field name, error message, validation rules including duplication check
        $this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|is_unique[user.userEmail]');
        $this->form_validation->set_rules('pass', 'Password', 'trim|required|min_length[4]|max_length[32]');


        if ($this->form_validation->run() == FALSE) {
            $message = 'Email duplication not allowed';
            $this->form_validation->set_message('Email', 'Email duplication not allowed');
            $this->data["alertMessage"] = array(
                "message" => "Email duplication not allowed",
                "type" => "error"
            );
            //$this->loadView('/home');
            redirect(site_url("/register"));
        } else {
            $this->user_m->add_userIndividual();
            $userrec = $this->user_m->getUserDataByEmail($postemail);
            $this->setsession($userrec);
            redirect(site_url("/home"));
        }
    }

    public function messages() {
        exit(1);
        if (!$this->checkLoggedIn())
            redirect(site_url("/user/login"));
        $this->load->model("notification_m");
        $userid = $this->objSess->userId;
        $notifs = $this->notification_m->getNotification($userid);
        $this->data["notifs"] = $notifs;
        $this->loadView('notifications');
    }

    public function fblogin() {

        $this->load->library('facebook'); // Automatically picks appId and secret from config
        $this->load->model("user_m");
        // OR
        // You can pass different one like this
        //$this->load->library('facebook', array(
        //    'appId' => 'APP_ID',
        //    'secret' => 'SECRET',
        //    ));

        $user = $this->facebook->getUser();
        //print_r($user);
        if ($user) {
            try {
                $data['user_profile'] = $this->facebook->api('/me');
                $email = $data['user_profile']['email'];
                $dataInfo['userEmail'] = $data['user_profile']['email'];
                $dataInfo['oauthId'] = $user;
                $dataInfo['oauthProvider'] = "facebook";
                $dataInfo['firstName'] = $data['user_profile']['first_name'];
                $dataInfo['lastName'] = $data['user_profile']['last_name'];
                $dataInfo['userGender'] = $data['user_profile']['gender'];
                //print $this->user_m->checkDuplicateEmail($email);
                if ($this->user_m->checkDuplicateEmail($email)) {
                    //print_r($dataInfo);exit;
                    $this->user_m->facebook_user($dataInfo);
                }
                //print $email;
                $userrec = $this->user_m->getUserDataByEmail($email);
                $this->setsession($userrec);
                $data['stat'] = "success";
                redirect(site_url("/home"));
            } catch (FacebookApiException $e) {
                $user = null;
            }
        } else {
            $this->facebook->destroySession();
        }

        if ($user) {

            $data['logout_url'] = site_url('welcome/logout'); // Logs off application
            // OR 
            // Logs off FB!
            // $data['logout_url'] = $this->facebook->getLogoutUrl();
        } else {
            $data['login_url'] = $this->facebook->getLoginUrl(array(
                'redirect_uri' => site_url('user/login'),
                'scope' => array("email") // permissions here
            ));
            $data['stat'] = "Failed";
            //redirect($data['login_url']);
        }
        return $data;
    }

    public function twitterLogin() {

        include_once("thirdparty/twitteroauth.php");
        $this->config->load('twitter');
        $this->load->model("user_m");
        if (isset($_REQUEST['oauth_token']) && $this->session->userdata('token') !== $_REQUEST['oauth_token']) {

            // if token is old, distroy any session and redirect user to index.php
            //session_destroy();
            print "Entered123";
            redirect(site_url("/user/login"));
        } elseif (isset($_REQUEST['oauth_token']) && $this->session->userdata('token') == $_REQUEST['oauth_token']) {

            // everything looks good, request access token
            //successful response returns oauth_token, oauth_token_secret, user_id, and screen_name
            $connection = new TwitterOAuth($this->config->item('consumer_token'), $this->config->item('consumer_secret'), $this->session->userdata('token'), $this->session->userdata('token_secret'));
            $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
            if ($connection->http_code == '200') {
                //redirect user to twitter
                $data = $access_token;
                $this->session->set_userdata('request_vars', $access_token);
                //$_SESSION['request_vars'] = $access_token;
                // unset no longer needed request tokens
                $email = $data['user_id'] . '@twitter.com';
                $dataInfo['userEmail'] = $email;
                $dataInfo['oauthId'] = $data['user_id'];
                $dataInfo['oauthProvider'] = "twitter";
                $dataInfo['twitterOauthToken'] = $data['oauth_token'];
                $dataInfo['twitterOauthTokenSecret'] = $data['oauth_token_secret'];
                $dataInfo['firstName'] = $data['screen_name'];
                $dataInfo['lastName'] = $data['screen_name'];
                $this->load->model("user_m");
                //print $email;
                //print $this->user_m->checkDuplicateEmail($email);
                if ($this->user_m->checkDuplicateEmail($email)) {
                    //print_r($dataInfo);
                    $this->user_m->twitter_user($dataInfo);
                }
                //print $email;
                $userrec = $this->user_m->getUserDataByEmail($email);
                $this->setsession($userrec);
                $data['stat'] = "success";
                //print_r($data);exit;
                //header('Location: ./index.php');
                redirect(site_url("/home"));
            } else {
                die("error, try again later!");
            }
        } else {

            if (isset($_GET["denied"])) {
                //redirect(site_url("/user/login"));
                print "Denied";
                die();
            }
            //echo CONSUMER_KEY."<br>".CONSUMER_SECRET."<br>";
            //fresh authentication
            $connection = new TwitterOAuth($this->config->item('consumer_token'), $this->config->item('consumer_secret'));
            //print_r($connection);
            $request_token = $connection->getRequestToken($this->config->item('callback'));

            //received token info from twitter
            $this->session->set_userdata('token', $request_token['oauth_token']);
            $this->session->set_userdata('token_secret', $request_token['oauth_token_secret']);

            //print $connection->http_code;
            // any value other than 200 is failure, so continue only if http code is 200
            if ($connection->http_code == '200') {
                //redirect user to twitter
                $twitter_url = $connection->getAuthorizeURL($request_token['oauth_token']);
                redirect($twitter_url);
            } else {
                die("error connecting to twitter! try again later!");
            }
        }
    }

    public function googleLogin() {
        require_once 'openid.php';
        $openid = new LightOpenID("dazzler");
        $openid->identity = 'https://www.google.com/accounts/o8/id';
        $openid->required = array(
            'namePerson/first',
            'namePerson/last',
            'contact/email',
            'birthDate',
            'person/gender',
            'contact/postalCode/home',
            'contact/country/home',
            'pref/language',
            'pref/timezone',
        );
//  $openid->returnUrl = 'http://localhost/login_thirdparty/login_google.php';

        $openid->returnUrl = site_url('logingoogle/loginAuth');

//  echo '<a href="'.$openid->authUrl().'">Login with Google</a>';

        $data['openid'] = $openid;
        return $data;
        //$this->load->view('googleLoginView', $data);
    }

    public function googleApi() {
        /* $google_client_id = '733542303898-2tf2c7e64nlrrejua2om2gkjtkanq3rc.apps.googleusercontent.com';
          $google_client_secret = 'xLn4pep6HmtaAtovA1Y4-Ctp';
          $google_redirect_url = 'http://dazzler.com/ci/user/googleApi'; //path to your script
          $google_developer_key = 'AIzaSyCMa0AHXTqAVNAHVvFMFGujdVyAyCbbtmM'; */

        $google_client_id = '733542303898-2tf2c7e64nlrrejua2om2gkjtkanq3rc.apps.googleusercontent.com';
        $google_client_secret = 'xLn4pep6HmtaAtovA1Y4-Ctp';
        $google_redirect_url = 'http://dazzler.com/ci/user/googleApi'; //path to your script
        $google_developer_key = 'AIzaSyCMa0AHXTqAVNAHVvFMFGujdVyAyCbbtmM';

        require_once 'thirdparty/Google_Client.php';
        require_once 'thirdparty/contrib/Google_Oauth2Service.php';

        $gClient = new Google_Client();
        $gClient->setApplicationName('Login to Sanwebe.com');
        $gClient->setClientId($google_client_id);
        $gClient->setClientSecret($google_client_secret);
        $gClient->setRedirectUri($google_redirect_url);
        $gClient->setDeveloperKey($google_developer_key);

        $google_oauthV2 = new Google_Oauth2Service($gClient);

//If user wish to log out, we just unset Session variable
        if (isset($_REQUEST['reset'])) {
            $gClient->revokeToken();
            redirect(filter_var($google_redirect_url, FILTER_SANITIZE_URL));
            //header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL)); //redirect user back to page
        }

//If code is empty, redirect user to google authentication page for code.
//Code is required to aquire Access Token from google
//Once we have access token, assign token to session variable
//and we can redirect user back to page and login.
        if (isset($_GET['code'])) {
            $gClient->authenticate($_GET['code']);
            $this->session->set_userdata('googletoken', $gClient->getAccessToken());
            //$_SESSION['token'] = $gClient->getAccessToken();
            redirect(filter_var($google_redirect_url, FILTER_SANITIZE_URL));
            //header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
            return;
        }
        $googletoken = ($this->session->userdata('googletoken') != '') ? $this->session->userdata('googletoken') : '';

        if ($googletoken != '') {  //if (isset($_SESSION['token'])) {
            $gClient->setAccessToken($this->session->userdata('googletoken'));
        }


        if ($gClient->getAccessToken()) {
            //For logged in user, get details from google using access token
            $user = $google_oauthV2->userinfo->get();
            $user_id = $user['id'];
            $user_name = filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
            $profile_url = filter_var($user['link'], FILTER_VALIDATE_URL);
            $profile_image_url = filter_var($user['picture'], FILTER_VALIDATE_URL);
            $personMarkup = "$email<div><img src='$profile_image_url?sz=50'></div>";
            $this->session->set_userdata('googletoken', $gClient->getAccessToken());
            //$_SESSION['token'] = $gClient->getAccessToken();
        } else {
            //For Guest user, get google login url
            $authUrl = $gClient->createAuthUrl();
        }
        if (isset($authUrl)) { //user is not logged in, show login button
            redirect($authUrl);
        } else { // user logged in 
            //list all user details
            $data['userEmail'] = $user['email'];
            $data['firstName'] = $user['given_name'];
            $data['lastName'] = $user['family_name'];
            $data['oauthId'] = $user['id'];
            $data['userGender'] = $user['gender'];
            $this->load->model("user_m");
            //print_r($data);
            $email = $this->user_m->googleApi($data);

            if ($email != 'error') {
                $userrec = $this->user_m->getUserDataByEmail($email);
                $this->setsession($userrec);
                $data['stat'] = "success";
                redirect(site_url("/home"));
            } else {
                $this->data["alertMessage"] = array(
                    "message" => "Invalid UserName/Password",
                    "type" => "error"
                );
                $this->loadView('login');
            }
            /* echo '<pre>';
              print_r($user);
              echo '</pre>'; */
        }
    }

    public function profile($userid = NULL) {
        //print "Checkin";exit;
        $this->load->model("user_m");
        $this->load->model("usermedia_m");
        $this->load->model("userprofile_m");
        $this->load->model("userfollower_m");
        $this->data["showFollow"] = true;
		if(!$this->checkLoggedIn()) {
			redirect(site_url("/home"));
            exit;
		}
        if (!$userid) {
            $userid = $this->objSess->userId;
            $this->data["showFollow"] = false;
        }
        if (!$this->user_m->checkUser($userid)) {
            redirect(site_url("/home"));
            exit;
        }
        $userRow = $this->user_m->get($userid, true);
        $userRow->profileImage = $this->user_m->getProfileImg($userid);
        $profile = $userRow->profile = $this->userprofile_m->getProfile($userid);
        $uploads = $this->usermedia_m->getUserUploads($userid);
        $userRow->uploads = $uploads;
        //print "Constant=>".UPLOADROOT;
        $total = 0;
        foreach ($uploads as $key=>$val){
            $total = $total + @filesize(UPLOADROOT.$val->bigSizeFile);
            $total = $total + @filesize(UPLOADROOT.$val->smallSizeFile);
        }
        //print $total;
        $usedSpace = $total;
        $totGB = formatbytes($total,'GB');
        //print '       '.$totGB;
        $this->data['totGB'] = $totGB;
        $followers = $this->userfollower_m->getUserFollower($userid);
        $followers = $this->user_m->addProfileImage($followers, "followerId");
        $userRow->followers = $followers;
        $total = 0;
        foreach ($followers as $key=>$val){
            $total = $total + GETSIZE;
        }
        //print $total;
        $getGB = formatbytes($total,'GB');
        $this->data['getGB'] = $getGB;
        $totalSpace = COMMONSPACE + $total;
        $remSpace = $totalSpace - $usedSpace;
        $this->data['remGB'] = formatbytes($remSpace, 'GB');
        $perUsed = $usedSpace/$totalSpace * 100;
        $perRem = $usedSpace/$totalSpace * 100;
        $perEarn = $total/$totalSpace * 100;
        $percentage = array($perUsed,$perRem,$perEarn);
        $this->data['percentage'] = $percentage;
        $followers = $this->userfollower_m->getUserFollowing($userid);
        $followers = $this->user_m->addProfileImage($followers, "followerId");
        $userRow->follows = $followers;


        $this->load->model("userprofileimage_m");
        $pimages = $this->userprofileimage_m->getByUserId($userid);
        $userRow->pimages = $pimages;
        if($profile->tCategoryId != 0)
            $similar = $this->getSimilarProfiles($profile->tCategoryId,$userid);
        else
            $similar = '';
        //print_r($similar);exit;
        $userRow->similar = $similar;
        
        $this->data["user"] = $userRow;

        

        $this->loadView("profile");
    }
    
    public function getSimilarProfiles($tcatId,$userid){
        //print "OKKK";
        $this->load->model("userprofileimage_m");
        $this->load->model("user_m");
        $similarProf = $similar = $this->userprofile_m->getSimilar($tcatId,$userid);
        foreach($similar as $key=>$val){
            //print $val->userId;
            $userRow = $this->user_m->get($val->userId, true);
            //print_r($userRow);
            $fullname = $userRow->firstName." ".$userRow->lastName;
            $similarProf[$key]->fullname = ($fullname != ' ')? $fullname : "Dummy" ;
            $similarProf[$key]->profileImage = $this->user_m->getProfileImg($val->userId);
        }
        return $similarProf;
    }

    public function usercombo($term = '') {
        if($term == ''){
            $term = $this->input->post('name');
        }
        $user_input = trim($term);
        
// Define two array, one is to store output data and other is for display
        $display_json = array();
        $json_arr = array();
        

        $user_input = preg_replace('/\s+/', ' ', $user_input);
        
         $this->load->model("user_m");
        //print $user_input;exit;
        $items = $this->user_m->checkEmailSuggest($user_input);
        
        foreach ($items as $key => $item) {
            $json_arr["id"] = $item->userId;
            $json_arr["value"] = $item->userEmail;
            $json_arr["label"] = '<a><img width="52px" height="52px" src="http://dazzler.com/images/noimage.gif"><span class="ui-detail"><span class="ui-label">' . $item->firstName . ' ' . $item->lastName . '</span><span class="ui-desc">' . $item->userEmail . '</span></span></a>';
            array_push($display_json, $json_arr);
        }

        $jsonWrite = json_encode($display_json); //encode that search data
        print $jsonWrite;
    }

    public function advSearch() {
        $this->load->library('facebook');
        $this->session->unset_userdata("objSess");
        $this->data["isloggedin"] = false;
        $this->facebook->destroySession();
        $this->loadView("logout");
    }
    
    public function logout() {
        $this->load->library('facebook');
        $this->session->unset_userdata("objSess");
        $this->data["isloggedin"] = false;
        $this->facebook->destroySession();
        $this->loadView("logout");
    }

}
