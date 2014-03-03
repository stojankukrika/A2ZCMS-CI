<!-- Tabs -->
<ul class="nav nav-tabs">
	<li class="active">
		<a href="#tab-general" data-toggle="tab">General</a>
	</li>
</ul>
<!-- ./ tabs -->
<form class="form-horizontal" method="post" action="" autocomplete="off">
	<!-- Tabs Content -->
	<div class="tab-content">
		<!-- General tab -->
		<div class="tab-pane active" id="tab-general">
			<!-- Name -->
			<div class="form-group">
				<div class="col-md-12">
				<?
					$this -> form_builder -> text('title', 'Title', (isset($content['gallery_edit']->title)?$content['gallery_edit']->title:""), 'form-control');
				?>
				</div>
			</div>
			<!-- ./ name -->
			<!-- Start publish -->
			<div class="form-group">
				<div class="col-md-12">
				<?
					$this -> form_builder -> text('start_publish', 'Start publish', (isset($content['gallery_edit']->start_publish)?$content['gallery_edit']->start_publish:""), 'form-control');
				?>
				</div>
			</div>
			<!-- ./ start publish -->			
			<!-- End publish -->
			<div class="form-group">
				<div class="col-md-12">
				<?
					$this -> form_builder -> text('end_publish', 'End publish', (isset($content['gallery_edit']->end_publish)?$content['gallery_edit']->end_publish:""), 'form-control');
				?>
				</div>
			</div>
			<!-- ./ end publish -->
		</div>
		<!-- ./ General tab -->
	</div>
	<!-- ./ tabs content -->

	<!-- Form Actions -->
	<div class="form-group">
		<div class="col-md-12">
			<button type="reset" class="btn btn-warning close_popup">
				<span class="icon-remove"></span> Cancel
			</button>
			<button type="reset" class="btn btn-default">
				<span class="icon-refresh"></span> Reset
			</button>
			<button type="submit" class="btn btn-success">
				<span class="icon-ok"></span>Save
			</button>
		</div>
	</div>
	<!-- ./ form actions -->
</form>

<script type="text/javascript">
	$(function() { 
		$("#end_publish,#start_publish").datepicker({ dateFormat: 'yy-mm-dd' }); 
	});
</script>