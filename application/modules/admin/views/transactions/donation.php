    <!-- Content Header (Page header) -->
    <section class="content-header">
	  <h1>
		<?php echo $title; ?>
	  </h1>
	  <?php echo $this->breadcrumbs->show(); ?> 
	</section>
	<?php
		if(empty($user_id)){
			$userId="";
		}else{
			$userId="/".$user_id;
		}
	?>
	<!-- Main content -->
	<section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
            	<?php 
					$postdata = $this->session->userdata('postdata');
					$user_status = '';
					$date        = '';
					if(!empty($postdata)){
						//$user_status    = (!empty($postdata['user_status']))?$postdata['user_status']:'';
						$date           = (!empty($postdata['search_date']))?$postdata['search_date']:'';
					}

					$url = site_url('admin/transactions/filterTransactionlist');
					$rseturl = site_url('admin/transactions/resetTransactionlist');
				?>
				<?php
					if(empty($user_id) || $user_id == "search"){ ?>
					 <!-- <div class="table-top-block">
						<form action="<?php echo $url; ?>" role="form" name="searchForm"  id="searchForm" method="POST">
							<div class="col-md-3"> 
								<div class="form-group">
									<div class="input-group">
										<div class="input-group-addon">
				                    <i class="fa fa-calendar"></i>
				                    </div>
				                    <input type="text" class="form-control pull-right" id="reservation" name="search_date" placeholder="Date"  value="<?php if(!empty($date)) { echo $date;} else{ echo ''; } ?>">
									</div>
								</div>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-6 table-search-form"> 
								<div class="form-group">
									<div class="input-group">
										<a href="<?php echo $rseturl; ?>" class="btn btn-danger pull-right" style="margin-left:5px;"><?php echo $this->lang->line('reset'); ?></a> <button type="submit" class="btn btn-primary pull-right" style="margin-left:5px;" name="search" ><?php echo $this->lang->line('search'); ?></button>  
									</div>
								</div>
							</div>

						</form>
					</div> -->
				<?php } ?>
				<!-- <div class="row">
					<div class="col-md-1">
		            	<form method="post" action="<?php echo base_url() ?>admin/transactions/exportTransactioncsv/csv" class="export-btn">
		            		<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
		                  	<button type="submit" class="btn btn-primary">Export CSV</button>
		            	</form>
					</div>
					<div class="col-md-11 text-left">
            			<form method="post" action="<?php echo base_url() ?>admin/transactions/exportTransactioncsv/xls">
            			<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
	           	   		<button type="submit" class="btn btn-primary">Export XLS</button>
	            		</form>
					</div>
				</div> -->

				<div class="text-right pull-right " >
				</div>
	        </div>
            <!-- /.box-header -->
			<div class="box-body">
					 <table id="userList" class="table table-bordered table-hover">
						 <thead>
							<tr>
								<th> <?php echo $this->lang->line('s_no'); ?> </th>
								<th> <?php echo 'User Name'?> </th>
								<th> <?php echo $this->lang->line('amount'); ?> </th>
								<th> <?php echo $this->lang->line('trans_id'); ?> </th>
								<th> <?php echo $this->lang->line('trans_type'); ?> </th>
								<th> <?php echo $this->lang->line('trans_method'); ?> </th>
								<th> <?php echo $this->lang->line('status'); ?> </th>
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
	//var postListingUrl =  BASEURL+"admin/transactions/transactionajaxlist";
	var postListingUrl =  BASEURL+"admin/transactions/donationajaxlist<?php echo $userId;?>";
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
	          'aoColumnDefs': [{'bSortable': false,'aTargets': [0,5,6,7]}],
	});

	$(function () {
	    //Date range picker
	    $('#reservation').daterangepicker()

	    //Date picker
	    $('#datepicker').datepicker({
	      autoclose: true
	    })
	  })
</script>
