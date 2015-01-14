<?php

class Useractivity_m extends MY_Model
{
	protected $_table_name = 'useractivity_m';
	protected $_primary_key  = 'useractivityid';
	
	protected $_order_by = 'position';
	public $rules = array(
		'eventTitle' => array(
			'field' => 'eventTitle', 
			'label' => 'Event Title', 
			'rules' => 'trim|required|xss_clean'
		)
	);

}
