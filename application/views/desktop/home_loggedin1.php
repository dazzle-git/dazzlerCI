<?php $this->load->view($viewFolder . "includes/meta"); ?>

<body>

<?php //echo $this->router->fetch_class(). $this->router->fetch_method().$this->uri->segment(2); ?>
<div class="wrapper">

	<?php $this->load->view($viewFolder . "includes/header"); ?>
	
	<div class="container section">
			 
			
			
			<div class="row">
                             <?php   echo validation_errors('<p class="error">','</p>'); ?>
				<?php
                                    
                                    if(isset($error) && $error != ''){
                                        $errors = $error;
                                     ?>
                                    <div class="errorMessage">
                                     <?php  print_r($errors);     ?>
                                    </div>
                                    <?php } ?>
				<h3 class="center">Dazzler.com is for everyone it empowers one & all</h3>
				
				<div class="col-sm-10 col-sm-offset-1">
					<div class="row">
					<div class="col-sm-4 col1"> 
                                            <a href="aboutus">
						<img src="<?php echo site_url("/images/col1_logged.png"); ?>"><br>
						<span class="bluetxt">For Fans</span>
                                            </a>
                                                
						<p class="center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a ultrices ipsum.</p>

					</div>
					<div class="col-sm-4 col2"> 
                                            <a href="aboutus">
						<img src="<?php echo site_url("/images/col2_logged.png"); ?>"><br>
						<span class="bluetxt">For Artists</span>
                                            </a>
						<p class="center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a ultrices ipsum.</p>
					 </div>
					
					<div class="col-sm-4 col3"> 
                                            <a href="aboutus">
						<img src="<?php echo site_url("/images/col3_logged.png"); ?>"><br>
						<span class="bluetxt">For Companies</span>
                                            </a>
						<p class="txt-sm center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In a ultrices ipsum.</p>
					</div>
					</div>
				</div>
				
				
			</div>
			
			
			<div class="row adazzler">
			 	
				<h3 class="center">Amazing <span>Dazzlers</span> to keep an eye on!</h3>
			
			
				<?php 
                                
                                
                                if(isset($topUsers)) {

						foreach($topUsers as $row ) {
							$userid  = $row->userId;
							$usertype = $row->userType;
							$follower = $row->userFollow;
							$dazzler  =  $row->userDazzle;
							//$dazzler = $row->dazzler;
							$countryName = $row->city . ", " . $row->countryname;
							$description = $row->about;
							$profileImg = $row->profileImage;
							$fullName = $row->firstName  . " " . $row->lastName;
							$profileImgUrl = site_url("images/profile/" . $profileImg );
							$hlink  = site_url("user/profile/" . $userid );
							if($countryName=="") $countryName = "&nbsp;";
							
							//print $row->userEmail;
										
				?>
				
					<div class="col-sm-4">
						
						<div class="user-list-1 hlink" onClick="javascript:location.href='<?php echo escapeJS($hlink); ?>'">
							<img class="userimg"  src="<?php echo $profileImgUrl; ?>">
							<div class="udetails">
								<span class="uname"><?php echo $fullName; ?></span>
								<span class="ulocation"><?php echo $countryName; ?></span>
								<span  class="ubrief"><?php echo truncateWords($description, 20,"..."); ?></span>
							
								<div class="row">
									<div class="udazzle center">
										<img src="images/icondazzle.png">
										<span class="dazzlecount"><?php echo $dazzler; ?></span>
										<a href="<?php echo site_url("/ajax/dazzle/" . $userid); ?>" data-upd-id="dazzlecount" class="dazzle">Dazzle</a>
									</div>
									<div class="ufollow center">
										<img src="images/iconfollow.png">
										<span class="followcount"><?php echo $follower; ?></span>
										<a href="<?php echo site_url("/ajax/follow/" . $userid); ?>" data-upd-id="followcount"  class="follow">Follow</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					
				<?php }  } ?>
					
					<!-- 
					
				  <div class="col-sm-4">
						<div class="user-list-1">
							<img class="userimg"  src="images/userimg1.jpg">
							<div class="udetails">
								<span class="uname">Avril Lavigne</span>
								<span class="ulocation">Brighton, UK</span>
								<span  class="ubrief">A writer, teacher, wife, mother, walker, cook, and..</span>
							
								<div class="row">
									<div class="udazzle center">
										<img src="images/icondazzle.png">
										<span class="dazzlecount">10</span>
										<a href="">Dazzle</a>
									</div>
									<div class="ufollow center">
										<img src="images/iconfollow.png">
										<span class="followcount">20</span>
										<a href="">Follow</a>
									</div>
								</div>
							</div>
						</div>
					</div>
			
					<div class="col-sm-4">
						<div class="user-list-1">
							<img class="userimg"  src="images/userimg2.jpg">
							<div class="udetails">
								<span class="uname">Adam Levine</span>
								<span class="ulocation">Brighton, UK</span>
								<span  class="ubrief">A writer, teacher, wife, mother, walker, cook, and..</span>
							
								<div class="row">
									<div class="udazzle center">
										<img src="images/icondazzle.png">
										<span class="dazzlecount">10</span>
										<a href="">Dazzle</a>
									</div>
									<div class="ufollow center">
										<img src="images/iconfollow.png">
										<span class="followcount">20</span>
										<a href="">Follow</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="user-list-1">
							<img class="userimg" src="images/userimg3.jpg">
							<div class="udetails">
								<span class="uname">Shakira</span>
								<span class="ulocation">Brighton, UK</span>
								<span  class="ubrief">A writer, teacher, wife, mother, walker, cook, and..</span>
							
								<div class="row">
									<div class="udazzle center">
										<img src="images/icondazzle.png">
										<span class="dazzlecount">10</span>
										<a href="">Dazzle</a>
									</div>
									<div class="ufollow center">
										<img src="images/iconfollow.png">
										<span class="followcount">20</span>
										<a href="">Follow</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				
						-->
				
				</div>
			
			</div>
			
			
	
	<div class="section contentlist">	
		<div class="container">
		<h3>Begin your journey & explore dazzlers in the world</h3>
		
		<div class="row">
			
			<?php 
			
				if(isset($topContents)) { 
					$cList = $topContents;
					foreach($cList as $row) {
						$img =  site_url("images/media/" . $row->smallImage);
						$profileIco = site_url("images/profile/50x50_" . $row->profileImage);
						$title = $row->videoName;
						$fullname = $row->fullname;
						$nav_url = site_url("/media/details/" . $row->mediaId);
						
			?>
				
				<div class="cont-list-1 hlink" onClick="location.href='<?php echo escapeJS($nav_url); ?>';">
					<img class="contentico" src="<?php echo $img; ?>"  />
					<div class="captions">
						<img class="ico-1" src="<?php echo $profileIco; ?>">
						<a href="<?php echo $nav_url; ?>"><span class="ctitle"><?php echo $title; ?></span></a><br />
						<span class="cartist">by <?php echo $fullname; ?></span>
					</div>
				</div>
			
			<?php 
					}
				}
			?>
		
	
		</div>
	</div>
	</div>
	
	
	
	<?php $this->load->view($viewFolder . "includes/footer"); ?>
	
</div>

	
	
		
</body>



<?php $this->load->view($viewFolder . "includes/close"); ?>



