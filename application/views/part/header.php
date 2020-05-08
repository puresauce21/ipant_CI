<!DOCTYPE html>
<html>
<?php  $this->load->view('part/head'); ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <?php

      $logo = getLogo();
      $logo=!empty($logo->option_value) ? $logo->option_value : "";
      $favicon = getFavicon();
      $favicon=!empty($favicon->option_value) ? $favicon->option_value : "";
      
      
      $userdetails = getuserdetails();

      $first_name=!empty($userdetails['firstname']) ? $userdetails['firstname'] : "";
      $last_name=!empty($userdetails['lastname']) ? $userdetails['lastname'] : "";
      $email=!empty($userdetails['email']) ? $userdetails['email'] : "";
      $profile_pic=!empty($userdetails['profile_pic']) ? $userdetails['profile_pic'] : "";
      
      //$image = !empty($recordData->campaign_image) ? $recordData->campaign_image : '';
      //$actionContent .='<img src="'.getImage($image,"campaign").'" class="show_menu_img" height="40" width="40"/>'; 
    ?>
    <a href="<?php echo base_url('admin/dashboard'); ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">
         <img src="<?php echo base_url('/uploads/logo_favicon/'.$favicon); ?>" class="user-image" alt="Logo" > 
         <!-- <img src="<?php echo base_url('assets_frontend/images/logo_icn.png'); ?>" class="user-image" alt="Logo" > --> 
      </span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">
       <!--  <img src="<?php echo base_url('/uploads/logo_favicon/ipant-Logo-white.png'); ?>" class="user-image" alt="Admin Logo" style="background-color: #c00040;"> -->
       
        <img src="<?php echo base_url('/uploads/logo_favicon/'.$logo); ?>" class="user-image" alt="Admin Logo" style="background-color: #c00040;">
        <!-- <img src="<?php echo base_url('assets/images/admin_logo_big.png'); ?>" class="user-image" alt="Admin Logo 2"> -->
      </span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
        <div class="pull-left">     
          <p class="headingname"><?php echo headerTitle(); ?></p>
        </div>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">

              <img src="<?php echo base_url('uploads/admin_profile/'). $profile_pic ?>" class="user-image" alt="User Image"> 
              <span class="hidden-xs"><?php echo $first_name." ".$last_name; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo getImage($profile_pic,"admin_profile"); //base_url('uploads/admin_profile/'). $profile_pic ?>" class="img-circle" alt="User Image">

                <!-- <p> -->
					       <?php //echo $first_name." ".$last_name; ?>
                <!-- </p> -->
                <p><?php echo $email;?></p>
              </li>
              <!-- Menu Body -->

              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo base_url('admin/profile'); ?>" class="btn btn-default btn-flat"><?php echo $this->lang->line('profile'); ?></a>
                </div>
                <div class="pull-right">
      					<a data-toggle="modal" data-target="#SignOutModal" href="javascript:void(0);" class="btn btn-default">
      						<i class="fa fa-fw fa-sign-in"></i> <?php echo $this->lang->line('sign_out'); ?>
      					</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          
        </ul>
      </div>
    </nav>
  </header>
  <div id="SignOutModal" class="modal fade modal_signout" role="dialog">
	<div class="modal-dialog">
	<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><?php echo $this->lang->line('alert'); ?></h4>
			</div>
			<div class="modal-body">
				<p><?php echo $this->lang->line('are_your_want_to_sign_out'); ?></p> 
			</div>
			<div class="modal-footer">
				<a href="<?php echo base_url('admin/dashboard/logout'); ?>"  class='btn btn-default signout' style="background-color: #0B5169;color: #ffffff;"> <?php echo $this->lang->line('sign_out'); ?>  </a>
				
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('cancel'); ?></button>
			</div>
		</div>
	</div>
</div>
<style type="text/css">
 .signout:hover{
    background-color: #8cc443 !important;
} 
  
  
</style>
