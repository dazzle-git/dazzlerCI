<?php

class Tag_m extends MY_Model
{
	protected $_table_name = 'tag_m';
	protected $_primary_key  = 'tagid';
	
	protected $_order_by = 'position';
	public $rules = array(
		'eventTitle' => array(
			'field' => 'eventTitle', 
			'label' => 'Event Title', 
			'rules' => 'trim|required|xss_clean'
		)
	);
        public function tagSave($userid) {
            $data = array();
            $data['tagName'] = $this->input->post('tags');
            $data['userId'] = $userid;
            $data['status'] = "active";
            $data['createdDate'] = date('Y-m-d h:m:s');
            //print $data;exit;
            $this->db->insert('tag', $data);
            $insert_id = $this->db->insert_id();
            
            return $insert_id;
            //$data['tag'] = 
	}
}
