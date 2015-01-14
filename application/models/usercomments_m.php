<?php

class Usercomments_m extends MY_Model
{
	protected $_table_name = 'usercomments';
	protected $_primary_key  = 'cId';
	
	protected $_order_by = 'cId desc';
	public $rules = array(
		'eventTitle' => array(
			'field' => 'eventTitle', 
			'label' => 'Event Title', 
			'rules' => 'trim|required|xss_clean'
		)
	);
	
	
	
	public function mediaComments($mediaid, $lastid=null, $limit = 4 ) {
		$selectarray = array (
				"*",
				" (select  concat(firstname, ' ', lastname) from user where user.userId=usercomments.userId) as fullname "
		);		
		$this->db->select($selectarray, false);		
		$this->db->where("mediaId",$mediaid);
		
		if($lastid) $this->db->where("cId >",$lastid);
		if($limit) $this->db->limit($limit);
		
		$a = $this->get();
                //print $this->db->last_query();
                return $a;
	}
        
        public function fetchAll($mediaid, $lastid=null ) {
		$selectarray = array (
				"*",
				" (select  concat(firstname, ' ', lastname) from user where user.userId=usercomments.userId) as fullname "
		);		
		$this->db->select($selectarray, false);		
		$this->db->where("mediaId",$mediaid);
		
		if($lastid) $this->db->where("cId >",$lastid);
		
		
		$a = $this->get();
                //print $this->db->last_query();
                return $a;
	}
        
        public function fetchPortion($mediaid, $start, $lastid=null ) {
		$selectarray = array (
				"*",
				" (select  concat(firstname, ' ', lastname) from user where user.userId=usercomments.userId) as fullname "
		);		
		$this->db->select($selectarray, false);		
		$this->db->where("mediaId",$mediaid);
		
		if($lastid) $this->db->where("cId >",$lastid);
		if($start) $this->db->limit(4,$start);
		
		$a = $this->get();
                //print $this->db->last_query();
                return $a;
	}
        
        public function saveComments($userid){
            $data['mediaId'] = $this->input->post('medid');
            $data['text'] = $this->input->post('ucomment');
            $data['userId'] = $userid;
            $data['createdDate'] = date('Y-m-d h:m:s');
            
            $this->db->insert('usercomments', $data);
        }

}
