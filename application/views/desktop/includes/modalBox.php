<link rel="stylesheet" href="<?php echo site_url('assets/css/overlay.css'); ?>" type="text/css" media="all" />
<script src="<?php echo site_url('assets/js/ajax.js'); ?>"></script>
<!-- Modal -->

<?php
if(isset($user)){
$uploads = $user->uploads;
$followers = $user->followers;
$follows = $user->follows;
$upcnt = count($uploads);
$folcnt = count($followers);
$folscnt = count($follows);
?>
<div class="modal fade listForm" id="listForm" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><img src="<?php echo site_url("images/times.png"); ?>"></button>
                <h4 class="modal-title col-md-11">Uploads(<?php echo $upcnt; ?>)</h4>
                <?php if ($upcnt > 9) { ?>
                    <span class="navigation pull-right">
                        <a class="left" href="#uploadPopCarousel" data-slide="prev"><i class="fa fa-angle-left"></i></a>
                        <a class="left" href="#uploadPopCarousel" data-slide="next"><i class="fa fa-angle-right"></i></a>
                    </span>
                <?php } ?>
            </div>
            <div class="modal-body">
                <div class="listings row carousel slide " id="uploadPopCarousel"  data-ride="carousel">
                    <div class="col-md-11 carousel-inner">
                        <?php
                        foreach ($uploads as $key => $upl) {
                            $hlink = site_url("/media/details/" . $upl->mediaId);
                            $itemactive = ($key == 0) ? " active " : "";
                            $nomargin = ($key > 0 && ($key + 1) % 3 == 0) ? "no-rmargin" : "";
                            ?>
                            <?php if ($key % 9 == 0) { ?>	<div class="item <?php echo $itemactive; ?>"> <?php } ?>
                                <div class="col-md-4">
                                    <div class="listing lleft">
                                        <?php if ($upl->uploadtype == 'Audio') { ?>
                                            <a href="<?php echo $hlink; ?>">
                                                <img src="<?php echo site_url("images/audio.png"); ?>" id="d3">

                                            </a>                                            
                                        <?php } else { ?>
                                             <a href="<?php echo $hlink; ?>">
                                                 <img src="<?php echo site_url("images/media/".$upl->smallSizeFile); ?>" id="d3" height="175px">

                                            </a>
                                        <?php } ?>
                                            <div class='description'>                                                
                                                <p class='description_content'><button type="button" class="btn btn-danger" onclick="deleteMe(<?php echo $upl->mediaId; ?>)">Delete</button></p>

                                            </div>
                                    </div>
                                </div>
                                <?php if ($key > 0 && ($key + 1) % 9 == 0) { ?>	</div> <?php } ?>    
                            <?php
                        }
                        if ($key % 9 != 0)
                            echo "</div>";
                        ?>
                    </div>       
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php } ?>
<div class="modal fade listForm" id="listForm1" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><img src="<?php echo site_url("images/times.png"); ?>"></button>
                <h4 class="modal-title col-md-11">Following(<?php echo $folcnt; ?>)</h4>
                <?php if ($folcnt > 9) { ?>
                    <span class="navigation pull-right">
                        <a class="left" href="#followingPopCarousel" data-slide="prev"><i class="fa fa-angle-left"></i></a>
                        <a class="left" href="#followingPopCarousel" data-slide="next"><i class="fa fa-angle-right"></i></a>
                    </span>
                <?php } ?>
            </div>
            <div class="modal-body">
                <div class="listings row carousel slide" id="followingPopCarousel"  data-ride="carousel">
                    <div class="col-md-11  carousel-inner">
                        <?php
                        foreach ($followers as $key => $upl) {
                            $hlink = site_url("/user/profile/" . $upl->followerId);
                            $itemactive = ($key == 0) ? " active " : "";
                            $nomargin = ($key > 0 && ($key + 1) % 3 == 0) ? "no-rmargin" : "";
                            ?>
                            <?php if ($key % 9 == 0) { ?>	<div class="item <?php echo $itemactive; ?>"> <?php } ?>
                                <div class="col-md-4">
                                    <div class="listing lleft">
                                        <a href="<?php echo $hlink; ?>"><img src="<?php echo site_url("images/profile/" . $upl->profileImage); ?>"></a>                            
                                        <div class='description'>                                                
                                            <p class='description_content'><button type="button" class="btn btn-danger" onclick="deleteFollower(<?php echo $upl->followId; ?>)">Delete</button></p>

                                        </div>
                                    </div>
                                </div>
                                <?php if ($key > 0 && ($key + 1) % 9 == 0) { ?>	</div> <?php } ?>         
                        <?php
                        }
                        if ($key % 9 != 0)
                            echo "</div>";
                        ?>

                    </div>       
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade listForm" id="listForm2" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><img src="<?php echo site_url("images/times.png"); ?>"></button>
                <h4 class="modal-title col-md-11">Follows(<?php echo $folscnt; ?>)</h4>
<?php if ($folscnt > 9) { ?>
                    <span class="navigation pull-right">
                        <a class="left" href="#followsPopCarousel" data-slide="prev"><i class="fa fa-angle-left"></i></a>
                        <a class="left" href="#followsPopCarousel" data-slide="next"><i class="fa fa-angle-right"></i></a>
                    </span>
<?php } ?>
            </div>
            <div class="modal-body">
                <div class="listings row carousel slide" id="followingPopCarousel"  data-ride="carousel">
                    <div class="col-md-11 carousel-inner">
                        <?php
                        foreach ($follows as $key => $upl) {
                            $hlink = site_url("/user/profile/" . $upl->userId);
                            $itemactive = ($key == 0) ? " active " : "";
                            $nomargin = ($key > 0 && ($key + 1) % 3 == 0) ? "no-rmargin" : "";
                            ?>
    <?php if ($key % 9 == 0) { ?>	<div class="item <?php echo $itemactive; ?>"> <?php } ?>
                                <div class="col-md-4">
                                    <div class="listing lleft">
                                        <a href="<?php echo $hlink; ?>"><img src="<?php echo site_url("images/profile/" . $upl->profileImage); ?>" height="180px"></a>                            
                                        <div class='description'>                                                
                                            <p class='description_content'><button type="button" class="btn btn-danger" onclick="deleteFollowing(<?php echo $upl->followId; ?>)">Delete</button></p>

                                        </div>
                                    </div>
                                </div>
                            <?php if ($key > 0 && ($key + 1) % 9 == 0) { ?>	</div> <?php } ?>     
                        <?php
                        }
                        if ($key % 9 != 0)
                            echo "</div>";
                        ?>
                    </div>       
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

