<header>
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid nheader">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo site_url("/"); ?>"><img src="<?php echo site_url("images/logo.png"); ?>"></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      
      <ul class="nav navbar-nav navbar-right">
      	<li>
      	 	<form name="searchform" id="searchform">
			<div class="inner-addon right-addon">
			   <i class="fa fa-search"></i><input type="text" class="searchtxt form-control" placeholder="Search" />
			</div>
			</form>
		</li>
      	
      	<?php if($isloggedin) { ?>
      	
      	<?php if(isset($h_messages)) { ?>
       	 <li class="dropdown">
          <a href="<?php echo site_url("/user/messages"); ?>" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope-o"></i> <span class="nmgs lbl txt-notif"><?php echo $h_messages; ?></span></a>
       </li>
       <?php } ?>

       	<?php if(isset($h_notification)) { ?>
       	<li class="dropdown">
          <a href="<?php echo site_url("/user/notification"); ?>"><i class="fa fa-bell-o"></i> <span class="nmgs lbl txt-notif"><?php echo $h_notification; ?></span></a>
       	</li>
       	<?php } ?>
       	<li class="dropdown">
          <a href="#" class="dropdown-toggle" id="uploadbtn"><i class="fa fa-upload"></i> <span class="nmgs lbl">upload</span></a>
       </li>
      	 
       <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img class="profileicon lbl" src="<?php echo site_url("images/profile/" . $UserSession->userImage); ?>" border="0"> <span class="fa fa-angle-down"></span></a>
          <ul class="dropdown-menu" role="menu">
          		<li><a href="<?php echo site_url("/user/profile"); ?>"> Profile</a></li>
          		<li><a href="#" class="dropdown-toggle" data-toggle="modal" data-target="#settings"> Account Setting</a></li>
          		<li><a href="<?php echo site_url("/user/logout"); ?>">   Logout</a></li>
          </ul>
       </li>
       
       <?php } else { ?>
       
       
       	<li class="dropdown">
          <a href="<?php echo site_url("/user/login"); ?>"><i class="fa fa-sign-in"></i> <span class="lbl">Sign In</span></a>
       </li>
       <?php } ?>

      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</header>
