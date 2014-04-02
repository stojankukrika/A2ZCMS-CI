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
						$this -> form_builder -> text('title', trans('Title'), (isset($content['todolist_edit']->title))?$content['todolist_edit']->title:"", 'form-control');
					?>
				</div>
			</div>
			<!-- ./ name -->
			<!-- Permissions -->
			<div class="form-group">
				<div class="col-lg-12">
				<?
					$this -> form_builder -> textarea('content', trans('Content'), (isset($content['todolist_edit']->content))?$content['todolist_edit']->content:"", 'wysihtml5');
				?>
				</div>
		    </div>
		    <!-- ./ permissions -->
		    <!-- FInished-->
			<div class="form-group">
				<div class="col-lg-12">
					<?
						$this -> form_builder -> text('finished', trans('Finished'), (isset($content['todolist_edit']->finished))?$content['todolist_edit']->finished:"0.00", 'form-control');
					?>
				</div>			
			</div>
			<!-- ./ finished -->
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
		$("#permission").select2() // 0-based index;  
	});
</script>