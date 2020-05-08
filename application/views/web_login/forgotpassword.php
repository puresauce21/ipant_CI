<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Stac | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
     <link rel="icon" href="<?php echo base_url(); ?>assets_frontend/images/favicon_stac.png" type="image/x-icon">
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
<body class="hold-transition login-page" style="height: auto;">
  <?php
    $logo = getLogo();
    $logo=!empty($logo->option_value) ? $logo->option_value : "";
  ?>
<div class="login-box">
  <div class="login-logo" style="margin:28% auto;">
    <a href="#"><img src="<?php echo base_url('/uploads/logo_favicon/'.$logo); ?>" class="user-image" alt="Web Logo" ></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Forgot your password</p>
	 <?php echo $this->messages->getMessageFront(); ?>
	<form id="sign_in" class="my-form" action="<?php echo site_url('account/forgotpassword'); ?>" method="post" data-parsley-validate>
      <div class="form-group has-feedback">
        <input type="text" class="form-control check_no" name="mobile_number" maxlength="10" placeholder="Mobile Number" data-parsley-required-message="Mobile Number is required" required="">
        <span class="glyphicon glyphicon-earphone form-control-feedback"></span>
      </div>
      
      <div class="row">
        <!-- /.col -->
        <!-- <div class="col-xs-4">
          <button type="submit" class="btn btn-flat signinbtn">Submit</button>
        </div> -->
        <div class="col-xs-12">
          <button type="submit" class="btn btn-danger btn-block">Submit</button>
        </div>

        <div class="col-xs-8 text-right"><br>
          <a href="<?php echo base_url('account')?>"><label class="add-cursor">Back to Sign In</label></a>
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
  

//check staff code accept character
$(".check_no").keypress(function(e) {
    if (e.which != 8 && !(e.which >= 48 && e.which <= 57)) {
        return false;
    }
});

  
</script>
</body>
</html>
