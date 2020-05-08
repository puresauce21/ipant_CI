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
                                    <form id="sign_in" class="my-form" action="<?php echo site_url('account/register'); ?>" method="post"  data-parsley-validate>
                                       <!--  <form id="login-form" name="login-form" class=" login-form form-wrap nobottommargin form-horizontal" action="#" method="post" role="form" novalidate="novalidate"> -->
                                       <h4 class="form-title uppercase font-600">Register a new membership</h4>
                                       <?php echo $this->messages->getMessageFront(); ?>
                                       <div class="label_input">
                                          <label>Mobile Number <span class="colorred">*</span></label>
                                          <div style="margin-bottom: 25px;display: flex;" class="input-group">
                                             <!-- <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span> -->
                                            <div class="col-md-3" style="padding-right: 0;padding-left: 0;">
                                              <select id="country-code" name="country_code" class="form-control" required="" onchange="changeTab()"> 
                                              <option value="">Select</option>
                                              <?php
                                                if(!empty($countries_code)){
                                                  foreach($countries_code as $code){ 
                                              ?>
                                                  <option value="<?php echo $code->id; ?>" <?php echo (set_value('country_code', isset($country_code) ? $country_code : '')==$code->id) ? 'selected="selected"':'';?>><?php echo $code->code; ?></option>

                                              <?php
                                                  }
                                                }
                                              ?>
                                              </select>
                                            </div>
                                            <div class="col-md-9 leftpadding">
                                              <input type="text" class="form-control mobileExist check_no" <?php if(!empty($mobile_no)){ echo "readonly"; } ?>  id="mobile-number" style="" name="mobile_number" placeholder="Enter 10 digit mobile number" value="<?php echo (isset($mobile_no)) ? $mobile_no : ""; ?>" data-parsley-required-message="Mobile No is required" maxlength="10" required="">
                                            </div>
                                          </div>
                                          <div style="color: red" id="mobError" class="mobErrorr"></div>
                                          <div style="color: green" id="mobSucc" class="mobSucc"></div>
                                       </div>


                                       <div class="label_input otp-text" <?php if(empty($country_code)) {?>  style="display: none;" <?php } ?>>
                                          <label>OTP <span class="colorred">*</span></label>
                                          <div style="margin-bottom: 25px" class="input-group">
                                             <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                             <input type="text" class="form-control" name="otp" placeholder="Otp" data-parsley-required-message="OTP is required" required="">
                                          </div>
                                       </div>

                                          
                                       <div class="controls form-actions clearfix loginborder">
                                          <div id="working"></div>
                                          <div class="btnlog col-md-6 col-sm-6 col-xs-6 padding-0 form-group loginsignup-submit">
                                             <button type="submit" class="btn login-btn uppercase btnlogin font-normal">Next</button>
                                          </div>
                                          

                                          <div class="col-md-6  col-sm-6 col-xs-6 padding-0 text-right uppercase font-14">
                                            <a href="<?php echo base_url('web/account');?>" class="signupregister color-black">Skip</a>
                                          </div>

                                       </div>



                                      <div class="col-md-12 padding-0">
                                        <div class="dontknowpass font-15">
                                          <a href="<?php echo base_url('account');?>" class="">Already registered, Please login</a>
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

       function changeTab(){
          $("#mobile-number").focus();  
        }


    $('.mobileExist').blur(function(){
        var mobile_number = $(this).val();
        
        var countrycode = $("#country-code").val();

        if ((mobile_number!="") && (countrycode!="")) {

         var url = '<?php echo base_url('account/checkMobileExist');?>';
         var formData    = {
             'mobile_number':mobile_number
             };
            $.ajax({
                type: 'POST',
                url: url,
                dataType: 'json',
                async: false,
                data: formData,  
                success: function(data) {
                  if(data.isSuccess==true){
                    $('.otp-text').css('display','block');
                    $(".mobileExist").prop("readonly", true);
                    $("#mobError").html('');
                    $("#mobSucc").html(data.message);
                  }else{
                    $("#mobError").html(data.message);
                  }
                },
            });   
        }
    });

    $(".check_no").keypress(function(e) {
        if (e.which != 8 && !(e.which >= 48 && e.which <= 57)) {
            return false;
        }
    });
  
    </script>


   </body>
</html>
<style type="text/css">
  .parsley-errors-list.filled {bottom:-17px;}
  .leftpadding .parsley-errors-list.filled {padding-left:15px;}
</style>