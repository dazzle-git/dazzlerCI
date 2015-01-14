<!-- Modal -->
<div class="modal fade uploadmodal" id="uploadfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Upload</h4>
      </div>
        
        <form class="form-horizontal" id="formupload"  role="form" enctype="multipart/form-data" method="post" action="<?php echo site_url("media/do_upload"); ?>" >
      <div class="modal-body">
          
      	 
      	 		<div class="form-group">
      	 			<label for="title" class="col-md-3">Title</label>
      	 			<div class=" col-md-9">
      	 			<input class="form-control" placeholder="" id="title" name="title" required >
      	 			</div>
      	 		</div>
      	 
      	 
      	 		<div class="form-group">
      	 			<label for="tags" class="col-md-3">Tags</label>
      	 			<div class=" col-md-9">
      	 				<input class="form-control" placeholder="" id="tags" name="tags" required >
      	 			</div>
      	 		</div>


      	 		<div class="form-group">
      	 			<label for="descr" class="col-md-3">Description</label>
      	 			<div class=" col-md-9">
      	 			<textarea class="form-control" placeholder="" rows="5" id="descr" name="descr" required ></textarea>
      	 			</div>      				
      	 		</div>
      	 
      	 
      	 		<div class="form-group">
      	 			<label for="descr" class="col-md-3">File Upload</label>
      	 			<div class=" col-md-9">
                                    <input type="file" class="form-control" placeholder="" name="fileUpload"  id="fileUpload" required >
      	 			</div>      				
      	 		</div>
      	 
      	 
				       


      </div>
      <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Upload</button>
      </div>
        </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade settingsmodal" id="settings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Settings</h4>
      </div>
      <div class="modal-body">
      
      
      <div class="row">

		  <!-- Navigation Buttons -->
		  <div class="col-md-3 lside">
		    <ul class="nav nav-stacked" id="settingsTabs">
		      <li class="active"><a href="#password">Password</a></li>
		      <li><a href="#notifications">Notifications</a></li>
		      <li><a href="#msgsettings">Message Settings</a></li>
		    </ul>
		  </div>
		
		  <!-- Content -->
		  <div class="col-md-9 rside">
		    <div class="tab-content">
		      <div class="tab-pane active" id="password">
					<form class="form-horizontal" role="form" method="post" action="<?php echo site_url("get_password/chpassword"); ?>">
					<div class="form-group">
						<label for="oldpass" class="col-md-3 col-md-offset-1">Old Password</label>
						<div class="col-md-8">
						<input type="password" id="oldpass" name="oldpass" class="form-control squared" value="" placeholder="Old Password" required />
						</div>
					</div>
					
					<div class="form-group">
						<label for="newpass" class="col-md-3 col-md-offset-1">New Password</label>
						<div class="col-md-8">
						<input type="password" id="newpass" name="newpass" class="form-control squared" value="" placeholder="New Password" required />
						</div>
					</div>
					
					<div class="form-group">
						<label for="confirmpass" class="col-md-3 col-md-offset-1">Confirm Password</label>						
						<div class="col-md-8">
						<input type="password" id="confirmpass" name="confirmpass" class="form-control squared" value="" placeholder="Retype Password" required />
						</div>
					</div>

					<div class="form-group right">
                                            <button class="btn squared" type="submit">Save</button>
					</div>
					
					</form>	
			  </div>
		      <div class="tab-pane" id="notifications">Profile</div>
		      <div class="tab-pane" id="msgsettings">Messages</div>
		    </div>
		  </div>

	  </div>
      
      
      </div>
 
    </div>
  </div>
</div>

</body>
</html>
<?php $this->load->view($viewFolder . "includes/modalBox"); ?>