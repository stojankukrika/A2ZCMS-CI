<!-- start: Main Menu -->
<div class="sidebar-nav nav-collapse collapse navbar-collapse">
	<ul class="nav main-menu">
		<li>
			<a href="<?=base_url('admin/plugins/dashboard')?>"><i class="icon-dashboard"></i><span class="hidden-sm text"><?=trans('Dashboard')?></span></a>
		</li>
		<?php
		$menu = '';
		foreach ($items['mainadminmenu'] as $adminmainmenu) {
			if(!empty($adminmainmenu->adminsubmenu))
			{
				$menu .='<li>
						<a class="dropmenu" href="'.base_url('admin/'.$adminmainmenu->url.'/').'"><i class="'.$adminmainmenu->icon.'"></i>
							<span class="hidden-sm text">'.trans($adminmainmenu->title).'</span></a><ul>';
				foreach($adminmainmenu->adminsubmenu as $adminsubmenu)
				{
					$menu .='<li>
						<a href="'.base_url('admin/'.$adminsubmenu->url.'/').'"><i class="'.$adminsubmenu->icon.'"></i>
							<span class="hidden-sm text">'.trans($adminsubmenu->title).'</span></a>
					</li>';
				}	
				$menu .='</ul></li>';			
			}
			else {
				$menu .='<li>
						<a href="'.base_url('admin/'.$adminmainmenu->url.'/').'"><i class="'.$adminmainmenu->icon.'"></i>
							<span class="hidden-sm text">'.trans($adminmainmenu->title).'</span></a>
					</li>';
			}
		}
		echo $menu;
		?>
				
	</ul>
</div>
<a href="#" id="main-menu-min" class="full visible-md visible-lg"><i class="icon-double-angle-left"></i></a>
<!-- end: Main Menu -->
