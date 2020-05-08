    <!-- Content Header (Page header) -->
    <section class="content-header">
	  <h1>
		<?php echo $title; //change by harish kumar
                ?>
	  </h1>
	  <?php echo $this->breadcrumbs->show(); ?> 
	</section>

    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box">
	<div class="box-header with-border">
	  <h3 class="box-title">Transaction charge is applicable on following type transactions.</h3>
          <ul><li>Send money from wallet to wallet</li><li>Withdraw money from wallet to bank</li></ul>
	</div>
	<!-- /.box-header -->
	<!-- form start -->
	<form class="form-horizontal" method="POST" action="<?php echo base_url('admin/settings/saveFeeCharge'); ?>" data-parsley-validate>
	  <div class="box-body">
	  	<div class="form-group">
  		</div>
              <?php $fees = $charge_detail['charge_fee']; $fix = ''; $float = ''; if($charge_detail['charge_method']=='FIX') {$fix='selected';}elseif($charge_detail['charge_method']=='FLOAT'){$float='selected';}  ?>
		<div class="form-group">
		  <label for="fee_method" class="col-sm-2 control-label">Charge Type</label>

		  <div class="col-sm-8">
			  <select class="form-control" id="fee_method" name="charge_method" class="form-control" data-parsley-required-message="Charge type is required" required="">
                             <option value="">--Select--</option>
                                    <option value="FIX" <?= $fix ?> >
                                        Fix
                                    </option> 
                                    <option value="FLOAT" <?= $float ?>>
                                        In Percent
                                    </option>                                   

                            </select>
		  </div>
		</div>
		<div class="form-group">
		  <label for="transaction_fee" class="col-sm-2 control-label">Charge</label>

		  <div class="col-sm-8">
                      <input type="number" value="<?= $fees ?>" max="100" class="form-control" id="inputPassword3" placeholder="Enter charge" name="transaction_fee" id="transaction_fee" data-parsley-required-message="Charge is required" required="">
		  </div>
		</div>		
		
	 </div>
	  <!-- /.box-body -->
	  <div class="box-footer">
		<button type="submit" class="btn btn-info ">Submit</button>
	  </div>
	  <!-- /.box-footer -->
	</form>
  
		 
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->

  
