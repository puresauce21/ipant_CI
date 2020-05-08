<?php 
   $permissions = !empty($permission) ? $permission : "";
   $id = "";
   $roleid = "";
   
   //echo "<pre>"; print_r($permission);die;
   
   if(!empty($permissions)){
      $permission = unserialize($permission[0]->permission);
      $id = $permissions[0]->id;
      $roleid = $permissions[0]->roleid;
   }

	// $permissions = !empty($permission) ? $permission : "";
	// $permission = unserialize($permission[0]->permission);
	$dashboard  = !empty($permission['dashboard']) ? $permission['dashboard'] : 0 ;
	$user_list  = !empty($permission['user_list']) ? $permission['user_list'] : 0 ;
	$user_edit  = !empty($permission['user_edit']) ? $permission['user_edit'] : 0 ;
	$user_status  = !empty($permission['user_status']) ? $permission['user_status'] : 0 ;
	$user_view  = !empty($permission['user_view']) ? $permission['user_view'] : 0 ;
   if(empty($user_list)){ $userDis="disabled"; }else{ $userDis=""; } // check user list active or not
   //Merchant
	$merchant_list  = !empty($permission['merchant_list']) ? $permission['merchant_list'] : 0 ;
	$add_merchant  = !empty($permission['add_merchant']) ? $permission['add_merchant'] : 0 ;
	$edit_merchant  = !empty($permission['edit_merchant']) ? $permission['edit_merchant'] : 0 ;
	$merchant_status  = !empty($permission['merchant_status']) ? $permission['merchant_status'] : 0 ;
   $merchant_view  = !empty($permission['merchant_view']) ? $permission['merchant_view'] : 0 ;
   if(empty($merchant_list)){ $merchantDis="disabled"; }else{ $merchantDis=""; } // check merchant list active or not
   //Agent
	$agent_list  = !empty($permission['agent_list']) ? $permission['agent_list'] : 0 ;
   $add_agent  = !empty($permission['add_agent']) ? $permission['add_agent'] : 0 ;
	$edit_agent  = !empty($permission['edit_agent']) ? $permission['edit_agent'] : 0 ;
	$agent_status  = !empty($permission['agent_status']) ? $permission['agent_status'] : 0 ;
   if(empty($agent_list)){ $agentDis="disabled"; }else{ $agentDis=""; } // check agent list active or not
   //Distributor
	$distributor_list  = !empty($permission['distributor_list']) ? $permission['distributor_list'] : 0 ;
	$add_distributor  = !empty($permission['add_distributor']) ? $permission['add_distributor'] : 0 ;
	$edit_distributor  = !empty($permission['edit_distributor']) ? $permission['edit_distributor'] : 0 ;
   $distributor_status  = !empty($permission['distributor_status']) ? $permission['distributor_status'] : 0 ;
   if(empty($distributor_list)){ $distributorDis="disabled"; }else{ $distributorDis=""; } // check distributor list active or not

   $transactions_list  = !empty($permission['transactions_list']) ? $permission['transactions_list'] : 0 ;
   $Withdrawal_list  = !empty($permission['Withdrawal_list']) ? $permission['Withdrawal_list'] : 0 ;
   $deposit_list  = !empty($permission['deposit_list']) ? $permission['deposit_list'] : 0 ;
   $sendmoney_list  = !empty($permission['sendmoney_list']) ? $permission['sendmoney_list'] : 0 ;
   $requestmoney_list  = !empty($permission['requestmoney_list']) ? $permission['requestmoney_list'] : 0 ;
   // share bill
   $sharebill_list  = !empty($permission['sharebill_list']) ? $permission['sharebill_list'] : 0 ;
   $sharebill_detail  = !empty($permission['sharebill_detail']) ? $permission['sharebill_detail'] : 0 ;
   if(empty($sharebill_list)){ $sharebillDis="disabled"; }else{ $sharebillDis=""; } // check sharebill list active or not
   $qrcodes_list  = !empty($permission['qrcodes_list']) ? $permission['qrcodes_list'] : 0 ;
   // business
   $business_list  = !empty($permission['business_list']) ? $permission['business_list'] : 0 ;
   $add_business  = !empty($permission['add_business']) ? $permission['add_business'] : 0 ;
   $edit_business  = !empty($permission['edit_business']) ? $permission['edit_business'] : 0 ;
   $business_status  = !empty($permission['business_status']) ? $permission['business_status'] : 0 ;
   if(empty($business_list)){ $businessDis="disabled"; }else{ $businessDis=""; } // check business list active or not
   //category
   $category_list  = !empty($permission['category_list']) ? $permission['category_list'] : 0 ;
   $add_category  = !empty($permission['add_category']) ? $permission['add_category'] : 0 ;
   $edit_category  = !empty($permission['edit_category']) ? $permission['edit_category'] : 0 ;
   $category_status  = !empty($permission['category_status']) ? $permission['category_status'] : 0 ;
   if(empty($category_list)){ $categoryDis="disabled"; }else{ $categoryDis=""; } // check category list active or not
   //$add_agent  = !empty($permission['add_agent']) ? $permission['add_agent'] : 0 ;
   //$edit_agent  = !empty($permission['edit_agent']) ? $permission['edit_agent'] : 0 ;
   //$agent_status  = !empty($permission['agent_status']) ? $permission['agent_status'] : 0 ;
   $feedback_list  = !empty($permission['feedback_list']) ? $permission['feedback_list'] : 0 ;
   $request_list  = !empty($permission['request_list']) ? $permission['request_list'] : 0 ;
   //transaction limit
   $viewTrsLimit  = !empty($permission['viewTrsLimit']) ? $permission['viewTrsLimit'] : 0 ;
   $add_money  = !empty($permission['add_money']) ? $permission['add_money'] : 0 ;
   $send_money  = !empty($permission['send_money']) ? $permission['send_money'] : 0 ;
   $withdrawal_money  = !empty($permission['withdrawal_money']) ? $permission['withdrawal_money'] : 0 ;
   $cashout  = !empty($permission['cashout']) ? $permission['cashout'] : 0 ;
   if(empty($viewTrsLimit)){ $trsLimitDis="disabled"; }else{ $trsLimitDis=""; } // check transaction limit active or not
   //faq 
   $faq_list  = !empty($permission['faq_list']) ? $permission['faq_list'] : 0 ;
	$faq_add  = !empty($permission['faq_add']) ? $permission['faq_add'] : 0 ;
   $faq_edit  = !empty($permission['faq_edit']) ? $permission['faq_edit'] : 0 ;
	$faq_status  = !empty($permission['faq_status']) ? $permission['faq_status'] : 0 ;
   $faq_delete  = !empty($permission['faq_delete']) ? $permission['faq_delete'] : 0 ;
   if(empty($faq_list)){ $faqDis="disabled"; }else{ $faqDis=""; } // check faq list active or not
   //virtual faq
   $virtual_faq_list  = !empty($permission['virtual_faq_list']) ? $permission['virtual_faq_list'] : 0 ;
   $add_virtual_faq  = !empty($permission['add_virtual_faq']) ? $permission['add_virtual_faq'] : 0 ;
   $edit_virtual_faq  = !empty($permission['edit_virtual_faq']) ? $permission['edit_virtual_faq'] : 0 ;
   $virtual_faq_status  = !empty($permission['virtual_faq_status']) ? $permission['virtual_faq_status'] : 0 ;
   $virtual_faq_delete  = !empty($permission['virtual_faq_delete']) ? $permission['virtual_faq_delete'] : 0 ;
   if(empty($virtual_faq_list)){ $virtualfaqDis="disabled"; }else{ $virtualfaqDis=""; } // check virtual faq list active or not
   //Tutorial Splash Wallet 
   $tutorialSplashWallet  = !empty($permission['tutorialSplashWallet']) ? $permission['tutorialSplashWallet'] : 0 ;
   $tutorialSplashWalletStatus  = !empty($permission['tutorialSplashWalletStatus']) ? $permission['tutorialSplashWalletStatus'] : 0 ;
   $tutorialSplashWalletDelete  = !empty($permission['tutorialSplashWalletDelete']) ? $permission['tutorialSplashWalletDelete'] : 0 ;
   $tutorialSplashWalletMulDelete  = !empty($permission['tutorialSplashWalletMulDelete']) ? $permission['tutorialSplashWalletMulDelete'] : 0 ;
   if(empty($tutorialSplashWallet)){ $tutSplWalDis="disabled"; }else{ $tutSplWalDis=""; } // check tutorial Splash Wallet list active or not
   //Tutorial Splash Master 
   $tutorialSplashMaster  = !empty($permission['tutorialSplashMaster']) ? $permission['tutorialSplashMaster'] : 0 ;
   $tutorialSplashMasterStatus  = !empty($permission['tutorialSplashMasterStatus']) ? $permission['tutorialSplashMasterStatus'] : 0 ;
   $tutorialSplashMasterDelete  = !empty($permission['tutorialSplashMasterDelete']) ? $permission['tutorialSplashMasterDelete'] : 0 ;
   $tutorialSplashMasterMulDelete  = !empty($permission['tutorialSplashMasterMulDelete']) ? $permission['tutorialSplashMasterMulDelete'] : 0 ;
   if(empty($tutorialSplashMaster)){ $tutSplMasDis="disabled"; }else{ $tutSplMasDis=""; } // check tutorial Splash Master list active or not
   $addTutSpwalletMaster  = !empty($permission['addTutSpwalletMaster']) ? $permission['addTutSpwalletMaster'] : 0 ;
   //settings
   $web_setting  = !empty($permission['web_setting']) ? $permission['web_setting'] : 0 ;
   $change_password  = !empty($permission['change_password']) ? $permission['change_password'] : 0 ;
	//if(empty($web_setting)){ $settingDis="disabled"; }else{ $settingDis=""; } // check web-setting active or not

?>
	


<!-- Content Header (Page header) -->
 <section class="content-header">
  <h1>
	<?php echo $title." ".$role_name; ?>
  </h1>
  <?php echo $this->breadcrumbs->show(); ?> 
</section>

<!-- Main content -->
<section class="content">
   <div class="row">
      <!-- left column -->
      <!-- right column -->
      <div class="col-md-12">
         <!-- /.box -->
         <!-- general form elements disabled -->
         <div class="box box-warning">
            <div class="box-header with-border">
               <h3 class="box-title"></h3>
            </div>
            <!-- /.box-header -->
            <form role="form" method="POST" action="<?php echo base_url('admin/subadmin/setPermission'); ?>">
               <!-- Users Permission start -->
               <div class="box-body"> 
                  <input type="hidden" name="per_id" value="<?php echo (!empty($id)) ? $id : ""; ?>">
                  <input type="hidden" name="per_role_id" value="<?php echo (!empty($roleid)) ? $roleid : ""; ?>">
                

				  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
						         <b><?php echo $this->lang->line('users_permission'); ?> :</b>
                        </label>
                     </div>
                  </div>
                   <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="flat-red" id="user-list" name="user_list" value="<?php echo $user_list ?>" <?php echo ($user_list==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('users_list'); ?>
                        </label>
                     </div>
                  </div>
                  
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" id="user_edit" class="user-data" <?php echo $userDis; ?> name="user_edit" value="<?php echo $user_edit ?>" <?php echo ($user_edit==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('edit_user'); ?>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" id="user_status" class="user-data" <?php echo $userDis; ?> name="user_status" value="<?php echo $user_status ?>" <?php echo ($user_status==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('users_status'); ?>                        
                        </label>
                     </div>
                  </div>
                  
               </div>
               
               
                <div class="box-body"> 
				<div class="col-md-3">
                     <div class="checkbox">
                        <label>
						
                        </label>
                     </div>
                  </div>
                  
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" id="user_view" class="user-data" <?php echo $userDis; ?> name="user_view" value="<?php echo $user_view ?>" <?php echo ($user_view==1) ? 'checked' : ''; ?>>
                           <?php echo $this->lang->line('user_view'); ?>                        
                        </label>
                     </div>
                  </div>
                  
			  </div>
				
				<!-- Users Permission End -->
				<!-- Merchant Permission Start -->

            <div class="box-body">
				   <div class="col-md-3">
                     <div class="checkbox">
                        <label>
						         <b><?php echo $this->lang->line('merchant_permission'); ?> :</b>
                        </label>
                     </div>
               </div>
				   
				  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" id="merchant-list" class="flat-red" name="merchant_list" value="<?php echo $merchant_list ?>" <?php echo ($merchant_list==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('merchant_list'); ?>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="merchant-data" <?php echo $merchantDis; ?> name="add_merchant" value="<?php echo $add_merchant ?>" <?php echo ($add_merchant==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('add_merchant'); ?>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="merchant-data" name="edit_merchant" <?php echo $merchantDis; ?> value="<?php echo $edit_merchant ?>" <?php echo ($edit_merchant==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('edit_merchant'); ?>
                        </label>
                     </div>
                  </div>
                  
               </div>
               <div class="box-body">
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="merchant-data" <?php echo $merchantDis; ?> name="merchant_status" value="<?php echo $merchant_status ?>" <?php echo ($merchant_status==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('merchant_status'); ?>
                        </label>
                     </div>
                  </div>

                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="merchant-data" <?php echo $merchantDis; ?> name="merchant_view" value="<?php echo $merchant_view ?>" <?php echo ($merchant_view==1) ? 'checked' : ''; ?>>
                           <?php echo $this->lang->line('merchant_view'); ?>                        
                        </label>
                     </div>
                  </div>
                  
                  
               </div>
               
               	<!-- Merchant Permission End -->

               <!-- Agent Permission Start -->
            
            <div class="box-body">
               <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                           <b><?php echo $this->lang->line('agent_permission'); ?> :</b>
                        </label>
                     </div>
               </div>
               
              <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" id="agent-list" class="flat-red" name="agent_list" value="<?php echo $agent_list ?>" <?php echo ($agent_list==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('agent_list'); ?>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="agent-data" <?php echo $agentDis; ?> name="add_agent" value="<?php echo $add_agent ?>" <?php echo ($add_agent==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('add_agent'); ?>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="agent-data" <?php echo $agentDis; ?> name="edit_agent" value="<?php echo $edit_agent ?>" <?php echo ($edit_agent==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('edit_agent'); ?>
                        </label>
                     </div>
                  </div>
                  
               </div>
               <div class="box-body">
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="agent-data" <?php echo $agentDis; ?> name="agent_status" value="<?php echo $agent_status ?>" <?php echo ($agent_status==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('agent_status'); ?>
                        </label>
                     </div>
                  </div>
                  
                  
               </div>
               
                  <!-- Agent Permission End -->


                  <!-- Distributor Permission Start -->
            
            <div class="box-body">
               <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                           <b><?php echo $this->lang->line('distributor_permission'); ?> :</b>
                        </label>
                     </div>
               </div>
               
              <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" id="distributor-list" class="flat-red" name="distributor_list" value="<?php echo $distributor_list ?>" <?php echo ($distributor_list==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('distributor_list'); ?>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="distributor-data" <?php echo $distributorDis; ?> name="add_distributor" value="<?php echo $add_distributor ?>" <?php echo ($add_distributor==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('add_distributor'); ?>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="distributor-data" <?php echo $distributorDis; ?> name="edit_distributor" value="<?php echo $edit_distributor ?>" <?php echo ($edit_distributor==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('edit_distributor'); ?>
                        </label>
                     </div>
                  </div>
                  
               </div>
               <div class="box-body">
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="distributor-data" <?php echo $distributorDis; ?> name="distributor_status" value="<?php echo $distributor_status ?>" <?php echo ($distributor_status==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('distributor_status'); ?>
                        </label>
                     </div>
                  </div>
                  
                  
               </div>
               
                  <!-- Distributor Permission End -->

               <!--Transactions Permission Start -->
               <div class="box-body">
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                     <b><?php echo $this->lang->line('transactions_permission'); ?> :</b>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="flat-red" name="transactions_list" value="<?php echo $transactions_list ?>" <?php echo ($transactions_list==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('transactions_list'); ?>
                        </label>
                     </div>
                  </div>
               </div>
               <!--Transactions Permission End -->



               <!--Withdrawal Permission Start -->
               <div class="box-body">
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                     <b><?php echo $this->lang->line('Withdrawal_permission'); ?> :</b>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="flat-red" name="Withdrawal_list" value="<?php echo $Withdrawal_list ?>" <?php echo ($Withdrawal_list==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('Withdrawal_list'); ?>
                        </label>
                     </div>
                  </div>
               </div>
               <!--Withdrawal Permission End -->


               <!--Deposit Permission Start -->
               <div class="box-body">
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                     <b><?php echo $this->lang->line('deposit_permission'); ?> :</b>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="flat-red" name="deposit_list" value="<?php echo $deposit_list ?>" <?php echo ($deposit_list==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('deposit_list'); ?>
                        </label>
                     </div>
                  </div>
               </div>
               <!--Deposit Permission End -->


               <!--Send Money Permission Start -->
               <div class="box-body">
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                     <b><?php echo $this->lang->line('sendmoney_permission'); ?> :</b>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="flat-red" name="sendmoney_list" value="<?php echo $sendmoney_list ?>" <?php echo ($sendmoney_list==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('sendmoney_list'); ?>
                        </label>
                     </div>
                  </div>
               </div>
               <!--Send Money Permission End -->


                <!--Request Money Permission Start -->
               <div class="box-body">
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                     <b><?php echo $this->lang->line('requestmoney_permission'); ?> :</b>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="flat-red" name="requestmoney_list" value="<?php echo $requestmoney_list ?>" <?php echo ($requestmoney_list==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('requestmoney_list'); ?>
                        </label>
                     </div>
                  </div>
               </div>
               <!--Request Money Permission End -->

                <!--Sharebill Permission Start -->
               <div class="box-body">
               <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                     <b><?php echo $this->lang->line('sharebill_permission'); ?> :</b>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" id="sharebill-list" name="sharebill_list" value="<?php echo $sharebill_list ?>" <?php echo ($sharebill_list==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('sharebill_list'); ?>
                        </label>
                     </div>
                  </div>
                  
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="sharebill-data" name="sharebill_detail" <?php echo $sharebillDis; ?> value="<?php echo $sharebill_detail ?>" <?php echo ($sharebill_detail==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('sharebill_detail'); ?>
                        </label>
                     </div>
                  </div>
               </div>
               <!--Sharebill Permission End -->


                <!--Request Money Permission Start -->
               <div class="box-body">
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                     <b><?php echo $this->lang->line('qrcodes_permission'); ?> :</b>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="flat-red" name="qrcodes_list" value="<?php echo $qrcodes_list ?>" <?php echo ($qrcodes_list==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('qrcodes_list'); ?>
                        </label>
                     </div>
                  </div>
               </div>
               <!--Request Money Permission End -->
            

               <!-- Business Permission Start -->
               
               <div class="box-body">
					<div class="col-md-3">
                     <div class="checkbox">
                        <label>
						         <b><?php echo $this->lang->line('business_type_permission'); ?> :</b>
                        </label>
                     </div>
                  </div>
				   
				   
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" id="business-list" class="flat-red" name="business_list" value="<?php echo $business_list ?>" <?php echo ($business_list==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('business_list'); ?>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="business-data" <?php echo $businessDis; ?> name="add_business" value="<?php echo $add_business ?>" <?php echo ($add_business==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('add_business'); ?>
                        </label>
                     </div>
                  </div>
                  
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="business-data" <?php echo $businessDis; ?> name="edit_business" value="<?php echo $edit_business ?>" <?php echo ($edit_business==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('edit_business'); ?>
                        </label>
                     </div>
                  </div>
               </div>
                <div class="box-body">
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="business-data" <?php echo $businessDis; ?> name="business_status" value="<?php echo $business_status ?>" <?php echo ($business_status==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('business_status'); ?>
                        </label>
                     </div>
                  </div>
                  
                  
               </div>
               <!-- Business Permission End -->

               <!-- Category Permission Start -->
               
               <div class="box-body">
               <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <b><?php echo $this->lang->line('category_permission'); ?> :</b>
                        </label>
                     </div>
                  </div>
               
               
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" id="category-list" class="flat-red" name="category_list" value="<?php echo $category_list ?>" <?php echo ($category_list==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('category_list'); ?>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="category-data" <?php echo $categoryDis; ?> name="add_category" value="<?php echo $add_category ?>" <?php echo ($add_category==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('add_category'); ?>
                        </label>
                     </div>
                  </div>
                  
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="category-data" <?php echo $categoryDis; ?> name="edit_category" value="<?php echo $edit_category ?>" <?php echo ($edit_category==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('edit_category'); ?>
                        </label>
                     </div>
                  </div>
               </div>
                <div class="box-body">
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="category-data" <?php echo $categoryDis; ?> name="category_status" value="<?php echo $category_status ?>" <?php echo ($category_status==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('category_status'); ?>
                        </label>
                     </div>
                  </div>
                  
                  
               </div>
               <!-- Category Permission End -->

               	

                <!--Feedback Permission Start -->
               <div class="box-body">
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <b><?php echo $this->lang->line('feedback_permission'); ?> :</b>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="flat-red" name="feedback_list" value="<?php echo $feedback_list ?>" <?php echo ($feedback_list==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('feedback_list'); ?>
                        </label>
                     </div>
                  </div>
               </div>
               <!--Feedback Permission End -->


                <!--Request Permission Start -->
               <div class="box-body">
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <b><?php echo $this->lang->line('request_permission'); ?> :</b>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="flat-red" name="request_list" value="<?php echo $request_list ?>" <?php echo ($request_list==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('request_list'); ?>
                        </label>
                     </div>
                  </div>
               </div>
               <!--Request Permission End -->

               <!--Transactions Limit  Permission Start -->
               <div class="box-body">
				   <div class="col-md-3">
                     <div class="checkbox">
                        <label>
						      	<b><?php echo $this->lang->line('transactions_limit_permission'); ?> :</b>
                        </label>
                     </div>
                  </div>

                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                           <input type="checkbox" id="trans-limit" name="viewTrsLimit" value="<?php echo $viewTrsLimit ?>" <?php echo ($viewTrsLimit==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('view_limit_setting'); ?>
                        </label>
                     </div>
                  </div>

                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="view-limit" name="add_money" <?php echo $trsLimitDis; ?> value="<?php echo $add_money ?>" <?php echo ($add_money==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('add_money'); ?>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="view-limit" name="send_money" <?php echo $trsLimitDis; ?> value="<?php echo $send_money ?>" <?php echo ($send_money==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('send_money'); ?>
                        </label>
                     </div>
                  </div>
                  
               </div>
               
               <div class="box-body">
				   <div class="col-md-3">
                     <div class="checkbox">
                        <label>
							
                        </label>
                     </div>
                  </div>
                     
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="view-limit" name="withdrawal_money" <?php echo $trsLimitDis; ?> value="<?php echo $withdrawal_money ?>" <?php echo ($withdrawal_money==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('withdrawal_money'); ?>
                        </label>
                     </div>
                  </div>

                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="view-limit" name="cashout" <?php echo $trsLimitDis; ?> value="<?php echo $cashout ?>" <?php echo ($cashout==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('cashout'); ?>
                        </label>
                     </div>
                  </div>


               </div>
               
               <!--Transactions Limit Permission End -->


                <!--Faq  Permission Start -->
               <div class="box-body">
               <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                     <b><?php echo $this->lang->line('faq_permission'); ?> :</b>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="flat-red" id="faq-list" name="faq_list" value="<?php echo $faq_list ?>" <?php echo ($faq_list==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('faq_list'); ?>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="faq-data" <?php echo $faqDis; ?> name="faq_add" value="<?php echo $faq_add ?>" <?php echo ($faq_add==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('add_faq'); ?>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="faq-data" <?php echo $faqDis; ?> name="faq_edit" value="<?php echo $faq_edit ?>" <?php echo ($faq_edit==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('edit_faq'); ?>
                        </label>
                     </div>
                  </div>
                  
               </div>
               
               <div class="box-body">
               <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                     
                        </label>
                     </div>
                  </div>
                  
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="faq-data" <?php echo $faqDis; ?> name="faq_status" value="<?php echo $faq_status ?>" <?php echo ($faq_status==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('faq_status'); ?>
                        </label>
                     </div>
                  </div>

                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="faq-data" <?php echo $faqDis; ?> name="faq_delete" value="<?php echo $faq_delete ?>" <?php echo ($faq_delete==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('faq_delete'); ?>
                        </label>
                     </div>
                  </div>
               </div>
               <!--Faq Permission End -->

               <!--Virtual Faq Permission Start -->
               <div class="box-body">
               <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                     <b><?php echo $this->lang->line('virtual_faq_permission'); ?> :</b>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="flat-red" id="virtualfaq-list" name="virtual_faq_list" value="<?php echo $virtual_faq_list ?>" <?php echo ($virtual_faq_list==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('virtual_faq_list'); ?>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="virtualfaq-data" <?php echo $virtualfaqDis; ?> name="add_virtual_faq" value="<?php echo $add_virtual_faq ?>" <?php echo ($add_virtual_faq==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('add_virtual_faq'); ?>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="virtualfaq-data" <?php echo $virtualfaqDis; ?> name="edit_virtual_faq" value="<?php echo $edit_virtual_faq ?>" <?php echo ($edit_virtual_faq==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('edit_virtual_faq'); ?>
                        </label>
                     </div>
                  </div>
                  
               </div>
               
               <div class="box-body">
               <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                     
                        </label>
                     </div>
                  </div>
                  
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="virtualfaq-data" name="virtual_faq_status" <?php echo $virtualfaqDis; ?> value="<?php echo $virtual_faq_status ?>" <?php echo ($virtual_faq_status==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('virtual_faq_status'); ?>
                        </label>
                     </div>
                  </div>

                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="virtualfaq-data" name="virtual_faq_delete" <?php echo $virtualfaqDis; ?> value="<?php echo $virtual_faq_delete ?>" <?php echo ($virtual_faq_delete==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('virtual_faq_delete'); ?>
                        </label>
                     </div>
                  </div>
               </div>
               
               <!--Virtual Faq Permission End -->

                <!--Tutorial Splash Wallet Permission Start -->
               <div class="box-body">
               <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                     <b><?php echo $this->lang->line('tutorial_splash_wallet_permission'); ?> :</b>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="flat-red" id="tutorial-w-list" name="tutorialSplashWallet" value="<?php echo $tutorialSplashWallet ?>" <?php echo ($tutorialSplashWallet==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('tutorial_splash_wallet_list'); ?>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="tutorial-w-data" <?php echo $tutSplWalDis; ?> name="tutorialSplashWalletStatus" value="<?php echo $tutorialSplashWalletStatus ?>" <?php echo ($tutorialSplashWalletStatus==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('tutorial_splash_wallet_status'); ?>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="tutorial-w-data" <?php echo $tutSplWalDis; ?> name="tutorialSplashWalletDelete" value="<?php echo $tutorialSplashWalletDelete ?>" <?php echo ($tutorialSplashWalletDelete==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('tutorial_splash_wallet_delete'); ?>
                        </label>
                     </div>
                  </div>
                  
               </div>
               
               <div class="box-body">
               <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                     
                        </label>
                     </div>
                  </div>
                  
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="tutorial-w-data" <?php echo $tutSplWalDis; ?> name="tutorialSplashWalletMulDelete" value="<?php echo $tutorialSplashWalletMulDelete ?>" <?php echo ($tutorialSplashWalletMulDelete==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('tutorial_splash_wallet_multi_delete'); ?>
                        </label>
                     </div>
                  </div>
               </div>
               
               <!--Tutorial Splash Wallet Permission End -->




                <!--Tutorial Splash Master Permission Start -->
               <div class="box-body">
               <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                     <b><?php echo $this->lang->line('tutorial_splash_master_permission'); ?> :</b>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="flat-red" id="tutorial-m-list" name="tutorialSplashMaster" value="<?php echo $tutorialSplashMaster ?>" <?php echo ($tutorialSplashMaster==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('tutorial_splash_master_list'); ?>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="tutorial-m-data" <?php echo $tutSplMasDis; ?> name="tutorialSplashMasterStatus" value="<?php echo $tutorialSplashMasterStatus ?>" <?php echo ($tutorialSplashMasterStatus==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('tutorial_splash_master_status'); ?>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="tutorial-m-data" <?php echo $tutSplMasDis; ?> name="tutorialSplashMasterDelete" value="<?php echo $tutorialSplashMasterDelete ?>" <?php echo ($tutorialSplashMasterDelete==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('tutorial_splash_master_delete'); ?>
                        </label>
                     </div>
                  </div>
                  
               </div>
               
               <div class="box-body">
               <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                     
                        </label>
                     </div>
                  </div>
                  
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="tutorial-m-data" <?php echo $tutSplMasDis; ?> name="tutorialSplashMasterMulDelete" value="<?php echo $tutorialSplashMasterMulDelete ?>" <?php echo ($tutorialSplashMasterMulDelete==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('tutorial_splash_master_multi_delete'); ?>
                        </label>
                     </div>
                  </div>
               </div>
               
               <!--Tutorial Splash Master Permission End -->


                <!--Settings Permission Start -->
               <div class="box-body">
				   <div class="col-md-3">
                     <div class="checkbox">
                        <label>
							<b><?php echo $this->lang->line('add_tutorial_splash_permission'); ?> :</b>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="flat-red" name="addTutSpwalletMaster" value="<?php echo $addTutSpwalletMaster ?>" <?php echo ($addTutSpwalletMaster==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('add_tutorial_splash_wallet_master'); ?>
                        </label>
                     </div>
                  </div>
              </div>
                  <!--Settings Permission End -->


               <!--Settings Permission Start -->
               <div class="box-body">
				   <div class="col-md-3">
                     <div class="checkbox">
                        <label>
							<b><?php echo $this->lang->line('settings_permission'); ?> :</b>
                        </label>
                     </div>
                  </div>
                  <div class="col-md-3">
                  	<div class="checkbox">
                        <label>
                        <input type="checkbox" class="flat-red" name="web_setting" id="web-setting" value="<?php echo $web_setting ?>" <?php echo ($web_setting==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('web_setting'); ?>
                        </label>
                     </div>
                     
                     </div>
                     <div class="col-md-3">
                     <div class="checkbox">
                        <label>
                        <input type="checkbox" class="change-password" <?php //echo $settingDis; ?> name="change_password" value="<?php echo $change_password ?>" <?php echo ($change_password==1) ? 'checked' : ''; ?>>
                        <?php echo $this->lang->line('change_password'); ?></label>
                     </div>
                  </div>

                  <!--Settings Permission End --> 
               </div>
			      <div class="box-footer">
				     <button type="submit" class="btn btn-primary">Submit</button>
			      </div>
            </form>
         </div>
         <!-- /.box-body -->
      </div>
      <!-- /.box -->
   </div>
   <!--/.col (right) -->
</section>
<!-- /.content -->