<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>STAC</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo base_url()?>assets_frontend/css/style.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets_frontend/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets_frontend/css/stac.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets_frontend/css/media.css">
  <link rel="icon" href="<?php echo base_url()?>assets_frontend/images/favicon_stac.png" type="image/gif">
  <!-- <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet"> -->
  <link href="<?php echo base_url()?>assets_frontend/css/font.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url()?>assets_frontend/css/bootstrap-datetimepicker.css">
  <link href="<?php echo base_url()?>assets_frontend/css/parsley.css" rel="stylesheet">
</head>
<body>
  <div class="header-top-wrap"></div>
    <!--**************header starts here ************-->
          <!---========Mobile Navigation===--> 
  <div class="mobile_navigation">
    <div class="text-center  mobile-logo-wrap">
      <!-- <a class="navbar-brand mobile-logo" href="#">
        <img style="margin: 0 auto;left: -30px;position: absolute; right: 0;" src="images/bonga-logo.svg" alt="" class="logoimg">
      </a> -->
      <a class="navbar-brand mobile-logo text-left" href="<?php echo base_url(); ?>">
        <span><img src="<?php echo base_url()?>assets_frontend/images/stac-logo.png" alt="" class="logoimg" style="width: 14%;margin-top: -6px;"></span>
        <!-- <span style="padding-left:5px;">STAC-egPay</span> -->
        </a>
      <a href="#" class="login-mobile">Login</a>
    </div>
 
    <nav >
      <div class="burger js-menuToggle">
        <span class="burger-top"></span>
        <span class="burger-middle"></span>
        <span class="burger-bottom"></span>
       <p>Menu</p> 
      </div>
      <ul class="pushNav js-topPushNav">
        <li>
          <div class="openLevel js-openLevel hdg">FOR YOU &nbsp;&nbsp;&nbsp; ></div>
          <ul class="pushNav pushNav_level js-pushNavLevel">
            <li class="pushNav_level-label hdg"><b>Get started with Bongapay</b><br>
              <span>Signup for free </span>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>/web/sendmoney"><b>Send Money</b><br>
                <span>Transfer money without borders!</span>
              </a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>/web/requestmoney"><b>Request Money</b><br>
                <span>No waiting! Get instant pay for casual payments</span>
              </a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>/web/download"><b>Get Bongapay app</b><br>
                <span>Have your money on-the-go always</span>
              </a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>/web/receivemoney"><b>Receive Money</b><br>
                <span>Easy, secure and a faster way to receive money</span>
              </a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>/web/happyshopping"><b>Happy shopping with Bongapay</b><br>
                <span>Pay with on-tap on any store easy and fast</span>
              </a>
            </li>
            <li class="closeLevel js-closeLevel">X</li>
          </ul>
        </li>
        <li>
          <div class="openLevel js-openLevel hdg">FOR YOUR BUSINESS  &nbsp;&nbsp;&nbsp; ></div>
          <ul class="pushNav pushNav_level js-pushNavLevel">
            <li class="pushNav_level-label hdg"><b>Get started with Bongapay</b><br>
              <span>Discover what works for your business </span>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>/web/agent"><b>Become an agent</b><br>
                <span>Earn big by dispensing cash to users</span>
              </a>
            </li>
             <li>
              <a href="<?php echo base_url(); ?>/web/client"><b>Connect with your clients</b><br>
                <span>Chat and make free calls to your clients</span>
              </a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>/web/getpaid"><b>Get Paid</b><br>
                <span>Get hustle free payments from your clients </span>
              </a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>/web/accept_payment"><b>Accept online payments</b><br>
                <span>Get contactless payments anywhere to your wallet</span>
              </a>
            </li>
            <li>
              <a href="<?php echo base_url(); ?>/web/downloadbusiness"><b>Pay bills </b><br>
                <span>Make prompt payment to your recurring bills</span>
              </a>
            </li>
            <li class="closeLevel js-closeLevel">X</li>
          </ul>
        </li>
        <li><a href="#">SEND MONEY</a></li>
        <li><a href="<?php echo base_url(); ?>/web/setupcontent">SET-UP</a></li>
        <li><a href="<?php echo base_url(); ?>/web/help">HELP</a></li> 
        <li class="signup bottom-side-nav"><a href="<?php echo base_url(); ?>/web/signupnew">Sign Up</a></li>
        <li class="closeLevel js-closeLevelTop close-level-inner">X </li>
      </ul>
    </nav>
  </div>
        <!--==============Mobile Navigation=============-->

        <!--=============Desktop Navigation===============--> 
<header id="header" class="header-wrap desktop_navigation">
  <div>

    <nav class="navbar navbar-inverse header header-navwrap">
      <div class="container">
        <div class="navbar-header">
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo base_url(); ?>">
            <img src="<?php echo base_url()?>assets_frontend/images/stac-logo.png" width="40" alt="" class="logoimg">
          </a>
        </div>
    
        <div class="collapse navbar-collapse js-navbar-collapse">
          <ul class="nav navbar-nav mid">
            <li class="dropdown data-toggle1 mega-dropdown">
              <a href="#" class="dropdown-toggle test1" data-toggle="dropdown">FOR YOU <span class="caret"></span></a> 
              
              <ul class="dropdown-menu toggle1 mega-dropdown-menu">
             
                <li class="mega_menu">
                  <ul class="megamenu_li">
                    <li>
                      <a href="<?php echo base_url(); ?>/web/signupnew"><b>Get started with Bongapay</b><br>
                        <span>Signup for free </span>
                      </a>
                    </li>
                    <li>
                      <a href="<?php echo base_url(); ?>/web/sendmoney"><b>Send Money</b><br>
                        <span>Transfer money without borders!</span>
                      </a>
                    </li>
                    <li>
                      <a href="<?php echo base_url(); ?>/web/requestmoney"><b>Request Money</b><br>
                        <span>No waiting! Get instant pay for casual payments</span>
                      </a>
                    </li>
                    <a href="#" class="close_megamenu white-color">X</a>
                    <li>
                      <a href="<?php echo base_url(); ?>/web/download"><b>Get Bongapay app</b><br>
                        <span>Have your money on-the-go always</span>
                      </a>
                    </li>
                    <li>
                      <a href="<?php echo base_url(); ?>/web/receivemoney"><b>Receive Money</b><br>
                        <span>Easy, secure and a faster way to receive money</span>
                      </a>
                    </li>
                    <li>
                      <a href="<?php echo base_url(); ?>/web/happyshopping"><b>Happy shopping with Bongapay</b><br>
                        <span>Pay with on-tap on any store easy and fast</span>
                      </a>
                    </li>
                  
                  </ul>
                </li>
              </ul>       
            </li>
            <li class="dropdown data-toggle2 mega-dropdown">
             <a href="#" class="dropdown-toggle" data-toggle="dropdown">FOR YOUR BUSINESS <span class="caret"></span></a> 
              <div class="dropdown-menu-wrap">
                 <ul class="dropdown-menu toggle2 mega-dropdown-menu">
             
                <li class="mega_menu">
                  <ul class="megamenu_li">
                    <li>
                      <a href="<?php echo base_url(); ?>/web/signupnew"><b>Get started with Bongapay</b><br>
                        <span>Discover what works for your business </span>
                      </a>
                    </li>
                     <li>
                      <a href="<?php echo base_url(); ?>/web/agent"><b>Become an agent</b><br>
                        <span>Earn big by dispensing cash to users</span>
                      </a>
                    </li>
                     <li>
                      <a href="<?php echo base_url(); ?>/web/client"><b>Connect with your clients</b><br>
                        <span>Chat and make free calls to your clients</span>
                      </a>
                    </li>
                     <a href="#" class="close_megamenu white-color">X</a>
                    <li>
                      <a href="<?php echo base_url(); ?>/web/getpaid"><b>Get Paid</b><br>
                        <span>Get hustle free payments from your clients </span>
                      </a>
                    </li>
                    <li>
                      <a href="<?php echo base_url(); ?>/web/accept_payment"><b>Accept online payments</b><br>
                        <span>Get contactless payments anywhere to your wallet</span>
                      </a>
                    </li>
                    <li>
                      <a href="<?php echo base_url(); ?>/web/downloadbusiness"><b>Pay bills </b><br>
                        <span>Make prompt payment to your recurring bills</span>
                      </a>
                    </li>
                  
                  </ul>
                </li>
              </ul> 
              </div> 
                   
                   
            </li>
            <li><a href="<?php echo base_url(); ?>/web/sendmoney">SEND MONEY</a></li>
            <li><a href="<?php echo base_url(); ?>/web/setupcontent">SET-UP</a></li>
            <li><a href="<?php echo base_url(); ?>/web/help">HELP</a></li>
          </ul>
              <ul class="nav navbar-nav navbar-right">
                <li class="signup"><a href="<?php echo base_url(); ?>/web/signupnew">Sign Up</a></li>
                <li class="signup"><a href="#">Login</a></li>
              </ul>
        </div>
      </div>
    </nav>
  </div>
</header>
              <!--==========Desktop Navigation=============--> 

          <!--**************header ends here ************-->
	