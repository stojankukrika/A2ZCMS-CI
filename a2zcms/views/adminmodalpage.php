<?php $this->load->view('includes/adminmodalheader'); 
?>
<!-- Container -->
		<div class="container">
			<!-- ./ notifications -->
			<div class="page-header">
				<h3> <div class="pull-right">
					<button class="btn btn-link btn-small btn-inverse close_popup">
						<span class="icon-remove-sign"></span> <?=trans('Back')?>
					</button>
				</div></h3>
			</div>
<?php
if(isset($view)) $this->load->view('admin/'.$view); 
$this->load->view('includes/adminmodalfooter'); ?>
