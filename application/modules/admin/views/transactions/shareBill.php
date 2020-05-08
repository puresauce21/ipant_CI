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
								<th> <?php echo $this->lang->line('reference_no'); ?> </th>
								<th> <?php echo $this->lang->line('shared_by'); ?> </th>
								<th> <?php echo $this->lang->line('amount'); ?> </th>
								<th> <?php echo $this->lang->line('shared_time'); ?> </th>
								<th style="width: 120px;"> <?php echo $this->lang->line('action'); ?> </th>
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
  
    <div class="modal fade" id="modal-default">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title"><?php echo $this->lang->line('share_bill_users'); ?></h4>
		  </div>
		  <div class="modal-body">
			<table class="table dashboard-table">
				<thead>
				<tr>
					<th><?php echo $this->lang->line('users'); ?></th>
					<th><?php echo $this->lang->line('amount'); ?></th>
					<th><?php echo $this->lang->line('status'); ?></th>
					<th><?php echo $this->lang->line('reference_no'); ?></th>
				</tr>
				</thead>
				<tbody id="shareBillId">
				
				</tbody>
			</table>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>

		  </div>
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
	</div>



  <div class="modal fade" id="bill-img">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title"><?php echo $this->lang->line('share_bill_image'); ?></h4>
		  </div>
		  <div class="modal-body">
			  <div class="timeline-item">
                <div class="timeline-body" id="shareBillimage">
                </div>
              </div>
          </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></button>

		  </div>
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
	</div>


<script type="text/javascript">
	var postListingUrl =  BASEURL+"admin/transactions/shareBillajaxlist";
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
	          'aoColumnDefs': [{'bSortable': false,'aTargets': [0,5]}],
	});

</script>
