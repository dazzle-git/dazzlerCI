<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ajax extends MY_Controller {

    public function index() {
        
    }

    public function follow($userid) {
        if ($this->checkLoggedIn()) {
            $followerid = $this->objSess->userId;

            if ($userid != $followerid) {
                $d = array(
                    "userId" => $userid,
                    "followerId" => $followerid,
                    "type" => "User"
                );

                $this->load->model("userfollower_m");
                $exists = $this->userfollower_m->get_where($d);
                if (count($exists) == 0)
                    $this->userfollower_m->save($d);
                unset($exists);
            }
        }

        $outputArray = array(
            "success" => 1,
            "message" => ""
        );
        echo $this->_outputJSON($outputArray);
    }

    public function allFollow() {
        $userFollow = $this->input->post('userFollow');
        $followerid = $this->objSess->userId;
        //print_r($userFollow);exit;
        foreach ($userFollow as $key => $followid) {
            if ($userid != $followerid) {
                $d = array(
                    "userId" => $followid,
                    "followerId" => $followerid,
                    "type" => "User"
                );

                $this->load->model("userfollower_m");
                $exists = $this->userfollower_m->get_where($d);
                if (count($exists) == 0)
                    $this->userfollower_m->save($d);
                unset($exists);
            }
        }

        $outputArray = array(
            "success" => 1,
            "message" => ""
        );
        //echo $this->_outputJSON($outputArray);
        redirect(site_url('profile/'.$followerid));
    }

    public function dazzle($userid) {
        if ($this->checkLoggedIn()) {
            $dazzlerid = $this->objSess->userId;

            if ($userid != $dazzlerid) {
                $d = array(
                    "userId" => $userid,
                    "dazzlerId" => $dazzlerid,
                    "type" => "User"
                );

                $this->load->model("userdazzle_m");
                $exists = $this->userdazzle_m->get_where($d);
                if (count($exists) == 0)
                    $this->userdazzle_m->save($d);

                unset($exists);
            }
        }

        $outputArray = array(
            "success" => 1,
            "message" => ""
        );
        echo $this->_outputJSON($outputArray);
    }

    public function like($videoid) {
        if ($this->checkLoggedIn()) {
            $userid = $this->objSess->userId;
            $d = array(
                "mediaId" => $videoid,
                "userId" => $userid,
                "type" => "Video"
            );
            $this->load->model("userlike_m");
            $exists = $this->userlike_m->get_where($d);
            if (count($exists) == 0)
                $this->userlike_m->save($d);
            unset($exists);
        }

        $outputArray = array(
            "success" => 1,
            "message" => ""
        );
        $this->_outputJSON($outputArray);
    }

    public function dislike($videoid) {
        if ($this->checkLoggedIn()) {
            $userid = $this->objSess->userId;
            $d = array(
                "mediaId" => $videoid,
                "userId" => $userid,
                "type" => "Video"
            );
            $this->load->model("userlike_m");
            $this->userlike_m->delete_where($d);
            $this->load->model("userdislike_m");
            $exists = $this->userdislike_m->get_where($d);
            if (count($exists) == 0)
                $this->userdislike_m->save($d);
            unset($exists);
        }

        $outputArray = array(
            "success" => 1,
            "message" => ""
        );
        $this->_outputJSON($outputArray);
    }

    function _outputJSON($outputArray) {
        $this->output->set_content_type('application/json');
        //$this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        $this->output->set_header('Access-Control-Allow-Headers: X-Requested-With');
        $this->output->set_output(json_encode($outputArray));
    }

    function delete($id) {
        //echo $id;exit;
        $this->load->model("userfollower_m");
        $ret = $this->userfollower_m->delete($id);
        if ($ret == 1) {
            //unlink(site_url('/media/'.$arr['bigSizeFile']));   
        }
        echo $ret;
    }

    public function shoutout($userid) {
        if ($this->checkLoggedIn()) {
            $shoutouterId = $this->objSess->userId;

            if ($userid != $shoutouterId) {
                $d = array(
                    "userId" => $userid,
                    "shoutouterId" => $shoutouterId,
                    "type" => "User"
                );

                $this->load->model("usershoutout_m");
                $exists = $this->usershoutout_m->get_where($d);
                if (count($exists) == 0)
                    $this->usershoutout_m->save($d);

                unset($exists);
            }
        }

        $outputArray = array(
            "success" => 1,
            "message" => ""
        );
        echo $this->_outputJSON($outputArray);
    }

    function loadData() {
        //echo $id;exit;
        //print_r($_POST);exit;
        $this->load->model("user_m");
        $mediaId = $this->input->post('medid');
        $commentLimit = $this->input->post('commStart');
        $this->load->model("usercomments_m");
        $mediaComments = $this->usercomments_m->fetchPortion($mediaId, $commentLimit);
        $mediaComments = $this->user_m->addProfileImage($mediaComments);
        $i = 0;
        foreach ($mediaComments as $key => $mrow) {
            $cprofilepic = site_url("images/profile/50x50_" . $mrow->profileImage);
            $fullname = $mrow->fullname;
            //$enterTime = DateTime($mrow->createdDate);
            //$timespan = timeDifference($enterTime,$now);
            $timespan = GetTimeDifference($mrow->createdDate);
            $oddclass = ($i++ % 2) ? "" : "odd";
            $comment = $mrow->text;
            ?>
            <div class="row comment <?php echo $oddclass; ?>">
                <div class="col-md-1"><img class="comment-ppic" src="<?php echo $cprofilepic; ?>"></div>
                <div class="col-md-11">
                    <div class="row">
                        <div class="col-md-10">
                            <span class="comment-user-name pull-left"><?php echo $fullname; ?> </span>
                        </div>
                        <div class="col-md-2">
                            <span class="comment-timestamp pull-right"><?php echo $timespan; ?></span>
                        </div>
                        <div class="col-md-12">
                            <p class="comment-comment"><?php echo $comment; ?> </p>
                        </div>
                    </div>
                </div>

            </div>

            <?php
        }
    }

    function loadPage($page) {
        //print "OK";exit;
        $this->config->load('customconfig');
        $limit = $this->config->item('paginationCnt');
        $start = ($page - 1) * $limit;
        $this->load->model("usermedia_m");
        $total = $this->usermedia_m->getAllMediaCnt();
        $arr = $this->usermedia_m->getAllMedia($start, $limit);
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th style="width: 26px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($arr as $key => $item) { ?>
                    <tr>
                        <td><?php echo $key + $start + 1; ?></td>
                        <td><?php echo $item->videoName; ?></td>
                        <td><?php echo substr($item->description, 0, 15); ?></td>
                        <td><?php echo $item->uploadtype; ?></td>
                        <td>
                            <a href="<?php echo site_url("admin/mediadetails/" . $item->mediaId); ?>"><i class="icon-search"></i></a>
                            <a href="javascript:" role="button" data-toggle="modal" onclick="deleteMe(<?php echo $item->mediaId; ?>)"><i class="icon-remove"></i></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>

        </table>
        <?php
    }

    function loadContent($msgid) {
        $this->load->model("message_m");
        $sess = $this->session->userdata("objSess");
        $userid = $sess->userId;
        $out = $this->message_m->getMessageById($msgid);
        $this->load->model("user_m");
        if ($out->fromUserId == $userid)
            $chkId = $out->toUserId;
        else
            $chkId = $out->fromUserId;
        $filter = '(fromUserId=' . $chkId . ' or toUserId=' . $chkId . ')';
        $pview = $this->message_m->get_message($userid, 2, $filter);
        $pview = $this->associateImage($pview);
        if (count($pview) > 0) {
            ?>
            <form id="replymessage" method="post" name="frmReply" action="<?php echo site_url('message/saveMessage'); ?>">
                <input type="hidden" name="msgTopId" id="msgTopId" value="<?php echo $pview[0]->messageID; ?>" />
                <?php
                foreach ($pview as $key => $val) {
                    $timespan = GetTimeDifference($val->createdDate);
                    //print_r($val);
                    ?>
                    <li class="messagelist">
                                                                    <!--<img src="images/mgsuser.jpg">-->
                        <img src="<?php echo site_url("images/profile/50x50_" . $val->pimage); ?>">
                        <p>
                            <span class="timeago"><?php echo $timespan; ?></span>
                            <span class="muser"><?php echo ((!isset($val->fullname)) ? $val->emailAddress : $val->fullname); ?></span>
                            <br />
                            <?php if ($userid == $val->fromUserId) { ?>
                                <span class="replied"></span> 
                            <?php } ?>
                            <?php echo $val->message; ?>
                        </p>							
                    </li>
                <?php } ?>
                <input id="useremail" name="useremail"  placeholder="Enter user email" type="hidden" value="<?php echo $val->otherEmail; ?>">
                <li class="messagelist">
                    <img src="images/mgsuser1.jpg">
                    <div class="form-group replyform">
                        <textarea class="form-control cfc" name="message" id="message" required></textarea>
                        <button class="btn sq pull-right" type="submit">Send</button>
                    </div>					
                </li>

            </form>    
            <?php
        }
        else
            echo '<li class="messagelist">No Message Selected</li>';
    }

    public function blockUser($userId) {
        $this->load->model("user_m");
        $sess = $this->session->userdata("objSess");
        $userid = $sess->userId;
        $data = array();
        if (!$this->user_m->checkUserAlreadyBlock) {
            $data['userId'] = $userid;
            $data['blockId'] = $userId;
            //$data['created'] = date('Y-m-d h:m:s');
            $this->user_m->saveUserBlockData($data);
        }
    }

}
?>
