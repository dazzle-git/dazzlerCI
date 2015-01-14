<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Newsletter_m
 *
 * @author user
 */
class Newsletter_m  extends MY_Model {
    //put your code here
    protected $_table_name = 'newsletter';
    protected $_primary_key = 'newsid';
    protected $_order_by = "userid";
    protected $newsid = null;
    
    public function add_userinfo() {
        $name = $this->input->post('uname');
        $email = $this->input->post('email');
        
        $data = array(
            'name' => $name,
            'email' => $email,
            'Active' => 1
        );
        //print_r($data);exit;
        $this->db->insert('newsletter', $data);
    }
}

?>
