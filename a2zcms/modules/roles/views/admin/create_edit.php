<!-- Tabs -->
<ul class="nav nav-tabs">
	<li class="active">
		<a href="#tab-general" data-toggle="tab"><?=trans('General')?></a>
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
				<div class="col-lg-12">
					<?
						$this -> form_builder -> text('name', trans('Title'), (isset($content['rolename']))?$content['rolename']:"", 'form-control');
					?>
				</div>
			</div>
			<!-- ./ name -->
			<!-- Permissions -->
			<div class="form-group">
			<label class="col-md-2 control-label" for="name"><?=trans('ChooseRole')?></label>
				<div class="col-md-10">
					<select tabindex="3" name="permission[]" id="permission" multiple="" style="width:350px;" 
					data-placeholder="<?=trans('ChooseRole')?>">		             
		            	<?php		            	
		            	$opt ='<optgroup label="'.trans('UserRole').'">';
		            	foreach ($content['permissionsUser'] as $permission){
		            		$opt .= '<option value="'.$permission->id.'"';
		            			foreach($content['permisionsadd'] as $item) {
				            		if($item->permission_id==$permission->id) 
				            			$opt.= "selected='selected'";
		            			}
		            		$opt .=">".$permission->display_name."</option>";
		            	}
		            	$opt .='</optgroup>
  							<optgroup label="'.trans('AdminRole').'">';
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
		$("#permission").select2() // 0-based index;  
	});
</script>