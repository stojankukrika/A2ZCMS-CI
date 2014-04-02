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
			<!-- Title -->
			<div class="form-group">
				<div class="col-lg-12">
					<?php
					$this -> form_builder -> text('title', trans('Title'), 
					(isset($content['navigation_edit']->title))?$content['navigation_edit']->title:"", 'form-control');
					?>
				</div>
			</div>
			<!-- ./ Title -->

			<!-- navigation parent -->
			<div class="form-group">
				<div class="col-lg-12">
					<?php
					$options = '';
					if(isset($content['navigation_parent'])){
						foreach ($content['navigation_parent'] as $parent) {
							$options[] = (object) array('id' => $parent->id, 'name' => $parent->title);
						}
					}
					$this -> form_builder -> option('parent', trans('Parent'), $options, 
					(isset($content['navigation_edit']->parent))?$content['navigation_edit']->parent:"", 'form-control');
					?>
				</div>
			</div>
			<!-- ./ navigation parent -->

			<!-- Link Type -->
			<div class="form-group">
				<div class="col-lg-12">
					<?php
					$options = '';
					$options[] = (object) array('id' => 'page', 'name' => trans('Page'));
					$options[] = (object) array('id' => 'url', 'name' => 'URL');
					$options[] = (object) array('id' => 'uri', 'name' => 'URI');
					$this -> form_builder -> option('link_type', trans('LinkType'), $options, 
						(isset($content['navigation_edit']->link_type))?$content['navigation_edit']->link_type:"page", 'form-control');
					?>
				</div>
			</div>
			<!-- ./ link Type -->

			<!-- navigation page_id -->
			<div id="page" style="display: none;" class="form-group link_type">
				<div class="col-lg-12">
					<?php
					$options = '';
					if(isset($content['pagelist'])){
						foreach ($content['pagelist'] as $parent) {
							$options[] = (object) array('id' => $parent->id, 'name' => $parent->title);
						}
					}
					$this -> form_builder -> option('page_id', trans('Page'), $options, (isset($content['navigation_edit']->page_id))?$content['navigation_edit']->page_id:"", 'form-control');
					?>
				</div>
			</div>
			<!-- ./ navigation page_id -->

			<!-- URL -->
			<div id="url" style="display: none;" class="form-group link_type">
				<div class="col-lg-12">
					<?php
					$this -> form_builder -> text('url', 'URL', (isset($content['navigation_edit']->url))?$content['navigation_edit']->url:"", 'form-control');
					?>
				</div>
			</div>
			<!-- ./ URL -->

			<!-- URL -->
			<div id="uri" style="display: none;" class="form-group link_type">
				<div class="col-lg-12">
					<?php
					$this -> form_builder -> text('uri', 'URI', (isset($content['navigation_edit']->uri))?$content['navigation_edit']->uri:"", 'form-control');
					?>
				</div>
			</div>
			<!-- ./ URL -->

			<!-- navigation navigation_group_id -->
			<div class="form-group">
				<div class="col-lg-12">
					<?php
					$options = '';
					if(isset($content['navigationGroupList'])){
						foreach ($content['navigationGroupList'] as $key => $parent) {
							$options[] = (object) array('id' => $parent['id'], 'name' => $parent['title']);
						}
						$this -> form_builder -> option('navigation_group_id', trans('NavigationGroup'), $options, 
						(isset($content['navigation_edit']->page_id))?$content['navigation_edit']->page_id:"", 'form-control');
					}
					?>
				</div>
			</div>
			<!-- ./ navigation navigation_group_id -->

			<!-- navigation target -->
			<div class="form-group">
				<div class="col-lg-12">
					<?php
					$options = '';
					$options[] = (object) array('id' => 'selected', 'name' => 'Self');
					$options[] = (object) array('id' => '_blank', 'name' => 'Blank page');
					$this -> form_builder -> option('target', trans('Target'), $options, 
					(isset($content['navigation_edit']->target))?$content['navigation_edit']->target:"_blank", 'form-control');
					?>
				</div>
			</div>
			<!-- ./ navigation target -->

			<!-- Css Class -->
			<div class="form-group">
				<div class="col-lg-12">
					<?php
					$this -> form_builder -> text('class', trans('Class'), 
					(isset($content['navigation_edit']->class))?$content['navigation_edit']->class:"", 'form-control');
					?>
				</div>
			</div>
			<!-- ./ Css Class -->

		</div>
		<!-- ./ general tab -->
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
		$("#link_type").change(function() {
			var link_type = $(this).val();
			$(".link_type").hide();
			$("#" + link_type).show();

		}).change();
	}); 
</script>