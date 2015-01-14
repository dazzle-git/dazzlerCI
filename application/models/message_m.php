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
class Message_m extends MY_Model {

    //put your code here
    protected $_table_name = 'usermessage';
    protected $_primary_key = 'messageId';
    protected $_order_by = "toUserId";
    protected $newsid = null;

    public function add_message($touser, $userId) {
        date_default_timezone_set('Asia/Kolkata');
        $message = $this->input->post('message');

        $data = array(
            'toUserId' => $touser,
            'message' => $message,
            'fromUserId' => $userId,
            'createdDate' => date('Y-m-d h:m:s')
        );
        //print_r($data);exit;
        $this->db->insert('usermessage', $data);
    }

    public function get_message($userId, $limit = '',$filter = '') {
        if (!$userId) {
            return false;
        }
        $selectarray = array(
            "*",
            " (select  concat(firstname, ' ', lastname) from user where user.userId=usermessage.fromUserId) as fullname ,"
            . "(select userEmail from user where user.userId=usermessage.fromUserId) as emailAddress");
        $this->db->select($selectarray, false);
        $where = array("toUserId" => $userId);
        $wh = array("is_deleted"=>"no");
        $this->db->order_by("createdDate", "desc");
        $this->db->where($where);
        $this->db->or_where('fromUserId', $userId);
        $this->db->where($wh);
        $this->db->where('toUserId NOT IN (SELECT `blockId` FROM `userblock` where userId='.$userId.') or fromUserId NOT IN (SELECT `blockId` FROM `userblock` where userId='.$userId.')', NULL, FALSE);
        if($filter != '') $this->db->where($filter);
        if ($limit)
            $this->db->limit($limit, 0);
        $a = $this->db->get('usermessage')->result();

        //print $this->db->last_query();
        return $a;
    }

    public function getMessageById($msgid) {
        if (!$msgid) {
            return false;
        }
        $where = array("messageId" => $msgid);
        return $this->get_where($where, true);
    }
    
    public function messageUpdate($data,$selMsg){
        
        $this->db->where_in('messageID', $selMsg);
        //$this->db->update('user', $data);
        $this->db->update("usermessage", $data);
    }

}

?>
