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
	<div class="box-header with-border">
	  <h3 class="box-title"></h3>
	</div>
	<!-- /.box-header -->
	<!-- form start -->
	<form class="form-horizontal" method="POST" action="<?php echo base_url('admin/profile/resetPassword'); ?>" data-parsley-validate>
	  <div class="box-body">
	  	<div class="form-group">
  			<label for="notification" class="col-sm-2 control-label">
  				Notification Settings
  			</label>
	  		<div class="col-sm-8">
	  			<label class="switch">
					  <input type="checkbox" id="notification" value="<?php echo $notification_val[0]->notification;?>" <?php if(!empty($notification_val[0]->notification)){?> checked <?php }?> >
					  <span class="slider round"></span>
				</label>	
			</div>
	  	</div>

		<div class="form-group">
		  <label for="inputEmail3" class="col-sm-2 control-label">Current Password</label>

		  <div class="col-sm-8">
			<input type="password" class="form-control" name="oldPassword" id="inputEmail3" placeholder="Current Password" data-parsley-required-message="Current password is required" data-parsley-minlength="6" data-parsley-maxlength="12" required="">
		  </div>
		</div>
		<div class="form-group">
		  <label for="inputPassword3" class="col-sm-2 control-label">New Password</label>

		  <div class="col-sm-8">
			<input type="password" class="form-control" id="inputPassword3" placeholder="New Password" name="newPassword" data-parsley-required-message="New password is required" data-parsley-minlength= "6" data-parsley-maxlength="12" required="">
		  </div>
		</div>
		
		<div class="form-group">
		  <label for="inputPassword3" class="col-sm-2 control-label">Confirm Password</label>

		  <div class="col-sm-8">
			<input type="password" class="form-control" id="inputPassword4" name="confPassword" placeholder="Confirm Password" data-parsley-required-message="Confirm Password is required" data-parsley-minlength= "6" data-parsley-maxlength="12" required="" equalto="#inputPassword3" data-parsley-equalto-message=" Confirm password should be same" >
		  </div>
		</div>
	 </div>
	  <!-- /.box-body -->
	  <div class="box-footer">
		<button type="submit" class="btn btn-info ">Submit</button>
	  </div>
	  <!-- /.box-footer -->
	</form>
  
		 
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
<script>
   $("#notification").change(function (){
   	var msg = '';
    	if($(this).is(':checked')){
            status = 1;
            msg = "On";
         }
         else{
            status = 0;
            msg = "Off";
         }

         $.ajax({
            url: BASEURL + "admin/profile/change_notification",
            type: "POST",
            data: {'notification' : status},
            cache: false,
            success :  function(response){
            	var data = JSON.parse(response);
               if(data.status == 1){
                  showErrorMessage('Notification Successfully Turned  '+msg);
               }
               else{
                  showErrorMessage('Error');
               }
            }
         });
      });
</script>
  
