<?php $this->load->view('includes/header'); ?>

<div class="container">
	<div class="row">
		<?php echo modules::run("menu"); ?>
		<?php $this->load->view($main_content); ?>
	</div>
</div>
<?php $this->load->view('includes/footer'); ?>