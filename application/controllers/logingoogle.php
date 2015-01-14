<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class LoginGoogle extends My_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_m');
    }

    public function index() {
        require_once 'openid.php';
        $openid = new LightOpenID("localhost");
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

        $openid->returnUrl = 'http://localhost/login_thirdparty/codeigniterlogin/index.php/logingoogle/loginAuth';

//  echo '<a href="'.$openid->authUrl().'">Login with Google</a>';

        $data['openid'] = $openid;
        $this->load->view('googleLoginView', $data);
    }

    public function loginAuth() {
        $resp = $this->user_m->googlelogin();
        if ($resp['error'] == '') {
            $email = $resp['email'];
            $userrec = $this->user_m->getUserDataByEmail($email);
            $this->setsession($userrec);
            redirect(site_url("/home"));
        } else {
            redirect(site_url("/user/login"));
        }
    }

}
