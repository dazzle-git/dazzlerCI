<?php $this->load->view($viewFolder . "includes/meta"); ?>
<link rel="stylesheet" href="<?php echo site_url('assets/css/css.css'); ?>">
<body>


    <div class="wrapper">

        <?php $this->load->view($viewFolder . "includes/header"); ?>

        <div class="container login section">


            <div class="row">

                <div class="col-md-10 col-md-offset-1 search">
                    <h2>List Page</h2>
                    <?php
                    foreach ($items as $key => $val) {
                        //echo mediaUrl($val->bigSizeFile);
                        ?>
                        <div class="row vfeed">
                            <div class="col-sm-2">
                                <div class="pr_brief pull-left">
                                    <img width="150" height="150" src="http://dazzler.com/ci/images/profile/noimage.jpg">
                                    <span class="profile_name"><?php echo $val->fullname; ?></span>
                                </div>
                            </div>
                            <div class="col-sm-10">

                                <div class="videoUiWrapper thumbnail videoSearch">

                                    <div class="vc-player">
                                        <video id="a240e92d" class="sublime" poster="<?php echo mediaUrl($val->smallSizeFile); ?>" width="500" height="360" title="Midnight Sun" data-uid="a240e92d" preload="none">
                                            <source src="<?php echo mediaUrl($val->bigSizeFile); ?>" data-quality="hd"/>

                                        </video>
                                    </div>


                                    <div class="pdescr">
                                        <h2>Nice delicious dish</h2>

                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras ultricies vitae ante a bibendum. Donec ullamcorper a erat in condimentum.				 				
                                        <div class="pstats row">
                                            <div class="col-md-6">
                                                <i class="fa fa-eye fa-2x"></i> &nbsp; 26 Views
                                            </div>
                                            <div class="col-md-3">
                                                <a class="dz-like like" href="http://dazzler.com/ci/ajax/like/13"><i class="fa fa-thumbs-o-up fa-2x"></i>I Like this</a>
                                            </div>
                                            <div class="col-md-3">
                                                <a class="dz-dislike dislike" href="http://dazzler.com/ci/ajax/dislike/13"><i class="fa fa-thumbs-o-down fa-2x"></i>I Dislike this</a>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div> 
                    <?php } ?>
                </div>
                <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> 


            </div>



        </div>





        <?php $this->load->view($viewFolder . "includes/footer"); ?>

    </div>




</body>



<?php $this->load->view($viewFolder . "includes/close"); ?>



