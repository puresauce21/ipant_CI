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
        <form role="form" method="POST" action="<?php echo base_url('admin/users/userUpdate/'.encode($userInfo->id)) ; ?>" enctype="multipart/form-data" data-parsley-validate>
			<div class="box-body">
				
				<div class="row text-center no-margin">
					<div class="user-img-wrap">
						<div class="circle">
							<label for="picsss">
								<?php $image=!empty($userInfo->profile_pic) ? $userInfo->profile_pic : ""; ?>
								<img class="profile-pic" src="<?php echo getImage($image,"user"); ?>" id="blah">
							</label>
						</div>
						<div class="p1-image">
							<i class="fa fa-camera upload-button"></i>
							<input class="file-upload" name="userProfile" id="picsss" type="file" accept="image/*"/>
						</div>
						<input type="hidden" name="oldImageName" value="<?php echo (isset($userInfo->profile_pic)) ? $userInfo->profile_pic : ""; ?>">
					</div>
				</div>

				

				<div class="row no-margin">
					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo $this->lang->line('first_name'); ?></label>
						  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('first_name'); ?>" name="first_name" value="<?php echo (isset($userInfo->firstname)) ? $userInfo->firstname : ""; ?>" data-parsley-required-message="<?php echo $this->lang->line('first_name_required'); ?>" maxlength="25" required="">
						</div>
					</div>
					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo $this->lang->line('last_name'); ?></label>
						  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('last_name'); ?>" name="last_name" value="<?php echo (isset($userInfo->lastname)) ? $userInfo->lastname : ""; ?>" data-parsley-required-message="<?php echo $this->lang->line('last_name_required'); ?>" maxlength="25" required="">
						</div>
					</div>
				</div>
				
				<div class="row no-margin">
					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo $this->lang->line('email'); ?> </label>
						  <input type="email" class="form-control" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('email'); ?>" disabled name="email" value="<?php echo (isset($userInfo->email)) ? $userInfo->email : ""; ?>" data-parsley-required-message="<?php echo $this->lang->line('email_required'); ?>" required="">
						</div>
					</div>
					
					
					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo $this->lang->line('mobile'); ?></label>
						  <input type="text" class="form-control check_no" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('mobile'); ?>" name="mobile" disabled value="<?php echo (isset($userInfo->mobile_no)) ? $userInfo->mobile_no : ""; ?>" data-parsley-required-message="<?php echo $this->lang->line('mobile_number_required'); ?>" maxlength="25" required="">
						</div>
					</div>

					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo "Country" //$this->lang->line('mobile'); ?></label>
						  <select class="form-control" id="exampleInputEmail1" name="country_code"  disabled>
						  	<option value="">--Select--</option>
						  	<?php 
						  		if(!empty($countries)){
						  			foreach($countries as $list){
						  	?>
						  		<option value="<?php echo $list->code; ?>" <?php echo (set_value('country_code', isset($userInfo->country_code) ? $userInfo->country_code : '')==$list->code) ? 'selected="selected"':'';?>><?php echo $list->name; ?></option>
						  	<?php
						  			}
						  		}
					  	 	?>
						  </select>
						</div>
					</div>

					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo $this->lang->line('family_name'); ?></label>
						  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Family Name" name="family_name" value="<?php echo (isset($userInfo->familyname)) ? $userInfo->familyname : ""; ?>" >
						</div>
					</div>

				
					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo $this->lang->line('address'); ?></label>
						  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Address" name="address" value="<?php echo (isset($userInfo->address)) ? $userInfo->address : ""; ?>" >
						</div>
					</div>


					<!-- <div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo "Document Front" //$this->lang->line('mobile'); ?></label>
						  <input type="file" class="" id="exampleInputEmail1" name="dock_front">
						</div>
					</div> 

					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo "Document Back" //$this->lang->line('mobile'); ?></label>
						  <input type="file" class="" id="exampleInputEmail1" name="dock_back">
						</div>
					</div> -->

					<!-- <div class="col-md-6"> 
					<div class="form-group">
					  <label for="exampleInputFile">Document Front</label>
					  <input type="file" name="doc_front">
					  <input type="hidden" name="oldFrontDoc" value="<?php echo (isset($userInfo->varification_front_image)) ? $userInfo->varification_front_image : ""; ?>"> 
					  
					  <br>
					<?php 
						$varificationFrontImg = "";
						if(!empty($userInfo->varification_front_image)){
							$varificationFrontImg = base_url('uploads/identification').'/'.$userInfo->varification_front_image;
						}
						
						if(!empty($varificationFrontImg)){
					?>
						<img src="<?php echo $varificationFrontImg; ?>" height="70" width="70">
					<?php }else{ ?>
						<img src="<?php echo  base_url('uploads/identification/default.png')?>" height="70" width="70" id="blah">
					<?php } ?>
				 </div>
					
				</div> -->



					<!-- <div class="col-md-6"> 
					<div class="form-group">
					  <label for="exampleInputFile">Document Back</label>
					  <input type="file" name="doc_back">
					  <input type="hidden" name="oldBackDoc" value="<?php echo (isset($userInfo->varification_end_image)) ? $userInfo->varification_end_image : ""; ?>"> 
					  
					  <br>
					<?php 
						$varificationBackImg = "";
						if(!empty($userInfo->varification_end_image)){
							$varificationBackImg = base_url('uploads/identification').'/'.$userInfo->varification_end_image;
						}
						
						if(!empty($varificationBackImg)){
					?>
						<img src="<?php echo $varificationBackImg; ?>" height="70" width="70">
					<?php }else{ ?>
						<img src="<?php echo  base_url('uploads/identification/default.png')?>" height="70" width="70" id="blah">
					<?php } ?>
				 </div>
					
				</div> -->


				<!-- 	<div class="col-md-6"> 
						<div class="form-group">
				  			<label for="user_suspended" class="col-sm-3 control-label">
				  				<?php echo $this->lang->line('suspended_user'); ?>
				  			</label>
					  		<div class="col-sm-8">
					  			<label class="switch">
									  <input type="checkbox" name="user_suspended" id="user_suspended" value="<?php echo (isset($userInfo->status)) ? $userInfo->status : ""; ?>" <?php if($userInfo->status!=2){?> checked <?php }?> >
									  <span class="slider round"></span>

									  <input type="hidden" name="user_id" id="user_id" value="<?php echo (isset($userInfo->id)) ? $userInfo->id : ""; ?>">
								</label>	
							</div>
	  					</div>
	  				</div> -->
				</div>
				
				<div class="row no-margin">
					<div class="col-md-12 button-wrap">
						<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('update'); ?></button>
				    </div>
				</div>

			 </div>

		  </form>
	  </div>
      <!-- /.box -->
	</section>
    <!-- /.content -->
    <script>
   $("#user_suspended").change(function (){
   	var id = $("#user_id").val();
   	var msg = '';
    	if($(this).is(':checked')){
            status = 1;
            msg = "User Un-Suspend Successfully";
         }else{
            status = 2;
            msg = "User Suspend Successfully";
         }
         console.log(status);
         $.ajax({
            url: BASEURL + "admin/users/userSuspend",
            type: "POST",
            data: {'status' : status, 'id' : id},
            cache: false,
            success :  function(response){
            	var data = JSON.parse(response);
            	
               if(data.isSuccess == true){
                  showErrorMessage(msg);
               }else{
                  showErrorMessage('Error');
               }
            }
         });
      });
</script>
