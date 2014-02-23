<?php echo validation_errors('<p class="error">', '</p>'); ?>
<?php foreach ($errors as $error): ?>
    <p class="error"><?php echo $error; ?></p>
<?php endforeach; ?>
<?php echo form_open('install/step4',array('class' => 'form-horizontal')); ?>
<div class="box form">
     <div class="control-group">
        <label class="control-label" for="first_name">First Name:<span class="required">*</span></label>
         <div class="controls">
         	<?php echo form_input(array('name' => 'first_name', 'id' => 'first_name', 'value' => set_value('first_name'))); ?>
         </div>
    </div>
   <div class="control-group">
        <label class="control-label" for="last_name">Last Name:<span class="required">*</span></label>
         <div class="controls">
         	<?php echo form_input(array('name' => 'last_name', 'id' => 'last_name', 'value' => set_value('last_name'))); ?>
         </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="email">Username:<span class="required">*</span></label>
         <div class="controls">
         	<?php echo form_input(array('name' => 'username', 'id' => 'username', 'value' => set_value('username','admin'))); ?>
         </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="email">Email:<span class="required">*</span></label>
         <div class="controls">
         	<?php echo form_input(array('name' => 'email', 'id' => 'email', 'value' => set_value('email'))); ?>
         </div>
    </div>
   <div class="control-group">
        <label class="control-label" for="admin_password">Password:<span class="required">*</span></label>
         <div class="controls">
         	<?php echo form_password(array('name' => 'admin_password', 'id' => 'admin_password')); ?>
         </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="confirm_admin_password">Confirm Password:<span class="required">*</span></label>
         <div class="controls">
         	<?php echo form_password(array('name' => 'confirm_admin_password', 'id' => 'confirm_admin_password')); ?>
         </div>
    </div>
   
</div>
<div class="control-group">
	<div class="controls">
		<input type="submit" name="submit" class="btn save" value="Next step" />
	</div>
</div>
<?php echo form_close(); ?>