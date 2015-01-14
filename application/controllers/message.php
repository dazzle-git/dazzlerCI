<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of message
 *
 * @author arun
 */
class message extends MY_Controller {

    //put your code here

    public function index() {
        if (!$this->checkLoggedIn()) {
            redirect(site_url('/'));
        } else {
            $this->load->model("message_m");
            $sess = $this->session->userdata("objSess");
            $userid = $sess->userId;
            $this->getMessage();
            $pview = $this->message_m->get_message($userid, 2);
            //print_r($pview);
            $pview = $this->associateImage($pview);
            $this->data['pview'] = $pview;
            $this->loadview('message');
        }
    }

    public function saveMessage() {

        $sess = $this->session->userdata("objSess");
        $userid = $sess->userId;
        //print_r($_POST);exit;
        $useremail = $this->input->post('useremail');
        $this->load->model("user_m");
        $userrec = $this->user_m->getUserDataByEmail($useremail);
        $touserid = $userrec->userId;
        $this->load->model("message_m");
        $tagId = $this->message_m->add_message($touserid, $userid);

        $this->getMessage();
        $pview = $this->message_m->get_message($userid, 2);
        $pview = $this->associateImage($pview);
        $this->data['pview'] = $pview;
        $this->loadview('message');
    }

    public function getMessage() {
        $sess = $this->session->userdata("objSess");
        $userid = $sess->userId;

        $this->load->model("message_m");
        $messages = $this->message_m->get_message($userid);
        $messages = $this->associateImage($messages);
        //print_r($messages);exit;
        $this->data['userId'] = $userid;
        $this->data['messages'] = $messages;
    }

    public function messageRead() {
        $msgid = $this->input->post('msgid');
        //print_r($msgid);
        $selMsg = implode(',', $msgid);
        $data['is_read'] = "yes";
        $this->load->model("message_m");
        $this->message_m->messageupdate($data, $selMsg);
        redirect(site_url('/message'));
        //exit;
    }

    public function operationDropdown($msgid) {
        $opr = $this->input->post('operation');
        $this->load->model("message_m");
        $this->load->model("user_m");
        switch ($opr) {
            case 1:
                $this->messageSparm($msgid);
                break;
            case 2:
                $rec = $this->message_m->getMessageById($msgid);
                if($this->user_m->checkUserAlreadyBlock($rec->toUserId)){
                    $data['userId'] = $this->objSess->userId;
                    $data['blockId'] = $rec->toUserId;
                    $this->user_m->saveUserBlockData($data);
                }
                //$this->messageSparm($msgid);
                break;
            case 3:
                $this->messageDel($msgid);
                break;
        }
        echo "Process Finished";
    }

    public function messageSparm($msgid) {
        //$msgid = $this->input->post('msgid');
        //print_r($msgid);
        //$selMsg = implode(',', $msgid);
        $data['is_sparm'] = "yes";
        $this->load->model("message_m");
        $this->message_m->messageupdate($data, $msgid);
        //redirect(site_url('/message'));
        //exit;
    }

    public function messageDelete() {
        $msgid = $this->input->post('msgid');
        //print_r($msgid);
        $selMsg = implode(',', $msgid);
        $data['is_deleted'] = "yes";
        $this->load->model("message_m");
        $this->message_m->messageupdate($data, $selMsg);
        redirect(site_url('/message'));
        //exit;
    }

    public function messageDel($selMsg) {
        //$msgid = $this->input->post('msgid');
        //print_r($msgid);
        //$selMsg = implode(',', $msgid);
        $data['is_deleted'] = "yes";
        $this->load->model("message_m");
        $this->message_m->messageupdate($data, $selMsg);
        //redirect(site_url('/message'));
        //exit;
    }

}
