<?php

class Settings_m extends MY_Model
{
	protected $_table_name = 'settings';
	protected $_primary_key  = 'settingsid';
	
	protected $_order_by = 'position';
	public $rules = array(
		'eventTitle' => array(
			'field' => 'eventTitle', 
			'label' => 'Event Title', 
			'rules' => 'trim|required|xss_clean'
		)
	);

}
