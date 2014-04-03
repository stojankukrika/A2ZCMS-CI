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
           <li class='dropdown'>
						<a class="dropdown-toggle" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#">
							<?=trans('Jezik')?><b class="caret"></b>
						</a>
						<ul class='dropdown-menu' role="menu" aria-labelledby="dLabel">
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
