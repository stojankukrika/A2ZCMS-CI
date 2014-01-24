<?php $this->load->view('includes/header'); ?>

<div class="container">
	<div class="row">
		<?php echo modules::run("menu"); ?>
		<?php if(isset($left_content)) $this->load->view($left_content); ?>
		<?php if(isset($main_content)) $this->load->view($main_content); ?>
		<?php if(isset($right_content)) $this->load->view($right_content); ?>
	</div>
</div>
<?php $this->load->view('includes/footer'); ?>
