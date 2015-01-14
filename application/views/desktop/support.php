
<?php $this->load->view($viewFolder . "includes/meta"); ?>

<body>


<div class="wrapper">

	<?php $this->load->view($viewFolder . "includes/header"); ?>
	
	
	<div class="container csupport">
		
	<div class="supporttitle">
		<h2>Contact Customer Support</h2>
		<p>Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum </p>
	</div>
	
	<div class="support-section">
		<p class="topbar">Your question may already be answered in our Support Center. If not, send us a message:</p>
		<div class="solutionform">
		
			<form class="form-horizontal">
			
			<div class="form-group">
				<label for="cname" class="col-md-2 control-label left">Your Name</label>
				<div class="col-md-8">
				<input type="text" class="form-control squared" value="" placeholder="" />
				</div>			
			</div>
			
			<div class="form-group">
				<label for="cname" class="col-md-2 control-label left">Your Email Address</label>
				<div class="col-md-8">
				<input type="text" class="form-control squared" value="" placeholder="" />
				</div>			
			</div>
			
			<div class="form-group">
				<label for="cname" class="col-md-2 control-label left">Message</label>
				<div class="col-md-8">
				<textarea class="form-control squared" placeholder="" rows="8"></textarea>
				</div>			
			</div>
			 
			 
			 <div class="form-group">
				<div class="col-md-10">
				 <button class="btn btn-squared pull-right">Send</button>
				</div>			
			</div>
			 
			</form>
			
			 
			 
			 
		</div>
		
		
	</div>
	
	<div class="support-section">
		<p class="topbar">Email Support</p>
		
		<div class="row">
			<div class="col-md-3">
				<div class="bcard">
				<span>Business Development</span>
				<a href="mailto:bizdev@dazzler.com">bizdev@dazzler.com</a>
				</div>
			</div>
		
			<div class="col-md-3">
				<div class="bcard"><span>Public Relations</span>
				<a href="mailto:press@dazzler.com">press@dazzler.com</a>
				</div>
			</div>
		
			<div class="col-md-3">
				<div class="bcard"><span>Contributor Support</span>
				<a href="mailto:submit@dazzler.com">submit@dazzler.com</a></div>
			</div>
		
		</div>
	
	</div>
	 
	

	</div>
	
	<?php $this->load->view($viewFolder . "includes/footer"); ?>
	
</div>

	
	
		
</body>



<?php $this->load->view($viewFolder . "includes/close"); ?>



