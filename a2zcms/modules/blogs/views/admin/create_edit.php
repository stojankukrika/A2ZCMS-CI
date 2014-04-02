<!-- Tabs -->
<ul class="nav nav-tabs">
	<li class="active">
		<a href="#tab-general" data-toggle="tab"><?=trans('General')?></a>
	</li>	
	<li class="">
		<a href="#tab-dates" data-toggle="tab"><?=trans('PublishDate')?></a>
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
				<div class="col-md-12">
				<?
					$this -> form_builder -> text('title', trans('Title'), isset($content['blog_edit']->title)?$content['blog_edit']->title:"", 'form-control');
				?>
				</div>
			</div>
			<!-- text -->
			<!-- resource_link -->
			<div class="form-group">
				<div class="col-md-12">
				<?
					$this -> form_builder -> text('resource_link', trans('ResourceLink'), isset($content['blog_edit']->resource_link)?$content['blog_edit']->resource_link:"", 'form-control');
				?>
				</div>
			</div>
			<!-- resource_link -->
			<!-- Show image -->
			<div class="form-group">
				<div class="col-lg-12">
					<label class="control-label" for="image"><?=trans('Image')?></label>
					<input name="image" type="file" class="uploader" id="image" value="Upload" /> 
				</div>
			</div>
			<!-- ./ show image -->
			<!-- category -->
			<div class="form-group">
				<label class="col-md-2 control-label" for="category"><?=trans('Category')?></label>
				<div class="col-md-6">
					<select name="category[]" id="category" multiple style="width:350px;" >
						<?php						
						foreach ($content['category'] as $category){
							echo '<option value="'.$category->id.'"';
							$temp = "";
							for($i=0;$i<count($content['assignedcategory']);$i++){
								if(array_search($category->id, $content['assignedcategory'][$i]) !== false 
										&& array_search($category->id, $content['assignedcategory']) >= 0)
									$temp = ' selected="selected"';
								}							
							echo $temp.'>'.$category->title.'</option>';
						}							
						?>
					</select>
				</div>
			</div>
			<!-- ./ category -->
			<!-- Content -->
			<div class="form-group">
				<div class="col-md-12">
				<?
					$this -> form_builder -> textarea('content', trans('Content'), isset($content['blog_edit']->content)?$content['blog_edit']->content:"", 'wysihtml5');
				?>
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
				<?
					$this -> form_builder -> text('start_publish', trans('StartPublish'), isset($content['blog_edit']->start_publish)?$content['blog_edit']->start_publish:"", 'form-control');
				?>
				</div>
			</div>
			<!-- ./ start publish -->

			<!-- End publish -->
			<div class="form-group">
				<div class="col-md-12">
				<?
					$this -> form_builder -> text('end_publish', trans('EndPublish'), isset($content['blog_edit']->end_publish)?$content['blog_edit']->end_publish:"", 'form-control');
				?>
				</div>
			</div>
			<!-- ./ end publish -->
	</div>
	<!-- ./ tabs content -->

	<!-- Form Actions -->
	<div class="form-group">
		<div class="col-md-12">
			<button type="reset" class="btn btn-warning close_popup">
				<span class="icon-remove"></span> <?=trans('Cancel')?>
			</button>
			<button type="reset" class="btn btn-default">
				<span class="icon-refresh"></span> <?=trans('Reset')?>
			</button>
			<button type="submit" class="btn btn-success">
				<span class="icon-ok"></span><?=trans('Save')?>
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