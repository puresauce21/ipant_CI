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
      <form role="form" method="POST" action="<?php echo base_url('admin/profile/profileUpdate/'.encode($adminInfo->id)); ?>" enctype="multipart/form-data" data-parsley-validate>
			<div class="box-body">
				
				<div class="row text-center no-margin">
					<div class="user-img-wrap">
						<div class="circle">
							<label for="picsss">
							<?php $image=!empty($adminInfo->profile_pic) ? $adminInfo->profile_pic : ""; ?>
							<img class="profile-pic" src="<?php echo getImage($image,"admin_profile"); ?>" id="blah">
							</label>
						</div>
						<div class="p1-image ">
							<i class="fa fa-camera upload-button"></i>
							<input class="file-upload" name="adminProfile" id="picsss" type="file" accept="image/*"/>
						</div>
						<input type="hidden" name="oldImageName" value="<?php echo (isset($adminInfo->profile_pic)) ? $adminInfo->profile_pic : ""; ?>">
					</div>
				</div>

				

				<div class="row no-margin">
					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo $this->lang->line('first_name'); ?></label>
						  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('first_name'); ?>" name="firstname" value="<?php echo (isset($adminInfo->firstname)) ? $adminInfo->firstname : ""; ?>" data-parsley-required-message="<?php echo $this->lang->line('first_name_required'); ?>" maxlength="25" required="">
						</div>
					</div>
					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo $this->lang->line('last_name'); ?></label>
						  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('last_name'); ?>" name="lastname" value="<?php echo (isset($adminInfo->lastname)) ? $adminInfo->lastname : ""; ?>" data-parsley-required-message="<?php echo $this->lang->line('last_name_required'); ?>" maxlength="25" required="">
						</div>
					</div>
				</div>
				
				<div class="row no-margin">
					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo $this->lang->line('email'); ?> </label>
						  <input type="email" disabled  class="form-control" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('email'); ?>" name="email" value="<?php echo (isset($adminInfo->email)) ? $adminInfo->email : ""; ?>" data-parsley-required-message="<?php echo $this->lang->line('email_required'); ?>" required="">
						</div>
					</div>
				
					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1"><?php echo $this->lang->line('mobile'); ?></label>
						  <input type="text" class="form-control check_no" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('mobile'); ?>" name="mobile" disabled value="<?php echo (isset($adminInfo->mobile_no)) ? $adminInfo->mobile_no : ""; ?>" data-parsley-required-message="<?php echo $this->lang->line('mobile_number_required'); ?>" maxlength="25" required="">
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
  