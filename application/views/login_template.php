<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed');  ?>

<?php
    //load header
    //echo $head;
	$this->load->view('part/header')
?>
 
  <body class="login-page">
<div class="content">
	<?php echo $this->messages->getMessageFront();
		// load content area
		echo $content
	?>
</div>
   <!-- jQuery 2.1.3 -->
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
        $('.alert').fadeOut( 5000);        
      });
    </script>
  </body>
</html>




