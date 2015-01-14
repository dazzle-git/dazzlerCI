<?php $this->load->view($viewFolder . "includes/meta"); ?>

<body>


<div class="wrapper">

	<?php $this->load->view($viewFolder . "includes/header"); ?>
	
	<div class="container account">
			<div class="jumbotron">
			  <h1>.99$</h1>
			  <p class="line1 bluetxt">Be a Pro Dazzler</p>
			  <p class="line2">Upgrade to a more efficient and collaborative workday.</p>
			  
			  
			  <p class="line-small">Speed up your meetings, keep everyting at your fingertips and make Evernote even more file-friendly with Evernote Premium.<br />
			  No need to build slides, just one click and your notes are transformed into a beautiful screen-friendly layout.
			</div>			
			
			<h3>Upgrade now or <a href="">Create Account</a></h3>
			
			<div class="register">
				<p class="title">Register with us and get access to some awesome features</p>
				
				<div class="row">
						<input type="text" id="user_email" name="user_email" placeholder="Email" class="form-control col-sm-12">
				
					     <input type="password" placeholder="Password" class="form-control  col-sm-12">
				</div>
				
				<div class="row btnrow">
				
					<p class="txt-sm pull-left">By registering, you agree to our Terms of Service</p>	
					<button class="btn btn-green pull-right">Upgrade to Pro</button>
				</div>
				</div>
			
			
			<div class="row benefits">
				 
				<h3 class="center">More reasons to upgrade</h3>
				
				<div class="col-sm-10 col-sm-offset-1">
					<div class="row">
					<div class="col-sm-4 col1"> 
						<img src="<?php echo site_url("/images/acc-col1.png"); ?>"><br>
						<span class="bluetxt">STATISTICS</span>
						<p class="txt-sm center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a ultrices ipsum.</p>

					</div>
					<div class="col-sm-4 col2"> 
						<img src="<?php echo site_url("/images/acc-col2.png"); ?>"><br>
						<span class="bluetxt">ADD MORE FILES</span>
						<p class="txt-sm center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a ultrices ipsum.</p>
					 </div>
					
					<div class="col-sm-4 col3"> 
						<img src="<?php echo site_url("/images/acc-col3.png"); ?>"><br>
						<span class="bluetxt">ADVANCED SEARCH</span>
						<p class="txt-sm center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a ultrices ipsum.</p>
					</div>
					</div>
				</div>
				
				
			</div>
			
			
			<div class="row accountstype">
			
			<div class="col-sm-10 col-sm-offset-1">
			<div class="row">
				<div class="col-md-4">
					
					<div class="squared acnttype">
						<h3>Free Account</h3>
						
						<ul>
							<li><i class="fa fa-check fa-1x"></i> Lorem Ipsum</li>
							<li><i class="fa fa-check fa-1x"></i> Lorem Ipsum</li>
							<li><i class="fa fa-check fa-1x"></i> Lorem Ipsum</li>
							<li><i class="fa fa-check fa-1x"></i> Lorem Ipsum</li>
							<li><i class="fa fa-check fa-1x"></i> Lorem Ipsum</li>
													
						</ul>
					</div>
				
				</div>
			
			<div class="col-md-7 col-md-offset-1">
				<div class="squared acnttype doublelist">
						<h3>Pro Account</h3>
						<ul>
							<li><i class="fa fa-check fa-1x"></i> Lorem Ipsum</li>
							<li><i class="fa fa-check fa-1x"></i> Lorem Ipsum</li>
							<li><i class="fa fa-check fa-1x"></i> Lorem Ipsum</li>
							<li><i class="fa fa-check fa-1x"></i> Lorem Ipsum</li>
							<li><i class="fa fa-check fa-1x"></i> Lorem Ipsum</li>						
							<li><i class="fa fa-check fa-1x"></i> Lorem Ipsum</li>
							<li><i class="fa fa-check fa-1x"></i> Lorem Ipsum</li>
							<li><i class="fa fa-check fa-1x"></i> Lorem Ipsum</li>
							<li><i class="fa fa-check fa-1x"></i> Lorem Ipsum</li>
							<li><i class="fa fa-check fa-1x"></i> Lorem Ipsum</li>
						</ul>
					</div>
				
				</div>
			
			
			</div>
			
			
			
			<p class="acc-descr">Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum 
			Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum </p>
			
			<button class="btn btn-squared registernow">Register Now!</button>
			
			<p class="acc-invite">Invite more friends to gain some more early bird features!</p>
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
			
				<div class="col-sm-6">
						<input type="email" class="form-control col-sm-6" id="email" placeholder="Enter email">
		        </div>
        
		        <div class="col-sm-6">
						<input type="email" class="form-control col-sm-6" id="email" placeholder="Enter email">
		        		<button class="btn btn-primary pull-right">Subscribe</button>
        		</div>
        		
			</div>
 
 
		
		</div>
			
	
	
	
	</div>

	
	
	<?php $this->load->view($viewFolder . "includes/footer"); ?>
	
</div>

	
	
		
</body>



<?php $this->load->view($viewFolder . "includes/close"); ?>



