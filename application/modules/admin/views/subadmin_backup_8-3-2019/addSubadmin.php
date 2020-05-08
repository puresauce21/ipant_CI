    <!-- Content Header (Page header) -->
    <section class="content-header">
	  <h1>
		<?php echo $title; ?>
	  </h1>
	  <?php echo $this->breadcrumbs->show(); ?> 
	</section>
	
	<!-- Main content -->
    <section class="content">
		<!-- Default box -->
      <div class="box">
      	<?php
			if (!empty($subadminDetails->id)) { 
				$emailDisable = "disabled";
				$url = site_url('admin/subadmin/updateSubadmin/'.encode($subadminDetails->id));
		    } else { 
		    	$emailDisable = "";
		    	$url = site_url('admin/subadmin/save');
		    }

			?>
      	<form role="form" method="POST" action="<?php echo $url; ?>" enctype="multipart/form-data" data-parsley-validate>
			<div class="box-body">
				
				<div class="row text-center no-margin">
					<div class="user-img-wrap">
						<div class="circle">
							<label for="picsss">
							<?php $image=!empty($subadminDetails->profile_pic) ? $subadminDetails->profile_pic : ""; ?>
							<img class="profile-pic" src="<?php echo getImage($image,"admin_profile"); ?>" id="blah">
							</label>
						</div>
						<div class="p-image">
							<i class="fa fa-camera upload-button"></i>
							<input class="file-upload" name="adminProfile" id="picsss" type="file" accept="image/*"/>
						</div>
						<input type="hidden" name="oldImageName" value="<?php echo (isset($subadminDetails->profile_pic)) ? $subadminDetails->profile_pic : ""; ?>">
					</div>
				</div>

				

				<div class="row no-margin">
					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo $this->lang->line('first_name'); ?></label>
						  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('first_name'); ?>" name="firstname" value="<?php echo (isset($subadminDetails->firstname)) ? $subadminDetails->firstname : ""; ?>" data-parsley-required-message="<?php echo $this->lang->line('first_name_required'); ?>" maxlength="25" required="">
						</div>
					</div>
					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo $this->lang->line('last_name'); ?></label>
						  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('last_name'); ?>" name="lastname" value="<?php echo (isset($subadminDetails->lastname)) ? $subadminDetails->lastname : ""; ?>" data-parsley-required-message="<?php echo $this->lang->line('last_name_required'); ?>" maxlength="25" required="">
						</div>
					</div>
				</div>
				
				<div class="row no-margin">
					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo $this->lang->line('email'); ?> </label>
						  <input type="email" <?php echo $emailDisable; ?>  class="form-control emailExist" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('email'); ?>" name="email" value="<?php echo (isset($subadminDetails->email)) ? $subadminDetails->email : ""; ?>" data-parsley-required-message="<?php echo $this->lang->line('email_required'); ?>" required="">
						</div>
					</div>
				<?php 
					if (empty($subadminDetails->id)) { 
				 ?>
					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo $this->lang->line('password'); ?> </label>
						  <input type="password" class="form-control" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('password'); ?>" name="password" value="" data-parsley-required-message="<?php echo $this->lang->line('password_required'); ?>" required="">
						</div>
					</div>
				</div>
					<?php 
					}
				 ?>
				<div class="row no-margin">
					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo $this->lang->line('mobile'); ?></label>
						  <input type="text" class="form-control check_no" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('mobile'); ?>" name="mobile" value="<?php echo (isset($subadminDetails->mobile_no)) ? $subadminDetails->mobile_no : ""; ?>" data-parsley-required-message="<?php echo $this->lang->line('mobile_number_required'); ?>" maxlength="25" required="">
						</div>
					</div>

					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo $this->lang->line('select_role'); ?></label>
						  <select class="form-control" id="exampleInputEmail1" name="role_id" data-parsley-required-message="<?php echo $this->lang->line('role_required'); ?>" required="">
						  	<option value="">Select</option>
						  	<?php 
						  		if(!empty($roleDetails)){
									$activeRole = getActiveRole();
    								foreach($roleDetails as $role){
						  				if (in_array($role->id, $activeRole)) {
							?>
							<option value="<?php echo $role->id; ?>" <?php echo (set_value('role_id', isset($subadminDetails->role_id) ? $subadminDetails->role_id : '')==$role->id) ? 'selected="selected"':'';?>><?php echo $role->role_name; ?></option>
							<?php
						  				}
						  			}
						  		}
						  	?>
						  	
						  </select>
						</div>
					</div>
				</div>
				
				<div class="row no-margin">
					<div class="col-md-12 button-wrap">
						<button type="submit" class="btn btn-primary"><?php echo $button; ?></button>
				    </div>
				</div>

			 </div>

		  </form>
	  </div>
      <!-- /.box -->
	</section>
    <!-- /.content -->
   
 <script>
    $('.emailExist').blur(function(){
        var emailId = $(this).val();
        
        var email=validateEmail(emailId);
        if (email==true) {
            var url         =  '<?php echo base_url('admin/subadmin/getemail');?>';
            var formData    = {
                'emailId':emailId
                };
            $.ajax({
                type: 'POST',
                url: url,
                dataType: 'json',
                async: false,
                data: formData,	
                success: function(data) {
                   if(data.isSuccess==true){
						showErrorMessage("Email Already Exists!");
						$('.emailExist').val("");
                    }else{
                         $("#emailError").html('');
                    }
                },
            });	
        }
    });
    
    
    function validateEmail(email) { 
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email.trim());
    } 
     
  
    </script>