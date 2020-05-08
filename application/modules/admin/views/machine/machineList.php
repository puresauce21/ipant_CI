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
					<a href="<?php echo base_url('admin/machine/add'); ?>" class="btn btn add-btn btn-block btn-info deleteaction1"> <?php echO $this->lang->line('add_machine'); ?></a>

					<a class="btn btn-block btn-danger add-btn top-delete-btn deleteaction1" onclick="deleteAction();"> <?php echo $this->lang->line('delete'); ?></a>
				</div>
            </div>
            <!-- /.box-header -->
			<div class="box-body">
				<form role="form" id="delete-form" accept-charset="utf-8" method="POST" action="<?php echo base_url('admin/machine/deleteMachine'); ?>">
					 <table id="userList" class="table table-bordered table-hover">
						 <thead>
							<tr>
								<th> <input type="checkbox" id="select_all" name="checkedaction" /> </th>
								<th> <?php echo $this->lang->line('machine_number'); ?></th>
								<th> <?php echo $this->lang->line('person_name'); ?></th>
								<th> <?php echo $this->lang->line('email'); ?> </th>
								<th> <?php echo $this->lang->line('mobile'); ?> </th>
								<th> <?php echo $this->lang->line('complex_name'); ?> </th> 
								<th> <?php echo $this->lang->line('image'); ?> </th>
								<th> <?php echo $this->lang->line('address'); ?> </th>
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
	var postListingUrl =  BASEURL+"admin/machine/machineajaxlist";
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
	          'aoColumnDefs': [{'bSortable': false,'aTargets': [0,5,6,7,8]}],
	});


	// function to delete data in database 
	function deleteMachine(id, urls){
		swal({
			title:  "Are you sure you want to Delete ?", 
			type: "warning",
			showCancelButton: true,
			cancelButtonText: "Cancel",
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Yes",
			closeOnConfirm: false
		}, function () {
			swal("Deleted", "Delete successfully", "success");
			    var formData    = {
                    'id':id
                    };
                 $.ajax({
                    type: 'POST',
                    url: urls,
                    dataType: 'json',
                    async: false,
                    data: formData,	
                    success: function(data) {
					   refreshPge();
                    },
                });
		});
	}
</script>
