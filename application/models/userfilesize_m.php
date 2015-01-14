<?php

class Userfilesize_m extends MY_Model
{
	protected $_table_name = 'userfilesize_m';
	protected $_primary_key  = 'userfilesizeid';
	
	protected $_order_by = 'position';
	public $rules = array(
		'eventTitle' => array(
			'field' => 'eventTitle', 
			'label' => 'Event Title', 
			'rules' => 'trim|required|xss_clean'
		)
	);

}
