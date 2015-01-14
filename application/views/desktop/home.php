<?php $this->load->view($viewFolder . "includes/meta"); ?>

<body>


    <div class="wrapper">

        <?php $this->load->view($viewFolder . "includes/header"); ?>

        <div class="container section">
            <div class="jumbotron">
                <h1>Welcome to Dazzler</h1>
                <p class="line1 bluetxt">Showcase yourself. Get better exposure. Dazzle!</p>
                <p class="line2">Phenomenal HD player • No disturbing Ads • Free!</p>
            </div>			
            <div class="register">

                <form id="frmRegister" name="frmRegister" method="post" action="user/registration">
                    <?php //echo form_open("user/registration"); ?>
                    <p class="title">Register with us and get access to some awesome features</p>
                    <?php echo (isset($message) ? $message : ''); ?>
                    <div class="row">
                        <input type="email" id="user_email" name="user_email" placeholder="Email" class="form-control col-sm-12" required>

                        <input type="password" placeholder="Password" name="pass" name="pass" class="form-control col-sm-12" required>
                    </div>

                    <div class="row btnrow">

                        <p class="txt-sm pull-left">By registering, you agree to our Terms of Service</p>	
                        <button class="btn btn-green pull-right" type="submit">Register</button>
                    </div>
                </form>
                <?php //echo form_close(); ?>
            </div>


            <div class="row benefits">

                <h3 class="center">Dazzler.com is for everyone it empowers one & all</h3>

                <div class="col-sm-10 col-sm-offset-1">
                    <div class="row">
                        <div class="col-sm-4 col1"> 
                            <img src="<?php echo site_url("/images/col1.png"); ?>"><br>
                            <span class="bluetxt">For Fans</span>
                            <p class="center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a ultrices ipsum.</p>

                        </div>
                        <div class="col-sm-4 col2"> 
                            <img src="<?php echo site_url("/images/col2.png"); ?>"><br>
                            <span class="bluetxt">For Artists</span>
                            <p class="center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a ultrices ipsum.</p>

                            <img class="mscroll" src="<?php echo site_url("/images/mscroll.png"); ?>">
                        </div>

                        <div class="col-sm-4 col3"> 
                            <img src="<?php echo site_url("/images/col3.png"); ?>"><br>
                            <span class="bluetxt">For Companies</span>
                            <p class="txt-sm center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a ultrices ipsum.</p>
                        </div>
                    </div>
                </div>


            </div>

        </div>




        <div class="section contentlist">	
            <div class="container">
                <h3>Begin your journey & explore dazzlers in the world</h3>

                <div class="row">

                    <?php
                    if (isset($topContents)) {
                        $cList = $topContents;
                        foreach ($cList as $row) {
                            $img = site_url("images/media/" . $row->smallImage);
                            $profileIco = site_url("images/profile/50x50_" . $row->profileImage);
                            $title = $row->videoName;
                            $fullname = $row->fullname;
                            $nav_url = site_url("/media/details/" . $row->mediaId);
                            ?>

                            <div class="cont-list-1 hlink" onClick="location.href = '<?php echo escapeJS($nav_url); ?>';">
                                <img class="contentico" src="<?php echo $img; ?>"  />
                                <div class="captions">
                                    <img class="ico-1" src="<?php echo $profileIco; ?>">
                                    <a href="<?php echo $nav_url; ?>"><span class="ctitle"><?php echo $title; ?></span></a><br />
                                    <span class="cartist">by <?php echo $fullname; ?></span>
                                </div>
                            </div>

                            <?php
                        }
                    }
                    ?>


                </div>
            </div>
        </div>




        <div class="newsletter">

            <div class="nlform">
                <div class="envdiamond">
                    <img src="<?php echo site_url("images/env-diamond.png"); ?>">
                </div>
                <h3>Subscribe to our newsletter</h3>

                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum.</p>                
                <div class="row inputlist">
                    <?php
                    echo (isset($error_message) ? $error_message : '');
                    echo form_open('newsletter/save');                    
                    ?>
                    <div class="col-sm-6">
                        <input type="text" class="form-control col-sm-6" id="uname" name="uname" placeholder="Enter name" required="required">
                    </div>

                    <div class="col-sm-6">
                        <input type="email" class="form-control col-sm-6" id="email" name="email" placeholder="Enter email" required="required">
                        <button class="btn btn-primary pull-right" type="submit">Subscribe</button>
                    </div>
                    <?php echo form_close();?>
                </div>

            </div>

        </div>

<?php $this->load->view($viewFolder . "includes/footer"); ?>

    </div>




</body>



<?php $this->load->view($viewFolder . "includes/close"); ?>



