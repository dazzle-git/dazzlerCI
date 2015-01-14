<?php

class Userview_m extends MY_Model
{
	protected $_table_name = 'userview_m';
	protected $_primary_key  = 'userviewid';
	
	protected $_order_by = 'position';
	public $rules = array(
		'eventTitle' => array(
			'field' => 'eventTitle', 
			'label' => 'Event Title', 
			'rules' => 'trim|required|xss_clean'
		)
	);

}
