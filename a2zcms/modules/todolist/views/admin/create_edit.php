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
				<label class="col-md-2 control-label" for="title">Name</label>
				<div class="col-md-10">
					<input class="form-control" type="text" name="title" id="title" value="<?=(isset($content['todolist_edit']->title))?$content['todolist_edit']->title:"";?>" />
				</div>
			</div>
			<!-- ./ name -->
			<!-- Permissions -->
			<div class="form-group">
			<label class="col-md-2 control-label" for="name">Content</label>
				<div class="col-md-10">
					<textarea class="full-width col-md-12 wysihtml5" name="content" id="content" ><?=(isset($content['todolist_edit']->content))?$content['todolist_edit']->content:"";?></textarea>
		        </div>
		    </div>
		    <!-- ./ permissions -->
		    <!-- FInished-->
			<div class="form-group">
				<div class="col-md-12">
					 <label class="control-label"  for="finished">Finished</label></br>
					 <input id="finished" class="form-control"  name="finished" value="<?=(isset($content['todolist_edit']->finished))?$content['todolist_edit']->finished:"0.00"?>" />
				</div>				
			</div>
			<!-- ./ finished -->
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
		$("#permission").select2() // 0-based index;  
	});
</script>