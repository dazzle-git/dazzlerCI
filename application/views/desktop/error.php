<?php $this->load->view($viewFolder . "includes/meta"); ?>

<body>


<div class="wrapper">

	<?php $this->load->view($viewFolder . "includes/header"); ?>
	
	<div class="container login section">
		
		
		<div class="row">
		
			<div class="col-md-10 col-md-offset-1">
				<h3>Error Page</h3>
				<br><p><?php print_r($error);?></p>
			</div>
			<br> <br> <br> <br> <br> <br> <br> <br> <br> <br> 


		</div>
	
			    
			
	</div>

  
		

	
	<?php $this->load->view($viewFolder . "includes/footer"); ?>
	
</div>

	
	
		
</body>



<?php $this->load->view($viewFolder . "includes/close"); ?>



