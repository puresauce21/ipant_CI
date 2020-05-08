<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>iPant | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" href="<?php echo base_url(); ?>assets_frontend/images/favicon.png" type="image/x-icon">
  <!-- Bootstrap 3.3.7 -->
   
  <link href="<?php echo base_url('templates/admin'); ?>/css/bootstrap/bootstrap.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url('templates/admin'); ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('templates/admin'); ?>/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('templates/admin'); ?>/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('templates/admin'); ?>/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url('templates/admin'); ?>/plugins/iCheck/square/blue.css">
<!-- Google Font -->
<link href="<?php echo base_url('templates'); ?>/css/parsley.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url('templates'); ?>/css/style.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
  <img src="https://ipant.consagous.co.in/uploads/user/BG-login-ipant.png" class="show_menu_img" height="auto" width="100%" style="position: relative;">
  <?php
    $logo = getLogo();
    $logo=!empty($logo->option_value) ? $logo->option_value : "";
  ?>
<div class="login-box" style="position: absolute; top: 13%; right: 41%;">
  <div class="login-logo">
    <a href="#"><img src="<?php echo base_url('/uploads/logo_favicon/ipant-Logo-white.png'); ?>" class="user-image" alt="Web Logo" ></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Forgot your password</p>
	 <?php echo $this->messages->getMessageFront(); ?>
	<form id="sign_in" class="my-form" action="<?php echo site_url('login/forgotpassword'); ?>" method="post" data-parsley-validate>
      <div class="form-group has-feedback">
        <input type="email" class="form-control" name="email" placeholder="Email" data-parsley-required-message="Email is required" required="">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      
      <div class="row">
        <!-- /.col -->
        <!-- <div class="col-xs-4">
          <button type="submit" class="btn btn-flat signinbtn">Submit</button>
        </div> -->
        <div class="col-xs-12">
          <button type="submit" class="btn btn-block" style="background: linear-gradient(40deg, #8CC443 10%, #0B5169 80%); color: #fff;">Submit</button>
        </div>

        <div class="col-xs-8 text-right">
          <a href="<?php echo base_url('login')?>"><label class="add-cursor">Back to Sign In</label></a>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <!-- /.social-auth-links -->

    
    
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo base_url('templates/admin'); ?>/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('templates/admin'); ?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url('templates/admin'); ?>/plugins/iCheck/icheck.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('templates'); ?>/js/parsley.js"></script>


<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
  
$(document).ready(function(){
	setTimeout(function() {
	   // Do something after 2 seconds
	   $('#messages').hide();
	 }, 2000);
});

  
</script>
</body>
</html>
