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
			<!-- name -->
			<div class="form-group">
				<div class="col-lg-12">
					<?
						$this -> form_builder -> text('name', 'Name', (isset($content['user_edit']->name))?$content['user_edit']->name:"", 'form-control');
					?>
				</div>
			</div>
			<!-- name -->
			<!-- surname -->
			<div class="form-group">
				<div class="col-lg-12">
					<?
						$this -> form_builder -> text('surname', 'Surname', (isset($content['user_edit']->surname))?$content['user_edit']->surname:"", 'form-control');
					?>
				</div>
			</div>
			<!-- surname -->
			<!-- username -->
			<div class="form-group">
				<div class="col-lg-12">
					<?
						$this -> form_builder -> text('username', 'Username', (isset($content['user_edit']->username))?$content['user_edit']->username:"", 'form-control');
					?>
				</div>
			</div>
			<!-- ./ username -->

			<!-- Email -->
			<div class="form-group">				
				<div class="col-lg-12">
					<?
						$this -> form_builder -> text('email', 'Email', (isset($content['user_edit']->email))?$content['user_edit']->email:"", 'form-control');
					?>
				</div>
			</div>
			<!-- ./ email -->

			<!-- Password -->
			<div class="form-group">								
				<div class="col-lg-12">
					<?
						$this -> form_builder -> password('password', 'Password', "", 'form-control');
					?>
				</div>
			</div>
			<!-- ./ password -->

			<!-- Activation Status -->
			<div class="form-group {{{ $errors->has('activated') || $errors->has('confirm') ? 'error' : '' }}}">
				<div class="col-lg-12">
					<?php
						$radios = '';
						$radios[] = (object) array('id' => 0, 'name' => 'Yes');
						$radios[] = (object) array('id' => 1, 'name' => 'No');
					
						$this -> form_builder -> radio('confirm', 'Activate User?', $radios, (isset($content['page_edit']->active))?$content['page_edit']->active:"1", 'form-control');							
					?>	
				</div>
			</div>
			<!-- ./ activation status -->

			<!-- Groups -->
			<div class="form-group {{{ $errors->has('roles') ? 'error' : '' }}}">
				<label class="col-md-2 control-label" for="roles">Roles</label>
				<div class="col-md-6">
					<select name="roles[]" id="roles" multiple style="width:350px;" >
						<?php
						foreach ($content['roles'] as $role){
							echo '<option value="'.$role->id.'"'.
							(( array_search($role->id, $content['assignedrole']) !== false 
								&& array_search($role->id, $content['assignedrole']) >= 0) ? ' selected="selected"' : '').
								'>'.$role->name.'</option>';
						}
							
						?>
					</select>

					<span class="help-block">Select a group to assign to the user, remember that a user takes on the permissions of the group they are assigned.  </span>
				</div>
			</div>
			<!-- ./ groups -->
		</div>
		<!-- ./ general tab -->

	</div>
	<!-- ./ tabs content -->
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
		$("#roles").select2() // 0-based index;  
	});
</script>