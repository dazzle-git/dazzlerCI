<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$method = $this->router->method;
?>
<div class="sidebar-nav">
    <a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-dashboard"></i>Dashboard</a>
    <ul id="dashboard-menu" class="nav nav-list collapse in">
        <li><a href="<?php echo site_url('/admin');?>">Home</a></li>
        <li <?php if($method == 'medialist') { ?> class="active"<?php } ?>><a href="<?php echo site_url('admin/medialist');?>">Media List</a></li>
        <li <?php if($method == 'mediadetails') { ?> class="active"<?php } ?>><a href="#">Media Item</a></li>
        <!--        <li><a href="media.html">Media</a></li>
                <li><a href="calendar.html">Calendar</a></li>-->

    </ul>

    <a href="#accounts-menu" class="nav-header" data-toggle="collapse"><i class="icon-briefcase"></i>Account<span class="label label-info">+3</span></a>
    <ul id="accounts-menu" class="nav nav-list collapse">
        <!--        <li ><a href="sign-in.html">Sign In</a></li>
                <li ><a href="sign-up.html">Sign Up</a></li>-->
        <li ><a href="<?php echo site_url('admin/changepassword');?>">Change Password</a></li>
    </ul>

<!--    <a href="#error-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-exclamation-sign"></i>Error Pages <i class="icon-chevron-up"></i></a>
    <ul id="error-menu" class="nav nav-list collapse">
        <li ><a href="403.html">403 page</a></li>
        <li ><a href="404.html">404 page</a></li>
        <li ><a href="500.html">500 page</a></li>
        <li ><a href="503.html">503 page</a></li>
    </ul>

    <a href="#legal-menu" class="nav-header" data-toggle="collapse"><i class="icon-legal"></i>Legal</a>
    <ul id="legal-menu" class="nav nav-list collapse">
        <li ><a href="privacy-policy.html">Privacy Policy</a></li>
        <li ><a href="terms-and-conditions.html">Terms and Conditions</a></li>
    </ul>

    <a href="help.html" class="nav-header" ><i class="icon-question-sign"></i>Help</a>
    <a href="faq.html" class="nav-header" ><i class="icon-comment"></i>Faq</a>-->
</div>
