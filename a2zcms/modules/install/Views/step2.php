<?=validation_errors('<p class="error">', '</p>'); ?>
<?php foreach ($errors as $error): ?>
    <p class="error"><?=$error; ?></p>
<?php endforeach; ?>
<p><h5>1. Please configure your PHP settings to match requirements listed below.</h5></p>
<div class="box">
    <table width="100%">
        <thead>
            <tr>
                <th class="align_left">PHP Settings</th>
                <th>Current Settings</th>
                <th>Required Settings</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>PHP Version:</td>
                <td class="align_center"><?=phpversion(); ?></td>
                <td class="align_center">5.1.6+</td>
                <td class="align_center"><img src="<?=base_url() . 'data/assets/install/img/' . ((phpversion() >= '5.1.6') ? 'good' : 'bad'); ?>.png" /></td>
            </tr>
            <tr>
                <td>Register Globals:</td>
                <td class="align_center"><?=(ini_get('register_globals')) ? 'On' : 'Off'; ?></td>
                <td class="align_center">Off</td>
                <td class="align_center"><img src="<?=base_url() . 'data/assets/install/img/' . (( ! ini_get('register_globals')) ? 'good' : 'bad'); ?>.png" /></td>
            </tr>
            <tr>
                <td>Magic Quotes GPC:</td>
                <td class="align_center"><?=(ini_get('magic_quotes_gpc')) ? 'On' : 'Off'; ?></td>
                <td class="align_center">Off</td>
                <td class="align_center"><img src="<?=base_url() . 'data/assets/install/img/' . (( ! ini_get('magic_quotes_gpc')) ? 'good' : 'bad'); ?>.png" /></td>
            </tr>
            <tr>
                <td>File Uploads:</td>
                <td class="align_center"><?=(ini_get('file_uploads')) ? 'On' : 'Off'; ?></td>
                <td class="align_center">On</td>
                <td class="align_center"><img src="<?=base_url() . 'data/assets/install/img/' . ((ini_get('file_uploads')) ? 'good' : 'bad'); ?>.png" /></td>
            </tr>
            <tr>
                <td>Session Auto Start:</td>
                <td class="align_center"><?=(ini_get('session_auto_start')) ? 'On' : 'Off'; ?></td>
                <td class="align_center">Off</td>
                <td class="align_center"><img src="<?=base_url() . 'data/assets/install/img/' . (( ! ini_get('session_auto_start')) ? 'good' : 'bad'); ?>.png" /></td>
            </tr>
        </tbody>
    </table>
</div>
<p><h5>2. Please make sure the extensions listed below are installed.</h5></p>
<div class="box">
    <table width="100%">
        <thead>
            <tr>
                <th class="align_left">Extension</th>
                <th>Current Settings</th>
                <th>Required Settings</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>MySQL:</td>
                <td class="align_center"><?=extension_loaded('mysql') ? 'On' : 'Off'; ?></td>
                <td class="align_center">On</td>
                <td class="align_center"><img src="<?=base_url() . 'data/assets/install/img/' . ((extension_loaded('mysql')) ? 'good' : 'bad'); ?>.png" /></td>
            </tr>
            <tr>
                <td>GD:</td>
                <td class="align_center"><?=extension_loaded('gd') ? 'On' : 'Off'; ?></td>
                <td class="align_center">On</td>
                <td class="align_center"><img src="<?=base_url() . 'data/assets/install/img/' . ((extension_loaded('gd')) ? 'good' : 'bad'); ?>.png" /></td>
            </tr>
            <tr>
                <td>cURL:</td>
                <td class="align_center"><?=extension_loaded('curl') ? 'On' : 'Off'; ?></td>
                <td class="align_center">On</td>
                <td class="align_center"><img src="<?=base_url() . 'data/assets/install/img/' . ((extension_loaded('curl')) ? 'good' : 'bad'); ?>.png" /></td>
            </tr>
        </tbody>
    </table>
</div>
<p><h5>3. Please make sure you have set the correct permissions on the files list below.</h5></p>
<div class="box">
    <table width="100%">
        <thead>
            <tr>
                <th class="align_left">Files</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?=CMS_ROOT . 'config/config.php'; ?></td>
                <td class="align_center"><?=is_writable(CMS_ROOT . 'config/config.php') ? '<span class="good">Writable</span>' : '<span class="bad">Unwritable</span>'; ?></td>
            </tr>
            <tr>
                <td><?=CMS_ROOT . 'config/database.php'; ?></td>
                <td class="align_center"><?=is_writable(CMS_ROOT . 'config/database.php') ? '<span class="good">Writable</span>' : '<span class="bad">Unwritable</span>'; ?></td>
            </tr>
            <tr>
                <td><?=CMS_ROOT . 'config/a2zcms.php'; ?></td>
                <td class="align_center"><?=is_writable(CMS_ROOT . 'config/a2zcms.php') ? '<span class="good">Writable</span>' : '<span class="bad">Unwritable</span>'; ?></td>
            </tr>
        </tbody>
    </table>
</div>
<p><h5>4. Please make sure you have set the correct permissions on the directories list below.</h5></p>
<div class="box">
    <table width="100%">
        <thead>
            <tr>
                <th class="align_left">Directories</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($writable_dirs as $path => $is_writable): ?>
            <tr>
                <td><?=CMS_ROOT.'../' . $path; ?></td>
                <td class="align_center"><?=$is_writable ? '<span class="good">Writable</span>' : '<span class="bad">Unwritable</span>'; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="control-group">
	<div class="controls">
		<?=form_open(); ?>
	    	<input type="submit" name="submit" class="btn save" value="Next step" />
	    <?=form_close(); ?>
	</div>
</div>