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
			if (!empty($machineDetails->id)) { 
				$emailDisable = "disabled";
				$url = site_url('admin/machine/updateMachine/'.encode($machineDetails->id));
		    } else { 
		    	$emailDisable = "";
		    	$url = site_url('admin/machine/save');
		    }

			?>
      	<form role="form" method="POST" action="<?php echo $url; ?>" enctype="multipart/form-data" data-parsley-validate>
			<div class="box-body">
				
				<div class="row text-center no-margin">
					<div class="user-img-wrap">
						<div class="circle">
							<label for="picsss">
							<?php $image=!empty($machineDetails->machine_image) ? $machineDetails->machine_image : ""; ?>
							<img class="profile-pic" src="<?php echo getImage($image,"machine_pic"); ?>" id="blah">
							</label>
						</div>
						<div class="p-image">
							<i class="fa fa-camera upload-button"></i>
							<input class="file-upload" name="machineProfile" id="picsss" type="file" accept="image/*"/>
						</div>
						<input type="hidden" name="oldImageName" value="<?php echo (isset($machineDetails->machine_image)) ? $machineDetails->machine_image : ""; ?>">
					</div>
				</div>

				

				<div class="row no-margin">
					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo $this->lang->line('machine_number'); ?></label>
						  <input type="text" class="form-control check_no" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('machine_number'); ?>" name="machine_number" value="<?php echo (isset($machineDetails->machine_number)) ? $machineDetails->machine_number : ""; ?>" data-parsley-required-message="<?php echo $this->lang->line('machine_number_required'); ?>" maxlength="25" required="">
						</div>
					</div>
					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo $this->lang->line('person_name'); ?></label>
						  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('person_name'); ?>" name="person_name" value="<?php echo (isset($machineDetails->person_name)) ? $machineDetails->person_name : ""; ?>" data-parsley-required-message="<?php echo $this->lang->line('person_name_required'); ?>" maxlength="25" required="">
						</div>
					</div>
				</div>
				
				<div class="row no-margin">
					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo $this->lang->line('email'); ?> </label>
						  <input type="email" <?php echo $emailDisable; ?>  class="form-control emailExist" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('email'); ?>" name="email" value="<?php echo (isset($machineDetails->email)) ? $machineDetails->email : ""; ?>" data-parsley-required-message="<?php echo $this->lang->line('email_required'); ?>" required="">
						</div>
					</div>
				
					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo $this->lang->line('complex_name'); ?></label>
						  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('complex_name'); ?>" name="complex_name" value="<?php echo (isset($machineDetails->complex_name)) ? $machineDetails->complex_name : ""; ?>" data-parsley-required-message="<?php echo $this->lang->line('complex_name_required'); ?>" maxlength="25" required="">
						</div>
					</div>
				</div>
					
				<div class="row no-margin">
					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo $this->lang->line('mobile'); ?></label>
						  <input type="text" class="form-control check_no" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('mobile'); ?>" name="mobile" value="<?php echo (isset($machineDetails->contact_number)) ? $machineDetails->contact_number : ""; ?>" data-parsley-required-message="<?php echo $this->lang->line('mobile_number_required'); ?>" maxlength="25" required="">
						</div>
					</div>

					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo $this->lang->line('address'); ?></label>
						  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('address'); ?>" name="address" value="<?php echo (isset($machineDetails->address)) ? $machineDetails->address : ""; ?>" data-parsley-required-message="<?php echo $this->lang->line('address_required'); ?>" maxlength="25" required="">
						</div>
					</div>
				</div>

				<div class="row no-margin">
					<div class="col-md-12 button-wrap">
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo $this->lang->line('comment'); ?></label>
						  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('comment'); ?>" name="comment" value="<?php echo (isset($machineDetails->comment)) ? $machineDetails->comment : ""; ?>" data-parsley-required-message="<?php echo $this->lang->line('comment_required'); ?>" maxlength="25" required="">
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
            var url         =  '<?php echo base_url('admin/machine/getemail');?>';
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