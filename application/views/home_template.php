<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php 
	error_reporting(0);
	//header of template
	$this->load->view('part/header');	
?>		
	<aside class="main-sidebar">
		<?php 
		$this->load->view('part/sidebar'); 
		?>
	</aside>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
    
<?php
	// display success/error message
	echo $this->messages->getMessageFront();
	// load content area
	echo $content
?>
<script>
	var delete_confirmation = "<?php echo $this->lang->line('r_u_sure_you_want_to_delete'); ?>";
	var select_record_error = "<?php echo $this->lang->line('please_select_atleast_one_record'); ?>";
	var deleted             = "<?php echo $this->lang->line('deleted'); ?>";
	var delete_successfully = "<?php echo $this->lang->line('delete_successfully'); ?>";
	var success             = "<?php echo $this->lang->line('success'); ?>";
	var cancel              = "<?php echo $this->lang->line('cancel'); ?>";
	var yes                 = "<?php echo $this->lang->line('yes'); ?>";
	var status_change       = "<?php echo $this->lang->line('status_change'); ?>";
	var yes_change          = "<?php echo $this->lang->line('yes_change'); ?>";
</script>
</div>
<?php
	//footer of template
	$this->load->view('part/footer')
?>
