    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $title; ?>
        <!-- <small>In Progress</small> -->
      </h1>
      <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol> -->
    </section>
    <?php
    	$roleId = $this->session->userdata('userRoleId');
    ?>
    <?php if($roleId == 1) { ?>
      <!-- Main content -->
      <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
	            <!-- small box -->
	            <a href="<?php echo base_url('admin/users');?>" class="small-box-footer">
		            <div class="small-box bg-aqua">
		              <div class="inner">
		                <h3><?php echo $total_user; ?> Users</h3>

		                <p><?php echo $this->lang->line('users'); ?></p>
		              </div>
		              <div class="icon">
		                <i class="ion ion-person-add"></i>
		              </div>
		          
		              <?php if(($roleId == '1') || ($userListPer==1)){?>
		  	        
		  	        <?php }else{?>
		  	        <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
		  	        <?php }?>
		            </div>
	            </a>
	        </div>
          <!-- ./col -->
          
          <!-- ./col -->
        </div>
        <!-- /.row -->
        
        <h1>
          <?php //echo "Statistics"; ?>
          <small>Statistics</small>
        </h1>
         <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
	            <!-- small box -->
	            <a href="<?php echo base_url('admin/transactions/depositHistory');?>" class="small-box-footer">
		            <div class="small-box bg-aqua">

		              <div class="inner">
		                <h3><?php echo !empty($totalDepositAmt) ? $this->lang->line('money_sign').number_format($totalDepositAmt,2) : "0"; ?></h3>

		                <p><?php echo  "Total Deposit"//$this->lang->line('users'); ?></p>
		              </div>
		              <div class="icon">
		                Kr<!-- <i class="fa fa-gbp"></i> -->
		              </div>
		          
		              <?php //if(($roleId == '1') || ($userListPer==1)){?>
		            <!-- <a href="<?php echo base_url('admin/users');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
		            <?php //}else{?>
		            
		            <?php //}?>
		            </div>
	            </a>
            </div>
          <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
	            <!-- small box -->
	            <a href="<?php echo base_url('admin/transactions/withdraw');?>" class="small-box-footer">
		            <div class="small-box bg-green">
		              <div class="inner">
		                <h3><?php echo !empty($totalWithdraAmt) ? $this->lang->line('money_sign').number_format($totalWithdraAmt,2) : "0"; ?></h3>

		                <p><?php echo "Total Withdrawal" //$this->lang->line('merchants'); ?></p>
		              </div>
		              <div class="icon">
		                <i class="fa fa-gg-circle"></i>
		              </div>
		              
		              <!-- <?php if(($roleId == '1') || ($merchantListPer==1)){?>
		            <a href="<?php echo base_url('admin/merchant');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
		            <?php }else{?>
		            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
		            <?php }?> -->
		            </div>
	            </a>
            </div>
          <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
	            <!-- small box -->
	            <a href="#" class="small-box-footer">
		            <div class="small-box bg-yellow">
		              <div class="inner">
		                <h3><?php echo !empty($totalChargeAmt) ? $this->lang->line('money_sign').number_format($totalChargeAmt,2) : "0"; ?></h3>

		                <p><?php echo "Total Charges" //$this->lang->line('agent'); ?></p>
		              </div>
		              <div class="icon">
		                <i class="ion ion-person-add"></i>
		              </div>
		              
		              <!-- <?php if(($roleId == '1') || ($agentListPer==1)){?>
		            <a href="<?php echo base_url('admin/agent');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
		            <?php }else{?>
		            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
		            <?php }?> -->
		            </div>
	            </a>
            </div>
          <!-- ./col -->
          
        </div>
       
      </section>
   
   <?php } else { ?>

          <!-- Main content -->
      <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3><?php echo $total_machine; ?> Machine</h3>

                <p><?php echo $this->lang->line('machine'); ?></p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
          
              <?php if(($roleId == '3') || ($userListPer==1)){?>
            <a href="<?php echo base_url('admin/machine');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            <?php }else{?>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            <?php }?>
            </div>
          </div>
          <!-- ./col -->
          
          <!-- ./col -->
        </div>
        <!-- /.row -->
      
      </section>

   <?php } ?>

<style type="text/css">
	.small-box { 
		height: 180px;
		width: 180px;
		border-radius: 100%;
		margin: 0 auto;
		box-shadow: 0px 0px 22px 8px rgba(0,0,0,0.2);
	}
	.small-box .inner { 
		text-align: center;
	}
</style>