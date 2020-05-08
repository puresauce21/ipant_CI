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
		
          <div class="box-tools pull-right"></div>
        </div>
        <form role="form" method="POST" action="<?php echo base_url('admin/settings/updateStaticTemp/'.encode($staticTemp->id)); ?>" data-parsley-validate>
			<div class="box-body">
				<div class="col-md-6"> 
					<div class="form-group">
					  <label for="exampleInputEmail1">subject<?php //echo $this->lang->line('first_name'); ?></label>
					  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('first_name'); ?>" name="subject" value="<?php echo (isset($staticTemp->subject)) ? $staticTemp->subject : ""; ?>" data-parsley-required-message="<?php echo $this->lang->line('first_name_required'); ?>" required="">
					</div>
				</div>
				
				<div class="col-md-12"> 
					<div class="form-group">
					  <label for="Answer">content :</label>
					  <textarea id="answer" name="content" rows="5" columns="50" placeholder="Enter Answer" data-parsley-required-message="Answer is required" required="">
					  	<?php echo (isset($staticTemp->content)) ? $staticTemp->content : ""; ?>
					  </textarea>
					</div>
				</div>
				
			  </div>
			  <div class="box-footer">
				<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('update'); ?></button>
			  </div>
		  </form>
	  </div>
      
      <!-- /.box -->

    </section>
    <!-- /.content -->
 
<script src="<?php echo base_url('templates/admin/bower_components/ckeditor')?>/ckeditor.js"></script>
<script> CKEDITOR.replace( 'answer' ); </script>
