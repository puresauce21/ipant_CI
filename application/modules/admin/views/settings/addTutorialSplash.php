    <!-- Content Header (Page header) -->
    <section class="content-header">
	  <h1>
		<?php echo $title; ?>
	  </h1>
	  <?php echo $this->breadcrumbs->show(); ?> 
	</section>
	<?php 
		//~ if(!empty($artistsInfo)){
			//~ $urls = base_url('category/updateArtists/'.encode($artistsInfo->id));
		//~ }else{
			//~ $urls = base_url('category/saveArtists');
		//~ }
	?>
	
	<!-- Main content -->
    <section class="content">
		<!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"></h3>

          <div class="box-tools pull-right"></div>
        </div>
        <form role="form" method="POST" action="<?php echo base_url('admin/settings/saveTutorialSplash'); ?>" enctype="multipart/form-data" data-parsley-validate>
			<div class="box-body">

				<div class="col-md-4"> 
					<div class="form-group">
					  <label for="exampleInputEmail1"><?php echo $this->lang->line('type'); ?></label>
					  <select class="form-control" name="type" class="form-control" data-parsley-required-message="<?php echo $this->lang->line('tutorial_splash_required'); ?>" required="">
                        <option value="">--Select--</option>
							<option value="1">Wallet</option>
							<option value="2">Master</option>						
						</select>
					</div>
					
				</div>
				<div class="col-md-4"> 
					<div class="form-group">
					  <label for="exampleInputEmail1"><?php echo $this->lang->line('title'); ?></label>
					  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('title'); ?>" name="title" data-parsley-required-message="<?php echo $this->lang->line('title_required'); ?>" maxlength="25" required="">
					</div>
				</div>

				<div class="col-md-4"> 
					<div class="form-group">
					  <label for="exampleInputFile"><?php echo $this->lang->line('image'); ?> </label>
					  <input type="file" name="splashImg" id="imgInp">
					</div>
				</div>


				<div class="col-md-12"> 
					<div class="form-group">
					  <label for="exampleInputEmail1"><?php echo $this->lang->line('content'); ?></label>
					  <textarea id="shop_id" name="tutorial_content" class="form-control" rows="3" placeholder="Description" required="" ><?php echo set_value('tutorial_content')?></textarea>
					</div>
				</div>


			  </div>
			  <div class="box-footer footer-212">
			  	<div class="col-md-12">
					<button type="submit" class="btn btn-primary back-btn-left"><?php echo $this->lang->line('submit'); ?> </button>
				</div>
			  </div>
		  </form>
	  </div>
      
      <!-- /.box -->

    </section>
    <!-- /.content -->
 
<script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
<script> CKEDITOR.replace( 'shop_id' ); </script>
