<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Reset Password</title>
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/lib/bootstrap/css/bootstrap.css'); ?>">

        <link rel="stylesheet" type="text/css" href="<?php echo site_url('assets/css/theme.css'); ?>">
        <link rel="stylesheet" href="<?php echo site_url('assets/lib/font-awesome/css/font-awesome.css'); ?>">

        <script src="<?php echo site_url('assets/lib/jquery-1.7.2.min.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('assets/lib/bootstrap/js/bootstrap.js'); ?>"></script>

        <!-- Demo page code -->

        <style type="text/css">
            #line-chart {
                height:300px;
                width:800px;
                margin: 0px auto;
                margin-top: 1em;
            }
            .brand { font-family: georgia, serif; }
            .brand .first {
                color: #ccc;
                font-style: italic;
            }
            .brand .second {
                color: #fff;
                font-weight: bold;
            }
        </style>

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Le fav and touch icons -->
        
    </head>

    <!--[if lt IE 7 ]> <body class="ie ie6"> <![endif]-->
    <!--[if IE 7 ]> <body class="ie ie7 "> <![endif]-->
    <!--[if IE 8 ]> <body class="ie ie8 "> <![endif]-->
    <!--[if IE 9 ]> <body class="ie ie9 "> <![endif]-->
    <!--[if (gt IE 9)|!(IE)]><!--> 
    <body class=""> 
        <!--<![endif]-->

        <div class="navbar">
            <div class="navbar-inner">
                <ul class="nav pull-right">

                </ul>
                <a class="brand" href="<?php echo site_url('/admin');?>"><span class="second">Dazzler</span></a>
            </div>
        </div>






        <div class="row-fluid">
            <div class="dialog">
                <div class="block">
                    <p class="block-heading">Reset your password</p>
                    <div class="block-body">
                        <?php echo validation_errors('<p class="alert alert-danger">','</p>'); ?>
                        <?php echo ((isset($message)) ? $message : ''); ?>
                        <form name="forgotFrm" id="forgotFrm" method="post" action="<?php echo site_url('gfp/adminEmail');?>">
                            <label>Email Address</label>
                            <input type="email" class="span12" name="emailadd" id="emailadd" required></input>
                            <button type="submit" class="btn btn-primary pull-right">Send</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
                <a href="<?php echo site_url('/admin');?>">Sign in to your account</a>
            </div>
        </div>





        <script src="lib/bootstrap/js/bootstrap.js"></script>
        <script type="text/javascript">
            $("[rel=tooltip]").tooltip();
            $(function() {
                $('.demo-cancel-click').click(function() {
                    return false;
                });
            });
        </script>

    </body>
</html>


