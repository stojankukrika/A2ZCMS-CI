<!-- Tabs -->
<ul class="nav nav-tabs">
	<li class="active">
		<a href="#tab-general" data-toggle="tab">General</a>
	</li>	
	<li class="">
		<a href="#tab-dates" data-toggle="tab">Publish date</a>
	</li>
</ul>
<!-- ./ tabs -->
<form class="form-horizontal" method="post" action=""  enctype="multipart/form-data" autocomplete="off">
	<!-- Tabs Content -->
	<div class="tab-content">
		<!-- General tab -->
		<div class="tab-pane active" id="tab-general">
			<!-- text -->
			<div class="form-group">
				<label class="col-md-2 control-label" for="title">Title</label>
				<div class="col-md-10">
					<input class="form-control" tabindex="1" placeholder="Title" type="text" name="title" id="title" value="<?=isset($content['blog_edit']->title)?$content['blog_edit']->title:""?>">
				</div>
			</div>
			<!-- text -->
			<!-- resource_link -->
			<div class="form-group">
				<label class="col-md-2 control-label" for="resource_link">Resource link</label>
				<div class="col-md-10">
					<input class="form-control" tabindex="2" placeholder="Resource link" type="text" name="resource_link" id="resource_link" value="<?=isset($content['blog_edit']->resource_link)?$content['blog_edit']->resource_link:""?>">
				</div>
			</div>
			<!-- resource_link -->
			<!-- Show image -->
			<div class="form-group">
				<div class="col-lg-12">
					<label class="control-label" for="image">Image</label>
					<input name="image" type="file" class="uploader" id="image" value="Upload" /> 
				</div>
			</div>
			<!-- ./ show image -->
			<!-- category -->
			<div class="form-group">
				<label class="col-md-2 control-label" for="category">Category</label>
				<div class="col-md-6">
					<select name="category[]" id="category" multiple style="width:350px;" >
						<?php
						foreach ($content['category'] as $category){
							echo '<option value="'.$category->id.'"'.
							(( array_search($category->id, $content['assignedcategory']) !== false 
								&& array_search($category->id, $content['assignedcategory']) >= 0) ? ' selected="selected"' : '').
								'>'.$category->title.'</option>';
						}							
						?>
					</select>
				</div>
			</div>
			<!-- ./ category -->
			<!-- Content -->
			<div class="form-group">
				<div class="col-md-12">
					<label class="control-label" for="content">Content</label>
					<textarea class="form-control full-width wysihtml5" name="content" value="content" rows="10"><?=isset($content['blog_edit']->content)?$content['blog_edit']->content:""?></textarea>
				</div>
			</div>
			<!-- ./ content -->
		</div>
		<!-- ./ general tab -->
		<!-- Dates tab -->
		<div class="tab-pane" id="tab-dates">
			<!-- Start publish -->
			<div class="form-group">
				<div class="col-md-12">
					<label class="control-label" for="start_publish">Start publish</label>
					<input class="form-control" type="text" name="start_publish" id="start_publish" value="<?=isset($content['blog_edit']->start_publish)?$content['blog_edit']->start_publish:""?>" />
				</div>
			</div>
			<!-- ./ start publish -->

			<!-- End publish -->
			<div class="form-group">
				<div class="col-md-12 controls">
					<label class="control-label" for="end_publish">End publish</label>
					<input class="form-control" type="text" name="end_publish" id="end_publish" value="<?=isset($content['blog_edit']->end_publish)?$content['blog_edit']->end_publish:""?>" />
				</div>
			</div>
			<!-- ./ end publish -->
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
		$("#category").select2() // 0-based index;  
		$("#end_publish,#start_publish").datepicker({ dateFormat: 'yy-mm-dd' });  
	});
</script>