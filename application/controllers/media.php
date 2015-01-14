<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Media extends My_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index() {
        $this->loadView('video');
    }

    public function details($mediaid = 0) {
        //print $mediaid; exit;
        $this->config->load('customconfig');
        if ($mediaid == 0)
            redirect(site_url("/"));
        $this->load->model("usermedia_m");
        $mRow = $this->usermedia_m->getMedia($mediaid);

        if (!count($mRow))
            redirect(site_url("/"));

        $this->load->model("user_m");
        $this->load->model("usercomments_m");
        $mRow = $this->user_m->addProfileImage($mRow);
        $row = $cRow = $this->usercomments_m->fetchAll($mediaid);
        $cRow = $this->usercomments_m->mediaComments($mediaid);
        $cRow = $this->user_m->addProfileImage($cRow);
        $this->data["mediaRow"] = $mRow[0];
        $this->data["mediaComments"] = $cRow;
        $this->data["totalCnt"] = count($row);
        $relatedVideo = $this->usermedia_m->getRelatedContents();
        $this->data["mediaId"] = $mediaid;
        $this->data["commentLimit"] = $this->config->item('commentcnt');
        $this->data["relatedVideo"] = $relatedVideo;
        $this->loadView('video');
    }

    function do_upload() {
        $config['upload_path'] = 'images/media/';
        $config['allowed_types'] = 'mp3|mp4|ogv|webm|ogg';
        $config['max_size'] = '2048000';

        $types = array('mpg', 'mpeg', 'mp4', 'avi','ogv','webm','3gp');
        // You can give video formats if you want to upload any video file.

        $this->load->library('upload', $config);
        //print "OKKK";
        if (!$this->upload->do_upload('fileUpload')) {
            $error = array('error' => $this->upload->display_errors());
            $data1 = array_merge($this->data,$error);
            //var_dump($_FILES);exit;
            $this->load->view('desktop/error', $data1);

            // uploading failed. $error will holds the errors.
        } else {

            $data = array('upload_data' => $this->upload->data());
            $sess = $this->session->userdata("objSess");
            $userid = $sess->userId;
            $this->load->model("tag_m");
            $tagId = $this->tag_m->tagSave($userid);
            $this->load->model("usermedia_m");
            $fileName = $data['upload_data']['file_name'];
            list($file, $ext) = explode('.', $fileName);
            if (in_array($ext, $types)) {
                $video = $config['upload_path'] . '/' . $fileName;
                @chmod($video, 0777);
                $image = $config['upload_path'] . '/' . $file . ".jpg";
                $interval = 5;
                $size = '640x480';
                $out = shell_exec("ffmpeg -i $video -deinterlace -an -ss $interval -f mjpeg -t 1 -r 1 -y -s $size $image 2>&1");
                //echo $out;exit;
                @chmod($image, 0777);
            }
            $this->usermedia_m->mediaSave($userid, $tagId, $fileName);
            //print_r($data);
            redirect(site_url('/home'));
            // uploading successfull, now do your further actions
        }
    }

    function delete($id) {
        //echo $id;exit;
        $this->load->model("usermedia_m");
        $arr = $this->usermedia_m->getMedia($id);
        $ret = $this->usermedia_m->mediaDelete($id);
        if ($ret == 1) {
            //unlink(site_url('/media/'.$arr['bigSizeFile']));   
        }
        echo $ret;
    }

    function saveComments() {
        $this->load->model("usercomments_m");
        $mediaId = $this->input->post('medid');
        $sess = $this->session->userdata("objSess");
        $userid = $sess->userId;
        $this->usercomments_m->saveComments($userid);
        redirect(site_url('media/details/' . $mediaId));
    }
    
    
    function search() {
        //echo $id;exit;
        $this->load->model("usermedia_m");
        $searchTxt = $this->input->post('searchTxt');
        $arr = $this->usermedia_m->getMediaBySearch();
        $this->data['items'] = $arr;
        $this->loadview('search');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */