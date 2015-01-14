
<?php $this->load->view($viewFolder . "includes/meta"); ?>

<body>


<div class="wrapper">

	<?php $this->load->view($viewFolder . "includes/header"); ?>
	
	
	<div class="container notifications">
	<span class="title uline">Notifications</span>
	<br>
	
	<ul class="notif-list">
		<?php 
			foreach($notifs as $nrow) { 
				$type = $nrow->type;
				$mediaid = $nrow->mediaId;
				$mediatype = $nrow->mediaType;
				$isRead = "Y";
				$dt = $nrow->dt;
				$count = count($nrow->rows);
				$txt = "";
				$clen= ($count<2)?$count:2;				
				for($ic=0; $ic<$clen; $ic++) {
					$irow  = $nrow->rows[$ic];
					$userurl = site_url("/user/profile/" . $irow->senderId);
					$txt .= "<a href=\"" . $userurl . "\">"  . $irow->fullname . "</a>, ";
					if($irow->isRead=="N") $isRead="N";		
				}
				$txt = trim(trim($txt),",");
				
				if($clen<$count) {
					$txt = $txt . " and " . ($count-$clen) . " others ";
				}
				$mediaurl = site_url("/media/details/" . $mediaid);
				$type = ($type == "Dazzle")?"dazzled":$type;
				$type = ($type == "Follow")?"followed":$type;
				$type = ($type == "Comment")?"commented on":$type;
				
				if($type=="dazzled" || $type=="followed")
				  $endtxt = " you ";
				else 
				  $endtxt = " your <a href=\"" .  $mediaurl . "\">"  . $mediatype . "</a>";
				
				
		?>
			<li class="<?php echo ($isRead!="N")?"read":""; ?>"><i class="fa fa-thumbs-o-up"></i> <?php echo $txt; ?> <?php echo strtolower($type) . "  "  . $endtxt; ?>  <span class="notif-time"><?php echo GetTimeDifference($dt); ?></span></li>
		<?php } ?>
	
		</ul>

	</div>
	
	<?php $this->load->view($viewFolder . "includes/footer"); ?>
	
</div>

	
	
		
</body>



<?php $this->load->view($viewFolder . "includes/close"); ?>



