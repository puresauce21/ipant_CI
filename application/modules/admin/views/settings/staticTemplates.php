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
				<div class="text-right pull-right " >
				</div>
            </div>
            <!-- /.box-header -->
			<div class="box-body">
					 <table id="userList" class="table table-bordered table-hover">
						 <thead>
							<tr>
								<th> <?php echo $this->lang->line('s_no'); ?> </th>
								<th> subject <?php //echo $this->lang->line('category_name'); ?> </th>
								<th> content <?php //echo $this->lang->line('content'); ?> </th>
								
								<th> <?php echo $this->lang->line('action'); ?> </th>
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
	var postListingUrl =  BASEURL+"admin/settings/staticTempajaxlist";
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
		//"buttons": 'csv',
		"ajax": postListingUrl,
	    "columnDefs": [ { "targets": 0, "bSortable": true,"orderable": true, "visible": true } ],
	          'aoColumnDefs': [{'bSortable': false,'aTargets': [0,1,2]}],
		//"buttons": ['copy', 'csv', 'excel', 'pdf', 'print']
      });
</script>
