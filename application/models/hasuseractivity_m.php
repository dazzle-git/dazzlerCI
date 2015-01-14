<?php

class Hasuseractivity_m extends MY_Model
{
	protected $_table_name = 'hasuseractivity';
	protected $_primary_key  = 'hasuseractivityid';
	
	protected $_order_by = 'position';
	public $rules = array(
		'eventTitle' => array(
			'field' => 'eventTitle', 
			'label' => 'Event Title', 
			'rules' => 'trim|required|xss_clean'
		)
	);

}
