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
				 <table id="userPointList" class="table table-bordered table-hover">
					 <thead>
						<tr>
							<th> No. </th>
							<th> Name </th>
							<th> Song Name </th>
							<th> Categogry </th>
							<th> Points </th>
							<th> Wining Date </th>
						</tr>
					</thead>
				</table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
			<!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  

<script type="text/javascript">
	var postListingUrl =  BASEURL+"users/userPointajaxlist";
	$('#userPointList').dataTable({
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
	          'aoColumnDefs': [{'bSortable': false,'aTargets': [0,2,4,5]}],
      });
</script>

