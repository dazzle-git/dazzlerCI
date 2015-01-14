<?php

class Admin_m extends MY_Model {

    protected $_table_name = 'admin';
    protected $_primary_key = 'adminId';
    protected $_order_by = 'position';
    public $rules = array(
        'eventTitle' => array(
            'field' => 'eventTitle',
            'label' => 'Event Title',
            'rules' => 'trim|required|xss_clean'
        )
    );

    public function verifyLoginInfo($user, $pass, $rememberMe = null) {

        $this->db->where("username", $user);
        $this->db->where("password", "sha1(CONCAT('$pass', salt))", FALSE);
        $this->db->where("status", "Active");
        $result = $this->db->get("admin")->result();
        //print $this->db->last_query();exit;
        if (count($result) == 1) {
            $userid = $result[0]->adminId;
            if (isset($rememberMe) && $rememberMe == 1) {
                setcookie('AUTH_UN', base64_encode($user), time() + 24 * 60 * 60 * 365, '/', false);
                setcookie('AUTH_UP', base64_encode($pass), time() + 24 * 60 * 60 * 365, '/', false);
            } else {
                setcookie('AUTH_UN', base64_encode($user), time() - 24 * 60 * 60 * 365, '/', false);
                setcookie('AUTH_UP', base64_encode($pass), time() - 24 * 60 * 60 * 365, '/', false);
            }
            return true;
        }

        return false;
    }
    
    public function getUserDataUsername($useremail) {
        if (!$useremail) {
            return false;
        }
        $where = array("username" => $useremail);
        return $this->get_where($where, true);
    }
    
    public function updateLastLogin($id) {
        $this->db->where('adminId', $id);
        $data['fromIP'] = $_SERVER['REMOTE_ADDR'];
        $data['lastLoginDate'] = date('Y-m-d H:i:s', time());
        return $this->db->update("admin", $data);
    }
    
    public function saveToken($email) {
        $this->load->helper('string');
        $rs = random_string('alnum', 12);

        $data = array(
            'forgotPasswordToken' => $rs
        );
        $this->db->where('userEmail', $email);
        $this->db->update('admin', $data);
        return $rs;
    }

    public function removeToken($rs, $password) {
        $this->load->helper('string');
        $salt = getUniqueCode(20);
        $encPwd = sha1($password . $salt);
        $pass = $encPwd;
        $data = array(
            'password' => $encPwd,
            'salt' => $salt,
            'forgotPasswordToken' => ''
        );
        $this->db->where('forgotPasswordToken', $rs);
        $this->db->update('admin', $data);
        //print $this->db->last_query();
        //return $rs;
    }
    
    function check_oldpassword($oldpass, $user_id) {
        $this->db->where("adminId", $user_id);
        $this->db->where("password", "sha1(CONCAT('$oldpass', salt))", FALSE);
        $query = $this->db->get('admin'); //data table
        //print $this->db->last_query();
        return $query->num_rows();
        
    }
    
    function changepasswd($password,$user_id) {
        //$this->load->helper('string');
        $this->db->where("adminId", $user_id);
        $salt = getUniqueCode(20);
        $encPwd = sha1($password . $salt);
        $pass = $encPwd;
        $data['password'] = $pass;
        $data['salt'] = $salt;
        $a = $this->db->update("admin", $data);
        
        print $this->db->last_query();
        return $a;
    }
}
