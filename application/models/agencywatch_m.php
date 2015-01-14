<?php

class Agencywatch_m extends MY_Model
{
	protected $_table_name = 'agencywatch';
	protected $_primary_key  = 'agencywatchid';
	
	protected $_order_by = 'position';
	public $rules = array(
		'eventTitle' => array(
			'field' => 'eventTitle', 
			'label' => 'Event Title', 
			'rules' => 'trim|required|xss_clean'
		)
	);

}
