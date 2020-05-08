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
							<th>Enduserid </th>
							<th>Type </th>
							<th>Amount </th>
							<th>Currency </th>
							<th>Order Id </th>
							<th> Meassge Id </th>
							<th> <?php echo $this->lang->line('created_date'); ?> </th>
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
	var postListingUrl =  BASEURL+"admin/TrustlyTransaction/trxajaxlist";
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
		 "order": [ 0, "desc" ],
		"ajax": postListingUrl,
	    "columnDefs": [ { "targets": 0, "bSortable": true,"orderable": true, "visible": true } ],
	          'aoColumnDefs': [{'bSortable': false,'aTargets': [0,4,5,6,7]}]
	});
      
      
	/*$(function () {
	    //Date range picker
	    $('#reservation').daterangepicker()

	    //Date picker
	    $('#datepicker').datepicker({
	      autoclose: true
	    })
	  })      */
</script>
