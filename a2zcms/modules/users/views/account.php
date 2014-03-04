<?php $this->load->view('includes/header'); ?>

<div class="container">
	<div class="row">
		
		<?php $this->load->module('menu/menu');
		echo $this->menu->mainmenu('top');
		if(!empty($content['left_content'])) {
		 	echo '<div class="col-xs-6 col-lg-4"><br><br>';
		 	foreach ($content['left_content'] as $item)
			 {
			 	if($item['content']!="")
			 	echo '<div class="well">'.$item['content'].'</div>';
			 }
			 echo "</div>"; 
		}
		if(empty($content['right_content']) && empty($content['left_content'])) {
		echo '<div class="col-xs-12 col-sm-12 col-lg-12"><br>';
		}
		else {
			echo '<div class="col-xs-12 col-sm-6 col-lg-8"><br>';
		}
		?>
			<div class="page-header">
				<h3>Change password/avatar</h3>
			</div>
						
			<?php if(@$error): ?>
			<div class="alert">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<?php echo $error; ?>
			</div>
			<?php endif; ?>
			<form method="post" action="" enctype="multipart/form-data" >
				<div class="form-group">
					<div class="form-group">
						<div class="col-lg-12">
						<?
							$this -> form_builder -> password('old_password', 'Old password', "", 'form-control');
						?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-12">
						<?
							$this -> form_builder -> password('password', 'New password', "", 'form-control');
						?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-12">
						<?
							$this -> form_builder -> password('confirm_password', 'Confirm password', "", 'form-control');
						?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-12">
							<label class="control-label" for="avatar">Avatar</label>
							<input name="avatar" type="file" class="uploader" id="avatar" value="Upload" /> 
						</div>
					</div>
					<div class="form-group">&nbsp;</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-10">
							<button class="btn btn-primary" type="submit" tabindex="3">
								Change password			
							</button>
						</div>
					</div>
				</form>
			<div class="form-group">&nbsp;</div>
	<?php	echo '</div></div>';
		if(!empty($content['right_content'])) {
			echo '<div class="col-xs-6 col-lg-4"><br><br>';
			foreach ($content['right_content'] as $item)
			 {
			 	if($item['content']!="")
			 	echo '<div class="well">'.$item['content'].'</div>';
			 }
			  echo "</div>"; 
			}
		?>
	</div>
</div>
<?php $this->load->view('includes/footer'); ?>	

