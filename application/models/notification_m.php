<?php

class Notification_m extends MY_Model
{
	protected $_table_name = 'notification';
	protected $_primary_key  = 'notificationid';
	
	protected $_order_by = 'notificationId desc';
	public $rules = array(
		'eventTitle' => array(
			'field' => 'eventTitle', 
			'label' => 'Event Title', 
			'rules' => 'trim|required|xss_clean'
		)
	);


	function getNotification($userid, $lastid = null, $limit = null) {
		$this->db->select("type,mediaId,mediaType, count(*) as cnt, max(sendDateTime) as dt ");
		$this->db->where("recipientId", $userid);
		if($lastid) $this->db->where("notificationId >", $lastid);
		if($limit) $this->db->limit($limit);
		$this->db->group_by("type, mediaId,mediaType");
		$this->db->order_by("dt desc");
		$notifarray = $this->get();
		return $notifarray;	
	}
	
	function completeNotification($notifarray, $userid) {
		foreach($notifarray as $nf) {
			$this->db->select("*, (select  concat(firstname, ' ', lastname) from user where user.userId=notification.senderId) as fullname ", false);
			$this->db->where("recipientId", $userid);
			$this->db->where("mediaId", $nf->mediaId);
			$this->db->where("mediaType", $nf->mediaType);
			$this->db->where("type", $nf->type);
			$nf->rows = $this->get();						
		}
		return $notifarray;
	}
	
	
}
