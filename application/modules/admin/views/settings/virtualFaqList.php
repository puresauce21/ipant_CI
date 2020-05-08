    <!-- Content Header (Page header) -->
    <section class="content-header">
	  <h1>
		<?php echo $title; ?>
	  </h1>
	  <?php echo $this->breadcrumbs->show(); ?> 
	</section>
	<!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header clearfix">
				<div class="text-right pull-right col-md-4 col-sm-4 col-xs-12">
				<?php if($add_virtual_faq==1){ ?>
                  <a href="<?php echo base_url('admin/settings/addVirtualFaq'); ?>" class="btn btn add-btn btn-block btn-info deleteaction1"> <?php echo $this->lang->line('add'); ?></a>
                <?php }else{ ?>
                  <a href="#" disabled class="btn btn btn-block add-btn btn-info deleteaction1"> <?php echo $this->lang->line('add'); ?></a>
                <?php } ?>

				<?php if($virtual_faq_delete==1){
						$disabled = '';
				 ?>
					<a class="btn btn-block btn-danger add-btn top-delete-btn deleteaction1" onclick="deleteAction();"> <?php echo $this->lang->line('delete'); ?></a>
				<?php }else{ 
						$disabled = 'disabled';
					?>
					<a class="btn btn-block btn-danger add-btn top-delete-btn deleteaction1" disabled> <?php echo $this->lang->line('delete'); ?></a>
				<?php	} ?>
				</div>
            </div>
            <!-- /.box-header -->
            <form role="form" id="delete-form" accept-charset="utf-8" method="POST" action="<?php echo base_url('admin/settings/deleteVirtualFaq'); ?>">
				<div class="box-body">
					 <table id="userList" class="table table-bordered table-hover">
						 <thead>
							<tr>
								<th> <input type="checkbox" <?php echo $disabled; ?> id="select_all" name="checkedaction" /> </th>
								<th> <?php echo $this->lang->line('title'); ?> </th>
								<th> <?php echo $this->lang->line('content'); ?> </th>
								<th> <?php echo $this->lang->line('status'); ?> </th>
								<th> <?php echo $this->lang->line('action'); ?> </th>
							</tr>
						</thead>
					</table>
				</div>
			</form>
			<!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  
<script type="text/javascript">
	var postListingUrl =  BASEURL+"admin/settings/virtualFaqajaxlist";
	$('#userList').dataTable({
		"bPaginate": true,
		"bLengthChange": true,
		"bFilter": true,
		"bSort": true,
		"bInfo": true,
		"bAutoWidth": false,
		"processing": true,
		"serverSide": true,
		"stateSave": false,
		"ajax": postListingUrl,
	    "columnDefs": [ { "targets": 0, "bSortable": true,"orderable": true, "visible": true } ],
	          'aoColumnDefs': [{'bSortable': false,'aTargets': [0,3,4]}]
	});
</script>
