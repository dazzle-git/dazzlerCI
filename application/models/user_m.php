<?php

class User_m extends MY_Model {

    protected $_table_name = 'user';
    protected $_primary_key = 'userid';
    protected $_order_by = "userid";
    public $rules = array(
        'eventTitle' => array(
            'field' => 'eventTitle',
            'label' => 'Event Title',
            'rules' => 'trim|required|xss_clean'
        )
    );
    protected $userid = null;

    public function saveData(array $data) {
        $data['oauthProvider'] = "";
        $data['createdDate'] = date('Y-m-d H:i:s');
        $data['updatedDate'] = date('Y-m-d H:i:s');
        return $this->save($data);
    }

    public function checkDuplicateEmail($post_email) {
        //print "Entered ";exit;
        $this->db->where('userEmail', $post_email);

        $query = $this->db->get('user');

        $count_row = $query->num_rows();
        //print $count_row;exit;
        if ($count_row > 0) {
            //if count row return any row; that means you have already this email address in the database. so you must set false in this sense.
            return FALSE; // here I change TRUE to false.
        } else {
            // doesn't return any row means database doesn't have this email
            return TRUE; // And here false to TRUE
        }
    }

    public function add_user() {
        $password = $this->input->post('pass');
        //print "Pass".$password."<br>";

        $salt = getUniqueCode(20);
        $encPwd = sha1($password . $salt);
        $pass = $encPwd;
        //print $salt."    ";
        //print $encPwd;exit;
        $data = array(
            'userEmail' => $this->input->post('user_email'),
            'password' => $encPwd,
            'salt' => $salt,
            'oauthProvider' => "",
            'status' => "Active",
            'uniqueFlag' => "N"
        );
        //print_r($data);exit;
        $this->db->insert('user', $data);
    }

    public function facebook_user($data) {
        $data['status'] = "Active";
        $data['uniqueFlag'] = "N";
        $this->db->insert('user', $data);
    }

    public function twitter_user($data) {
        $data['status'] = "Active";
        $data['uniqueFlag'] = "N";
        //print $data;exit;
        $this->db->insert('user', $data);
        //print $this->db->last_query();
        //exit;
    }

    public function googlelogin() {
        require 'openid.php';
        $openid = new LightOpenID("dazzler");

        if ($openid->mode) {
            if ($openid->mode == 'cancel') {
                //echo "User has canceled authentication !";
                $out['error'] = "Cancel";
            } elseif ($openid->validate()) {
                $data = $openid->getAttributes();
                $email = $data['contact/email'];
                $first = $data['namePerson/first'];
                $last = $data['namePerson/last'];
                //          header("Location: http://speechwithmilo.com/speechtherapy/adminpanel/");
                list($url, $oauId) = explode('=', $openid->identity);
                /* echo "Identity : $openid->identity <br />";
                  echo "Email : $email <br />";
                  echo "First name : $first";
                  echo "<pre>"; print_r($data); echo "</pre>"; */
                $dataInfo['userEmail'] = $email;
                $dataInfo['oauthId'] = $oauId;
                $dataInfo['oauthProvider'] = "google";
                $dataInfo['firstName'] = $first;
                $dataInfo['lastName'] = $last;
                $dataInfo['status'] = "Active";
                $dataInfo['uniqueFlag'] = "N";
                if ($this->checkDuplicateEmail($email)) {
                    $this->db->insert('user', $dataInfo);
                }
                $out['email'] = $email;
                $out['error'] = '';
//              echo "<meta http-equiv = 'refresh' content = '0; url=http://speechwithmilo.com/speechtherapy/adminpanel/'>";
            } else {
                //echo "The user has not logged in";
                $out['error'] = "LogError";
            }
        } else {
            //echo "Go to the login page to logged in";
            $out['error'] = "RedirectLogin";
        }
        return $out;
    }

    public function googleApi($dataInfo) {
        $email = $dataInfo['userEmail'];
        $dataInfo['oauthProvider'] = "google";
        $dataInfo['status'] = "Active";
        $dataInfo['uniqueFlag'] = "N";
        if ($this->checkDuplicateEmail($email)) {
            $this->db->insert('user', $dataInfo);
        }
        $out['email'] = $email;
    }

    public function saveToken($email) {
        $this->load->helper('string');
        $rs = random_string('alnum', 12);

        $data = array(
            'forgotPasswordToken' => $rs
        );
        $this->db->where('userEmail', $email);
        $this->db->update('user', $data);
        return $rs;
    }

    public function removeToken($rs, $password) {
        $this->load->helper('string');
        $salt = getUniqueCode(20);
        $encPwd = sha1($password . $salt);
        $pass = $encPwd;
        $data = array(
            'password' => $encPwd,
            'salt' => $salt,
            'forgotPasswordToken' => ''
        );
        $this->db->where('forgotPasswordToken', $rs);
        $this->db->update('user', $data);
        //print $this->db->last_query();
        //return $rs;
    }

    public function verifyLoginInfo($user, $pass, $rememberMe = null) {

        $this->db->where("userEmail", $user);
        $this->db->where("password", "sha1(CONCAT('$pass', salt))", FALSE);
        $this->db->where("status", "Active");
        $this->db->where("uniqueFlag", "N");
        $result = $this->db->get("user")->result();
        //print $this->db->last_query();exit;
        if (count($result) == 1) {
            $userid = $result[0]->userId;
            if (isset($rememberMe) && $rememberMe == 1) {
                setcookie('AUTH_UN', base64_encode($user), time() + 24 * 60 * 60 * 365, '/', false);
                setcookie('AUTH_UP', base64_encode($pass), time() + 24 * 60 * 60 * 365, '/', false);
            } else {
                setcookie('AUTH_UN', base64_encode($user), time() - 24 * 60 * 60 * 365, '/', false);
                setcookie('AUTH_UP', base64_encode($pass), time() - 24 * 60 * 60 * 365, '/', false);
            }
            return true;
        }

        return false;
    }

    function check_oldpassword($oldpass, $user_id) {
        $this->db->where("userId", $user_id);
        $this->db->where("password", "sha1(CONCAT('$oldpass', salt))", FALSE);
        $query = $this->db->get('user'); //data table
        //print $this->db->last_query();
        return $query->num_rows();
        
    }
    
    function changepasswd($password,$user_id) {
        //$this->load->helper('string');
        $this->db->where("userId", $user_id);
        $salt = getUniqueCode(20);
        $encPwd = sha1($password . $salt);
        $pass = $encPwd;
        $data['password'] = $pass;
        $data['salt'] = $salt;
        $a = $this->db->update("user", $data);
        
        //print $this->db->last_query();
        return $a;
    }

    public function changePass($new_password, $user_id) {

        $this->db->where("userId", $user_id);
        $salt = getUniqueCode(20);
        $encPwd = sha1($new_password . $salt);
        $pass = $encPwd;

        $data['password'] = $pass;
        $data['salt'] = $salt;
        return $this->db->update("user", $data);
    }
    
    public function getAllCategoryUserWise($userId, $setId = '') {
        if (empty($setId)) {
            $setId = '';
        }
        $params = array('*', false, 'all', 0, '', '', '', $userId, $setId);
        $stmt = $this->db->query('CALL getListing(?,?,?,?,?,?,?,?,?)', $params);
        return $stmt->result();
    }

    public function checkUserAlreadyBlock($userId) {

        $resultData = array();
        $this->db->where("blockId", $userId);
        $this->db->where("userId", $this->objSess->userId);
        $resultData = $this->db->get("userblock")->result();
        if (empty($resultData)) {
            return true;
        }
        return false;
    }

    public function saveUserBlockData($data) {
        $data['created'] = date('Y-m-d H:i:s');
        $this->db->set($data);
        $this->insert("userblock");
        return $this->db->insert_id();
    }

    public function getBlockUserId($userId) {
        $resultData = array();
        $userIdStr = "";
        $this->db->where("blockId", $userId);
        $this->db->where("userId", $this->objSess->userId);
        $resultData = $this->db->get("userblock")->result();
        if (!empty($result)) {
            $idsArr = array();
            foreach ($resultData as $row) {
                $idsArr[] = $row['blockId'];
            }
            $userIdStr = implode(',', $idsArr);
        }
        return $userIdStr;
    }

    public function getUserFlowDetail($userId) {
        $params = array($userId, 'um.*,CONCAT(u1.firstName , \' \' ,u1.lastName) AS userName,CONCAT(u.firstName , \' \' ,u.lastName) AS uploadedName,MAX(upi.imageName) as userImage,\'Video\' as typeName,\'Like \' as userType,um.userId as uploadedUid,um.bigImage as mediaImage', false, 'video');
        $stmt = $this->_db->query('CALL getUserFlow(?,?,?,?)', $params);
        $rows = $stmt->result();
        return $rows;
    }

    public function getNotificationByRow($notificationId) {
        if (!empty($notificationId)) {
            $this->db->where("notificationId", $notificationId);
        }

        $result = $this->db->get("notification")->result();
        if (empty($result)) {
            return $result;
        } else {
            return array();
        }
    }

    public function getNotificationList($userId) {
        $result = array();
        if (!empty($notificationId)) {
            $this->db->where("notificationId", $notificationId);
        }

        $this->db->join('user as u', 'u.userId = nt.recipientId');
        $this->db->join('userprofileimage as up', 'up.userId = nt.recipientId', 'left');

        if (!empty($userId)) {
            $select->where("nt.senderId = ?", $userId);
        }

        $this->db->where("nt.isRead", 'N');
        $this->db->group_by('nt.notificationId');
        $this->db->order_by('nt.sendDateTime', "DESC");
        $result = $this->db->get("notification as nt")->result();

        if (empty($result)) {
            return $result;
        } else {
            return $result;
        }
    }

    public function updateNotificationList($notificationId, $userId) {
        $data['isRead'] = 'Y';
        $this->db->where('notificationId', $notificationId);
        $this->db->update('notification', $data);
    }

    public function getUserFlowDetailSidePanel($userId) {
        $params = array($userId, '*', false, '');
        $stmt = $this->db->query('CALL getUserFlow(?,?,?,?)', $params);
        $rows = $stmt->result();
        return $rows;
    }

    public function getAllCategoryByLike($data = array()) {
        $data['random_id'] = "most liked";
        return $this->getAllCategory($data);
    }

    public function getAllCategory($data = array(), $search = "") {

        if (empty($data)) {
            $params = array('*', false, 'all', 0, '', '', '', '', '');
        } else {
            $categoryId = 0;
            $talent_type = 'all';
            $tagIds = '';
            $randomIds = '';
            $search = '';
            if (!empty($data['category_id'])) {
                $categoryId = $data['category_id'];
            }
            if (!empty($data['talent_type'])) {
                $talent_type = $data['talent_type'];
            }
            if (!empty($data['allTags'])) {
                $tagIds = implode(',', $data['allTags']);
            }
            if (!empty($data['random_id'])) {
                $randomIds = $data['random_id'];
            }
            $params = array('*', false, $talent_type, $categoryId, $search, $tagIds, $randomIds, '', '');
        }

        $stmt = $this->db->query('CALL getListing(?,?,?,?,?,?,?,?,?)', $params);
        $rows = $stmt->result();
        return $rows;
    }

    public function getDataUser($ucode) {
        $resultData = array();
        $this->db->where("uniqueCode", $ucode);
        $this->db->where("uniqueFlag", 'Y');

        $result = $this->db->get("user");
        $resultData = $result->result();
        return $resultData;
    }

    public function getUpdateUser($userId) {
        $this->db->where("userId", $userId);
        $data['uniqueFlag'] = 'N';
        $data['updatedDate'] = date('Y-m-d H:i:s');
        return $this->db->update("user", $data);
    }

    public function getUserData($user_id) {
        if (!$user_id) {
            return false;
        }
        $where = array("userId" => $user_id);
        return $this->get_where($where, true);
    }

    public function getUserDataByEmail($useremail) {
        if (!$useremail) {
            return false;
        }
        $where = array("userEmail" => $useremail);
        return $this->get_where($where, true);
    }

    public function fetchSocialEntry($id) {
        $this->db->select(array('oauthId', 'oauthProvider', 'twitterOauthToken', 'twitterOauthTokenSecret', 'firstName', 'lastName', 'userEmail', 'userType'));
        $this->db->where("userId", $id);
        $result = $this->db->get("user")->result();

        if (empty($result)) {
            return $result;
        } else {
            return array();
        }
    }

    public function userEventCount($userId) {
        $this->db->select(array('userShow', 'userFriend', 'userFollow', 'userPick', 'userMessage'));
        $this->db->where('userId', $userId);

        $result = $this->db->get("user")->result();

        if (empty($result)) {
            return $result;
        } else {
            return array();
        }
    }

    public function mostFan($lmt = '') {

        $this->db->select(array('u.userId', 'u.firstName', 'u.lastName'));

        $this->db->where("u.userFriend !=", 0);
        $this->db->where("u.verify", 1);
        $this->db->where("u.userType", "Talented User");
        $this->db->where("u.userFriend !=", 0);
        $this->db->order_by("u.userFriend", "DESC");

        if (!empty($lmt)) {
            $this->db->limit($lmt);
        }
        $result = $this->db->get("user as u")->result();

        if (empty($result)) {
            return $result;
        } else {
            return array();
        }
    }

    public function frontSearchData($formdata) {

        echo "Not Completed";
        exit(1);
    }

    /**
     * Get use information for user listing of cPanel
     *
     * @param int $id
     * @return array
     */
    public function userInfo($id) {
        $this->db->select(array('u.userId', 'u.firstName', 'u.lastName', 'u.userType', 'u.oauthProvider', 'u.updatedDate', 'u.createdDate', 'u.lastLoginDate', 'u.fromIP', 'u.online'));
        $this->db->where("u.userId", $id);
        $result = $this->db->get("user as u")->result();
        if (empty($result)) {
            return $result;
        } else {
            return array();
        }
    }

    /**
     * check token generated for forgot password is exist or not
     *
     * @param string $token
     * @return array data
     */
    public function tokenExist($token) {

        $this->db->where("forgotPasswordToken", $token);
        $this->db->where("status", "Active");

        $result = $this->db->get("user")->result();

        if (empty($result)) {
            return $result;
        } else {
            return array();
        }
    }

    public function setDelete($data) {
        $ids = implode(",", $data['user']);
        $idsArray = $data["user"];
        $status = $data['status'];
        unset($data);

        if (!empty($ids)) {
            $this->db->where_in('userId', $idsArray);
            $data['status'] = $status;
            return $this->update("user", $data);
        } else {
            return false;
        }
    }

    public function setStatus($data) {
        $ids = implode(",", $data['user']);
        $idsArray = $data["user"];
        $status = $data['status'];
        unset($data);

        if (!empty($ids)) {
            $this->db->where_in('userId', $idsArray);
            $data['status'] = $status;
            return $this->update("user", $data);
        } else {
            return false;
        }
    }

    public function getTotalUsersRegistered() {
        $from = date("Y-m-d") . " 00:00:01";
        $to = date("Y-m-d") . " 24:00:00";

        $this->db->select(array('count(u.userId) AS TotUsers'));
        $this->db->where("status", "Active");
        $this->db->where("createdDate >=", $from);
        $this->db->where("createdDate <=", $to);
        $result = $this->db->get("user as u")->result();

        if (empty($result)) {
            return 0;
        } else {
            return $result[0]['TotUsers'];
        }
    }

    public function getTotalUsers($online = false) {

        $this->db->select(array('count(u.userId) AS TotUsers'));
        $this->db->where("status", "Active");
        if ($online) {
            $this->db->where("online", "Yes");
        }
        $this->db->where("createdDate <=", $to);
        $result = $this->db->get("user as u")->result();
        if (empty($result)) {
            return 0;
        } else {
            $totUsers = $result->toArray();
            return $totUsers[0]['TotUsers'];
        }
    }

    public function verifyUser($status, $user_id) {
        $this->db->where("userId", $user_id);
        $data['verify'] = $status;
        return $this->update("user", $data);
    }

    public function checkPassword($userId, $password) {

        $this->db->where("userId", $userId);
        $this->db->where("password", "sha1(CONCAT('$pass', salt))", FALSE);
        $this->db->where("status", "Active");
        $result = $this->db->get("user")->result();
        if (count($result) == 1) {
            return true;
        }
        return false;
    }

    /* ----------------------| Change User status  |----------------------------- */

    public function changeStatus($status, $user_id) {
        $this->db->where("userId", $user_id);
        $data['status'] = $status;
        return $this->update("user", $data);
    }

    /* ----------------------| fetch row data by id  |----------------------------- */

    public function fetchEntry($id) {
        $this->db->where("userId", $id);
        $result = $this->db->get("user")->result();
        if (empty($result)) {
            return $result;
        } else {
            return array();
        }
    }

    public function unreadMsgCnt(array $data, $id) {
        $this->db->where("userId", $id);
        return $this->update("user", $data);
    }

    /* ----------------------| update data  |----------------------------- */

    public function updateData(array $data, $user_id) {
        $this->db->where("userId", $user_id);
        $fields = $this->info($this->getConstCol());
        foreach ($data as $field => $value) {
            if (!in_array($field, $fields)) {
                unset($data[$field]);
            } else {
                $data[$field] = trim($value);
            }
        }
        $data['updatedDate'] = date('Y-m-d H:i:s');
        return $this->update("user", $data);
    }

    public function deleteUserStatus($id) {
        $this->db->where("userId", $id);
        $data['status'] = 'Deleted';
        return $this->update("user", $data);
    }

    public function getAllUserListdatatablegrid($columns, $sWhere, $sOrder, $sLimit) {
        echo "not completed";
        exit(1);
    }

    public function getAllUserListgrid($where, $sorting, $rp, $start) {
        echo "not completed";
        exit(1);
    }

    public function getAllUserListLimit($where, $sorting, $rp, $start) {

        $this->db->select(array('u.*, DATE_FORMAT(u.createdDate,"%d-%m-%Y") as registered_date'));
        $this->db->where($where);
        $this->db->order_by($sorting);
        $this->db->limit($rp, $start);
        $result = $this->db->get("user as u")->result();
        return $result;
    }

    /* ----------------------| fetch all data from searching parameters  |--------------- */

    public function getUserList($usertype = '', $searchText = '', $searchText1 = '', $srchuser_type = '', $sortby = '') {

        switch ($sortby) {
            case 'A1':
                $strSort = "firstName ASC";
                break;
            case 'D1':
                $strSort = "firstName DESC";
                break;
            case 'A2':
                $strSort = "userType ASC";
                break;
            case 'D2':
                $strSort = "userType DESC";
                break;
            case 'A3':
                $strSort = "userEmail ASC";
                break;
            case 'D3':
                $strSort = "userEmail DESC";
                break;
            case 'A5':
                $strSort = "status ASC";
                break;
            case 'D5':
                $strSort = "status DESC";
                break;
            case 'A6':
                $strSort = "registered_date ASC";
                break;
            case 'D6':
                $strSort = "registered_date DESC";
                break;
            default:
                $strSort = " userId DESC";
                break;
        }

        if ($usertype == 'Agency') {
            $this->db->select(array('u.*, DATE_FORMAT(u.createdDate,"%d-%m-%Y") as registered_date'));
            $this->db->join("subscription as s ", "s.subscriptionId = u.subscriptionId", "left");
            $this->db->where("u.userType", "Agency");
        } else {
            $this->db->select(array('u.*, DATE_FORMAT(u.createdDate,"%d-%m-%Y") as registered_date'));
            if ($srchuser_type != '') {
                $this->db->where("u.userType", $srchuser_type);
                $this->db->or_where("u.oauthProvider", $srchuser_type);
            }
            $this->db->where(('u.userType != "Agency"'));
        }

        if ($searchText != 'Name' && $searchText != '') {
            $this->db->where('u.firstName  like  "%' . $searchText . '%" OR u.lastName  like  "%' . $searchText . '%" OR u.userEmail  like  "%' . $searchText . '%"', null, false);
        }

        $this->db->order_by($strSort);
        $this->db->where("u.status !=", "Deleted");
        return $this->db->get("user")->result();
    }

    /* ----------------------| check Visitor Exist |--------------- */

    public function checkVisitorExist($user_id) {
        $this->db->select(array('userId'));
        $this->db->where("status !=", "Deleted");
        $this->db->where("oauthId", $user_id);
        $return = $this->db->get("user")->result();

        if (!empty($return))
            return array();
        else
            return $return;
    }

    /* ----------------------| check Visitor email existence  |--------------- */

    public function checkVisitorEmailExisted($emailId, $user_id = "") {

        $this->db->select("*");

        if ($user_id) {
            $this->db->where("userEmail", $emailId);
            $this->db->where("status !=", "Deleted");
            $this->db->where("oauthId !=", $user_id);
        } else {
            $this->db->where("userEmail", $emailId);
            $this->db->where("status !=", "Deleted");
        }

        $select = $this->db->get("user")->result();

        if (count($select) >= 1)
            return 1;
        else
            return 0;
    }

    public function checkEmailExisted($emailId, $user_id = "") {

        $this->db->select("*");

        if ($user_id) {
            $this->db->where("userEmail", $emailId);
            $this->db->where("status !=", "Deleted");
            $this->db->where("oauthId !=", $user_id);
        } else {
            $this->db->where("userEmail", $emailId);
            $this->db->where("status !=", "Deleted");
        }

        $select = $this->db->get("user")->result();

        if (count($select) >= 1)
            return 1;
        else
            return 0;
    }

    public function setLastActivity($userId) {
        $data['online'] = 'Yes';
        $data['lastActivity'] = time();
        $this->db->where("userId", $userId);
        return $this->update("user", $data);
    }

    public function checkemail($email) {

        $this->db->where("userEmail", $email);
        $this->db->where("status", "Active");
        $result = $this->db->get("user")->result();
        if (count($result))
            return $result;
        else
            return array();
    }
    
    public function checkUser($user_id) {

        $this->db->where("userId", $user_id);
        $this->db->where("status", "Active");
        $result = $this->db->get("user")->result();
        if (count($result) > 0)
            return 1;
        else
            return 0;
    }
    
    public function checkEmailSuggest($userEmail) {
        //print "OKKK";
        $this->db->like('userEmail', $userEmail);
        $result = $this->db->get("user")->result();
        //print $this->db->last_query();exit;
        return $result;
    }

    public function getLazyUsers($TimeLimit) {
        $TimeOut = time() - $TimeLimit;

        $this->db->where("online", "Yes");
        $this->db->where("lastActivity<=", $TimeOut);
        $result = $this->db->get("user")->result();
        if (empty($result)) {
            return false;
        } else {
            return array();
        }
    }

    public function setOnline($userId) {
        $this->db->where('userId', $userId);
        $data['online'] = 'Yes';
        $data['lastLoginDate'] = date('Y-m-d H:i:s');
        $data['lastActivity'] = time();
        return $this->db->update("user", $data);
    }

    public function setOffline($userId) {
        $this->db->where('userId', $userId);
        $data['online'] = 'No';
        return $this->update("user", $data);
    }

    public function authenticate($user, $pass) {
        $userid = null;
        $authFlg = $this->verifyLoginInfo($user, $pass);
        if ($authFlg) {
            return $userid;
        } else {
            return false;
        }
    }

    public function updateLastLogin($id) {
        $this->db->where('userId', $id);
        $data['fromIP'] = $_SERVER['REMOTE_ADDR'];
        $data['lastLoginDate'] = date('Y-m-d H:i:s', time());
        return $this->db->update("user", $data);
    }

    public function clearSession() {

        echo "not completed";
        exit(1);
        $userId = $this->objSess->userId;

        $this->_auth->clearIdentity();

        if ($this->objSess->userType == 'Visitor') {
            if ($this->objSess->userVisitorType == 'google') {
                $gClient = new NIC_src_Client();
                unset($_SESSION['token']);
                $gClient->revokeToken();
            }
            if ($this->objSess->userVisitorType == 'facebook') {
                $facebook = new NIC_Facebook_Oauth(array(
                    'appId' => APP_ID,
                    'secret' => APP_SECRET,
                ));

                $facebook->clearAllPersistentData();
            }
            $this->objSess->userVisitorType = '';
            unset($this->objSess->userVisitorType);
        }
        $this->objSess->userId = "";
        $this->objSess->username = "";
        $this->objSess->userType = "";
        $this->objSess->userImage = "";
        $this->objSess->isFrontLogin = false;
        $this->objSess->searchData = "";
        $this->objSess->userBlockId = "";
        unset($this->objSess->userId);
        unset($this->objSess->username);
        unset($this->objSess->userType);
        unset($this->objSess->userImage);
        unset($this->objSess->isFrontLogin);

        $this->clearObjSess();

        //$this->setOffline($userId);

        /* $this->objError->message = $this->translate('LOGOUT_SUCCESS');
          $this->objError->messageType = 'confirm'; */

        unset($userId);
    }

    public function getProfileImage($userId) {
        $this->db->select(array('imageName'));
        $this->db->where("userId", $userId);
        $this->db->order_by("userprofileimageId", "DESC");
        $result = $this->db->get("userprofileimage")->result();
        if (empty($result)) {
            return $result;
        } else {
            return array();
        }
    }

    public function getProfileImageLatest($userId) {
        $this->db->select(array('imageName'));
        $this->db->where("userId", $userId);
        $this->db->order_by("userprofileimageId", "DESC");
        $result = $this->db->get("userprofileimage")->result();
        if (empty($result)) {
            return $result;
        } else {
            return array();
        }
    }

    /**
     * set session for visitor users
     *
     */
    public function setVisitorSession($userId) {
        $arrData = array('userId', 'firstName', 'lastName', 'userType', 'oauthProvider');

        $this->db->select($arrData);
        $this->db->where("userId", $userId);

        $data = $this->db->get("user")->result();

        $this->objSess->userId = $userId;
        $this->objSess->username = $data['firstName'] . ' ' . $data['lastName'];
        $this->objSess->userType = $data['userType'];
        $this->objSess->userVisitorType = $data['oauthProvider'];
        $this->objSess->isFrontLogin = true;

        $img = $this->getProfileImageLatest($userId);
        if (!empty($img)) {
            $this->objSess->userImage = $img['imageName'];
        } else {
            $this->objSess->userImage = '';
        }
        $this->updateLastLogin($userId);
        $this->setOnline($userId);
    }

    public function agencyWatchUser() {
        $this->db->where("aw.agencyId", $this->objSess->userId);
        $result = $this->db->get("agencywatch")->result();
        if (empty($result)) {
            return $result;
        } else {
            return array();
        }
    }

    public function getAllUser($data = array()) {

        $this->db->select(array('u.*', 'MAX(up.imageName) as profileImage', 'upd.tCategoryId', 'upd.country', 'c.countryName', 't.pCategory', 't.tCategoryName', 'up.userprofileimageId', 'up.imageName'));
        $this->db->join("userProfile as upd", "upd.userId = u.userId", "left");
        $this->db->join("country as c", "c.countryId", "left");
        $this->db->join("talentCategory as t", "t.tCategoryId = upd.tCategoryId", "left");
        $this->db->join("userprofileimage as up", "up.userId = u.userId", "left");

        if (!empty($this->objSess->userId)) {
            $this->db->where("u.userId !=", $this->objSess->userId);
        }
        if (!empty($data['talent_type'])) {
            $this->db->where("t.pCategory", $data['talent_type']);
        }
        if (!empty($data['search'])) {
            $this->db->where("( u.firstName  LIKE '%" . addslashes($data['search']) . "%' OR u.lastName LIKE '%" . addslashes($data['search']) . "%' )", null, false);
        }
        if (!empty($data['category_id'])) {
            $this->db->where("upd.tCategoryId", $data['category_id']);
        }

        $this->db->group_by('u.userId');
        $result = $this->db->get("user as u");

        if (empty($result)) {
            return $result;
        } else {
            return array();
        }
    }

    public function getAllSetsByUser($userId) {
        $this->db->select("*");
        if (!empty($userId)) {
            $this->db->where("us.userId", $userId);
        }

        $result = $this->db->get("userset")->result();

        if (empty($result)) {
            return $result;
        } else {
            return array();
        }
    }

    public function saveSetData($data) {
        $fields = $this->info($this->getConstCol());
        foreach ($data as $field => $value) {
            if (!in_array($field, $fields)) {
                unset($data[$field]);
            } else {
                $data[$field] = trim($value);
            }
        }
        $data['createdDate'] = date('Y-m-d H:i:s');

        return $this->insert("userset", $data);
    }

    public function getHourByName($date1) {

        $date2 = date('Y-m-d H:i:s');
        $seconds = strtotime($date2) - strtotime($date1);
        $min = $seconds / 60;
        $hours = $seconds / 60 / 60;
        $hoursStr = (int) $hours . ":" . (int) $min . ":" . (int) $seconds;
        $age = '';


        list($hour, $min, $sec) = split(":", $hoursStr);
        if ($hour > 24)
            $days = round($hour / 24);
        else
            $days = 0;

        if ($days >= 61) {
            $date = date('M d, Y', strtotime("-$hour hours"));
            return $date;
        } else if ($days >= 1) {
            $age = "$days day";
            if ($days > 1) {
                $age .= "s";
            }
        } else {
            if ($hour > 0) {
                $hour = ltrim($hour, '0');
                $age .= " $hour hour";
                if ($hour > 1) {
                    $age .= "s";
                }
            }
            if ($min > 0) {
                $min = ltrim($min, '0');
                if (!$min)
                    $min = '0';
                $age .= " $min min";
                if ($min != 1) {
                    $age .= "s";
                }
            }
        }

        if ($min < 1 and $hour < 1) {
            $age = 'a few seconds';
        }
        $age .= ' ago';

        return $age;
    }

    function getTopFollowedUser($limit = null) {
        if ($limit)
            $this->db->limit($limit);
        $this->db->order_by("follower", "desc");
        $selectArray = array(
            "user.*, userProfile.about, userProfile.city, userProfile.country, userProfile.userName ",
            "(select count(*) from userfollower where userfollower.userId=user.userId) as follower ",
            "(select countryCode from country  where country.countryId=userProfile.country) as countryname "
        );
        $this->db->select($selectArray);
        $this->db->join("userProfile", "userProfile.userId=user.userId", "left");
        $this->db->where("status", "Active");
        $userArray = $this->db->get("user")->result();
        $userArray = $this->addProfileImage($userArray);
        return $userArray;
    }

    function addProfileImage($userArray, $userField = "userId") {
        foreach ($userArray as $u) {
            $userid = $u->$userField;
            $u->profileImage = $this->getProfileImg($userid);
        }
        return $userArray;
    }

    function getProfileImg($userid) {
        $this->db->select("imageName");
        $this->db->limit(1);
        $this->db->where("userId", $userid);
        $row = $this->db->get("userprofileimage")->row();
        if (count($row) == 1) {
            return $row->imageName;
        } else {
            return "noimage.jpg";
        }
    }

}

