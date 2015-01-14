<?php

class Get_password extends MY_Controller {

    public function index($rs = '') {
        $this->load->database();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[passconf]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            //echo form_open();
            //print $rs;
            $this->data['rs'] = $rs;
            $this->loadView('gp_form');
        } else {
            //print $rs;
            $query = $this->db->get_where('user', array('forgotPasswordToken' => $rs), 1);

            if ($query->num_rows() == 0) {
                show_error('Sorry!!! Invalid Request!');
            } else {
                $password = $this->input->post('password');
                $rs = $this->input->post('rs');
                //print "Pass".$password."<br>";

                $this->load->model("user_m");
                $this->user_m->removeToken($rs, $password);
                redirect(site_url("/user/login"));
            }
        }
    }

    public function adminPassChange($rs = '') {
        $this->load->database();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('password', 'Password', 'trim|required|matches[passconf]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            //echo form_open();
            //print $rs;
            $this->data['rs'] = $rs;
            $this->loadAdminView('changePassView/'.$rs);
        } else {
            //print $rs;
            $rs = $this->input->post('rs');
            $query = $this->db->get_where('admin', array('forgotPasswordToken' => $rs), 1);

            if ($query->num_rows() == 0) {
                show_error('Sorry!!! Invalid Request!');
            } else {
                $password = $this->input->post('password');
                $rs = $this->input->post('rs');
                //print "Pass".$password."<br>";

                $this->load->model("admin_m");
                $this->admin_m->removeToken($rs, $password);
                redirect(site_url("/admin"));
            }
        }
    }
    
    public function chpassword() {
        $this->load->database();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('oldpass', 'Current Password', 'trim|required|callback_oldpass_check');
        $this->form_validation->set_rules('newpass', 'Password', 'trim|required|matches[confirmpass]');
        $this->form_validation->set_rules('confirmpass', 'Password Confirmation', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            //echo form_open();
            //print $rs;
            $this->loadView('home_loggedin');
        } else {
                //print "Entered";exit;
                $pass = $this->input->post('newpass');  
                $sess = $this->session->userdata("objSess");
                $userid = $sess->userId;
                $this->user_m->changepasswd($pass,$userid);
                redirect(site_url("/home"));            
        }
    }

    function oldpass_check($oldpass) {
       // print $oldpass;exit;
        $this->load->model("user_m");
        $sess = $this->session->userdata("objSess");
        $user_id = $sess->userId;
        $result = $this->user_m->check_oldpassword($oldpass, $user_id);
        //print $result;exit;
        if ($result == 0) {
            $this->form_validation->set_message('oldpass_check', "%s doesn't match.");
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function adminchpassword() {
        $this->load->database();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('oldpass', 'Current Password', 'trim|required|callback_adminoldpass_check');
        $this->form_validation->set_rules('newpass', 'Password', 'trim|required|matches[confirmpass]');
        $this->form_validation->set_rules('confirmpass', 'Password Confirmation', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            //echo form_open();
            //print $rs;
            $this->data['usrData'] = $this->session->userdata("objSess");
            $this->loadAdminview('changepassword');
        } else {
                $this->load->model("admin_m");
                //print "Entered";exit;
                $pass = $this->input->post('newpass'); 
                $sess = $this->session->userdata("objSess");
                $userid = $sess->userId;
                $this->admin_m->changepasswd($pass,$userid);
                redirect(site_url("/admin"));            
        }
    }

    function adminoldpass_check($oldpass) {
       // print $oldpass;exit;
        $this->load->model("admin_m");
        $sess = $this->session->userdata("objSess");
        $user_id = $sess->userId;
        $result = $this->admin_m->check_oldpassword($oldpass, $user_id);
        //print $result;exit;
        if ($result == 0) {
            $this->form_validation->set_message('adminoldpass_check', "%s doesn't match.");
            return FALSE;
        } else {
            return TRUE;
        }
    }

}