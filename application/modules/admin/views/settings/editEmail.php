<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<?php echo $title; ?>
  </h1>
  <?php echo $this->breadcrumbs->show(); ?> 
</section>
<?php
//echo "<pre>"; print_r($emailInfo);die();
?>
<!-- Main content -->
<section class="content">
	<!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title"></h3>

      <div class="box-tools pull-right"></div>
    </div>
    <form action="<?php echo base_url();?>admin/settings/updateEmailInfo/<?php echo encode($emailInfo[0]->id);?>" method="post" data-parsley-validate>
		<div class="box-body">
			
			<div class="col-md-6"> 
				<div class="form-group">
				<label for="exampleInputEmail1"><?php echo $this->lang->line('subject'); ?></label>
				  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('question'); ?>" name="subject" value="<?php echo $emailInfo[0]->masterSubject;?>" data-parsley-required-message="<?php echo $this->lang->line('question_required'); ?>" maxlength="25" required="">
				</div>
			</div>
			

			<div class="col-md-12"> 
				<div class="form-group">
				  <label for="exampleInputEmail1"><?php echo "Email Template";//$this->lang->line('answer'); ?> </label>
				  <textarea id="faq_answer" name="email_template" rows="5" columns="50" placeholder="<?php echo $this->lang->line('answer'); ?>" data-parsley-required-message="<?php echo $this->lang->line('answer_required'); ?>" required="">
				  	<?php echo (isset($emailInfo[0]->masterContent)) ? $emailInfo[0]->masterContent : ""; ?>
				  </textarea>
				</div>
			</div>
		 </div>
		  <div class="box-footer">
		  	<div class="col-md-12">
				<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('update'); ?></button>
			</div>
		  </div>
	  </form>
  </div>
  <!-- /.box -->
</section>
<!-- /.content -->
 
<script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
<script> CKEDITOR.replace( 'faq_answer' ); </script>
