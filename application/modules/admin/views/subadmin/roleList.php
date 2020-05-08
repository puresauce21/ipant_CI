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
					<a href="<?php echo base_url('admin/subadmin/role'); ?>" class="btn btn add-btn btn-block btn-info deleteaction1"> <?php echo $this->lang->line('add_role'); ?></a>

				</div>
            </div>
            <!-- /.box-header -->
			<div class="box-body">
				<form role="form" id="delete-form" accept-charset="utf-8" method="POST" action="#<?php //echo base_url('admin/subadmin/deleteSubAdmin'); ?>">
					 <table id="userList" class="table table-bordered table-hover">
						 <thead>
							<tr>
								<th> <?php echo $this->lang->line('s_no'); ?> </th>
								<th> <?php echo $this->lang->line('role_name'); ?> </th>
								<th> <?php echo $this->lang->line('created_date'); ?> </th>
								<th> <?php echo $this->lang->line('action'); ?> </th>
							</tr>
						</thead>
					</table>
				</form>
			</div>
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
	var postListingUrl =  BASEURL+"admin/subadmin/roleajaxlist";
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
	          'aoColumnDefs': [{'bSortable': false,'aTargets': [0,3]}],
	});
</script>
