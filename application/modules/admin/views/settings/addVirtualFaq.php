    <!-- Content Header (Page header) -->
    <section class="content-header">
	  <h1>
		<?php echo $title; ?>
	  </h1>
	  <?php echo $this->breadcrumbs->show(); ?> 
	</section>
	<?php
	//echo "<pre>"; print_r($faqDetails);die();

	
	if (!empty($faqDetails->id)) { 
		//$faqAnswer= (isset($faqDetails->answer)) ? $faqDetails->answer : "";
		$url = site_url('admin/settings/updateVirtualFaq/'.encode($faqDetails->id));
    } else { 
    	//$faqAnswer='';
	    $url = site_url('admin/settings/saveVirtualFaq');
    }
    
	?>
	<!-- Main content -->
    <section class="content">
		<!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"></h3>

          <div class="box-tools pull-right"></div>
        </div>
        <form role="form" method="POST" action="<?php echo $url; ?>" data-parsley-validate>
			<div class="box-body">
				
				<div class="col-md-6"> 
					<div class="form-group">
					  <label for="exampleInputEmail1"><?php echo $this->lang->line('title'); ?></label>
					  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('title'); ?>" name="faq_title" value="<?php echo (isset($faqDetails->question)) ? $faqDetails->question : ""; ?>" data-parsley-required-message="<?php echo $this->lang->line('title_required'); ?>" maxlength="25" required="">
					</div>
				</div>
				

				<div class="col-md-12"> 
					<div class="form-group">
					  <label for="exampleInputEmail1"><?php echo $this->lang->line('content'); ?> </label>
					  <textarea id="faq_answer" name="faq_content" rows="5" columns="50" placeholder="<?php echo $this->lang->line('content'); ?>" data-parsley-required-message="<?php echo $this->lang->line('content_required'); ?>" required="">
					  	<?php echo (isset($faqDetails->answer)) ? $faqDetails->answer : ""; ?>
					  </textarea>
					</div>
				</div>
			 </div>
			  <div class="box-footer">
			  	<div class="col-md-12">
					<button type="submit" class="btn btn-primary"><?php echo $button; ?></button>
				</div>
			  </div>
		  </form>
	  </div>
      <!-- /.box -->
	</section>
    <!-- /.content -->
 
<script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
<script> CKEDITOR.replace( 'faq_answer' ); </script>
