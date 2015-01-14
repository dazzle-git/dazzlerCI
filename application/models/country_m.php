<?php

class Country_m extends MY_Model
{
	protected $_table_name = 'country';
	protected $_primary_key  = 'countryid';
	
	protected $_order_by = 'position';
	public $rules = array(
		'eventTitle' => array(
			'field' => 'eventTitle', 
			'label' => 'Event Title', 
			'rules' => 'trim|required|xss_clean'
		)
	);

}
