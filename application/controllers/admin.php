<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends MY_Controller {

    public function index() {
        $this->load->model("admin_m");
        //print_r($this->session->userdata("objSess"));
        if ($this->checkLoggedIn('admin')) {
            $this->data['usrData'] = $this->session->userdata("objSess");
            $this->loadAdminView('dashboard');
        } else {
            //$this->data['message'] = validation_errors();
            $this->loadAdminView('login');
        }
    }

    public function adminlogin() {
        $this->load->model("admin_m");
        //print_r($this->session->userdata("objSess"));
        if ($this->checkLoggedIn('admin')) {
            $this->data['usrData'] = $this->session->userdata("objSess");
            return true;
        } else {
            //$this->data['message'] = validation_errors();
            $this->redirect(site_url('admin/login'));
        }
    }

    public function login() {

        $this->load->model("admin_m");
        $this->load->library("form_validation");
        $rules = array(
            "username" => array(
                "field" => "username",
                "label" => "Username",
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
            $useremail = $this->input->post("username");
            $password = $this->input->post("password");
            if ($this->admin_m->verifyLoginInfo($useremail, $password, false)) {

                $userrec = $this->admin_m->getUserDataUsername($useremail);
                //print "OK";
                $this->setadminSession($userrec);
                redirect(site_url("/admin"));
            } else {

                $this->data["alertMessage"] = array(
                    "message" => "Invalid UserName/Password",
                    "type" => "error"
                );
                $this->loadAdminView('login');
            }
        } else {
            $this->load->view('cpanel/login', $data1);
        }
    }

    public function medialist($page = 0) {
        $this->load->model("usermedia_m");
        //print_r($_SESSION);
        $c = $this->adminlogin();
        $this->config->load('customconfig');
        $limit = $this->config->item('paginationCnt');
        $start = ($page - 1) * $limit;
        if ($c) {
            $total = ceil($this->usermedia_m->getAllMediaCnt() / $limit);
            $arr = $this->usermedia_m->getAllMedia($start, $limit);
            $this->data['items'] = $arr;
            $this->data['total'] = $total;
            $this->loadAdminView('media');
        }
    }

    public function mediadetails($id) {
        $this->load->model("usermedia_m");
        //print_r($_SESSION);
        $c = $this->adminlogin();

        if ($c) {
            $arr = $this->usermedia_m->getMedia($id);
            $this->data['row'] = $arr;
            $this->loadAdminView('mediadetails');
        }
    }

	public function restricted($id) {
        $this->load->model("usermedia_m");
        //print_r($_SESSION);
        $c = $this->adminlogin();

        if ($c) {
            $this->usermedia_m->setRestrict($id);
            //$this->data['row'] = $arr;
            redirect(site_url("/admin/medialist"));
        }
    }

    public function resetPassword() {
        $this->load->library('form_validation');
        $this->load->model("usermedia_m");

        $this->loadAdminView('forgotpassword');
    }

    public function changepassword() {
        $this->load->library('form_validation');
        $this->load->model("usermedia_m");
        $c = $this->adminlogin();

        if ($c) {
            $this->loadAdminView('changepassword');
        }
    }

    public function logout() {
        $this->session->unset_userdata("objSess");
        $this->data["isloggedin"] = false;
        redirect(site_url('/admin'));
    }

}

?>
