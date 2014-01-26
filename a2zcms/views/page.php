<?php $this->load->view('includes/header'); ?>

<div class="container">
	<div class="row">
		<?php echo modules::run("menu"); ?>
			
		<?php if(isset($left_content)) { echo '<div class="col-xs-6 col-lg-4"><br><br>'; $this->load->view($left_content); echo "</div>"; }?>
		<?php if(isset($main_content)) $this->load->view($main_content); ?>
		<?php if(isset($right_content)) { echo '<div class="col-xs-6 col-lg-4"><br><br>'; $this->load->view($right_content); echo "</div>";}?>
	</div>
</div>
<?php $this->load->view('includes/footer'); ?>
