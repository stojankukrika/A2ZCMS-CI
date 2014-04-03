<?php echo validation_errors('<p class="error">', '</p>'); ?>
<?php foreach ($errors as $error): ?>
    <p class="error"><?php echo $error; ?></p>
<?php endforeach; ?>
<?php echo form_open('install/step5',array('class' => 'form-horizontal')); ?>
<div class="box form">	
	<div class="control-group">
			<label class="control-label" for="title"><?=trans('SiteName',DEF_LANG)?>:<span class="required">*</span></label>
			<div class="controls">
				<?php echo form_input(array('name' => 'title', 'id' => 'title', 'value' => set_value('first_name'))); ?>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="theme"><?=trans('SiteTheme',DEF_LANG)?>:<span class="required">*</span></label>
			<div class="controls">
				<select name="theme">
					<?php
						foreach(glob(CMS_ROOT . '../data/assets/site/*', GLOB_ONLYDIR) as $dir) {
						    $dir = str_replace(CMS_ROOT . '../data/assets/site/', '', $dir);
						   echo '<option value="'.$dir.'">'.ucfirst($dir).'</option>';
						}
					?>
				</select>
			</div>
		</div>
	<div class="control-group">
			<label class="control-label" for="per_page"><?=trans('PostsPerPage',DEF_LANG)?>:<span class="required">*</span></label>
			<div class="controls">
				<select name="per_page" class="form-control">
					<?php
						for($i=1;$i<20;$i++) {
						   echo '<option value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select>
			</div>
	</div>
	<div class="control-group">
			<label class="control-label" for="per_page"><?=trans('PostsPerPageAdmin',DEF_LANG)?>:<span class="required">*</span></label>
			<div class="controls">
				<select name="pageitemadmin" class="form-control">
					<?php
						for($i=1;$i<20;$i++) {
						   echo '<option value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select>
			</div>
	</div>
	<div class="control-group">
	<div class="controls">
		<input type="submit" name="submit" class="btn save" value="<?=trans('Finish',DEF_LANG)?>" />
	</div>
</div>
	<?php echo form_close(); ?>
