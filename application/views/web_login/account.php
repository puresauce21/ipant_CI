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
  <link href="<?php echo base_url('templates'); ?>/css/new-style.css" rel="stylesheet" type="text/css" />

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
  <?php
    $logo = getLogo();
    $logo=!empty($logo->option_value) ? $logo->option_value : "";
  ?>


<?php /* ?>


<div class="login-box">
  <div class="login-logo">
    <a href="#"><img src="<?php echo base_url('/uploads/logo_favicon/'.$logo); ?>" class="user-image" alt="Web Logo" ></a>



  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">LOGIN TO YOUR ACCOUNT</p>

    <form id="sign_in" class="my-form" action="<?php echo site_url('account/loginAuth'); ?>" method="post" data-parsley-validate>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" name="email" placeholder="Email/Mobile" value="<?php //if(isset($_COOKIE['email'])){ echo $_COOKIE['email'];} ?>" data-parsley-required-message="Email Id/Mobile No is required" required="">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" placeholder="Password" value="<?php //if(isset($_COOKIE['password'])){ echo $_COOKIE['password'];} ?>" data-parsley-required-message="Password is required" required="">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group row">
        <!-- <div class="col-xs-6">
          <div class="checkbox icheck">
          	<label><input type="checkbox" name="keep_me" value="keep_me"<?php if(isset($_COOKIE['password'])){ ?> checked  <?php } ?> id="rememberme" class="filled-in chk-col-pink"> Remember Me </label>
         </div>
        </div> -->

        <!-- <div class="col-xs-6">
          <div class="">
            <a href="<?php echo base_url('login/forgotpassword'); ?>"><label class="add-cursor">Forgot Password</label></a>
         </div>
        </div> -->

        <!-- /.col -->
      </div>
      

      <div class="row">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-danger btn-block">Sign In</button>
        </div>
        <!-- <div class="col-xs-8 text-right">
          <a href="<?php echo base_url('login/forgotpassword'); ?>"><label class="add-cursor">Forgot Password</label></a>
        </div> -->
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
<!-- /.login-box -->


<?php */ ?>


<div class="login-box">
  <div class="login-logo">
    <a href="#"><img src="<?php echo base_url('/uploads/logo_favicon/'.$logo); ?>" class="user-image" alt="Web Logo" ></a>
  </div>
</div>


<!--**********login page starts here ************-->
<div class="page-content padd-0">
  <div class="container">
    <div class="page-content-inner center-form">
      <div class="row margin-auto">
    <div class="">
      <div class="">

        <div class="portlet-body padding-0">
          <div class="col-md-12 col-sm-12">
            <div class="boxshadow innerform clearfix">
              <div class="col-md-7">
                <form id="sign_in" class="my-form" action="<?php echo site_url('account/loginAuth'); ?>" method="post" data-parsley-validate>
               <!--  <form id="login-form" name="login-form" class=" login-form form-wrap nobottommargin form-horizontal" action="#" method="post" role="form" novalidate="novalidate"> -->
                  <h4 class="form-title uppercase font-600">LOGIN TO YOUR ACCOUNT</h4>
                  <?php echo $this->messages->getMessageFront(); ?>
                  <div class="label_input">
                    <label>Mobile Number <span class="colorred">*</span></label>
                    <div style="margin-bottom: 25px" class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>

     <input type="text" class="form-control" name="email" placeholder="Email/Mobile" value="<?php //if(isset($_COOKIE['email'])){ echo $_COOKIE['email'];} ?>" data-parsley-required-message="Email Id/Mobile No is required" required="">


                      <!-- <input id="login-username" type="text" class="form-control input-lg loginuser" name="username" value="" minlength="10" maxlength="10" pattern="[0-9]{1,}" placeholder="Enter 10 digit mobile number"> -->
                    </div> 
                  </div>
                  <div class="label_input">
                    <label>Password <span class="colorred">*</span></label>
                    <div style="margin-bottom: 25px" class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>

     <input type="password" class="form-control" name="password" placeholder="Password" value="<?php //if(isset($_COOKIE['password'])){ echo $_COOKIE['password'];} ?>" data-parsley-required-message="Password is required" required="">
     

                   <!--  <input name="password" id="password" class="form-control input-lg loginpass" type="password" required="" placeholder="Password">   -->      
                    </div> 
                  </div>
                  <div class="input-group col-md-12">
                  <div class="">
                    <label class="">
                      <input id="login-remember" type="checkbox" name="remember" value="1" data-parsley-multiple="remember"> 
                      <span class="">Remember me?</span>
                    </label>
                  </div>
                  </div>
                  <div class="controls form-actions clearfix loginborder">
                    <div id="working"></div>
                    <div class="btnlog col-md-6 col-sm-6 col-xs-6 padding-0 form-group loginsignup-submit">

    <button type="submit" class="btn login-btn uppercase btnlogin font-normal">Sign In</button>

                    <!--   <input type="submit" class="btn login-btn uppercase btnlogin font-normal" id="btn-login" name="login-form-submit" value="Login"> -->
                    </div>
                    <div class="col-md-6  col-sm-6 col-xs-6 padding-0 text-right uppercase font-14">
                      <a href="<?php echo base_url('account/register');?>" class="signupregister color-black">Create new Account</a>
                    </div>

                    <div class="col-md-6  col-sm-6 col-xs-6 padding-0 text-right uppercase font-14 margin-t-10">
                      <a href="<?php echo base_url('web/account');?>" class="signupregister color-black">Skip</a>
                    </div>

                  </div>
                  <div class="col-md-12 padding-0">
                    <div class="dontknowpass font-15">
                      <a href="<?php echo base_url('account/forgotpassword');?>" class="">Don't know your password?</a>
                    </div>
                  </div>
                </form>
              </div>
              <div class="col-md-5">
                <div class="rightcontent">
                  <div class="heading">
                    <h4 class="font-600">Keep your account Secure</h4>
                  </div>
                  <div class="right_icontxt">
                    <ul class="rightlogin list-unstyled">
                      <li>
                        <h5>Password Safety</h5>
                        <p>Do not share your password or have it stored on a browser by default unless necessary.</p> 
                      </li>
                      <li>
                        <h5>Always Logout</h5>
                        <p>Once done, always logout so that no one gains access to your account without your knowledge.</p> 
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div id="error" style="width: 420px;margin: 0 auto;"></div>
          </div>
        </div>
      </div>
    </div>
      </div>
    </div>
  </div>
</div>
<!--**********login page ends here ************-->

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
<style type="text/css">
  .parsley-errors-list.filled {bottom:-17px;}
  html, body {height:auto;}

</style>