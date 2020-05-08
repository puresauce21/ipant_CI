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
        <form role="form" method="POST" action="<?php echo base_url('admin/subadmin/machineUpdate/'.encode($machineInfo->id)) ; ?>" enctype="multipart/form-data" data-parsley-validate>
			<div class="box-body">
				
				<div class="row text-center no-margin">
					<div class="user-img-wrap">
						<div class="circle">
							<label for="picsss">
								<?php $image=!empty($machineInfo->machine_image) ? $machineInfo->machine_image : ""; ?>
								<img class="profile-pic" src="<?php echo getImage($image,"machine_pic"); ?>" id="blah">
							</label>
						</div>
						<div class="p1-image">
							<i class="fa fa-camera upload-button"></i>
							<input class="file-upload" name="machine_image" id="picsss" type="file" accept="image/*"/>
						</div>
						<input type="hidden" name="oldImageName" value="<?php echo (isset($machineInfo->machine_image)) ? $machineInfo->machine_image : ""; ?>">
					</div>
				</div>

				<div class="row no-margin">
					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo $this->lang->line('person_name'); ?></label>
						  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('person_name'); ?>" name="person_name" value="<?php echo (isset($machineInfo->person_name)) ? $machineInfo->person_name : ""; ?>" data-parsley-required-message="<?php echo $this->lang->line('person_name_required'); ?>" maxlength="25" required="">
						</div>
					</div>
					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo $this->lang->line('machine_number'); ?></label>
						  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('machine_number'); ?>" name="machine_number" value="<?php echo (isset($machineInfo->machine_number)) ? $machineInfo->machine_number : ""; ?>" data-parsley-required-message="<?php echo $this->lang->line('machine_number_required'); ?>" maxlength="25" required="">
						</div>
					</div>	
				</div>
				
				<div class="row no-margin">
					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo $this->lang->line('email'); ?> </label>
						  <input type="email" class="form-control" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('email'); ?>" disabled name="email" value="<?php echo (isset($machineInfo->email)) ? $machineInfo->email : ""; ?>" >
						</div>
					</div>
					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo $this->lang->line('mobile'); ?></label>
						  <input type="text" class="form-control check_no" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('mobile'); ?>" name="mobile" disabled value="<?php echo (isset($machineInfo->contact_number)) ? $machineInfo->contact_number : ""; ?>"  maxlength="25">
						</div>
					</div>

                   </div>
					<div class="row no-margin">
						<div class="col-md-6"> 
							<div class="form-group">
							  <label for="exampleInputEmail1"><?php echo $this->lang->line('complex_name'); ?></label>
							  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Complex Name" name="complex_name" value="<?php echo (isset($machineInfo->complex_name)) ? $machineInfo->complex_name : ""; ?>" >
							</div>
						</div>
						<div class="col-md-6"> 
							<div class="form-group">
							  <label for="exampleInputEmail1"><?php echo $this->lang->line('address'); ?></label>
							  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Address" name="address" value="<?php echo (isset($machineInfo->address)) ? $machineInfo->address : ""; ?>" >
							</div>
						</div>
				  </div>
                  <div class="row no-margin">
						<div class="col-md-6"> 
							<div class="form-group">
							  <label for="exampleInputEmail1"><?php echo $this->lang->line('comment'); ?></label>
							  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Comment " name="comment" value="<?php echo (isset($machineInfo->comment)) ? $machineInfo->comment : ""; ?>" >
							</div>
						</div>
				  </div>		
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
