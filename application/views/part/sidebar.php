 <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
	  <!-- sidebar menu: : style can be found in sidebar.less -->

	 <?php 
		$class = strtolower($module);
		$method = strtolower($moduleMethod);

		if(empty($method)){
		   $method = 'index';
		}
		$settings = array('settings');
		$subadminAct = array('subadmin');
		//$otherUser = getOtherUser();


		 $activeRole = getActiveRole();
	?>

      <ul class="sidebar-menu" data-widget="tree">
		  <li class="treeview">
			  <li class="<?php if($class == 'dashboard'){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i> <span><?php echo $this->lang->line('dashboard'); ?> </span></a></li>
			</li>			
	        <?php if(($this->session->userdata('userRoleId')==3) && ($this->session->userdata('userId')!='')){ ?>
			        <li class="treeview <?php if(in_array($class, $subadminAct)){echo 'active menu-open';}?>">
			          <a href="#">
			            <i class="fa fa-table"></i> <span>  <?php echo $this->lang->line('machine_management'); ?>  </span>
			            <span class="pull-right-container">
			            <i class="fa fa-angle-left pull-right"></i>
			            </span>
			          </a>	
			          <ul class="treeview-menu">
			            <li class="<?php if($method == 'index'){echo 'active menu-open';}?>"><a href="<?php echo base_url('admin/machine'); ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('machine_list'); ?> </a></li>			            
			          </ul>
			        </li>
	    	<?php } ?>
		<?php if(($this->session->userdata('userRoleId')==1) && ($this->session->userdata('userId')!='')){ ?>

			<?php //echo $class; echo "<br>"; echo $method; ?>				
		   <li class="treeview">
			  <li class="<?php if(($class=='users') && ($method == 'index' || $method = 'getUserDetail')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/users'); ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('users'); ?> </span></a></li>    
			</li>
		  	<!-- <li class="treeview">
			  <li class="<?php if(($class=='merchant') && ($method == 'index')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/merchant'); ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('merchants'); ?> </span></a></li>    
			</li>
			
			<li class="treeview">
			  <li class="<?php if(($class=='agent') && ($method == 'index')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/agent'); ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('agent'); ?> </span></a></li>    
			</li>

			<li class="treeview">
			  <li class="<?php if(($class=='distributor') && ($method == 'index')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/distributor'); ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('distributor'); ?> </span></a></li>    
			</li> -->


			<li class="treeview">
				<li class="<?php if(($class=='transactions') && ($method == 'index')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/transactions'); ?>"><i class="fa fa-money"></i> <span><?php echo $this->lang->line('transactions'); ?> </span></a></li>    
			</li>

			<li class="treeview">
			  <li class="<?php if(($class=='scan') && ($method == 'index')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/scan/'); ?>"><i class="fa fa-barcode" aria-hidden="true"></i> <span><?php echo $this->lang->line('scan'); ?> </span></a></li>    
			</li>

			<li class="treeview">
				<li class="<?php if(($class=='transactions') && ($method == 'deposithistory')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/transactions/depositHistory'); ?>"><i class="fa fa-money"></i> <span><?php echo $this->lang->line('deposit_money'); ?> </span></a></li>    
			</li>

			<li class="treeview">
			  <li class="<?php if(($class=='transactions') && ($method == 'sendmoney')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/transactions/sendMoney'); ?>"><i class="fa fa-money"></i> <span><?php echo $this->lang->line('send_money'); ?> </span></a></li>    
			</li>

			<li class="treeview">
				<li class="<?php if(($class=='transactions') && ($method == 'withdraw')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/transactions/withdraw'); ?>"><i class="fa fa-gg-circle" aria-hidden="true"></i> <span><?php echo $this->lang->line('withdrawals'); ?> </span></a></li>    
			</li>
			<li class="treeview">
				<li class="<?php if(($class=='transactions') && ($method == 'donation')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/transactions/donation'); ?>"><i class="fa fa-heart"></i> <span>Donation </span></a></li>    
			</li>
			<li class="treeview">
				<li class="<?php if(($class=='TrustlyTransaction') && ($method == 'index')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/TrustlyTransaction/'); ?>"><i class="fa fa-money"> </i> <span>Trustly Transactions </span></a></li>    
			</li>

			

			<!-- <li class="treeview">
				<a href="#">
					<i class="fa fa-table"></i> <span> <?php echo $this->lang->line('withdrawals'); ?>  </span>
					<span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li><a href="<?php echo base_url('admin/transactions/withdraw'); ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('withdrawal_charge'); ?> </a></li>
					
					<li><a href="<?php echo base_url('admin/transactions/withdraw'); ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('withdrawal_history'); ?></a></li>
					
				</ul>
			</li>
 -->

        <!-- <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span> <?php echo $this->lang->line('deposit_money'); ?>  </span>
            <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('admin/transactions/depositMethod'); ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('deposit_method'); ?> </a></li>
            
            <li><a href="<?php echo base_url('admin/transactions/depositHistory'); ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('deposit_history'); ?></a></li>
            
          </ul>
        </li>
 -->


  			  

			<!--<li class="treeview">
				 <li class="<?php if(($class=='lottery') && ($method == 'index')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/lottery/'); ?>"><i class="fa fa-podcast" aria-hidden="true"></i> <span><?php echo $this->lang->line('lottery'); ?> </span></a></li>    
			</li> -->
			

			<!--<li class="treeview">
				 <li class="<?php if(($class=='transactions') && ($method == 'qrcode')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/transactions/qrcode'); ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('all_qrcodes'); ?> </span></a></li>    
			</li>

			<li class="treeview">
				 <li class="<?php if(($class=='advertisement') && ($method == 'index')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/advertisement'); ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('advertisement'); ?> </span></a></li>    
			</li> -->



			<!-- <li class="treeview">
	          <a href="#">
	            <i class="fa fa-table"></i> <span>  <?php echo $this->lang->line('qr_codes'); ?>  </span>
	            <span class="pull-right-container">
	            <i class="fa fa-angle-left pull-right"></i>
	            </span>
	          </a>
	          <ul class="treeview-menu">
	            <li><a href="<?php echo base_url('admin/transactions/qrcode'); ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('all_qrcodes'); ?> </a></li>
	            
	            <li><a href="#<?php //echo base_url('admin/category/virtualFaq'); ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('qrcode_transactions'); ?></a></li>
	            
	          </ul>
	        </li> -->


	        <!-- <li class="treeview">
				 <li class="<?php if(($class=='business') && ($method == 'index')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/business'); ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('business_management'); ?> </span></a></li>    
			</li>

			

			

			<li class="treeview">
				 <li class="<?php if(($class=='category') && ($method == 'index')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/category'); ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('category'); ?> </span></a></li>    
			</li>




		      <li class="treeview">
		        <li class="<?php if(($class=='category') && ($method == 'feedback')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/category/feedback'); ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('feedback'); ?> </span></a></li>    
		      </li>

		      <li class="treeview">
		        <li class="<?php if(($class=='settings') && ($method == 'requestlist')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/settings/requestList'); ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('request'); ?> </span></a></li>    
		      </li>
			
		      <li class="treeview">
		        <li class="<?php if(($class=='category') && ($method == 'setlimit')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/category/setLimit'); ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('transactions_limit'); ?> </span></a></li>    
		      </li> -->


		      <!-- <li class="treeview">
		        <li class="<?php if(($class=='settings') && ($method == 'websetting')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/settings/webSetting'); ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('theme_settings'); ?> </span></a></li>    
		      </li> -->

		     <!-- <li class="treeview <?php if(in_array($class, $subadminAct)){echo 'active menu-open';}?>">
	          <a href="#">
	            <i class="fa fa-table"></i> <span>  <?php echo $this->lang->line('admin_management'); ?>  </span>
	            <span class="pull-right-container">
	            <i class="fa fa-angle-left pull-right"></i>
	            </span>
	          </a>	
	          <ul class="treeview-menu">
	            <li class="<?php if($method == 'index'){echo 'active menu-open';}?>"><a href="<?php echo base_url('admin/subadmin'); ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('staffs_list'); ?> </a></li>
	            
	            <li class="<?php if($method == 'permission'){echo 'active menu-open';}?>"><a href="<?php echo base_url('admin/subadmin/roleList'); ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('role_permission'); ?></a></li>	            
	            
	          </ul>
	        </li> -->
	        <li class="treeview <?php if(in_array($class, $subadminAct)){echo 'active menu-open';}?>">
		         <a href="#">
		           <i class="fa fa-table"></i> <span>  <?php echo $this->lang->line('brf_management'); ?>  </span>
		           <span class="pull-right-container">
		           <i class="fa fa-angle-left pull-right"></i>
		           </span>
		         </a>
		         <ul class="treeview-menu">
		           <li class="<?php if($method == 'index'){echo 'active menu-open';}?>"><a href="<?php echo base_url('admin/subadmin'); ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('staffs_list'); ?> </a></li>
		           
		           <li class="<?php if($method == 'machine_list'){echo 'active menu-open';}?>"><a href="<?php echo base_url('admin/subadmin/machine_list'); ?>"><i class="fa fa-circle-o"></i> <?php echo 'Machine List'?></a></li>            
		           
		         </ul>
       		</li>

<!-- requestList -->
			
	      <!-- <li class="treeview <?php if((in_array($class, $settings)) && ($method != 'requestlist') ){echo 'active menu-open';}?>"> -->
	      	<!-- <li class="treeview <?php if(($class=='settings') && ( $method == 'emaillist' || $method == 'websetting' || $method == 'changepassword')) { echo 'active menu-open'; } ?>">
	          <a href="#">
	            <i class="fa fa-table"></i> <span>  <?php echo $this->lang->line('theme_settings'); ?>  </span>
	            <span class="pull-right-container">
	            <i class="fa fa-angle-left pull-right"></i>
	            </span>
	          </a>
	          <ul class="treeview-menu">
	          	<li class="<?php if($method == 'emaillist'){echo 'active menu-open';}?>"><a href="<?php echo base_url('admin/settings/emailList'); ?>"><i class="fa fa-circle-o"></i> <?php echo "Email Template" //$this->lang->line('website_contents'); ?> </a></li>
	            <li class="<?php if($method == 'websetting'){echo 'active menu-open';}?>"><a href="<?php echo base_url('admin/settings/webSetting'); ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('website_contents'); ?> </a></li>
	            
	            <li class="<?php if($method == 'changepassword'){echo 'active menu-open';}?>"><a href="<?php echo base_url('admin/settings/changePassword'); ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('change_password'); ?></a></li>
	            
	          </ul>
	        </li> -->

		<!--  <li class="treeview <?php if((in_array($class, $settings)) && ( $method == 'websetting' ) && ($method == 'changepassword' ) ){echo 'active menu-open';}?>"> -->
		  <!-- <li class="treeview <?php if(($class=='settings') && ( $method == 'faq' || $method == 'virtualfaq' || $method == 'tutorialsplashwallet' || $method == 'tutorialsplashmaster' ||  $method=='addtutorialsplash')) { echo 'active menu-open'; } ?>"> 
          <a href="#">
            <i class="fa fa-table"></i> <span> <?php echo $this->lang->line('app_settings'); ?>  </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          	<li class="<?php if($method == 'faq'){echo 'active menu-open';}?>"><a href="<?php echo base_url('admin/settings/faq'); ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('faq'); ?> </a></li>
	            
	            <li class="<?php if($method == 'virtualfaq'){echo 'active menu-open';}?>"><a href="<?php echo base_url('admin/settings/virtualFaq'); ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('virtual_faq'); ?></a></li>
            <li class="<?php if($method == 'tutorialsplashwallet'){echo 'active menu-open';}?>"><a href="<?php echo base_url('admin/settings/tutorialSplashWallet'); ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('tutorial_splash_wallet'); ?> </a></li>

            <li class="<?php if($method == 'emaillist'){echo 'active menu-open';}?>"><a href="<?php echo base_url('admin/settings/tutorialSplashMaster'); ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('tutorial_splash_master'); ?> </a></li>

            <li class="<?php if($method == 'addtutorialsplash'){echo 'active menu-open';}?>"><a href="<?php echo base_url('admin/settings/addTutorialSplash'); ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('add_tutorial_splash'); ?> </a></li>

            
          </ul>
        </li> -->
     <?php 

      }else if((in_array($this->session->userdata('userRoleId'), $activeRole)) && ($this->session->userdata('userId')!='')){ 
        $perDetails = getSubAdminpermission();
        //echo "<pre>"; print_r($otherUser);echo "</pre>";
         
	 ?>		
 		<?php if($perDetails['user_list']=="1"){ ?>
 		   <li class="treeview">
			  <li class="<?php if(($class=='users') && ($method == 'index')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/users'); ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('users'); ?> </span></a></li>    
			</li>
			  <?php
         }
         if($perDetails['merchant_list']=="1"){
		 ?>
		  	<li class="treeview">
			  <li class="<?php if(($class=='merchant') && ($method == 'index')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/merchant'); ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('merchants'); ?> </span></a></li>    
			</li>
			  <?php
         }
         if($perDetails['agent_list']=="1"){
		 ?>
			<li class="treeview">
			  <li class="<?php if(($class=='agent') && ($method == 'index')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/agent'); ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('agent'); ?> </span></a></li>    
			</li>
  <?php
         }
         if($perDetails['distributor_list']=="1"){
		 ?>
			<li class="treeview">
			  <li class="<?php if(($class=='distributor') && ($method == 'index')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/distributor'); ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('distributor'); ?> </span></a></li>    
			</li>
  <?php
         }
         if($perDetails['transactions_list']=="1"){
		 ?>

			<li class="treeview">
				<li class="<?php if(($class=='transactions') && ($method == 'index')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/transactions'); ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('transactions'); ?> </span></a></li>    
			</li>

		 <?php
         }
         if($perDetails['Withdrawal_list']=="1"){
		 ?>

			<li class="treeview">
				<li class="<?php if(($class=='transactions') && ($method == 'withdraw')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/transactions/withdraw'); ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('withdrawals'); ?> </span></a></li>    
			</li>

		 <?php
         }
         if($perDetails['deposit_list']=="1"){
		 ?>
		 	<li class="treeview">
				<li class="<?php if(($class=='transactions') && ($method == 'deposithistory')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/transactions/depositHistory'); ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('deposit_money'); ?> </span></a></li>    
			</li>


		 <?php
         }
         if($perDetails['sendmoney_list']=="1"){
		 ?>


			<li class="treeview">
			  <li class="<?php if(($class=='transactions') && ($method == 'sendmoney')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/transactions/sendMoney'); ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('send_money'); ?> </span></a></li>    
			</li>


		 <?php
         }
         if($perDetails['requestmoney_list']=="1"){
		 ?>
		 		<li class="treeview">
			  <li class="<?php if(($class=='transactions') && ($method == 'requestmoney')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/transactions/requestMoney'); ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('request_money'); ?> </span></a></li>    
			</li>


		 <?php
         }
         if($perDetails['sharebill_list']=="1"){
		 ?>

			<li class="treeview">
				 <li class="<?php if(($class=='transactions') && ($method == 'sharebill')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/transactions/shareBill'); ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('sharebill_requests'); ?> </span></a></li>    
			</li>
			

		 <?php
         }
         if($perDetails['qrcodes_list']=="1"){
		 ?>


			<li class="treeview">
				 <li class="<?php if(($class=='transactions') && ($method == 'qrcode')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/transactions/qrcode'); ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('all_qrcodes'); ?> </span></a></li>    
			</li>


		 <?php
         }
         if($perDetails['business_list']=="1"){
		 ?>
 		 	<li class="treeview">
				 <li class="<?php if(($class=='business') && ($method == 'index')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/business'); ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('business_management'); ?> </span></a></li>    
			</li>


		 <?php
         }
         if($perDetails['category_list']=="1"){
		 ?>

 			<li class="treeview">
			  <li class="<?php if(($class=='category') && ($method == 'index')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/category'); ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('category'); ?> </span></a></li>    
			</li>
		 <?php
         }
         if($perDetails['feedback_list']=="1"){
		 ?>

		 	<li class="treeview">
		        <li class="<?php if(($class=='category') && ($method == 'feedback')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/category/feedback'); ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('feedback'); ?> </span></a></li>    
		      </li>
		 <?php
         }
         if($perDetails['request_list']=="1"){
		 ?>

		 	<li class="treeview">
		        <li class="<?php if(($class=='settings') && ($method == 'requestlist')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/settings/requestList'); ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('request'); ?> </span></a></li>    
		      </li>


		      <?php
         }
         if($perDetails['viewTrsLimit']=="1"){  
		 ?> 

		      <li class="treeview">
		        <li class="<?php if(($class=='category') && ($method == 'setlimit')){ echo 'active menu-open'; } ?>"><a href="<?php echo base_url('admin/category/setLimit'); ?>"><i class="fa fa-user"></i> <span><?php echo $this->lang->line('transactions_limit'); ?> </span></a></li>    
		      </li>

		 <?php
         }
         if($perDetails['web_setting']=="1" || $perDetails['change_password']=="1"){
		 ?>
		 		<li class="treeview <?php if(($class=='settings') && ( $method == 'websetting' || $method == 'changepassword' )) { echo 'active menu-open'; } ?>">
	          <a href="#">
	            <i class="fa fa-table"></i> <span>  <?php echo $this->lang->line('theme_settings'); ?>  </span>
	            <span class="pull-right-container">
	            <i class="fa fa-angle-left pull-right"></i>
	            </span>
	          </a>
	          <ul class="treeview-menu">
	          		<?php
        	 if($perDetails['web_setting']=="1"){
            ?>
	            <li class="<?php if($method == 'websetting'){echo 'active menu-open';}?>"><a href="<?php echo base_url('admin/settings/webSetting'); ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('website_contents'); ?> </a></li>
	             <?php
         }
         if($perDetails['change_password']=="1"){
            ?>
	            <li class="<?php if($method == 'changepassword'){echo 'active menu-open';}?>"><a href="<?php echo base_url('admin/settings/changePassword'); ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('change_password'); ?></a></li>
	            <?php } ?>
	            
	          </ul>
	        </li>


		 <?php
         }

          if($perDetails['faq_list']=="1" || $perDetails['virtual_faq_list']=="1" || $perDetails['tutorialSplashWallet']=="1" || $perDetails['tutorialSplashMaster']=="1" || $perDetails['addTutSpwalletMaster']=="1"){
         ?>

		 	<li class="treeview <?php if(($class=='settings') && ( $method == 'faq' || $method == 'virtualfaq' || $method == 'tutorialsplashwallet' || $method == 'tutorialsplashmaster' ||  $method=='addtutorialsplash')) { echo 'active menu-open'; } ?>"> 
          <a href="#">
            <i class="fa fa-table"></i> <span> <?php echo $this->lang->line('app_settings'); ?>  </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          	<?php
        	 if($perDetails['faq_list']=="1"){
            ?>
          	<li class="<?php if($method == 'faq'){echo 'active menu-open';}?>"><a href="<?php echo base_url('admin/settings/faq'); ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('faq'); ?> </a></li>
	            
	           <?php
         }
         if($perDetails['virtual_faq_list']=="1"){
            ?>
	            <li class="<?php if($method == 'virtualfaq'){echo 'active menu-open';}?>"><a href="<?php echo base_url('admin/settings/virtualFaq'); ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('virtual_faq'); ?></a></li>

	          <?php
         }
         if($perDetails['tutorialSplashWallet']=="1"){
            ?>
            <li class="<?php if($method == 'tutorialsplashwallet'){echo 'active menu-open';}?>"><a href="<?php echo base_url('admin/settings/tutorialSplashWallet'); ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('tutorial_splash_wallet'); ?> </a></li>
             <?php
         }
         if($perDetails['tutorialSplashMaster']=="1"){
            ?>
            <li class="<?php if($method == 'emaillist'){echo 'active menu-open';}?>"><a href="<?php echo base_url('admin/settings/tutorialSplashMaster'); ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('tutorial_splash_master'); ?> </a></li>
             <?php
         }
         if($perDetails['addTutSpwalletMaster']=="1"){
            ?>
            <li class="<?php if($method == 'addtutorialsplash'){echo 'active menu-open';}?>"><a href="<?php echo base_url('admin/settings/addTutorialSplash'); ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('add_tutorial_splash'); ?> </a></li>

             <?php
         }
            ?>
            <!-- <li><a href="<?php echo base_url('admin/settings/staticTemplates'); ?>"><i class="fa fa-circle-o"></i> <?php echo "Static Templates"; //echo $this->lang->line('tutorial_splash'); ?> </a></li> -->
          </ul>
        </li>
		<?php
         }
         ?>
	  <?php 
      	}
         
	 ?>
	 <li class="treeview <?php if(($class=='settings') && ( $method == 'emaillist' || $method == 'websetting' || $method == 'changepassword')) { echo 'active menu-open'; } ?>">
	          <a href="#">
	            <i class="fa fa-table"></i> <span>  <?php echo $this->lang->line('settings'); ?>  </span>
	            <span class="pull-right-container">
	            <i class="fa fa-angle-left pull-right"></i>
	            </span>
	          </a>
	          <ul class="treeview-menu">
	          	<!-- <li class="<?php if($method == 'emaillist'){echo 'active menu-open';}?>"><a href="<?php echo base_url('admin/settings/emailList'); ?>"><i class="fa fa-circle-o"></i> <?php echo "Email Template" //$this->lang->line('website_contents'); ?> </a></li>
	            <li class="<?php if($method == 'websetting'){echo 'active menu-open';}?>"><a href="<?php echo base_url('admin/settings/webSetting'); ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('website_contents'); ?> </a></li> -->
	            
	            <li class="<?php if($method == 'changepassword'){echo 'active menu-open';}?>"><a href="<?php echo base_url('admin/settings/changePassword'); ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('change_password'); ?></a></li>
                     <!-- Change by harish -->
                    <li class="<?php if($method == 'changeTransactionCharge'){echo 'active menu-open';}?>"><a href="<?php echo base_url('admin/settings/changeTransactionCharge'); ?>"><i class="fa fa-circle-o"></i> <?php echo $this->lang->line('transaction_charge'); ?></a></li>
	       
	            
	          </ul>
	        </li>
	  </ul>
    </section>
    <!-- /.sidebar -->
	      