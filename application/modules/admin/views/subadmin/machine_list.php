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
            <div class="box-header">
			
            </div>
            <!-- /.box-header -->
			<div class="box-body">
				
				<table id="userList" class="table table-bordered table-hover">
					 <thead>
						<tr>
							<th> <?php echo $this->lang->line('s_no'); ?> </th>
							<th> <?php echo $this->lang->line('name'); ?> </th>
							<th> <?php echo $this->lang->line('email'); ?> </th>
							<th> <?php echo $this->lang->line('mobile'); ?> </th>
							<th> <?php echo $this->lang->line('machine_image'); ?> </th>
							<th> <?php echo $this->lang->line('machine_number'); ?> </th>
							<th> <?php echo $this->lang->line('complex_name'); ?> </th>
							<th> <?php echo $this->lang->line('address'); ?> </th>
							<th> <?php echo $this->lang->line('created_date'); ?> </th>
							<th style="width: 80px;"> <?php echo $this->lang->line('action'); ?> </th>
						</tr>
					</thead>
				</table>
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
	var postListingUrl =  BASEURL+"admin/subadmin/machinejaxlist";
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
	          'aoColumnDefs': [{'bSortable': false,'aTargets': [0,4,7,8,9]}]
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
