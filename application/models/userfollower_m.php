<?php

class Userfollower_m extends MY_Model
{
	protected $_table_name = 'userfollower';
	protected $_primary_key  = 'followId';
	
	protected $_order_by = 'followId';
 
	
	function getUserFollower($userid) {
		
		$this->db->where("userId", $userid);
		return $this->get();
		
	}
	
	
	function getUserFollowing($userid) {
		$this->db->where("followerId", $userid);
		return $this->get();
	}
        
        function delete($followId) {
            $this->db->where('followId', $followId);
            $this->db->delete('userfollower');
            return 1;
        }
}	
