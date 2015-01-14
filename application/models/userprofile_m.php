<?php

class Userprofile_m extends MY_Model {

    protected $_table_name = "userProfile";
    protected $_primary_key = 'userProfileId';
    protected $_order_by = 'userProfileId';

    function getProfile($userid) {
        $selectArr = array(
            "*",
            " (select countryName from country where country.countryId=userProfile.country) as countryname ",
            " (select tCategoryName from talentCategory where talentCategory.tCategoryId=userProfile.tCategoryId) as CategoryName "
        );

        $this->db->select($selectArr, false);

        $this->db->where("userId", $userid);
        $retArray = $this->db->get($this->_table_name)->row();
        return $retArray;
    }

    function getSimilar($tcatId,$userid) {
        
        $this->db->where("tCategoryId", $tcatId);
        $this->db->where("userId !=", $userid);
        $retArray = $this->db->get($this->_table_name)->result();
        //print $this->db->last_query();
        return $retArray;
    }

}
