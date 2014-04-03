<!-- start: Header -->
		<header class="navbar">
			<div class="container">
				<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a id="main-menu-toggle" class="hidden-xs open"><i class="icon-reorder"></i></a>
				<a class="navbar-brand col-md-2 col-sm-1 col-xs-2" href="#"><span>A2Z CMS</span></a>
				<!-- start: Header Menu -->
				<div class="nav-no-collapse header-nav">
					<ul class="nav navbar-nav pull-right">
					<!-- start: User Dropdown -->
					<li class='dropdown'>
						<a class="btn account dropdown-toggle" data-toggle="dropdown" href="#">
							<div class="avatar">
								<span class="lang"><?=trans('Jezik')?></span>
							</div>
						</a>
						<ul class="dropdown-menu">								
						<?php foreach( $langs as $lang_id => $lang_name): ?>
				          <li class="<?php echo @$_SESSION['lang']==$lang_id ? ' active ' : ''?>"> 
				          	<a  href="<?php echo site_url('pages/change_uilang/' . $lang_id)?>">
				          		<img src="<?=FLAG_PATH.'/'.$lang_id.'.png' ?>" alt="<?=$lang_id?>" height="16" width="16">&nbsp;
				          		<?php echo $lang_name?>         		
				          	</a> 
				          	</li>
				          <?php endforeach; ?>
				         </ul>
			        </li>
			       	<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
			        <li class="dropdown">
							<a class="btn account dropdown-toggle" data-toggle="dropdown" href="#">
							<div class="avatar">
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
							<div class="user">
								<span class="hello"><?=trans('Welcome1')?></span>
								<span class="name"><?=$currentuser->name;?> <?=$currentuser->surname?></span>
							</div> </a>
							<ul class="dropdown-menu">
								<li>
									<a href="<?=base_url()?>"><i class="icon-home"></i> <?=trans('BackToWebsite')?></a>
								</li>
								<li>
									<a href="<?=base_url('users/account')?>"><i class="icon-cog"></i> <?=trans('ChangeProfile')?></a>
								</li>
								<li>
									<a href="<?=base_url('users/messages')?>"><i class="icon-envelope"></i> <?=trans('Messages')?></a>
								</li>
								<li>
									<a href="<?=base_url('users/logout')?>"><i class="icon-road icon-white"></i> <?=trans('Logout')?></a>
								</li>
							</ul>
						</li>
						<!-- end: User Dropdown -->
					</ul>
				</div>
				<!-- end: Header Menu -->
			</div>
		</header>
		<!-- end: Header -->
