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
					
          <?php if($TSwalletMulDelete==1){
            $disabled = '';
         ?>
          <a class="btn btn-block btn-danger add-btn top-delete-btn deleteaction1" onclick="deleteAction();"> <?php echo $this->lang->line('delete'); ?></a>
        <?php }else{ 
            $disabled = 'disabled';
          ?>
          <a class="btn btn-block btn-danger add-btn top-delete-btn deleteaction1" disabled> <?php echo $this->lang->line('delete'); ?></a>
        <?php } ?>
				</div>
            </div>
            <!-- /.box-header -->
             <form role="form" id="delete-form" accept-charset="utf-8" method="POST" action="<?php echo base_url('admin/settings/deleteTutorials'); ?>">
				<div class="box-body">
					 <table id="marchantlisttable" class="table table-bordered table-hover">
						 <thead>
							<tr>
								<th> <input type="checkbox" <?php echo $disabled; ?> id="select_all" name="checkedaction" /> </th>
                <th> <?php echo $this->lang->line('title'); ?> </th>
								<th> <?php echo $this->lang->line('content'); ?> </th>
								<th> <?php echo $this->lang->line('image'); ?> </th>
                <th> <?php echo $this->lang->line('type'); ?> </th>
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
			<!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  

<script type="text/javascript">
  var postListingUrl =  BASEURL+"admin/settings/tutorialSplashWallajaxlist";
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
          'aoColumnDefs': [{'bSortable': false,'aTargets': [0,3,4,5,6]}],
      });
      
</script>
