<?php $this->load->view($viewFolder . "includes/meta"); ?>

<body>
    <script src="<?php echo site_url('assets/js/perfect-scrollbar.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo site_url('assets/js/jquery-ui-1.8.2.custom.min.js'); ?>"></script> 
    <link href="<?php echo site_url('assets/css/css.css'); ?>" rel="stylesheet" type="text/css" />
    <script src="<?php echo site_url('assets/js/ajax.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo site_url('assets/js/message.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo site_url('assets/css/overlay.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/css/jquery.mCustomScrollbar.css'); ?>">	
    <link rel="stylesheet" href="<?php echo site_url('assets/css/perfect-scrollbar.css'); ?>">
    <div class="wrapper">

        <?php $this->load->view($viewFolder . "includes/header"); ?>


        <div class="container section message">
            <div class="inbox">
                <table class="table" border="0">
                    <thead>
                        <tr>
                            <td><span class="inboxtitle">Inbox</span></td>
                            <td class="right"><span class="composetxt">Compose</span></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="inb-left">
                                <div class="tophead">
                                    <label><input type="checkbox" name="selectall" id="selectall"> Select All</label>
                                    <div id="inboxactions" class="pull-right">
                                        <span class="act">Action <i class="fa fa-angle-down"></i></span>
                                        <span class="act" onClick="setAction(1);"><i class="fa fa-eye"></i> Mark as Read</span>
                                        <span class="act" onClick="setAction(2);"><i class="fa fa-trash"></i> Delete forever</span>
                                    </div>
                                </div>
                                <script>
                                            $("#inboxactions .act").click(function() {
                                                if ($("#inboxactions").hasClass("expanded")) {
                                                    $("#inboxactions").removeClass("expanded");
                                                } else {
                                                    $("#inboxactions").addClass("expanded");
                                                }
                                            });
                                </script>
                                <form name="inboxFrm" method="post" id="inboxFrm">
                                    <div  class="subcontainer">
                                        <ul>
                                            <?php
                                            foreach ($messages as $key => $val) {
                                                $timespan = GetTimeDifference($val->createdDate);
                                                //print_r($val);
                                                ?>
                                                <li class="messagelist"  onClick="loadData(<?php echo $val->messageID; ?>);">
                                                    <input type="checkbox" class="checkbox1" name="msgid[]" id="msgid_<?php echo $val->messageID; ?>" value="<?php echo $val->messageID; ?>">
                                                    <img src="<?php echo site_url("images/profile/50x50_" . $val->pimage); ?>">
                                                    <p>
                                                        <span class="timeago"><?php echo $timespan; ?></span>
                                                        <span class="muser"><?php echo ((!isset($val->fullname)) ? $val->emailAddress : $val->fullname); ?></span>
                                                        <br />
                                                        <?php if ($userId == $val->fromUserId) { ?>
                                                            <span class="replied"></span> 
                                                        <?php } ?>
                                                        <?php echo $val->message; ?>
                                                    </p>							
                                                </li>
                                            <?php } ?>

                                        </ul>
                                    </div>
                                </form>
                            </td>

                            <td class="inb-right">
                                <div class="usermessages" id="userM" ><h3>Message From <span>Markus John</span></h3>
                                    <div id="messageactions">
                                        <span class="act"><div class="actsettings"><img src="images/icosettings.png"> <i class="fa fa-angle-down"></i></div></span>
                                        <span class="act actlist"><i class="fa fa-flag-o"></i> Mark as Spam</span>
                                        <span class="act actlist"><i class="fa fa-eye"></i> Block User</span>
                                        <span class="act actlist"><i class="fa fa-trash"></i> Delete forever</span>
                                    </div>

                                    <script>
                                            $("#messageactions .act").click(function() {
                                                if ($("#messageactions").hasClass("expanded")) {
                                                    $("#messageactions").removeClass("expanded");
                                                } else {
                                                    $("#messageactions").addClass("expanded");
                                                }
                                            });
                                    </script>


                                    <ul id="messageContent">
                                        <?php if (count($pview) > 0) { ?>
                                            <form id="replymessage" method="post" name="frmReply" action="<?php echo site_url('message/saveMessage'); ?>">
                                                <input type="hidden" name="msgTopId" id="msgTopId" value="<?php echo $pview[0]->messageID;?>" />
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
                                                            <?php if ($userId == $val->fromUserId) { ?>
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
                                        ?> 
                                    </ul>

                                </div>

                                <div id="compose" class="form-container">
                                    <form id='sendMessage' method="post" action="<?php echo site_url('message/saveMessage'); ?>">
                                        <h3>New Message</h3>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label for="profession">To</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input id="useremail" name="useremail"  placeholder="Enter user email" class="form-control cfc">


                                            </div>

                                        </div>




                                        <div class="row">
                                            <div class="col-md-2">
                                                <label for="location">Message</label>
                                            </div>
                                            <div class="col-md-10">
                                                <textarea id="send_message" name="message" class="form-control cfc" placeholder="Enter message"></textarea>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-12 right">
                                                <button type="submit" class="btn btn-primary sq">Send</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </td>



                    </tbody>

                </table>




            </div>
        </div>
<?php $this->load->view($viewFolder . "includes/footer"); ?>
    </div>

</body>
<script src="<?php echo site_url('assets/js/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>

<script>
    (function($) {
        $(window).load(function() {
            $(".ui-autocomplete").mCustomScrollbar({
                setHeight: 300,
                theme: "dark-3"
            });
        });
    })(jQuery);
</script>
<script src="<?php echo site_url('assets/js/opr.js'); ?>"></script>
<?php $this->load->view($viewFolder . "includes/close"); ?>
