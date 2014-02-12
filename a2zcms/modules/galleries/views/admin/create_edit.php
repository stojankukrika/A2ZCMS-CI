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
				<label class="col-md-2 control-label" for="title">Title</label>
				<div class="col-md-10">
					<input class="form-control" type="text" name="title" id="title" value="<?=(isset($content['gallery_edit']->title))?$content['gallery_edit']->title:"";?>" />
				</div>
			</div>
			<!-- ./ name -->
			<!-- Start publish -->
			<div class="form-group">
				<div class="col-md-12">
					<label class="control-label" for="start_publish">Start publish</label>
					<input class="form-control" type="text" name="start_publish" id="start_publish" value="<?=(isset($content['gallery_edit']->start_publish))?$content['gallery_edit']->start_publish:"";?>" />
				</div>
			</div>
			<!-- ./ start publish -->			
			<!-- End publish -->
			<div class="form-group">
				<div class="col-md-12 controls">
					<label class="control-label" for="end_publish">End publish</label>
					<input class="form-control" type="text" name="end_publish" id="end_publish" value="<?=(isset($content['gallery_edit']->end_publish))?$content['gallery_edit']->end_publish:"";?>" />
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
			<button type="reset" class="btn btn-link close_popup">
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