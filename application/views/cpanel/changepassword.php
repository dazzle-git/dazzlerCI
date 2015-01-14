<?php $this->load->view($viewFolder . "includes/meta"); ?>
<script src="<?php echo site_url('assets/lib/bootstrap/js/jquery.bootpag.min.js'); ?>"></script>
<script src="<?php echo site_url('assets/js/ajax.js'); ?>"></script>    
<script type="text/javascript">
    $("[rel=tooltip]").tooltip();
    $(function() {
        $('.demo-cancel-click').click(function() {
            return false;
        });
    });

</script>

<body>
    <?php $this->load->view($viewFolder . "includes/navbar.php"); ?>

    <?php $this->load->view($viewFolder . "includes/menu.php"); ?>
    <div class="content">

        <div class="header">
            <h1 class="page-title">Media</h1>
        </div>

        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('/admin');?>">Account</a> <span class="divider">/</span></li>
            <li class="active">Change Password</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">


                <div class="block">
                    <p class="block-heading">Change your password</p>
                    <div class="block-body">
                        <?php echo validation_errors('<p class="alert alert-danger">','</p>'); ?>
                        <?php echo ((isset($message)) ? $message : ''); ?>
                        <form class="form-horizontal" role="form" method="post" action="<?php echo site_url("get_password/adminchpassword"); ?>">
                            <div class="form-group">
                                <label for="oldpass">Old Password</label>
                                <input type="password" id="oldpass" name="oldpass" class="form-control squared" value="" placeholder="Old Password" required />

                            </div>

                            <div class="form-group">
                                <label for="newpass">New Password</label>                                
                                <input type="password" id="newpass" name="newpass" class="form-control squared" value="" placeholder="New Password" required />

                            </div>

                            <div class="form-group">
                                <label for="confirmpass">Confirm Password</label>						
                                <input type="password" id="confirmpass" name="confirmpass" class="form-control squared" value="" placeholder="Retype Password" required />

                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group right">
                                <button class="btn squared" type="submit">Save</button>
                            </div>

                        </form>	

                        <div class="clearfix"></div>
                    </div>
                </div>
                <?php $this->load->view($viewFolder . "includes/footer"); ?>

            </div>
        </div>
    </div>
</body>
