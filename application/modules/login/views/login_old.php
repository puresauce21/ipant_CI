 <?php //echo $this->input->cookie('keep_me1', TRUE); die;?>
 
 <div class="login-box">
      <div class="login-logo">
       <b><img src="<?php echo base_url('templates/theme/dist/img/tmp-logo.png'); ?>" width="65%"></b>
      </div><!-- /.login-logo -->
      <div class="login-box-body"><?php echo $this->messages->getMessageFront(); ?>
        <p class="login-box-msg" style="font-weight: 600;">Sign In</p>
        <form action="<?php echo base_url('login/loginAuth'); ?>" method="post" data-parsley-validate >
          <div class="form-group has-feedback">
            <input type="email" class="form-control" autocomplete="off"  name="username" data-parsley-type-message="Please enter valid email" data-parsley-required-message="Email is required"  required="" placeholder="Email" value="<?php if(isset($_COOKIE['username'])){ echo $_COOKIE['username'];} ?>"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" autocomplete="off" name="password" placeholder="Password"  data-parsley-required-message="Password is required" required="" value="<?php if(isset($_COOKIE['password'])){ echo $_COOKIE['password'];} ?>"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row" >
               <div class="col-xs-7">    
          <div class="checkbox icheck">
                <label style="margin:0 0 0 19px;">
                  <input type="checkbox" id="rember" name="keep_me" value="keep_me"<?php if(isset($_COOKIE['password'])){ ?> checked  <?php } ?>> Remember Me
                </label>
              </div>                        
            </div><!-- /.col -->
            <div class="col-xs-5" style="margin: 8px 0px;">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>

     

        <a href="<?php echo base_url('login/forgotPassword'); ?>">I forgot my password</a><br>
       <!-- <a href="#" class="text-center">Register a new membership</a>-->

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

