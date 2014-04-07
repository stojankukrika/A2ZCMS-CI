   <? if($this->session->userdata('logged_in')){ ?>
   	<h4><?=trans('Welcome')?> <?=$this->session->userdata('name').' '.$this->session->userdata('surname')?></h4>
   	<div class="row">
  		<div class="col-md-4">
			<? if($this->session->userdata('avatar')!=""){
				if($this->session->userdata('usegravatar')=="No"){ 
					echo '<img alt="Avatar" src="'.base_url().'/data/avatar/'.$this->session->userdata('avatar').'">';
					}
					else {
					 echo '<img alt="Avatar" src="'.$this->session->userdata('avatar').'">';
					}
				} else {
				echo '<img alt="Avatar" src="'.base_url().'/data/avatar/avatar.png">';
				}
				?>
		</div>
		<div class="col-md-8">
		<ul style="list-style: none;">
		<? if($this->session->userdata('admin_logged_in')){
		?>
		<li>
			<a href="<?=base_url('admin/plugins/dashboard')?>"><?=trans('AdminPanel')?></a>
		</li>
		<? } ?>
		<li>
			<a href="<?=base_url('users/messages')?>"><?=trans('Messages')?><?=$this->Model_message->selectNonRead($this->session->userdata('user_id'))?></a>
		</li>
		<li>
			<a href="<?=base_url('users/account')?>"><?=trans('ChangeProfile')?></a>
		</li>
		<li>
			<a href="<?=base_url('users/logout')?>">
				<button tabindex="3" type="submit" class="btn btn-danger">
						<?=trans('Logout')?>
					</button></a>
		</li>
		</ul>
		</div></div>
		<? } 
		else { ?>
		<h4><?=trans('LoginUsers')?></h4>
		<form method="POST" action="<?=base_url('users/login')?>" accept-charset="UTF-8">
			<fieldset>
				<div class="form-group">
					<div class="col-lg-12">
					<?
						$this -> form_builder -> text('email', trans('UsernameOrEmail'), "", 'form-control');
					?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-lg-12">
					<?
						$this -> form_builder -> password('password', trans('Password'), "", 'form-control');
					?>
					</div>
				</div>			
				<div class="form-group">
					<div class="col-md-offset-2 col-md-10">
						<div class="checkbox">
							<label for="remember"><?=trans('RememberMe');?>
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
						<?=trans('Login');?>
					</button>
					<a class="btn btn-success" href="<?=base_url('users/forgot');?>"><?=trans('ForgotPassword');?></a>
				</p>
			</fieldset>
		</form>	
	    <h4><?=trans('NeedAnAccount');?></h4>
			<p>
				<?=trans('CreateAnAccountHere')?>
			</p>
			<p>
				<a href="<?=base_url('users/register');?>" class="btn btn-info"><?=trans('CreateAccount')?></a>
			</p>
		<? } ?>