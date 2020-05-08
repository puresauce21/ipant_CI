<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bizxpay</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/css/wow_animate.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/css/icons.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/css/swiper_min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/css/style.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/css/custom_style.css">
  <link rel="stylesheet" href="<?php echo base_url()?>assets/css/responsive.css">
  <link rel="icon" type="image/x-icon" href="<?php echo base_url()?>assets/images/biz_favicon.png">
</head>

<body data-spy="scroll" data-target=".navbar">
<!-- Header -->
  <header class="header">
    <nav class="navbar navbar-expand-lg fixed-top" id="main-nav">
      <div class="container">

        <a class="navbar-brand" href="<?php echo base_url()?>">
          <img src="<?php echo base_url()?>assets/images/logo.png" class="img-responsive" alt="Bizxpay">
        </a>
        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#main-nav-collapse" aria-controls="main-nav-collapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="menu-toggle">
            <span class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </span>
            <span class="hamburger-cross">
                <span></span> 
                <span></span>
            </span>
          </span>
        </button>
        <div class="collapse navbar-collapse order-3 order-lg-2" id="main-nav-collapse">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item"> 
              <a class="nav-link nav-link-scroll" href="#banner">Home</a>
            </li>
            <li class="nav-item">  
              <a class="nav-link nav-link-scroll" href="#feature">Features</a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-scroll" href="#service">Our Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-scroll" href="#about">About us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-scroll" href="#download">Download</a>
            </li> 
            <li class="nav-item">
              <a class="nav-link nav-link-scroll" href="#contact">Contact us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-scroll" href="#" data-toggle="modal" data-target="#exampleModal">Log In / Sign Up</a>
            </li>
          </ul>
        </div>
        
      </div>
    </nav>
  </header>
<!-- Header Ends Here -->



<!-- Button trigger modal -->

<!-- Modal -->
<div id="modal" class="popupContainer" style="display:none;">
        <header class="popupHeader">
            <span class="header_title">Login</span>
            <span class="modal_close"><i class="fa fa-times"></i></span>
        </header>

        <section class="popupBody">
            <!-- Social Login -->
            <div class="social_login">
                <div class="">
                    <a href="#" class="social_box fb">
                        <span class="icon"><i class="fa fa-facebook"></i></span>
                        <span class="icon_title">Connect with Facebook</span>

                    </a>

                    <a href="#" class="social_box google">
                        <span class="icon"><i class="fa fa-google-plus"></i></span>
                        <span class="icon_title">Connect with Google</span>
                    </a>
                </div>

                <div class="centeredText">
                    <span>Or use your Email address</span>
                </div>

                <div class="action_btns">
                    <div class="one_half"><a href="#" id="login_form" class="btn">Login</a></div>
                    <div class="one_half last"><a href="#" id="register_form" class="btn">Sign up</a></div>
                </div>
            </div>

            <!-- Username & Password Login form -->
            <div class="user_login">
                <form>
                    <label>Email / Username</label>
                    <input type="text" />
                    <br />

                    <label>Password</label>
                    <input type="password" />
                    <br />

                    <div class="checkbox">
                        <input id="remember" type="checkbox" />
                        <label for="remember">Remember me on this computer</label>
                    </div>

                    <div class="action_btns">
                        <div class="one_half"><a href="#" class="btn back_btn"><i class="fa fa-angle-double-left"></i> Back</a></div>
                        <div class="one_half last"><a href="#" class="btn btn_red">Login</a></div>
                    </div>
                </form>

                <a href="#" class="forgot_password">Forgot password?</a>
            </div>

            <!-- Register Form -->
            <div class="user_register">
                <form>
                    <label>Full Name</label>
                    <input type="text" />
                    <br />

                    <label>Email Address</label>
                    <input type="email" />
                    <br />

                    <label>Password</label>
                    <input type="password" />
                    <br />

                    <div class="checkbox">
                        <input id="send_updates" type="checkbox" />
                        <label for="send_updates">Send me occasional email updates</label>
                    </div>

                    <div class="action_btns">
                        <div class="one_half"><a href="#" class="btn back_btn"><i class="fa fa-angle-double-left"></i> Back</a></div>
                        <div class="one_half last"><a href="#" class="btn btn_red">Register</a></div>
                    </div>
                </form>
            </div>
        </section>
    </div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <!-- <h5 class="modal-title" id="exampleModalLabel"> </h5> -->
          <div class="tabs-center">
              <!-- Nav tabs -->
              <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" href="#profile" role="tab" data-toggle="tab">Log In</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#buzz" role="tab" data-toggle="tab">Sign Up</a>
                </li>
              </ul>
          </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Tab panes -->
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane fade in active" id="profile">
            <form>
              <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
              </div>
              <div class="text-center"> <a href="#" class="forgot_password" data-toggle="modal" data-target="#exampleModal1">Forgot password?</a></div>
              <div class="text-center"> <button type="submit" class="btn btn-primary mt-3">Log In</button></div>
            </form>
          </div>

          <div role="tabpanel" class="tab-pane fade" id="buzz">
            <form>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="formGroupExampleInput">First name</label>
                    <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Enter first name" required="">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="formGroupExampleInput">Last name</label>
                    <input type="text" class="form-control" id="formGroupExampleInput" placeholder="Enter last name" required="">
                  </div>
                </div>  
              </div>                 
              
              <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required="">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required="">
              </div>
              <div class="text-center"> <button type="submit" class="btn btn-primary mt-3">Sign Up</button></div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->

<!-- Modal forget padd -->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Forgot password?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required="">
        </div>
        <div class="text-center"> <button type="submit" class="btn btn-primary mt-3">Submit</button></div>

      </div>

    </div>
  </div>
</div>


