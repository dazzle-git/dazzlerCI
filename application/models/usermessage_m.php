<?php

class Usermessage_m extends MY_Model {

    protected $_table_name = 'usermessage';
    protected $_primary_key = 'messageID';
    protected $_order_by = 'messageID';
    public $rules = array(
        'eventTitle' => array(
            'field' => 'eventTitle',
            'label' => 'Event Title',
            'rules' => 'trim|required|xss_clean'
        )
    );

    

}
