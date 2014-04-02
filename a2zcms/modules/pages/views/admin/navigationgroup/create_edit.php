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
						$this -> form_builder -> text('title', trans('Title'), (isset($content['navigationgroup_edit']->title))?$content['navigationgroup_edit']->title:"", 'form-control');
					?>
				</div>
			</div>
			<!-- ./ name -->
			<!-- Show in Header -->
			<div class="form-group">
				<div class="col-md-12">
					<?
					$radios = array();
					$radios[] = (object) array('id' => '1', 'name' => trans("Yes"));
					$radios[] = (object) array('id' => '0', 'name' => trans("No"));
					$this -> form_builder -> radio('showmenu', trans("ShowInHeader"), $radios, (isset($content['navigationgroup_edit']->showmenu))?$content['navigationgroup_edit']->showmenu:"0", 'form-control');
					?>
				</div>
			</div>
			<!-- ./ show in Header -->			
			<!-- Show in Footer -->
			<div class="form-group">
				<div class="col-md-12">
					<?
					$radios = array();
					$radios[] = (object) array('id' => '1', 'name' => trans("Yes"));
					$radios[] = (object) array('id' => '0', 'name' => trans("No"));
					$this -> form_builder -> radio('showfooter', trans("ShowInFooter"), $radios, (isset($content['navigationgroup_edit']->showfooter))?$content['navigationgroup_edit']->showfooter:"0", 'form-control');
					?>
				</div>
			</div>
			<!-- ./ show in Footer -->	
			<!-- Show in Sidebar -->
			<div class="form-group">
				<div class="col-md-12">
					<?
					$radios = array();
					$radios[] = (object) array('id' => '1', 'name' => trans("Yes"));
					$radios[] = (object) array('id' => '0', 'name' => trans("No"));
					$this -> form_builder -> radio('showsidebar', trans("ShowInSidebar"), $radios, (isset($content['navigationgroup_edit']->showsidebar))?$content['navigationgroup_edit']->showsidebar:"0", 'form-control');
					?>
				</div>
			</div>
			<!-- ./ show in Sidebar -->	
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
		$("#end_publish,#start_publish").datepicker({ dateFormat: 'yy-mm-dd' }); 
	});
</script>