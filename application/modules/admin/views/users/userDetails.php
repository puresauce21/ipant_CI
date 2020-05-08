	<style type="text/css">
	
    .inner {margin-left: 15px;
     }
	</style>
	<?php //echo "<pre>"; print_r($userInfo);echo "</pre>";?>
	
	    <!-- Content Header (Page header) -->
    <section class="content-header">
	  <h1>
		<?php echo $title; ?>
	  </h1>
	  <?php echo $this->breadcrumbs->show(); ?> 
	</section>
    <!-- Main content -->

   
<?php
	
    if($transListPer=="1"){ 
    	$transUrl=base_url('admin/transactions/index/'.encode($userInfo->id));
    }else{
    	$transUrl="#";
    }
    if($depoListPer=="1"){ 
    	$depoUrl=base_url('admin/transactions/depositHistory/'.encode($userInfo->id));
    }else{
		$depoUrl="#";
    }
    if($withdrListPer=="1"){ 
    	$withdrUrl=base_url('admin/transactions/withdraw/'.encode($userInfo->id));
    }else{
    	$withdrUrl="#";
    }
?>


    <section class="content">
    	<!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $total_trans; ?></h3>
              <p> <?php echo $this->lang->line('transactions'); ?> </p>
            </div>
            <div class="icon">
              <i class="fa fa-money"></i>
            </div>
            <a href="<?php echo $transUrl;?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $total_deposite; ?></h3>

              <p> <?php echo $this->lang->line('deposit_money'); ?> </p>
            </div>
            <div class="icon">
              Kr<!-- <i class="fa fa-gbp"></i> -->
            </div>
            <a href="<?php echo $depoUrl;?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $total_withdraw; ?></h3>

              <p> <?php echo $this->lang->line('withdrawal_history'); ?> </p>
            </div>
            <div class="icon">
              <i class="fa fa-gg-circle"></i>
            </div>
            <a href="<?php echo $withdrUrl;?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->

      </div>
      <!-- /.row -->


		<!-- Default box -->
      <div class="box">
        <div class="box-body detail-page">
					<div class="col-md-12">
						<div class="row text-center no-margin">
						<div class="user-img-wrap">
								<h4><?php echo $this->lang->line('profile'); ?></h4>
								<div class="circle">
									<?php $image=!empty($userInfo->profile_pic) ? $userInfo->profile_pic : ""; ?>
									<img class="profile-pic" src="<?php echo getImage($image,"user"); ?>" id="blah">
								</div>
								</div>
							</div>
							<div class="row">
							<div class="col-md-6 col-sm-6">
							
								<div class="col-md-12"> 
								<div class="detail-page-block">
								  <h4 class="detail-page-headng"> <?php echo $this->lang->line('fullname'); ?> :</h4> 
								  <div class="detail-page-content"><?php echo $userInfo->firstname." ".$userInfo->lastname; ?></div>
								</div>
								</div>
							
								<div class="col-md-12"> 
								<div class="detail-page-block">
								  <h4 class="detail-page-headng"> <?php echo $this->lang->line('email'); ?> :</h4> 
								  <div class="detail-page-content"> <?php echo $userInfo->email; ?> </div>
								</div>
								</div>

								<div class="col-md-12"> 
								<div class="detail-page-block">
								  <h4 class="detail-page-headng"> <?php echo $this->lang->line('mobile'); ?> :</h4> 
								  <div class="detail-page-content"> <?php echo $userInfo->country_id."". $userInfo->mobile_no; ?> </div>
								</div>
								</div>

								<div class="col-md-12"> 
								<div class="detail-page-block">
								  <h4 class="detail-page-headng"> <?php echo "Country"; //$this->lang->line('mobile'); ?> :</h4> 
								  <div class="detail-page-content"> <?php echo $userInfo->country_name; ?> </div>
								</div>
								</div>
							</div>

							<div class="col-md-6 col-sm-6"> 
							 <!-- <div class="user-img-wrap">
							<h4><?php echo $this->lang->line('qr_codes'); ?></h4>
							<div class="circle">
							<?php 
							 $qrcodeImg = "";
							 if(!empty($userInfo->qr_code)){
								$qrcodeImg = base_url('uploads/coupon_qr').'/'.$userInfo->qr_code;
							 }
							if(!empty($qrcodeImg)){
							?>
								<img src="<?php echo $qrcodeImg; ?>">
							<?php }else{ ?>
								 <img src="<?php echo  base_url('uploads/coupon_qr/no-image.jpg')?>" id="blah">
							<?php } ?>
						 </div>
								</div> --> 
								 

								<div class="col-md-12"> 
							<div class="detail-page-block">
							  <h4 class="detail-page-headng"> <?php echo $this->lang->line('wallet_balance'); ?> :</h4> 
							  <div class="detail-page-content"><?php echo $this->lang->line('money_sign')."".number_format($userInfo->current_wallet_balance,2); ?></div>
							</div>
								</div>
						
								<div class="col-md-12"> 
							<div class="detail-page-block">
							  <h4 class="detail-page-headng"> <?php echo $this->lang->line('created_date'); ?> :</h4> 
							  <div class="detail-page-content"> <?php echo change_date_formate($userInfo->creation_date_time); ?> </div>
							</div>
								</div>

							<!-- <div class="col-md-12"> 
							<div class="detail-page-block">
							  <h4 class="detail-page-headng"> <?php echo $this->lang->line('family_name'); ?> :</h4> 
							  <div class="detail-page-content"> <?php echo $userInfo->familyname; ?>  </div>
							</div>
						  </div> -->

								<div class="col-md-12"> 
							<div class="detail-page-block">
							  <h4 class="detail-page-headng"> <?php echo $this->lang->line('address'); ?> :</h4> 
							  <div class="detail-page-content"> <?php echo $userInfo->address; ?>  </div>
							</div>
								</div> 
							</div>

					</div>
				</div>
	  	</div>
      <!-- /.box -->

    </section>
    <!-- /.content -->













				













						
















