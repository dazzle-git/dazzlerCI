<?php

class Userexperiance_m extends MY_Model
{
	protected $_table_name = 'userexperiance_m';
	protected $_primary_key  = 'userexperianceid';
	
	protected $_order_by = 'position';
	public $rules = array(
		'eventTitle' => array(
			'field' => 'eventTitle', 
			'label' => 'Event Title', 
			'rules' => 'trim|required|xss_clean'
		)
	);

}
