<?php

class Reportabuse_m extends MY_Model
{
	protected $_table_name = 'reportabuse';
	protected $_primary_key  = 'reportabuseid';
	
	protected $_order_by = 'position';
	public $rules = array(
		'eventTitle' => array(
			'field' => 'eventTitle', 
			'label' => 'Event Title', 
			'rules' => 'trim|required|xss_clean'
		)
	);

}
