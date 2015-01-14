<?php

class Userblock_m extends MY_Model
{
	protected $_table_name = 'userblock_m';
	protected $_primary_key  = 'userblockid';
	
	protected $_order_by = 'position';
	public $rules = array(
		'eventTitle' => array(
			'field' => 'eventTitle', 
			'label' => 'Event Title', 
			'rules' => 'trim|required|xss_clean'
		)
	);

}
