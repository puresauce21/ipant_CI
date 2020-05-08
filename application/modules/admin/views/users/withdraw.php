    <!-- Content Header (Page header) -->
    <section class="content-header">
	  <h1>
		<?php echo $title; ?>
	  </h1>
	  <?php //echo $this->breadcrumbs->show(); ?> 
	</section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
				<div class="text-right pull-right " >
<!--
					<a class="btn btn-block btn-danger deleteaction1" onclick="deleteAction();"> <i class="fa fa-trash"></i> Delete</a>
-->
				</div>
            </div>
            <!-- /.box-header -->
             <form role="form" id="delete-form" accept-charset="utf-8" method="POST" action="#<?php //echo base_url('users/deleteUser'); ?>">
				<div class="box-body">
					 <table id="marchantlisttable" class="table table-bordered table-hover">
						 <thead>
							<tr>
<!--
								<th> <input type="checkbox" id="select_all" name="checkedaction" /> </th>
-->

								<th> <?php echo $this->lang->line('s_no'); ?> </th>
								<th> <?php echo $this->lang->line('form'); ?> </th>
								<th> <?php echo $this->lang->line('to'); ?> </th>
								<th> <?php echo $this->lang->line('amount'); ?> </th>
								<th> <?php echo $this->lang->line('charge'); ?> </th>
								<th> <?php echo $this->lang->line('trans_id'); ?> </th>
								<th> <?php echo $this->lang->line('trans_type'); ?> </th>
								<th> <?php echo $this->lang->line('status'); ?> </th>
								<th> <?php echo $this->lang->line('message'); ?> </th>
								<th> <?php echo $this->lang->line('created_date'); ?> </th>
							</tr>
						</thead>
					</table>
				</div>
			</form>
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
  var postListingUrl =  BASEURL+"admin/users/withdrawajaxlist";
  $('#marchantlisttable').dataTable({
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
          'aoColumnDefs': [{'bSortable': false,'aTargets': [0,1,4,8]}],
      });
</script>
