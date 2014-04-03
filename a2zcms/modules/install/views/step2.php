<?=validation_errors('<p class="error">', '</p>'); ?>
<?php foreach ($errors as $error): ?>
    <p class="error"><?=$error; ?></p>
<?php endforeach; ?>
<p><h5><?=trans('Step1Point1',DEF_LANG)?></h5></p>
<div class="box">
    <table width="100%">
        <thead>
            <tr>
                <th class="align_left"><?=trans('PHPSettings',DEF_LANG)?></th>
                <th><?=trans('CurrentSettings',DEF_LANG)?></th>
                <th><?=trans('RequiredSettings',DEF_LANG)?></th>
                <th><?=trans('Status',DEF_LANG)?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?=trans('PHPVersion',DEF_LANG)?>:</td>
                <td class="align_center"><?=phpversion(); ?></td>
                <td class="align_center">5.1.6+</td>
                <td class="align_center"><img src="<?=base_url() . 'data/assets/install/img/' . ((phpversion() >= '5.1.6') ? 'good' : 'bad'); ?>.png" /></td>
            </tr>
            <tr>
                <td><?=trans('RegisterGlobals',DEF_LANG)?>:</td>
                <td class="align_center"><?=(ini_get('register_globals')) ? trans('On',DEF_LANG) : trans('Off',DEF_LANG); ?></td>
                <td class="align_center"><?=trans('Off',DEF_LANG)?></td>
                <td class="align_center"><img src="<?=base_url() . 'data/assets/install/img/' . (( ! ini_get('register_globals')) ? 'good' : 'bad'); ?>.png" /></td>
            </tr>
            <tr>
                <td><?=trans('MagicQuotesGPC',DEF_LANG)?>:</td>
                <td class="align_center"><?=(ini_get('magic_quotes_gpc')) ? trans('On',DEF_LANG) : trans('Off',DEF_LANG); ?></td>
                <td class="align_center"><?=trans('Off',DEF_LANG)?></td>
                <td class="align_center"><img src="<?=base_url() . 'data/assets/install/img/' . (( ! ini_get('magic_quotes_gpc')) ? 'good' : 'bad'); ?>.png" /></td>
            </tr>
            <tr>
                <td><?=trans('FileUploads',DEF_LANG)?>:</td>
                <td class="align_center"><?=(ini_get('file_uploads')) ? trans('On',DEF_LANG) : trans('Off',DEF_LANG); ?></td>
                <td class="align_center"><?=trans('On',DEF_LANG)?></td>
                <td class="align_center"><img src="<?=base_url() . 'data/assets/install/img/' . ((ini_get('file_uploads')) ? 'good' : 'bad'); ?>.png" /></td>
            </tr>
            <tr>
                <td><?=trans('SessionAutoStart',DEF_LANG)?>:</td>
                <td class="align_center"><?=(ini_get('session_auto_start')) ? trans('On',DEF_LANG) : trans('Off',DEF_LANG); ?></td>
                <td class="align_center"><?=trans('Off',DEF_LANG)?></td>
                <td class="align_center"><img src="<?=base_url() . 'data/assets/install/img/' . (( ! ini_get('session_auto_start')) ? 'good' : 'bad'); ?>.png" /></td>
            </tr>
        </tbody>
    </table>
</div>
<p><h5><?=trans('Step1Point2',DEF_LANG)?></h5></p>
<div class="box">
    <table width="100%">
        <thead>
            <tr>
                <th class="align_left"><?=trans('Extension',DEF_LANG)?></th>
                <th><?=trans('CurrentSettings',DEF_LANG)?></th>
                <th><?=trans('RequiredSettings',DEF_LANG)?></th>
                <th><?=trans('Status',DEF_LANG)?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>MySQL:</td>
                <td class="align_center"><?=extension_loaded('mysql') ? trans('On',DEF_LANG) : trans('Off',DEF_LANG); ?></td>
                <td class="align_center"><?=trans('On',DEF_LANG)?></td>
                <td class="align_center"><img src="<?=base_url() . 'data/assets/install/img/' . ((extension_loaded('mysql')) ? 'good' : 'bad'); ?>.png" /></td>
            </tr>
            <tr>
                <td>GD:</td>
                <td class="align_center"><?=extension_loaded('gd') ? trans('On',DEF_LANG) : trans('Off',DEF_LANG); ?></td>
                <td class="align_center"><?=trans('On',DEF_LANG)?></td>
                <td class="align_center"><img src="<?=base_url() . 'data/assets/install/img/' . ((extension_loaded('gd')) ? 'good' : 'bad'); ?>.png" /></td>
            </tr>
            <tr>
                <td>cURL:</td>
                <td class="align_center"><?=extension_loaded('curl') ? trans('On',DEF_LANG) : trans('Off',DEF_LANG); ?></td>
                <td class="align_center"><?=trans('On',DEF_LANG)?></td>
                <td class="align_center"><img src="<?=base_url() . 'data/assets/install/img/' . ((extension_loaded('curl')) ? 'good' : 'bad'); ?>.png" /></td>
            </tr>
        </tbody>
    </table>
</div>
<p><h5><?=trans('Step1Point3',DEF_LANG)?></h5></p>
<div class="box">
    <table width="100%">
        <thead>
            <tr>
                <th class="align_left"><?=trans('Files',DEF_LANG)?></th>
                <th><?=trans('Status',DEF_LANG)?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?=CMS_ROOT . 'config/config.php'; ?></td>
                <td class="align_center"><?=is_writable(CMS_ROOT . 'config/config.php') ? '<span class="good">'.trans('Writable',DEF_LANG).'</span>' : '<span class="bad">'.trans('Unwritable',DEF_LANG).'</span>'; ?></td>
            </tr>
            <tr>
                <td><?=CMS_ROOT . 'config/database.php'; ?></td>
                <td class="align_center"><?=is_writable(CMS_ROOT . 'config/database.php') ? '<span class="good">'.trans('Writable',DEF_LANG).'</span>' : '<span class="bad">'.trans('Unwritable',DEF_LANG).'</span>'; ?></td>
            </tr>
            <tr>
                <td><?=CMS_ROOT . 'config/a2zcms.php'; ?></td>
                <td class="align_center"><?=is_writable(CMS_ROOT . 'config/a2zcms.php') ? '<span class="good">'.trans('Writable',DEF_LANG).'</span>' : '<span class="bad">'.trans('Unwritable',DEF_LANG).'</span>'; ?></td>
            </tr>
        </tbody>
    </table>
</div>
<p><h5><?=trans('Step1Point4',DEF_LANG)?></h5></p>
<div class="box">
    <table width="100%">
        <thead>
            <tr>
                <th class="align_left">Directories</th>
                <th><?=trans('Status',DEF_LANG)?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($writable_dirs as $path => $is_writable): ?>
            <tr>
                <td><?=CMS_ROOT.'../' . $path; ?></td>
                <td class="align_center"><?=$is_writable ? '<span class="good">'.trans('Writable',DEF_LANG).'</span>' : '<span class="bad">'.trans('Unwritable',DEF_LANG).'</span>'; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="control-group">
	<div class="controls">
		<?=form_open(); ?>
	    	<input type="submit" name="submit" class="btn save" value="<?=trans('NextStep',DEF_LANG)?>" />
	    <?=form_close(); ?>
	</div>
</div>