 <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo base_url(); ?>"><?=$sitename?></a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
   		 <ul class="nav navbar-nav navbar-right">		
           <?php echo $items; ?>
     		<?php if($currentuser): ?>
					<li class='dropdown'>
						<a class="dropdown-toggle" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#">
							<?=trans('LoggedAs')?> <strong><?php echo $currentuser->username; ?></strong><b class="caret"></b>
						</a>
						<ul class='dropdown-menu' role="menu" aria-labelledby="dLabel">
							<? if(isset($admin)) {?>
								<li><a href="<?=base_url('admin/plugins/dashboard'); ?>"><?=trans('AdminPanel')?></a></li>
								<li class="divider"></li>
							<? }?>
							<li><a href="<?=base_url('users/account'); ?>"><?=trans('ChangeProfile')?></a></li>
							<li class="divider"></li>
							<li><a href="<?=base_url('users/logout'); ?>"><?=trans('Logout')?></a></li>
						</ul>
					</li>
			<?php endif; ?>
				
			</ul>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>
