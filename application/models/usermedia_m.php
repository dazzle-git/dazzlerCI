
<?php

class Usermedia_m extends MY_Model
{
	protected $_table_name = 'usermedia';
	protected $_primary_key  = 'mediaId';
	
	protected $_order_by = 'noView';
	public $rules = array(
		'eventTitle' => array(
			'field' => 'eventTitle', 
			'label' => 'Event Title', 
			'rules' => 'trim|required|xss_clean'
		)
	);
	
	
	function getTopContents($limit = null) {
		$this->db->select(" *, (select  concat(firstname, ' ', lastname) from user where user.userId=usermedia.userId) as fullname", false);
		$this->db->order_by("noView", "desc");
		$this->db->order_by("noLike", "desc");
		if($limit) $this->db->limit($limit);
		$retarray  =  $this->get();
		return $retarray;		
	}
	
	public function setRestrict($id) {
        $this->load->helper('string');
        $where=array('mediaId'=> $id);
		$retarray  =  $this->get_where($where);
		//print_r($retarray);exit;
		$notify = ($retarray[0]->restrict == 1) ? 0 : 1;
        $data = array(
            'restrict' => $notify            
        );
        $this->db->where('mediaId', $id);
        $this->db->update('usermedia', $data);
        //print $this->db->last_query();
        //return $rs;
    }
	
	
	function getUserUploads($userid) {
		$where= array("userId" => $userid);
		$retarray  =  $this->get_where($where);
		return $retarray;
		
	}
        
        function mediaSave($userid,$tagid,$fileName) {
            $types = array('mpg', 'mpeg', 'mp4', 'avi','ogv','webm','3gp');
            //$data['tag'] = 
            $data = array();
            $data['videoName'] = $this->input->post('title');
            $data['userId'] = $userid;
            $data['tagId'] = $tagid;
            $data['description'] = $this->input->post('descr');
            $data['createdDate'] = date('Y-m-d h:m:s');
            $data['bigSizeFile'] = $fileName;
            list($file,$ext) = explode('.',$fileName);
            if(in_array($ext, $types)){
                    $data['uploadtype'] = 'Video';
                    $data['smallSizeFile'] = $file.'.jpg';
            }
                else {
                    $data['uploadtype'] = 'Audio';
                }
            //print $data;exit;
            $this->db->insert('usermedia', $data);
            //$insert_id = $this->db->insert_id();
            
            //return $insert_id;
	}
	
        function mediaDelete($mediaId) {
            $this->db->where('mediaId', $mediaId);
            $this->db->delete('usermedia');
            return 1;
        }
        
	function getMedia($mediaid) {
		$this->db->select(" *, (select  concat(firstname, ' ', lastname) from user where user.userId=usermedia.userId) as fullname", false);
		$this->db->order_by("noView", "desc");
		$this->db->order_by("noLike", "desc");
		$retarray  =  $this->get_where(array("mediaId" => $mediaid));
		return $retarray;		
	}

        function getMediaBySearch() {
                $searchTxt = $this->input->post('searchTxt');
		$this->db->select(" *, (select  concat(firstname, ' ', lastname) from user where user.userId=usermedia.userId) as fullname", false);
		$this->db->order_by("noView", "desc");
		$this->db->order_by("noLike", "desc");
                $this->db->like('videoName',$searchTxt);
		$retarray = $this->db->get("usermedia")->result();
                //print $this->db->last_query();
		return $retarray;		
	}
	function getRelatedContents($limit = 5) {
		$this->db->select(" *, (select  concat(firstname, ' ', lastname) from user where user.userId=usermedia.userId) as fullname", false);
		$this->db->order_by("noView", "desc");
		$this->db->order_by("noLike", "desc");
		if($limit) $this->db->limit($limit);
		$retarray  =  $this->get();
		return $retarray;		
	}
	
	function getFeeds($lastid = NULL, $limit = NULL,$ids) {
		$selectarray = array (
			"*",
			" (select  concat(firstname, ' ', lastname) from user where user.userId=usermedia.userId) as fullname"
		);
		$this->db->select($selectarray, false);
                $this->db->where_in('userId',$ids);
		if($limit) $this->db->limit($limit);
		$retarray  =  $this->get();
		return $retarray;
	}
        
        function getAllMedia($start,$limit) {	
                $this->db->limit($limit,$start);
		$retarray  =  $this->get();
                //print $this->db->last_query();
		return $retarray;
		
	}
        
        function getAllMediaCnt() {	
                
		$retarray  =  $this->get();
                //print $this->db->last_query();
		return count($retarray);
		
	}
}
