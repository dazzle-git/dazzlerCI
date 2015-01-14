<?php

class Language_m extends MY_Model
{
	protected $_table_name = 'language';
	protected $_primary_key  = 'languageid';
	
	protected $_order_by = 'position';
	public $rules = array(
		'eventTitle' => array(
			'field' => 'eventTitle', 
			'label' => 'Event Title', 
			'rules' => 'trim|required|xss_clean'
		)
	);

}
