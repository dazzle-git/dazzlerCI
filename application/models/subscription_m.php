<?php

class Subscription_m extends MY_Model
{
	protected $_table_name = 'subscription';
	protected $_primary_key  = 'subscriptionid';
	
	protected $_order_by = 'position';
	public $rules = array(
		'eventTitle' => array(
			'field' => 'eventTitle', 
			'label' => 'Event Title', 
			'rules' => 'trim|required|xss_clean'
		)
	);

}
