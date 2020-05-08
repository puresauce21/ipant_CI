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
		$url = site_url('admin/settings/updateFaq/'.encode($faqDetails->id));
    } else { 
    	//$faqAnswer='';
	    $url = site_url('admin/settings/saveFaq');
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
					  <label for="exampleInputEmail1"><?php echo $this->lang->line('category_name'); ?></label>
					  <select class="form-control" name="category" class="form-control" data-parsley-required-message="<?php echo $this->lang->line('category_required'); ?>" required="">
                        <option value="">--Select--</option>
							<?php 
							if (!empty($categoryDetails)) {
								foreach($categoryDetails as $cate){ ?>
									<option value="<?php echo $cate->id; ?>" <?php echo (set_value('category', isset($faqDetails->category_id) ? $faqDetails->category_id : '')==$cate->id) ? 'selected="selected"':'';?>>
										<?php echo $cate->category_name;?>
									</option>
							<?php } } ?>
						</select>
					</div>
					
				</div>

				<div class="col-md-6"> 
					<div class="form-group">
					  <label for="exampleInputEmail1"><?php echo $this->lang->line('question'); ?></label>
					  <input type="text" class="form-control" id="exampleInputEmail1" placeholder="<?php echo $this->lang->line('question'); ?>" name="question" value="<?php echo (isset($faqDetails->question)) ? $faqDetails->question : ""; ?>" data-parsley-required-message="<?php echo $this->lang->line('question_required'); ?>" maxlength="25" required="">
					</div>
				</div>
				

				<div class="col-md-12"> 
					<div class="form-group">
					  <label for="exampleInputEmail1"><?php echo $this->lang->line('answer'); ?> </label>
					  <textarea id="faq_answer" name="answer" rows="5" columns="50" placeholder="<?php echo $this->lang->line('answer'); ?>" data-parsley-required-message="<?php echo $this->lang->line('answer_required'); ?>" required="">
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
