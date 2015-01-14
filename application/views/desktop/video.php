<?php $this->load->view($viewFolder . "includes/meta"); ?>
<script src="<?php echo site_url('assets/js/ajax.js'); ?>"></script>
<script type="text/javascript" src="//cdn.sublimevideo.net/js/x33k8yqg.js"></script>
<body>

<div class="wrapper">

        <?php $this->load->view($viewFolder . "includes/header"); ?>

        <div class="container section">
            <div class="row">
                <div class="col-sm-12">
                    <div class="videoUiWrapper thumbnail">
                        <div class="vc-player">
                            <?php if ($mediaRow->uploadtype == "Audio") { ?>
                                <audio controls>
                                    <source src="<?php echo mediaUrl($mediaRow->bigSizeFile); ?>" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio> 
                            <?php } else { ?>
                                <video id="a240e92d" class="sublime" poster="<?php echo mediaUrl($mediaRow->smallSizeFile); ?>" width="960" height="560" title="Midnight Sun" data-uid="a240e92d" preload="none">
                                    <source src="<?php echo mediaUrl($mediaRow->bigSizeFile); ?>" data-quality="hd"/>
                                    
                                </video>
                            <?php } ?>
                        </div>


                    </div>
                </div>
            </div>

        </div>


        <div class="container section">
            <div class="row">

                <div class="profile_desc col-md-12">

                    <div class="pr_brief pull-left">
                        <img src="<?php echo site_url("images/profile/150x150_" . $mediaRow->profileImage); ?>" width="150" height="150" />
                        <span class="profile_name"><?php echo $mediaRow->fullname; ?></span>
                        <a href="<?php echo site_url("/ajax/follow/" . $mediaRow->userId); ?>" class='btn col-sm-12 follow'>Follow</a>
                        <a href="<?php echo site_url("/ajax/dazzle/" . $mediaRow->userId); ?>" class='btn col-sm-12 dazzle'>Dazzle</a>
                    	<button class="btn btn-half col-sm-2 padd" data-toggle="modal" data-target="#socialshare"><i class="glyphicon glyphicon-share"></i></button>
					</div>
                    <div class="pdescr zerotopmargin">
                        <h2><?php echo $mediaRow->videoName; ?></h2>

                        <?php echo $mediaRow->description; ?>

                        <div class="pstats row">

                            <div class="col-md-6">
                                <p><i class="fa fa-eye fa-2x"></i> &nbsp; <?php echo $mediaRow->noView; ?> Views</p>
                            </div>
                            <div class="col-md-3">
                                <a href="" class="dz-like"><i class="fa fa-thumbs-o-up fa-2x"></i>I Like this</a>
                            </div>
                            <div class="col-md-3">
                                <a href="" class="dz-like"><i class="fa fa-thumbs-o-down fa-2x"></i>I Dislike this</a>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>



        <div class="container section">
            <div class="row">

                <div class="comments col-md-9">
                    <div class="row commentbox">
                        <form id="commentFrm" name="commentFrm" method="post" action="<?php echo site_url('media/saveComments'); ?>">
                            <div class="col-md-12">
                                <h2>All Comments (<?php echo $totalCnt; ?>)</h2>

                                <textarea  name="ucomment" id="ucomment"  placeholder="Share your comments" required ></textarea>
                                <input type="hidden" id="medid" name="medid" value="<?php echo $mediaId; ?>">
                                <button type="submit" class="btn  pull-right">Submit</button>
                            </div>
                        </form>    
                    </div>

                    <div id="commentList">
                        <?php
                        $i = 0;

                        //$now = new DateTime();
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

                        <?php } ?>
                    </div>    
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" id="totalcnt" name="totalcnt" value="<?php echo $totalCnt; ?>">
                            <input type="hidden" id="commentLimit" name="commentLimit" value="<?php echo $commentLimit; ?>">
                            <?php if ($totalCnt > $commentLimit) { ?>
                                <button class="btn btn-default col-md-12 center" onClick="loadComments();" id="viewmore">View More Comments</button>
                            <?php } ?>
                        </div>

                    </div>
                </div>

                <div class="sidelist col-md-3">
                    <div class="content-list-2">
                        <div class="topbar">
                            <span class="title">You may also like</span>
                        </div>		
                    </div>

                    <div class="imglist3">

                        <?php foreach ($relatedVideo as $rv) { ?>
                            <img src="<?php echo site_url("images/media/" . $rv->bigImage); ?>" width="212" alt="">


                        <?php } ?>


                    </div>


                </div>



            </div>
        </div>





        
		<?php $this->load->view($viewFolder . "includes/footer"); ?>

    </div>

	<?php $this->load->view($viewFolder . "includes/shoutbox"); ?>


</body>



<?php $this->load->view($viewFolder . "includes/close"); ?>

<?php if($mediaRow->restrict == 1) { ?>
<script>$('#restricted').modal('show');</script>
<?php } ?>

