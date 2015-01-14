<?php

class Agencyteammember_m extends MY_Model
{
	protected $_table_name = 'agencyteammember';
	protected $_primary_key  = 'agencyteammemberid';
	
	protected $_order_by = 'position';
	public $rules = array(
		'eventTitle' => array(
			'field' => 'eventTitle', 
			'label' => 'Event Title', 
			'rules' => 'trim|required|xss_clean'
		)
	);

}
