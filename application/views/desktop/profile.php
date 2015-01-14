<?php $this->load->view($viewFolder . "includes/meta"); ?>
<script src="<?php echo site_url('assets/js/ajax.js'); ?>"></script>
<body>



    <div class="wrapper">

        <?php
        //print_r($user);

        $fullname = $user->firstName . " " . $user->lastName;
        $userid = $user->userId;
        if (isset($user->profile) && !empty($user->profile)) {
            $about = $user->profile->about;
            $country = $user->profile->countryname;
            $city = $user->profile->city;
            $location = $city . ", " . $country;
            $category = $user->profile->CategoryName;
        } else {
            $about = "";
            $country = "";
            $city = "";
            $location = "";
            $category = "";
        }
        ?>
        <?php $this->load->view($viewFolder . "includes/header"); ?>
        <!--        <div id="dialog-form" title="Create new user">
                    <p class="validateTips">All form fields are required.</p>
                    <form name="updateForm" id="updateForm">
                        <fieldset>
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" value="Jane Smith" class="text ui-widget-content ui-corner-all">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" value="jane@smith.com" class="text ui-widget-content ui-corner-all">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" value="xxxxxxx" class="text ui-widget-content ui-corner-all">
                             Allow form submission with keyboard without duplicating the dialog button 
                            <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
                        </fieldset>
                    </form>
                </div>-->
        <div class="container sec-profile">

            <div class="row">

                <div class="profile-left">
                    <img class="p-pic" src="<?php echo site_url("images/profile/300x300_" . $UserSession->userImage); ?>" width="300" height="300">
                    <div class="p-details">
                        <h3><?php echo $fullname; ?></h3>

                        <span class="p-prof"><?php echo $category; ?></span>

                        <span class="p-loc"><a href="javascript:" id="update-user"><i class="fa fa-map-marker"></i></a><?php echo $location; ?></span>
                        <p> <?php echo $about; ?> </p>




                    </div>
                    <?php //print $showFollow;if ($showFollow) { ?>

                    <button type="button" onClick="follow(<?php echo $userid; ?>, 1)" class="btn col-sm-5 follow">Follow</button>
                    <!--<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#dazzle">dazzle</button>-->
                    <button type="button" onClick="dazzling(<?php echo $userid; ?>);" class="btn col-sm-5 dazzle">Dazzle</button>
                    <a class="btn btn-half col-sm-2" href="<?php echo site_url('/message'); ?>"><i class="fa fa-envelope-o fa-1x"></i></a>
                    <button class="btn btn-half col-sm-2" data-toggle="modal" data-target="#shoutout"><i class="glyphicon glyphicon-bullhorn"></i></button>

<!--<button class="btn btn-half col-sm-2 padd" data-toggle="modal" data-target="#followwho"><i class="glyphicon glyphicon-ok"></i></button>-->
                    <button class="btn btn-half col-sm-2 padd" data-toggle="modal" data-target="#advsearch"><i class="glyphicon glyphicon-search"></i></button>

                    <?php //} ?>
                    <p>&nbsp;</p>
                    <div class="clear"></div>
                    <div class="p-space">
                        <h2>Dazzler Space Station <span>5GB</span></h2>

                        <div class="row sbar">
                            <span>Used</span><br>
                            <span class="sptext"><?php echo $totGB; ?> </span>
                            <div class="sbar-wrap">
                                <div class="shaded" style="width:<?php echo $percentage[0]; ?>%"></div> 
                            </div>

                        </div>


                        <div class="row sbar">
                            <span>Earned</span><br>
                            <span class="sptext"><?php echo $getGB; ?></span>
                            <div class="sbar-wrap">
                                <div class="shaded" style="width:<?php echo $percentage[2]; ?>%"></div> 
                            </div>

                        </div>



                        <div class="row sbar">
                            <span>Unused</span><br>
                            <span class="sptext"><?php echo $remGB; ?></span>
                            <div class="sbar-wrap">
                                <div class="shaded" style="width:<?php echo $percentage[1]; ?>%"></div> 
                            </div>

                        </div>



                    </div>

                </div>


                <div class="profile-right">

                    <div class="content-list-2">
                        <div class="topbar">
                            <span class="title">You might want to follow these similar accounts</span> 
                            <i class="fa fa-close pull-right"></i>

                        </div>				
                        <div id="followerCarousel" class="carousel slide " data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="item active imglist5"> 
                                    <?php
                                    $similarps = $user->similar;
                                    if($similarps != ''){
                                    foreach ($similarps as $key => $val) {
                                        ?>
                                        <div class="imgdiv">
                                            <span class="pr-name"><?php echo ($val->fullname!= '') ? $val->fullname : "Dummy" ; ?></span>
                                            <img src="<?php echo site_url("images/profile/300x300_" . $val->profileImage); ?>" border="0">
                                            <button onClick="follow(<?php echo $val->userId; ?>, 0);" class="btn sq">Follow</button>					
                                        </div> 
                                    <?php } } else { ?>   
                                        <div class="imgdiv">
                                            <div style="text-align: center;"> No similar profiles found!</div>
                                        </div>
                                    <?php } ?>

                                </div> 								
                            </div>

                        </div>
                    </div>

                    <?php
                    if (isset($user->uploads) && !empty($user->uploads)) {

                        $itemcount = count($user->uploads);
                        ?>
                        <div class="content-list-2">
                            <div class="topbar">
                                <span class="title">Uploads (<a href="#" data-toggle="modal" data-target="#listForm"><?php echo $itemcount; ?></a>)</span>

    <?php if ($itemcount > 6) { ?>
                                    <span class="navigation pull-right">
                                        <a class="left" href="#uploadsCarousel" data-slide="prev"><i class="fa fa-angle-left"></i></a>
                                        <a class="left" href="#uploadsCarousel" data-slide="next"><i class="fa fa-angle-right"></i></a>
                                    </span>
    <?php } ?>
                            </div>				
                            <div id="uploadsCarousel" class="carousel slide " data-ride="carousel">
                                <div class="carousel-inner">

                                    <?php
                                    for ($i = 0; $i < $itemcount; $i++) {
                                        $v = $user->uploads[$i];
                                        $itemactive = ($i == 0) ? " active " : "";
                                        $nomargin = ($i > 0 && ($i + 1) % 3 == 0) ? "no-rmargin" : "";

                                        $hlink = site_url("/media/details/" . $v->mediaId);
                                        ?>
                                            <?php if ($i % 6 == 0) { ?>	<div class="item <?php echo $itemactive; ?> imglist"> <?php } ?>
                                            <a href="<?php echo $hlink; ?>"><img  class="<?php echo $nomargin; ?>"  src="<?php echo site_url("images/media/" . $v->smallImage); ?>" width="212" height="142"  alt="<?php echo $v->videoName; ?>"></a>
                                        <?php if ($i > 0 && ($i + 1) % 6 == 0) { ?>	</div> <?php } ?>
                                        <?php
                                    }
                                    if ($i % 6 != 0)
                                        echo "</div>";
                                    ?>	

                                </div>

                            </div>


                        </div>


<?php } ?>





                    <?php
                    if (isset($user->followers) && !empty($user->followers)) {

                        $itemcount = count($user->followers);
                        ?>
                        <div class="content-list-2">
                            <div class="topbar">
                                <span class="title">Followers (<a href="#" data-toggle="modal" data-target="#listForm1"><?php echo $itemcount; ?></a>)</span>

    <?php if ($itemcount > 6) { ?>
                                    <span class="navigation pull-right">
                                        <a class="left" href="#followerCarousel" data-slide="prev"><i class="fa fa-angle-left"></i></a>
                                        <a class="left" href="#followerCarousel" data-slide="next"><i class="fa fa-angle-right"></i></a>
                                    </span>
    <?php } ?>
                            </div>				
                            <div id="followerCarousel" class="carousel slide " data-ride="carousel">
                                <div class="carousel-inner">
                                    <?php
                                    $hitems = 6;
                                    for ($i = 0; $i < $itemcount; $i++) {
                                        $v = $user->followers[$i];
                                        $itemactive = ($i == 0) ? " active " : "";
                                        $nomargin = ($i > 0 && ($i + 1) % $hitems == 0) ? "no-rmargin" : "";
                                        $hlink = site_url("/user/profile/" . $v->followerId);
                                        ?>
                                            <?php if ($i % $hitems == 0) { ?>	<div class="item <?php echo $itemactive; ?> imglist1"> <?php } ?>
                                            <a href="<?php echo $hlink; ?>"><img  class="<?php echo $nomargin; ?>"  src="<?php echo site_url("images/profile/" . $v->profileImage); ?>" width="100" height="100"  alt=""></a>
                                        <?php if ($i > 0 && ($i + 1) % $hitems == 0) { ?>	</div> <?php } ?>
                                        <?php
                                    }
                                    if ($i % $hitems != 0)
                                        echo "</div>";
                                    ?>	
                                </div>

                            </div>
                        </div>
<?php } ?>







                    <?php
                    if (isset($user->follows) && !empty($user->follows)) {

                        $itemcount = count($user->follows);
                        ?>
                        <div class="content-list-2">
                            <div class="topbar">
                                <span class="title">Following (<a href="#" data-toggle="modal" data-target="#listForm2"><?php echo $itemcount; ?></a>)</span>

    <?php if ($itemcount > 6) { ?>
                                    <span class="navigation pull-right">
                                        <a class="left" href="#followingCarousel" data-slide="prev"><i class="fa fa-angle-left"></i></a>
                                        <a class="left" href="#followingCarousel" data-slide="next"><i class="fa fa-angle-right"></i></a>
                                    </span>
    <?php } ?>
                            </div>				
                            <div id="followingCarousel" class="carousel slide " data-ride="carousel">
                                <div class="carousel-inner">
                                    <?php
                                    $hitems = 6;
                                    for ($i = 0; $i < $itemcount; $i++) {
                                        $v = $user->follows[$i];
                                        $itemactive = ($i == 0) ? " active " : "";
                                        $nomargin = ($i > 0 && ($i + 1) % $hitems == 0) ? "no-rmargin" : "";
                                        $hlink = site_url("/user/profile/" . $v->userId);
                                        ?>
                                            <?php if ($i % $hitems == 0) { ?>	<div class="item <?php echo $itemactive; ?> imglist1"> <?php } ?>
                                            <a href="<?php echo $hlink; ?>"><img  class="<?php echo $nomargin; ?>"  src="<?php echo site_url("images/profile/" . $v->profileImage); ?>" width="100" height="100"  alt=""></a>
                                        <?php if ($i > 0 && ($i + 1) % $hitems == 0) { ?>	</div> <?php } ?>
                                        <?php
                                    }
                                    if ($i % $hitems != 0)
                                        echo "</div>";
                                    ?>	
                                </div>

                            </div>
                        </div>
<?php } ?>



                    <?php
                    if (isset($user->pimages) && !empty($user->pimages)) {

                        $itemcount = count($user->pimages);
                        ?>
                        <div class="content-list-2">
                            <div class="topbar">
                                <span class="title">Profile Pictures (<?php echo $itemcount; ?>)</span>

    <?php if ($itemcount > 6) { ?>
                                    <span class="navigation pull-right">
                                        <a class="left" href="#profileImgCarousel" data-slide="prev"><i class="fa fa-angle-left"></i></a>
                                        <a class="left" href="#profileImgCarousel" data-slide="next"><i class="fa fa-angle-right"></i></a>
                                    </span>
    <?php } ?>
                            </div>				
                            <div id="profileImgCarousel" class="carousel slide " data-ride="carousel">
                                <div class="carousel-inner">
                                    <?php
                                    $hitems = 2;
                                    for ($i = 0; $i < $itemcount; $i++) {
                                        $v = $user->pimages[$i];
                                        $itemactive = ($i == 0) ? " active " : "";
                                        $nomargin = ($i > 0 && ($i + 1) % $hitems == 0) ? "no-rmargin" : "";
                                        ?>
                                            <?php if ($i % $hitems == 0) { ?>	<div class="item <?php echo $itemactive; ?> imglist2"> <?php } ?>
                                            <img  class="<?php echo $nomargin; ?>"  src="<?php echo site_url("images/profile/" . $v->imageName); ?>" width="320" alt="">
                                        <?php if ($i > 0 && ($i + 1) % $hitems == 0) { ?>	</div> <?php } ?>
                                        <?php
                                    }
                                    if ($i % $hitems != 0)
                                        echo "</div>";
                                    ?>	
                                </div>

                            </div>
                        </div>
<?php } ?>






                </div>
            </div>


        </div>


<?php $this->load->view($viewFolder . "includes/footer"); ?>

    </div>


<?php $this->load->view($viewFolder . "includes/shoutbox"); ?>


</body>



<?php $this->load->view($viewFolder . "includes/close"); ?>





