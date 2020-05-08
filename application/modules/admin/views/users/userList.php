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
				<?php 
					$postdata = $this->session->userdata('postdata');
					$user_status = '';
					//$date        = '';
					if(!empty($postdata)){
						$user_status    = (!empty($postdata['user_status']))?$postdata['user_status']:'';
						$date           = (!empty($postdata['search_date']))?$postdata['search_date']:'';
					}

					$url = site_url('admin/users/filterUserlist');
					$rseturl = site_url('admin/users/index');
				?>
				<div class="table-top-block">
					<form action="<?php echo $url; ?>" role="form" name="searchForm"  id="searchForm" method="POST">
						<div class="col-md-3 col-sm-3 col-xs-6 no-padding-left"> 
							<div class="form-group">
								<select class="form-control" name="user_status" >
									<option value="">--<?php echo $this->lang->line('select'); ?>--</option>
									<option value="1" <?php if(!empty($user_status)) { if($user_status=='1') { echo 'selected="selected"'; } }?>><?php echo $this->lang->line('active'); ?></option>
									<option value="2" <?php if(!empty($user_status)) { if($user_status=='2') { echo 'selected="selected"'; } }?>><?php echo $this->lang->line('inactive'); ?></option>
									<!-- <option value="3" <?php if(!empty($user_status)) { if($user_status=='3') { echo 'selected="selected"'; } }?>><?php echo $this->lang->line('suspended'); ?></option> -->
								</select>
							</div>
						</div>
						<!-- <div class="col-md-3"> 
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-addon">
			                    <i class="fa fa-calendar"></i>
			                    </div>
			                    <input type="text" class="form-control pull-right" id="reservation" name="search_date" placeholder="Date"  value="<?php if(!empty($date)) { echo $date;} else{ echo ''; } ?>">
								</div>
							</div>
						</div> -->
						<div class="col-md-3 col-sm-3 col-xs-6 table-search-form"> 
							<div class="form-group">
								<div class="input-group">
									<a href="<?php echo $rseturl; ?>" class="btn btn-danger pull-right" style="margin-left:5px;"><?php echo $this->lang->line('reset'); ?></a> <button type="submit" class="btn btn-primary pull-right" style="margin-left:5px;" name="search" ><?php echo $this->lang->line('search'); ?></button>  
								</div><!-- /.input group -->
							</div>
						</div>

					</form>
				</div>
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
							<th> <?php echo $this->lang->line('balance'); ?> </th>
							<th> <?php echo $this->lang->line('image'); ?> </th>
							<th> <?php echo $this->lang->line('status'); ?> </th>
							<th>  <?php echo $this->lang->line('gift_card_no'); ?> </th>
							<th>  <?php echo $this->lang->line('gift_card'); ?> </th>
							<th> <?php echo $this->lang->line('created_date'); ?> </th>
							<th style="width: 80px;"> <?php echo $this->lang->line('action'); ?> </th>
						</tr>
					</thead>

				</table>
			</div>
			<!-- Button trigger modal -->


		
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  
<script type="text/javascript">
	var postListingUrl =  BASEURL+"admin/users/userajaxlist";
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
	          'aoColumnDefs': [{'bSortable': false,'aTargets': [0,5,6,8,9,10]}]
	});
      


	//$('.submit_card').click(function(){


 function gift_card_submit(user_id=''){
 var card_number = $("#cardno"+user_id).val();
  //alert(user_id+  card_number );
		      $.ajax({
		          type : "POST",
		          url : BASEURL+'admin/users/updateCardnumberOfUser',
		          data :{user_id : user_id,card_number : card_number},
		         // processData:false,
		          //contentType: false,     
		       beforeSend: function() {
		        $('.error').remove();
		       },
		      success: function(response){ 
		        var fdata=JSON.parse(response);
		       //console.log(fdata.status);
		        if(fdata.status ==  undefined || fdata.status ==  true){
		            $('.alert-success').text(fdata.message).show();
		              $('.alert-danger').hide();
		            setTimeout(function(){ location.reload(); },2000);
		           
		        }else{  
		             $('.alert-success').hide();
		              if(fdata.message !==''){
		              $('.alert-danger').text(fdata.message).show();  
		              }  
		              setTimeout(function(){ $('.alert-danger').text(fdata.message).hide();},2000);    
		               $.each(fdata.data, function(key, value) {    
		                  $('input[name='+key+']').closest('div').append(value);
		                  setTimeout(function(){ $('.inputerror').hide();},2000);   
		                });
		        }
		     }
		});
 
};




</script>
