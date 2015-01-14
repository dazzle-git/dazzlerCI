<?php

class Pages_m extends MY_Model
{
	protected $_table_name = 'pages';
	protected $_primary_key  = 'pagesid';
	
	protected $_order_by = 'position';
	public $rules = array(
		'eventTitle' => array(
			'field' => 'eventTitle', 
			'label' => 'Event Title', 
			'rules' => 'trim|required|xss_clean'
		)
	);

}
