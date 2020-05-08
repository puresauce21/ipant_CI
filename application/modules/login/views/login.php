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
  <link rel="stylesheet" href="<?php echo base_url('templates/admin'); ?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('templates/admin'); ?>/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('templates/admin'); ?>/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('templates/admin'); ?>/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url('templates/admin'); ?>/plugins/iCheck/square/blue.css">
  <link href="<?php echo base_url('templates'); ?>/css/parsley.css" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url('templates'); ?>/css/style.css" rel="stylesheet" type="text/css" />

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
  <!-- <img src="https://bizxpay.consagous.co.in/uploads/user/bg-img-1.png" class="show_menu_img" height="auto" width="100%" style="position: relative;"> -->
  <?php
    $logo = getLogo();
    $logo=!empty($logo->option_value) ? $logo->option_value : "";
  ?>
  <div class="login_back_img">
    <div class="inner_box">
      <div class="wrap_form">
  <div class="login-logo">
   <!--  <a href="#"><img src="<?php echo base_url('/uploads/logo_favicon/'.$logo); ?>" class="user-image" alt="Web Logo" ></a> -->
    <a href="#"><img src="<?php echo base_url('/uploads/logo_favicon/ipant-Logo-white.png'); ?>" class="user-image" alt="Web Logo" ></a>



  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <?php echo $this->messages->getMessageFront(); ?>
    <form id="sign_in" class="my-form" action="<?php echo site_url('login/loginAuth'); ?>" method="post" data-parsley-validate>
      <div class="form-group has-feedback">
        <input type="email" class="form-control" name="email" placeholder="Email" value="<?php if(isset($_COOKIE['email'])){ echo $_COOKIE['email'];} ?>" data-parsley-required-message="Email is required" required="">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="Password" value="<?php if(isset($_COOKIE['password'])){ echo $_COOKIE['password'];} ?>" data-parsley-required-message="Password is required" required="">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group row">
        <div class="col-xs-6">
          <div class="checkbox icheck">
            <label>
            	<input type="checkbox" style="top: -2px;" name="keep_me" value="keep_me"<?php if(isset($_COOKIE['password'])){ ?> checked  <?php } ?> id="rememberme" class="filled-in chk-col-pink"> Remember Me </label>
         </div>
        </div>

        <!-- <div class="col-xs-6">
          <div class="">
            <a href="<?php echo base_url('login/forgotpassword'); ?>"><label class="add-cursor">Forgot Password</label></a>
         </div>
        </div> -->

        <!-- /.col -->
      </div>
      

      <div class="row">
        <div class="col-xs-12">
          <button type="submit" name="signin" class="btn btn-block" style="text-align: center; background: linear-gradient(40deg, #8CC443 10%, #0B5169 80%); color: #fff;">Sign In</button>
        </div>
        <div class="col-xs-8 text-right">
          <a href="<?php echo base_url('login/forgotpassword'); ?>"><label class="add-cursor" style="color: #0B5169; text-align: center;">Forgot Password</label></a>
        </div>
        <!-- /.col -->
      </div>
    </form>

<!--
    <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div>
-->
    <!-- /.social-auth-links -->

    <!-- <a href="#">I forgot my password</a><br>
    <a href="register.html" class="text-center">Register a new membership</a> -->

  </div>
  <!-- /.login-box-body -->
</div>
    </div>

<!-- /.login-box -->
</div>


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
</script>
</body>
</html>
