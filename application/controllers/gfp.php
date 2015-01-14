<?php

class Gfp extends MY_Controller {

    var $isAdmin = 0;
    
    function __construct() {
        parent::__construct();
        //$this->load->database();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model("user_m");
    }

    public function index() {

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check');

        if ($this->form_validation->run() == FALSE) {
            $this->loadView('email_check');
        } else {
            //please see Codeigniter : Get your forgotten Password . Part-2
            $email = $this->input->post('email');
            $rs = $this->user_m->saveToken($email);
            $this->isAdmin = 0;
            //print "OK";exit;
            $this->sendMail($email, $rs);
        }
    }
    
    public function adminEmail() {

        $this->form_validation->set_rules('emailadd', 'Emailadm', 'trim|required|valid_email|callback_adminemail_check');
        //print $this->form_validation->run();exit;
        if ($this->form_validation->run() == FALSE) {
             $this->loadAdminView('forgotpassword');
        } else {
            $this->load->model("admin_m");
            //please see Codeigniter : Get your forgotten Password . Part-2
            $email = $this->input->post('emailadd');
            $rs = $this->admin_m->saveToken($email);
            $this->isAdmin = 1;
            //print "OK";exit;
            $this->sendMail($email, $rs);
        }
    }

    public function email_check($str) {
        $query = $this->db->get_where('user', array('userEmail' => $str), 1);

        if ($query->num_rows() == 1) {
            return true;
        } else {
            $this->form_validation->set_message('email_check', 'This Email does not exist.');
            return false;
        }
    }
    
    public function adminemail_check($str) {
        $query = $this->db->get_where('admin', array('userEmail' => $str), 1);

        if ($query->num_rows() == 1) {
            return true;
        } else {
            $this->form_validation->set_message('adminemail_check', 'This Email does not exist.');
            //$this->data['message'] = 'This Email does not exist.';
            return false;
        }
    }

    public function sendMail($email, $rs) {
        /* $config['protocol'] = 'smtp';
          $config['smtp_host'] = 'ssl://smtp.googlemail.com';
          $config['smtp_port'] = 465;
          $config['smtp_user'] = 'arun.zayan@gmail.com';
          $config['smtp_pass'] = 'arunfoto';
         */
        
         $this->load->library('email');

          $this->email->from('arun.zayan@gmail.com', 'Arun');
          $this->email->to($email);

          $this->email->subject('Get your forgotten Password');
          if($this->isAdmin == 1)
              $this->email->message('Please go to this link to get your password.'. site_url('get_password/adminPassChange/' . $rs));
          else
              $this->email->message('Please go to this link to get your password.'. site_url('get_password/index/' . $rs));

          $this->email->send(); 
        /*$to = $email;
        $subject = 'Get your forgotten Password';
        $message = 'Please go to this link to get your password.' . site_url('get_password/index/' . $rs);
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
        
        $headers .= 'From: Admin <arun.zayan@gmail.com>' . "\r\n";
        $headers .= 'Reply-To: arun.zayan@gmail.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);*/
        
        $this->mailSubmission($email);
    }
    
    public function mailSubmission($email) {
        $this->data['message'] = "<div class='alert alert-success'>Message successfully send to ".$email.'</div>';
        if($this->isAdmin == 1)
            $this->loadAdminView('forgotpassword');
        else
            $this->loadView('email_check');
    }

}