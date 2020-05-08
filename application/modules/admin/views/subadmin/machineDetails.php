	<?php //echo "<pre>"; print_r($machineInfo);echo "</pre>";?>
	
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
        <div class="box-body detail-page">
					<div class="col-md-12">
						<div class="row text-center no-margin">
						<div class="user-img-wrap">
								<h4><?php echo $this->lang->line('machine_image'); ?></h4>
								<div class="square">
									<?php $image=!empty($machineInfo->machine_image) ? $machineInfo->machine_image : ""; ?>
									<img class="profile-pic" src="<?php echo getImage($image,"machine_pic"); ?>" id="blah">
								</div>
								</div>
							</div>
							<div class="row">
							<div class="col-md-12 col-sm-12">
							
								<div class="col-md-6"> 
								<div class="detail-page-block">
								  <h4 class="detail-page-headng"> <?php echo $this->lang->line('person_name'); ?> :</h4> 
								  <div class="detail-page-content"><?php echo $machineInfo->person_name; ?></div>
								</div>
								</div>
								<div class="col-md-6"> 
								<div class="detail-page-block">
								  <h4 class="detail-page-headng"> <?php echo $this->lang->line('machine_number'); ?> :</h4> 
								  <div class="detail-page-content"><?php echo $machineInfo->machine_number; ?></div>
								</div>
								</div>
							
								
							</div>
							<div class="col-md-12 col-sm-12">
                              <div class="col-md-6"> 
								<div class="detail-page-block">
								  <h4 class="detail-page-headng"> <?php echo $this->lang->line('email'); ?> :</h4> 
								  <div class="detail-page-content"> <?php echo $machineInfo->email; ?> </div>
								 </div>
							  </div>
							  <div class="col-md-6"> 
								<div class="detail-page-block">
								  <h4 class="detail-page-headng"> <?php echo $this->lang->line('mobile'); ?> :</h4> 
								  <div class="detail-page-content"> <?php echo $machineInfo->contact_number; ?> </div>
								</div>
								</div>

							</div>
							<div class="col-md-12 col-sm-12">
							<div class="col-md-6"> 
								<div class="detail-page-block">
								  <h4 class="detail-page-headng"> <?php echo $this->lang->line('complex_name'); ?> :</h4> 
								  <div class="detail-page-content"> <?php echo $machineInfo->complex_name; ?> </div>
								</div>
							</div>
							<div class="col-md-6"> 
								<div class="detail-page-block">
								  <h4 class="detail-page-headng"> <?php echo $this->lang->line('comment'); ?> :</h4> 
								  <div class="detail-page-content"> <?php echo $machineInfo->comment; ?>  </div>
								</div>
							</div>
							</div> 
							<div class="col-md-12 col-sm-12">
							<div class="col-md-6"> 
								<div class="detail-page-block">
								  <h4 class="detail-page-headng"> <?php echo $this->lang->line('created_date'); ?> :</h4> 
								  <div class="detail-page-content"> <?php echo change_date_formate($machineInfo->creation_date_time); ?> </div>
								</div>
							</div>
							<div class="col-md-6"> 
								<div class="detail-page-block">
								  <h4 class="detail-page-headng"> <?php echo $this->lang->line('address'); ?> :</h4> 
								  <div class="detail-page-content"> <?php echo $machineInfo->address; ?>  </div>
								</div>
							</div>
							</div> 

						</div>

					</div>
				</div>
	  	</div>
      <!-- /.box -->

    </section>
    <!-- /.content -->













				













						
















