    <!-- Content Header (Page header) -->
    <section class="content-header">
	  <h1>
		<?php echo $title; ?>
	  </h1>
	  <?php echo $this->breadcrumbs->show(); ?> 
	</section>
    <!-- Main content -->
  <section class="content">

    <form role="form" method="POST" action="<?php echo base_url('admin/settings/updateLogo'); ?>" enctype="multipart/form-data" data-parsley-validate>
			<div class="row">
				<div class="col-md-3">
					<!-- Default box -->
					<div class="box">
						<div class="box-body"> 
							<div class="row text-center no-margin">
								<div class="user-img-wrap">
									<h4><?php echo $this->lang->line('logo'); ?></h4>
									<div class="circle">
										<label for="picsss">
										<?php $image1=!empty($logo->option_value) ? $logo->option_value : ""; ?>
										<img style="margin-top: 42px;max-width: 110px;" src="<?php echo getImage($image1,"logo_favicon"); ?>" id="blah">
										</label>
									</div>
									<div class="p-image">
										<i class="fa fa-camera upload-button" style="display: none;"></i>
										<input name="logo" id="picssst" type="file" accept="image/*"/>
									</div>
									<!-- <input type="hidden" name="oldImageName" value="<?php echo (isset($logo->option_value)) ? $logo->option_value : ""; ?>"> -->
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<!-- Default box -->
			      <div class="box">
							<div class="box-body"> 
								<div class="row text-center no-margin">
									<div class="user-img-wrap">
										<h4><?php echo $this->lang->line('favicon'); ?></h4>
										<div class="circle">
											<label for="picsss">
											<?php $image=!empty($favicon->option_value) ? $favicon->option_value : ""; ?>
											<img style="max-width: 215px; margin-top: 55px;" src="<?php echo getImage($image,"logo_favicon"); ?>" id="blah">
											</label>
										</div>
										<div class="p-image">
											<i class="fa fa-camera upload-button" style="display: none;"></i>
											<input  name="favicon" id="picssst" type="file" accept="image/*"/>
										</div>
										<!-- <input type="hidden" name="oldImageName" value="<?php echo (isset($favicon->option_value)) ? $favicon->option_value : ""; ?>"> -->
									</div>
								</div>
							</div>
						</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<!-- Default box -->
			      <div class="box">
							<div class="box-body text-center"> 
								<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('update'); ?></button>
							</div>
						</div>
					</div>
		      <!-- /.box -->
		  </div>
		</form>

  </section>
    <!-- /.content -->

			    	











 