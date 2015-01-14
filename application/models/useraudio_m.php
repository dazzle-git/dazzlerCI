<?php

class Useraudio_m extends MY_Model
{
	protected $_table_name = 'useraudio_m';
	protected $_primary_key  = 'useraudioid';
	
	protected $_order_by = 'position';
	public $rules = array(
		'eventTitle' => array(
			'field' => 'eventTitle', 
			'label' => 'Event Title', 
			'rules' => 'trim|required|xss_clean'
		)
	);

}
