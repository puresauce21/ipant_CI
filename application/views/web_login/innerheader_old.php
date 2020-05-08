<!DOCTYPE html>
<html lang="en">
<head>
  <title>STAC</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="<?php echo base_url()?>assets_frontend/css/bootstrap.min.css">
 <link rel="stylesheet" href="<?php echo base_url()?>assets_frontend/css/dashboard.css">
 <link rel="stylesheet" href="<?php echo base_url()?>assets_frontend/css/media.css">
 <link rel="icon" href="<?php echo base_url()?>assets_frontend/images/favicon_stac.png" type="image/gif">
 
 <link href="<?php echo base_url()?>assets_frontend/css/font.css" rel="stylesheet">
 <link rel="stylesheet" href="<?php echo base_url()?>assets_frontend/css/bootstrap-datetimepicker.css">



<link href="https://bongapay.co.ke/account/assets/css/font-awesome.min.css" rel="stylesheet" type="text/css" />




<link href="https://bongapay.co.ke/account/assets/css/components-rounded.min.css" rel="stylesheet" id="style_components" type="text/css" />
<link href="https://bongapay.co.ke/account/assets/css/plugins.min.css" rel="stylesheet" type="text/css" />
<link href="https://bongapay.co.ke/account/assets/css/layout.min.css" rel="stylesheet" type="text/css" />
<link href="https://bongapay.co.ke/account/assets/css/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
<link href="https://bongapay.co.ke/account/assets/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
<link href="https://bongapay.co.ke/account/assets/css/bootstrap-toggle.min.css" rel="stylesheet">


<link rel="stylesheet" href="https://bongapay.co.ke//account/assets/css/bongapay.css">
<link href="https://bongapay.co.ke/account/assets/css/new-style.css" rel="stylesheet">

 <link rel="stylesheet" href="<?php echo base_url()?>assets_frontend/css/stac.css">




</head>
<body>
	<!-- BEGIN HEADER -->
<div class="page-header">
  <nav class="navbar navbar-inverse header active-head">
      <div class="container header_top sectionbg">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>                        
        	</button>
       		<a class="navbar-brand mobile-logo text-left" href="<?php echo base_url(); ?>">
        <span><img src="<?php echo base_url()?>assets_frontend/images/stac-logo.png" alt="" class="logoimg" style="width: 14%;margin-top: -6px;"></span>
        <!-- <span style="padding-left:5px;">STAC-egPay</span> -->
        </a>
    		</div>
    		<div class="collapse navbar-collapse" id="myNavbar">
      <div class="headerdrop">
        <ul class="nav navbar-nav headersecondpart">
            <li><a href="/Dashboard"> Dashboard</a></li>
            <li><a href="/SendMoney"> Send Money</a></li>
            <li><a href="/RequestMoney"> Request Money</a></li>
            <li><a href="/AddMoney"> Add Money</a></li>
            <li><a href="/WithdrawMoney"> Withdraw Money</a></li>
            <li><a href="/ShareBill"> Share bill </a></li>
            <li><a href="/PayBill"> PayBill</a></li>
        </ul>

        <ul class="nav navbar-nav pull-right right-dropdown">

            
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell fa-2x"></i>
                    <span class="badge bg-red">0</span>
                </a>
                <ul class="dropdown-menu header-notification-menu" style="max-height: 300px; overflow-y: scroll;">
                    <li class="col-md-12">
                        <div class="col-md-8" style="padding-left:0;">
                            <h3>You have <strong>0 notifications</strong> </h3>
                        </div>
                        <div class="col-md-4">
                            <a href="/notificationDetails" class="text-center view_all">View all</a>
                        </div>
                    </li>

                                            </ul>
            </li>

            <li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img alt="" width"50" class="img-circle" src="https://bongapay.co.ke//propic/5b5a2c347e772.png">
                    <span class="username username-hide-mobile">EMMANUEL <i class="fa fa-angle-down"></i></span>
              </a>
              <ul class="dropdown-menu">
                <li>
                    <a href="/AccountSetting">
                        <i class="fa fa-user" style="color: #01A9DB;"></i> My Account 
                    </a>
                </li>
                <li>
                    <a href="/Chat">
                        <i class="fa fa-user" style="color: #01A9DB;"></i> Chat 
                    </a>
                </li>

                <li>
                    <a href="/ManageCards">
                        <i class="fa fa-credit-card" style="color: #01A9DB;"></i> Manage Cards 
                    </a>
                </li>

                <li>
                    <a href="/ManageBanks">
                        <i class="fa fa-building" style="color: #01A9DB;"></i> Manage Banks 
                    </a>
                </li>

                <li>
                    <a href="/SetPin">
                        <i class="fa fa-cog" style="color: #01A9DB;"></i> Set Transaction Pin 
                    </a>
                </li>

                <li>
                    <a href="/ChangePassword">
                        <i class="fa fa-cog" style="color: #01A9DB;"></i> Change Password 
                    </a>
                </li>

                <li class="divider"> </li>

                <li>
                    <a href="/signout">
                        <i class="fa fa-sign-out" style="color: #01A9DB;"></i> Log Out 
                    </a>
                </li>
              </ul>
            </li>
        </ul>
    	</div>
				</div>
			</div>
	</nav>
</div>
<!-- END HEADER -->