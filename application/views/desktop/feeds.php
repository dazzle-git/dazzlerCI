
<?php $this->load->view($viewFolder . "includes/meta"); ?>

<body>


<div class="wrapper">

	<?php $this->load->view($viewFolder . "includes/header"); ?>
	
	<div class="container section">
	
	<?php foreach($feeds as $frow) { 
					
			$profileimg = $frow->profileImage;
			$profileimgurl = site_url("/images/profile/" . $profileimg);
			$fullname = $frow->fullname;	
			$filename = $frow->bigSizeFile;
			$videoname = $frow->videoName;
			$descr = $frow->description;
			$noView = $frow->noView;
			$mediaid = $frow->mediaId;

	?>
	
	<div class="row vfeed">
		<div class="col-sm-2">
			<div class="pr_brief pull-left">
			 		<img src="<?php echo $profileimgurl; ?>" width="150" height="150" />
			 		<span class="profile_name"><?php echo $fullname; ?></span>
			 </div>
		</div>
		<div class="col-sm-10">
			
			<div class="videoUiWrapper thumbnail">
			  	<div class="vc-player"><video  id="featurevideo" class="mediumsize">
			    <source src="<?php echo mediaUrl($filename); ?>" type="video/mp4">
			    Your browser does not support the video tag.
			  	</video>
				</div>
			</div>
			
			<div class="pdescr">
				<h2><?php echo $videoname; ?></h2>
					
				<?php echo $descr; ?>
				 				
				<div class="pstats row">
					<div class="col-md-6">
					  <i class="fa fa-eye fa-2x"></i> &nbsp; <?php echo $noView; ?> Views
					</div>
					<div class="col-md-3">
					  <a href="<?php echo site_url("/ajax/like/" . $mediaid); ?>" class="dz-like like"><i class="fa fa-thumbs-o-up fa-2x"></i>I Like this</a>
					</div>
					<div class="col-md-3">
					 <a href="<?php echo site_url("/ajax/dislike/" . $mediaid); ?>" class="dz-dislike dislike"><i class="fa fa-thumbs-o-down fa-2x"></i>I Dislike this</a>
					</div>
				</div>
			</div>
			
			
			
		</div>
	</div> <!--  row ends -->
	
			<?php } ?>
		
	</div>  <!--  section ends -->


 


	
	
	<?php $this->load->view($viewFolder . "includes/footer"); ?>
	
</div>

	
	
		
</body>



<?php $this->load->view($viewFolder . "includes/close"); ?>



