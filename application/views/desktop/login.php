<?php $this->load->view($viewFolder . "includes/meta"); ?>

<body>


<div class="wrapper">

	<?php $this->load->view($viewFolder . "includes/header"); ?>
	<?php //print_r($info);?>
	<div class="container login section">
		
		
		<div class="row">
		
			<div class="col-md-10 col-md-offset-1">
				<h3>Sign In</h3>
				<p>Dazzler is a brand new social media platform which offers extraordinary exposure, ultimate opportunities & more exciting features coming soon…</p>
			
				<div class="row">
					<div class="col-md-6 sociallogin">
						<a href="<?=$login_url; ?>"><i class="fa fa-facebook fa-2x"></i> <span>Sign in with Facebook</span></a>
                		<a href="twitterLogin"><i class="fa fa-twitter fa-2x"></i> <span>Sign in with Twitter</span></a>
                		<a href="googleApi<?php //echo $openid->authUrl(); ?>"><i class="fa fa-google-plus fa-2x"></i> <span>Sign in with Google+</span></a>
					</div>
					
					
					<div class="col-md-6">
					
					<div class="loginform form-container form-horizontal">
					<form id="frmLogin" name="frmLogin" method="post"  onsubmit="//return validateFrm('frmLogin');">
					<input type="hidden" name="dataAction" id="endScroll" value="login" class="form-control">
                    <div class="form-group">
                    	<label for="userEmail">Email</label>
                    	<input type="text" name="userEmail" id="userEmail" value="" class="form-control squared textbox2 signin_form_input validate[required,custom[email]]" placeholder="Email"  required>
                    </div>
                    
                    <div class="form-group">
                    	<label for="password">Password</label>
                    	<input type="password" name="password" id="password" value="" class="form-control squared textbox2 signin_form_input validate[required,minSize[8]]" placeholder="Password" required>                    
                    	
                    	
                    </div>
                    
                    <div class="form-group">
                    	<input type="submit" class="btn btn-green" value="Sign In">	
                    </div>
                    <div class="form-group">
                        <a href="<?php echo site_url('gfp/index');?>" class="pull-right">Forgot Password?</a>
                    </div>                    
	                </form>	
	                </div>
					
					</div>
				
				
				</div>
			
			
			</div>
			

		</div>
<br><br><br>
	
	
			    
		<div class="row">
		
			<div class="new2daz col-md-10 col-md-offset-1">
				<div class="row titlerow">
				<span class="col-md-12 title">New to Dazzler</span>
				</div>
				<div class="row titlerow">
				<span class="col-md-6">For Individuals</span>
				<span class="col-md-6">For Companies</span>
				</div>
				
			
				<div class="row">
					<div class="col-md-6">
						<div class="loginform form-container form-horizontal">
					<form id="frmLogin" name="frmLogin" method="post" onsubmit="return validateFrm('frmLogin');">
					<input type="hidden" name="dataAction" id="endScroll" value="login" class="form-control">
                    <div class="form-group">
                    	<label for="userEmail">Email</label>
                    	<input type="text" name="userEmail" id="userEmail" value="" class="form-control squared textbox2 signin_form_input validate[required,custom[email]]" placeholder="Email" renderpassword="1">
                    </div>
                    
                    <div class="form-group">
                    	<label for="password">Password</label>
                    	<input type="password" name="password" id="password" value="" class="form-control squared textbox2 signin_form_input validate[required,minSize[8]]" placeholder="Password">                   
                    	
                    	
                    </div>
                    
                    <div class="form-group">
                    	<input type="submit" class="btn btn-green" value="Sign Up">	
                    </div>
                    <div class="form-group center">
                  	  By registering, you agree to our <a href="">Terms of Service</a>
                    </div>                    
	                </form>	
	                </div>
				</div>
					
					
					<div class="col-md-6">
					
					<div class="loginform form-container form-horizontal">
					<form id="frmLogin" name="frmLogin" method="post" onsubmit="return validateFrm('frmLogin');">
					<input type="hidden" name="dataAction" id="endScroll" value="login" class="form-control">
                    <div class="form-group">
                    	<label for="userEmail">Email</label>
                    	<input type="text" name="userEmail" id="userEmail" value="" class="form-control squared textbox2 signin_form_input validate[required,custom[email]]" placeholder="Email" renderpassword="1">
                    </div>
                    
                    <div class="form-group">
                    	<label for="password">Password</label>
                    	<input type="password" name="password" id="password" value="" class="form-control squared textbox2 signin_form_input validate[required,minSize[8]]" placeholder="Password">                   
                    	
                    	
                    </div>
                    
                    <div class="form-group">
                    	<input type="submit" class="btn btn-green" value="Sign Up">	
                    </div>
                    <div class="form-group center">
                  	  By registering, you agree to our <a href="">Terms of Service</a>
                    </div>                      
	                </form>	
	                </div>
					
					</div>
				
				
				</div>
			
			
			</div>
			
		
		</div>
		 
	</div>

  
		

	
	<?php $this->load->view($viewFolder . "includes/footer"); ?>
	
</div>

	
	
		
</body>



<?php $this->load->view($viewFolder . "includes/close"); ?>



