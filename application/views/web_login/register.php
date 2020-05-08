<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>STAC | Log in</title>
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
         $mobile_no = !empty($mobile_no) ? $mobile_no : "";

        // echo "<pre>"; print_r($countries_name);die;
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
                                    <form id="sign_in" class="my-form" action="<?php echo site_url('account/registersave'); ?>" method="post" enctype="multipart/form-data" data-parsley-validate>
                                       <!--  <form id="login-form" name="login-form" class=" login-form form-wrap nobottommargin form-horizontal" action="#" method="post" role="form" novalidate="novalidate"> -->
                                       <h4 class="form-title uppercase font-600">Register a new membership</h4>
                                       <?php echo $this->messages->getMessageFront(); ?>
                                       <div class="label_input">
                                          <label>First Name <span class="colorred">*</span></label>
                                          <div style="margin-bottom: 25px" class="input-group">
                                             <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                             <input type="text" class="form-control" name="firstname" placeholder="First Name" data-parsley-required-message="First Name is required" required="">
                                          </div>
                                          <!-- <div style="color: red" id="mobError" class="mobErrorr"></div> -->
                                       </div>


                                      <div class="label_input">
                                          <label>Last Name <span class="colorred">*</span></label>
                                          <div style="margin-bottom: 25px" class="input-group">
                                             <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                             <input type="text" class="form-control" name="lastname" placeholder="Last Name" data-parsley-required-message="Last Name is required" required="">
                                          </div>
                                          <!-- <div style="color: red" id="mobError" class="mobErrorr"></div> -->
                                      </div>


                                     <!--  <div class="label_input">
                                        <label>Gender <span class="colorred">*</span></label>
                                        <div style="margin-bottom: 25px" class="clearfix relative input-group">
                                          <span class=" custom_addon_formation"><i class="glyphicon glyphicon-user"></i></span>
                                          <div class="custom_select_view">
                                            <select name="gender" id="gender" class="form-control" required=""> 
                                              <option value="">Select</option>
                                              <option value="m">Male</option>
                                              <option value="f">Female</option>
                                            </select>
                                          </div> 
                                        </div> 
                                      </div> -->


                                      <div class="label_input">
                                          <label>Email <span class="colorred">*</span></label>
                                          <div style="margin-bottom: 25px" class="input-group">
                                             <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                             <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email" data-parsley-required-message="Email is required" required="">
                                          </div>
                                          <!-- <div style="color: red" id="mobError" class="mobErrorr"></div> -->
                                      </div>

                                       <div class="label_input">
                                          <label>Password <span class="colorred">*</span></label>
                                          <div style="margin-bottom: 25px" class="input-group">
                                             <span class="input-group-addon"><i class=" glyphicon glyphicon-lock"></i></span>
                                             <input type="password" name="password" class="form-control" id="exampleInputEmail1" placeholder="Password" data-parsley-required-message="Password is required" required="">
                                          </div>
                                      </div>

                                      <div class="label_input">
                                          <label>Country <span class="colorred">*</span></label>
                                          <div style="margin-bottom: 25px" class="input-group">
                                             <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
                                             <input type="text" name="country" value="<?php echo (isset($countries_name->name)) ? $countries_name->name : ""; ?>" class="form-control" id="exampleInputEmail1" disabled>
                                          </div>



    <!-- [code] => +355 -->


                                      </div>


                                      <div class="label_input">
                                          <label>Passport <span class="colorred">*</span></label>
                                          <div style="margin-bottom: 25px" class="input-group">
                                             <span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
                                             <input type="passport" name="passport" class="form-control" id="" placeholder="NID/Passport/Driving license" data-parsley-required-message="Passport number is required" required="">
                                          </div>
                                      </div>


                                      <div class="label_input">
                                          <label>Document front <span class="colorred">*</span></label>
                                          <div style="margin-bottom: 25px" class="input-group">
                                             <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                             <input type="file" name="doc_front" class="form-control imageupload" id="imageupload" data-parsley-required-message="Front Document is required" required="">
                                          </div>
                                      </div>

                                      <div class="label_input">
                                          <label>Document back</label>
                                          <div style="margin-bottom: 25px" class="input-group">
                                             <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
                                             <!-- <input type="file" name="adminProfle" id="imgInp"> -->
                                             <input type="file" name="doc_back" class="form-control imageupload" id="exampleInputEmail1">
                                          </div>
                                      </div>

                                      <div class="input-group col-md-12">
                                        <div class="">
                                          <label class="">
                                            <input id="accept_term" type="checkbox" name="accept_term" data-parsley-mincheck="1" >
                                            <span class="">By continuing you accept and agree to our Terms & Conditions</span>
                                          </label>
                                        </div>
                                      </div>

                                        <input type="hidden" name="mobile_number" value="<?php echo $mobile_no; ?>">
                                        <input type="hidden" name="country_code" value="<?php echo (isset($countries_name->code)) ? $countries_name->code : ""; ?>">
                                      
                                       <div class="controls form-actions clearfix "><br>
                                          <div id="working"></div>
                                          <div class="btnlog col-md-6 col-sm-6 col-xs-6 padding-0 form-group loginsignup-submit">
                                             <button type="submit" class="btn login-btn uppercase btnlogin font-normal">Submit</button>
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



      //image privew 
      $(".imageupload").on('change', function () {
          
           var countFiles = $(this)[0].files.length;
           //var extensions_error = image_extensions_error;
           //var supports_error = image_supports_error;
       
           var imgPath = $(this)[0].value;
           var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
           var image_holder = $("#preview-image");

          if(extn != ""){
              if (extn == "png" || extn == "jpg" || extn == "jpeg") {
                  image_holder.empty();
                  if (typeof (FileReader) != "undefined") {

                      for (var i = 0; i < countFiles; i++) {

                          var reader = new FileReader();
                          reader.onload = function (e) {
                              $("<img />", {
                                  "src": e.target.result,
                                  "class": "thumbimage"
                              }).appendTo(image_holder);

                              loadImage(e.target.result);
                          }

                          image_holder.show();
                          reader.readAsDataURL($(this)[0].files[i]);
                      }

                  } else {
                      //var ErrorMsg = "It doesn't supports";
                      //showErrorMessage(supports_error);
                      alert("It doesn't supports");
                  }
              } else {
                  alert("Please upload files having extensions : .jpg,.jpeg or .png only");
                  //var ErrorMsg = "Please upload files having extensions : .jpg,.jpeg or .png only";
                  //showErrorMessage(extensions_error);
              }
          }

       });


      $("#sign_in").submit(function(e) {
          if(!$('input[type=checkbox]:checked').length) {
              alert("Please select Terms & Conditions checkbox.");
              //stop the form from submitting
              return false;
          }
          return true;
      });


    </script>


   </body>
</html>
<style type="text/css">
  .parsley-errors-list.filled {bottom:-17px;}
</style>