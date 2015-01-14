<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newletter
 *
 * @author user
 */
class Newsletter  extends My_Controller {
    //put your code here
    
    public function save(){
        $this->load->model("newsletter_m");
        //print "Entered"; exit;
        $this->load->library('form_validation');
        $postemail = $this->input->post('email');
        //print $postemail."  ".$this->input->post('uname');
        // field name, error message, validation rules including duplication check
        $this->form_validation->set_rules('uname', 'Name', 'trim|required|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('email', 'EmailNewsletter', 'trim|required|valid_email|is_unique[newsletter.email]');
 
        if ($this->form_validation->run() == FALSE) {
            //$message = 'Email duplication not allowed';
            //print "Entered"; exit;
            $this->form_validation->set_message('EmailNewsletter', 'Email duplication not allowed');
            $this->data['error_message'] = "<span class='error'>Email duplication not allowed</span>";
            $this->loadView('/home');
        }
        else
        {
            $this->newsletter_m->add_userinfo();
            $this->thanks();
        }
    }
    
    public function thanks() {
        $this->data['message'] = "Thanks for subscribe our newsletter!";
        $this->loadView("thanks");
    }
}

?>
