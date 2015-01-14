<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {
	
	protected $_table_name = '';
	protected $_primary_key = 'id';
	protected $_primary_filter = 'intval';
	protected $_order_by = '';
	public $rules = array();
	protected $_timestamps = TRUE;
	protected $_userstamp = FALSE;
	
	
	function __construct()
    {
        parent::__construct();
    }
    
   	public function get($id = NULL, $single =  NULL) {
    
    	if( $id != NULL ) {
    		
    		$filter = $this->_primary_filter;
    		$id = $filter($id); 
			$this->db->where($this->_primary_key, $id);
			$method = 'row';
    	}
    	elseif($single == TRUE) {
    		$method = 'row';
    	} 
    	else {
    		$method = 'result';
    	}
    	
    	if(!count($this->db->ar_orderby)) {
    		$this->db->order_by($this->_primary_key);//_order_by
    	}    	
    	return $this->db->get($this->_table_name)->$method();

    }
    
    
    public function get_where($where,  $single =  NULL) {
    	$this->db->where($where);
    	return $this->get(NULL, $single);
    }
    

    public function save($data, $id = NULL) {
		
		// Set Timestamps 
		
		if($this->_timestamps == TRUE) {
			$now =  date('Y-m-d H:i:s');
			$id || $data['createdDate'] = $now;
			//$data["modified_date"] = $now;
		}
		
		
		// Set User Stamps 
		
		if($this->_userstamp == TRUE) {
			$username =  $this->session->userdata("username");
			if($username) $data['UserId'] = $username;
		}
		

    	// Inserting the data of ID is not provided
    	if( $id === NULL ) {
    		!isset($data[$this->_primary_key]) || $data[$this->_primary_key] = NULL;
    		$this->db->set($data);
    		$this->db->insert($this->_table_name);
    		$id = $this->db->insert_id();
    		
    	} 
    	// Update the record data for ID if provided
    	else {
    		$filter = $this->_primary_filter;
    		$id = $filter($id);
    		$this->db->set($data);
    		$this->db->where($this->_primary_key, $id);
    		$this->db->update($this->_table_name);    		
    	}
    	
    	return $id;
    	
    }
    
    
    public function delete($id) {
    	$filter = $this->_primary_filter;
    	$id = $filter($id);
    	
    	if( ! $id ) {
    		return FALSE;
    	}
    	$this->db->where($this->_primary_key, $id);
    	$this->db->limit(1);
    	$this->db->delete($this->_table_name);  
    }
	
 	public function update($data, $where) {
 		
 		if($this->_timestamps == TRUE) {
			$now =  date('Y-m-d H:i:s');
			$data["modified_date"] = $now;
		}
        $this->db->set($data);
    	$this->db->where($where);
    	$this->db->update($this->_table_name); 
    }
    
    public function delete_where($where) {
    	$this->db->where($where);
    	$this->db->delete($this->_table_name);  
    }
	
    
}