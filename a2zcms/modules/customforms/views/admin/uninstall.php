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
			<input class="form-control" type="hidden" name="plugin" id="plugin" value="customforms" />
			<div class="form-group">
				<div class="col-md-10">
					<label><?=trans('UninstallQuestion')?></label>				
				</div>
			</div>
			<!-- ./ name -->			
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
			<button type="submit" class="btn btn-success">
				<span class="icon-ok"></span><?=trans('Uninstall')?>
			</button>
		</div>
	</div>
	<!-- ./ form actions -->
</form>