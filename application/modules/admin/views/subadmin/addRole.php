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
			if (!empty($roleDetails->id)) { 
				$url = site_url('admin/subadmin/updateRole/'.encode($roleDetails->id));
		    } else { 
		    	$url = site_url('admin/subadmin/addRole');
		    }	
		?>
      	<form role="form" method="POST" action="<?php echo $url; ?>" enctype="multipart/form-data" data-parsley-validate>
			
			<div class="box-body">
				
				<div class="row no-margin">
					<div class="col-md-6"> 
						<div class="form-group">
						  <label for="exampleInputEmail1">Role Name</label>
						  <input type="text" class="form-control" id="exampleInputEmail1" name="role" value="<?php echo (isset($roleDetails->role_name)) ? $roleDetails->role_name : ""; ?>" data-parsley-required-message="<?php echo $this->lang->line('role_required'); ?>" maxlength="25" required="">
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
