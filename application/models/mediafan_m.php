<?php

class Mediafan_m extends MY_Model
{
	protected $_table_name = 'mediafan';
	protected $_primary_key  = 'mediafanid';
	
	protected $_order_by = 'position';
	public $rules = array(
		'eventTitle' => array(
			'field' => 'eventTitle', 
			'label' => 'Event Title', 
			'rules' => 'trim|required|xss_clean'
		)
	);

}
