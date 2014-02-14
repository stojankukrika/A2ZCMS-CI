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
			<!-- Name -->
			<div class="form-group">
				<label class="col-md-2 control-label" for="title">Title</label>
				<div class="col-md-10">
					<input class="form-control" type="text" name="title" id="title" value="<?=(isset($content['navigationgroup_edit']->title))?$content['navigationgroup_edit']->title:"";?>" />
				</div>
			</div>
			<!-- ./ name -->
			<!-- Show in Header -->
			<div class="form-group">
				<div class="col-md-12">
					<?
					$radios = array();
					$radios[] = (object) array('id' => '1', 'name' => "Yes");
					$radios[] = (object) array('id' => '0', 'name' => "No");
					$this -> form_builder -> radio('showmenu', "Show in Header", $radios, (isset($content['navigationgroup_edit']->showmenu))?$content['navigationgroup_edit']->showmenu:"0", 'form-control');
					?>
				</div>
			</div>
			<!-- ./ show in Header -->			
			<!-- Show in Footer -->
			<div class="form-group">
				<div class="col-md-12">
					<?
					$radios = array();
					$radios[] = (object) array('id' => '1', 'name' => "Yes");
					$radios[] = (object) array('id' => '0', 'name' => "No");
					$this -> form_builder -> radio('showfooter', "Show in Footer", $radios, (isset($content['navigationgroup_edit']->showfooter))?$content['navigationgroup_edit']->showfooter:"0", 'form-control');
					?>
				</div>
			</div>
			<!-- ./ show in Footer -->	
			<!-- Show in Sidebar -->
			<div class="form-group">
				<div class="col-md-12">
					<?
					$radios = array();
					$radios[] = (object) array('id' => '1', 'name' => "Yes");
					$radios[] = (object) array('id' => '0', 'name' => "No");
					$this -> form_builder -> radio('showsidebar', "Show in Sidebar", $radios, (isset($content['navigationgroup_edit']->showsidebar))?$content['navigationgroup_edit']->showsidebar:"0", 'form-control');
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
		$("#end_publish,#start_publish").datepicker({ dateFormat: 'yy-mm-dd' }); 
	});
</script>