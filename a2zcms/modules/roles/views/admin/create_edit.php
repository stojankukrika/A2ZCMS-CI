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
				<label class="col-md-2 control-label" for="name">Name</label>
				<div class="col-md-10">
					<input class="form-control" type="text" name="name" id="name" value="<?=$content['rolename']?>" />
				</div>
			</div>
			<!-- ./ name -->
			<!-- Permissions -->
			<div class="form-group">
			<label class="col-md-2 control-label" for="name">Choose role</label>
				<div class="col-md-10">
					<select tabindex="3" name="permission[]" id="permission" multiple="" style="width:350px;" 
					data-placeholder="Choose role">		             
		            	<?php		            	
		            	$opt ='<optgroup label="User role">';
		            	foreach ($content['permissionsUser'] as $permission){
		            		$opt .= '<option value="'.$permission->id.'"';
		            			foreach($content['permisionsadd'] as $item) {
				            		if($item->permission_id==$permission->id) 
				            			$opt.= "selected='selected'";
		            			}
		            		$opt .=">".$permission->display_name."</option>";
		            	}
		            	$opt .='</optgroup>
  							<optgroup label="Admin role">';
		            	foreach ($content['permissionsAdmin'] as $permission){
		            		$opt .= '<option value="'.$permission->id.'"';
		            			foreach($content['permisionsadd'] as $item) {
				            		if($item->permission_id==$permission->id) 
				            			$opt.= "selected='selected'";
		            			}
		            		$opt .=">".$permission->display_name."</option>";
		            	}
		            	echo $opt.'</optgroup>';
		            	?>
		          </select>
		        </div>
		    </div>
		    <!-- ./ permissions -->
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