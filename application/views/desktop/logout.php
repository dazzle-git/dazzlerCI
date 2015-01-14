<?php $this->load->view($viewFolder . "includes/meta"); ?>

<body>


<div class="wrapper">

	<?php $this->load->view($viewFolder . "includes/header"); ?>
	
	<div class="container login section">
		
		
		<div class="row">
		
			<div class="col-md-10 col-md-offset-1">
				<h3>Logged Out</h3>
				<br><p>You have successfully logged out. To login again <a href="<?php echo site_url("/user/login"); ?>">click here</a></p>
			</div>
			<br> <br> <br> <br> <br> <br> <br> <br> <br> <br> 


		</div>
	
			    
			
	</div>

  
		

	
	<?php $this->load->view($viewFolder . "includes/footer"); ?>
	
</div>

	
	
		
</body>



<?php $this->load->view($viewFolder . "includes/close"); ?>



