 <div class="well">	
<ul class="list-unstyled">
   <? if($this->session->userdata('logged_in')){ ?>
   	<h4>Welcome <?=$this->session->userdata('name').' '.$this->session->userdata('surname')?></h4>
		<? if($this->session->userdata('avatar')!=""){ ?>
		<img alt="Avatar" src="<?='data/avatar/'.$this->session->userdata('avatar');?>">
		<?} else {?>
		<img alt="Avatar" src="<?= 'data/avatar/avatar.png';?>">
		<? }
		if($this->session->userdata('admin_logged_in')){
		?>
		<li>
			<a href="<?=base_url('admin/users/index')?>">Admin panel</a>
		</li>
		<? } ?>
		<li>
			<a href="<?=base_url('messages/index')?>">Messages</a>
		</li>
		<li>
			<a href="<?=base_url('users/account')?>">Edit profile</a>
		</li>
		<li>
			<a href="<?=base_url('users/logout')?>">
				<button tabindex="3" type="submit" class="btn btn-danger">
						Logout
					</button></a>
		</li>
		<? } 
		else { ?>
		<h4>Login to system</h4>
		<form method="POST" action="login" accept-charset="UTF-8">
			<fieldset>
				<div class="form-group">
					<label class="col-md-4 control-label" for="email">Username or email</label>
					<div class="col-md-8">
						<input class="form-control" tabindex="1" placeholder="Username or email" type="text" name="email" id="email" value="">
					</div>
				</div>
				<div class="form-group">&nbsp;</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="password"> Password</label>
					<div class="col-md-8">
						<input class="form-control" tabindex="2" placeholder="Password" type="password" name="password" id="password">
					</div>
				</div>			
				<div class="form-group">
					<div class="col-md-offset-2 col-md-10">
						<div class="checkbox">
							<label for="remember">Remember me
								<input type="hidden" name="remember" value="0">
								<input tabindex="4" type="checkbox" name="remember" id="remember" value="1">
							</label>
						</div>
					</div>
				</div>							
			<?php if(@$error): ?>
			<div class="alert">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<?php echo $error; ?>
			</div>
			<?php endif; ?>		
				<p>
					<button tabindex="3" type="submit" class="btn btn-primary">
						Submit
					</button>
					<a class="btn btn-success" href="user/forgot">Forgot password</a>
				</p>
			</fieldset>
		</form>	
	    <h4>Need an account</h4>
			<p>
				Create an account here?
			</p>
			<p>
				<a href="register" class="btn btn-info">Create account</a>
			</p>
		<? } ?>
	</ul>
</div>