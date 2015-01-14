<script src="<?php echo site_url('assets/js/custom.js'); ?>"></script>
<?php
$current_url = current_url();
if (isset($user)) {
    $fullName = $user->firstName . " " . $user->lastName;
    $pimage = site_url("images/profile/300x300_" . $UserSession->userImage);
    $userid = $user->userId;
    ?>
    <!-- Modal -->
    <div class="modal fade" id="dazzle" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog gdialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title center" id="myModalLabel">Dazzle user & help spread the word across!</h4>
                </div>
                <div class="modal-body">
                    <div class="i-dazzle">
                        Im dazzled by @<?php echo $fullName; ?>    		
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary sq sq-icon" onclick="fbShare('<?php echo urlencode($current_url); ?>', '<?php echo $fullName; ?>', 'Profile page', '<?php echo $pimage; ?>', 520, 350);"><i class="fa fa-facebook"></i> Share it on Facebook</button>
                    <a href="http://twitter.com/share?text=<?php echo urlencode($fullName); ?>&url=<?php echo urlencode($current_url); ?>&via=twitter&related=<?php echo urlencode("coderplus:Wordpress Tips, jQuery and more"); ?>" title="Share on Twitter" rel="nofollow" target="_blank" class="btn btn-primary sq sq-icon"><i class="fa fa-twitter"></i> Share it on Twitter</a>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="shoutout" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog gdialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title center" id="myModalLabel">Shoutout user to your followers?</h4>
                </div>
                <div class="modal-body">
                    <div class="i-shoutout">
                        Shoutout to @<?php echo $fullName; ?> 		
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary sq" onclick="cancelling(1);">Cancel</button>
                    <button type="button" class="btn btn-primary sq" onclick="shoutout(<?php echo $userid; ?>)">Shoutout</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    $similar = $user->similar;
    //print_r($similar);
    //print count($similar);
    ?>
    <div class="modal fade" id="followwho" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog gdialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Whom to follow</h5>
                </div>
                <?php if($similar != '') { //print "OK";?>
                <div>
                    <form name="followFrm" id="followFrm" method="post" action="<?php echo site_url('ajax/allFollow');?>">
                    <div class="modal-body">
                        <div class="row">
                            <?php foreach ($similar as $key => $val) { ?>
                                <div class="col-md-3">
                                    <div class="fdiv"> 
                                        <img src="<?php echo site_url("images/profile/50x50_" . $val->profileImage); ?>" border="0">
                                        <span onClick="follow(<?php echo $val->userId; ?>, 0);"><?php echo ($val->fullname!= '') ? $val->fullname : "Dummy" ; ?></span>					
                                    </div>
                                </div>
                            <input type="hidden" name="userFollow[]" id="userFollow<?php echo $key;?>" value="<?php echo $val->userId; ?>" />
                            <?php } ?> 

                        </div>		
                    </div>
                    <div class="modal-footer center">
                        <button type="submit" class="btn btn-primary sq">Follow All</button>
                        <button type="button" class="btn btn-primary sq"  onclick="cancelling(2);">Cancel</button>
                    </div>
                    </form>
                </div>
                <?php } else { ?>
                <div class="modal-body">
                        <div class="row">
                            There is no follower suggessions!!

                        </div>		
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
<div class="modal fade" id="socialshare" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog gdialog">
        <div class="modal-content">

            <div class="modal-body center">
                <p class="text-big">Share it on your Social networks</p>      		

                <button type="button" class="btn btn-primary sq sq-icon" onclick="fbShare('<?php echo urlencode($current_url); ?>', '<?php echo $mediaRow->videoName; ?>', 'Video/Audio', '<?php echo mediaUrl($mediaRow->smallSizeFile); ?>', 520, 350);"><i class="fa fa-facebook"></i> Share it on Facebook</button>
                <a href="http://twitter.com/share?text=<?php echo $mediaRow->videoName; ?>&url=<?php echo urlencode($current_url); ?>&via=twitter&related=<?php echo urlencode("coderplus:Wordpress Tips, jQuery and more"); ?>" title="Share on Twitter" rel="nofollow" target="_blank" class="btn btn-primary sq sq-icon"><i class="fa fa-twitter"></i> Share it on Twitter</a>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="advsearch" tabindex="-1"  aria-hidden="true">
    <div class="modal-dialog gdialog">
        <div class="modal-content">

            <div class="modal-body">
                <h2 class="center">Advanced User Search</h2>
                <div class="form-container">
                    <form name="advSearch" id="advSearch" method="post" action="<?php echo site_url('user/advSearch'); ?>">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="profession">Profession</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control cfc" value="" name="profession" id="profession">
                                <ul class="suggestion">
                                    <li>Actor</li><li>Singer</li>
                                    <li>Dancer</li><li>Musician</li>
                                    <li>Disco Jockey</li><li>Theatrician</li>
                                    <li>Actress</li><li>B-Boy</li>
                                    <li>Ballet Dancer</li>
                                </ul>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-md-2">
                                <label for="location">Location</label>
                            </div>
                            <div class="col-md-10">
                                <input type="text" class="form-control cfc" value="" name="location" id="location">
                                <ul class="suggestion">
                                    <li>California</li><li>San francisco</li>
                                    <li>New York</li><li>Brooklyn</li>
                                    <li>Boston</li><li>Australia</li>
                                    <li>London</li><li>South Africa</li>
                                </ul>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <label for="browseby">Browse by</label>
                            </div>
                            <div class="col-md-10">
                                <label for="optbrowseby1" class="lblradio"><input type="radio" class="cfc"  name="optbrowseby" id="optbrowseby1">Most Dazzles</label>
                                <label for="optbrowseby2" class="lblradio"><input type="radio" class="cfc"  name="optbrowseby" id="optbrowseby2">Most Recent</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 center">
                                <button type="button" class="btn btn-primary sq">Submit</button>


                            </div>

                        </div>
                    </form>
                </div>




            </div>

        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="restricted" tabindex="-1"  aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog gdialog">
        <div class="modal-content">

            <div class="modal-body center">
                <img src="<?php echo site_url('images/restricted.png'); ?>">

                <h2>Content Warning</h2>

                <p>This video may be inappropriate for some users</p>
                <span>Kindly enter your age to continue</span>

                <div class="row">

                    <div class="col-md-2 col-md-offset-3"><input type="text" class="form-control cfc" value="" maxlength="2" placeholder="DD" name="rdd" id="rdd"></div>
                    <div class="col-md-2"><input type="text" class="form-control cfc" value="" maxlength="2" placeholder="MM" name="rmm" id="rmm"></div>
                    <div class="col-md-2"><input type="text" class="form-control cfc" value="" maxlength="4" placeholder="YYYY" name="ryy" id="ryy"></div>
                </div>

                <span>By confirming, you agree that this warning will no longer be shown in the future.</span>

                <button type="button" class="btn btn-primary sq" onclick="return checkAge();">I understand and wish to proceed</button>





            </div>

        </div>
    </div>
</div>

<script>
                    function fbShare(url, title, descr, image, winWidth, winHeight) {
                        var winTop = (screen.height / 2) - (winHeight / 2);
                        var winLeft = (screen.width / 2) - (winWidth / 2);
                        window.open('http://www.facebook.com/sharer.php?s=100&p[title]=' + title + '&p[summary]=' + descr + '&p[url]=' + url + '&p[images][0]=' + image, 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
                    }
</script>



