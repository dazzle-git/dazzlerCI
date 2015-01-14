<?php

class Events_m extends MY_Model
{
	protected $_table_name = 'events';
	protected $_primary_key  = 'eventsid';
	
	protected $_order_by = 'position';
	public $rules = array(
		'eventTitle' => array(
			'field' => 'eventTitle', 
			'label' => 'Event Title', 
			'rules' => 'trim|required|xss_clean'
		)
	);

}
