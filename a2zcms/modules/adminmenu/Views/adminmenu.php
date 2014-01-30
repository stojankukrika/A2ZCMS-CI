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
						<li class="dropdown">
							<a class="btn account dropdown-toggle" data-toggle="dropdown" href="#">
							<div class="avatar">
								<?php if($currentuser->avatar!=""){ ?>
									<img alt="Avatar" src="<?=base_url()?>data/avatar/'.<?=$currentuser->avatar;?>">
								<?php } 
								else { ?>
									<img alt="Avatar" src="<?=base_url()?>data/avatar/avatar.png">
								<?php } ?>
							</div>
							<div class="user">
								<span class="hello">Welcome!</span>
								<span class="name"><?=$currentuser->name;?> <?=$currentuser->surname?></span>
							</div> </a>
							<ul class="dropdown-menu">
								<li>
									<a href="<?=base_url()?>"><i class="icon-home"></i> Back to website</a>
								</li>
								<li>
									<a href="<?=base_url('users/'.$currentuser->username)?>"><i class="icon-cog"></i> Edit profile</a>
								</li>
								<li>
									<a href="<?=base_url('user/messages')?>"><i class="icon-envelope"></i> Messages</a>
								</li>
								<li>
									<a href="<?=base_url('users/logout')?>"><i class="icon-road icon-white"></i> Logout</a>
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
