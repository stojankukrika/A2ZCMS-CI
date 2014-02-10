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
				<label class="col-md-2 control-label" for="name">Name</label>
				<div class="col-md-10">
					<input class="form-control" tabindex="1" placeholder="Name" type="text" name="name" id="name" value="<?=isset($content['user_edit']->name)?$content['user_edit']->name:""?>">
				</div>
			</div>
			<!-- name -->
			<!-- surname -->
			<div class="form-group">
				<label class="col-md-2 control-label" for="surname">Surname</label>
				<div class="col-md-10">
					<input class="form-control" tabindex="2" placeholder="Surname" type="text" name="surname" id="surname" value="<?=isset($content['user_edit']->surname)?$content['user_edit']->surname:""?>">
				</div>
			</div>
			<!-- surname -->
			<!-- username -->
			<div class="form-group {{{ $errors->has('username') ? 'error' : '' }}}">
				<label class="col-md-2 control-label" for="username">Username</label>
				<div class="col-md-10">
					<input class="form-control" type="text" tabindex="3" placeholder="Username" name="username" id="username" value="<?=isset($content['user_edit']->username)?$content['user_edit']->username:""?>" />
				</div>
			</div>
			<!-- ./ username -->

			<!-- Email -->
			<div class="form-group {{{ $errors->has('email') ? 'error' : '' }}}">
				<label class="col-md-2 control-label" for="email">Email</label>
				<div class="col-md-10">
					<input class="form-control" type="text" tabindex="4" placeholder="Email" name="email" id="email" value="<?=isset($content['user_edit']->email)?$content['user_edit']->email:""?>" />
				</div>
			</div>
			<!-- ./ email -->

			<!-- Password -->
			<div class="form-group {{{ $errors->has('password') ? 'error' : '' }}}">
				<label class="col-md-2 control-label" for="password">Password</label>
				<div class="col-md-10">
					<input class="form-control"  tabindex="5" placeholder="Password" type="password" name="password" id="password" value="" />
				</div>
			</div>
			<!-- ./ password -->

			<!-- Activation Status -->
			<div class="form-group {{{ $errors->has('activated') || $errors->has('confirm') ? 'error' : '' }}}">
				<label class="col-md-2 control-label" for="confirm">Activate User?</label>
				<div class="col-md-6">
					<select class="form-control" name="active" id="active">
						<option value="1" <?=(!isset($content['user_edit']) || (isset($content['user_edit']->active) && $content['user_edit']->active=='1'))?'selected="selected"':""; ?>>Yes</option>
						<option value="0" <?=(isset($content['user_edit']->active) && $content['user_edit']->active=='0')?'selected="selected"':""; ?>>No</option>
					</select>					
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
		$("#roles").select2() // 0-based index;  
	});
</script>