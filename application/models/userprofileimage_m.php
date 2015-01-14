<?php

class Userprofileimage_m extends MY_Model
{
	protected $_table_name = 'userprofileimage';
	protected $_primary_key  = 'userprofileimageId';
	
	protected $_order_by = 'userprofileimageId desc';
	 
	
	
	function getByUserId($userid) {
		$this->db->where("userId", $userid);
		return $this->get();		
	}
}
