	<div class="row">
		<div class="span6 offset3">
			<div class="page-header">
				<h3>Change password</h3>
			</div>
						
			<?php if(@$error): ?>
			<div class="alert">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<?php echo $error; ?>
			</div>
			<?php endif; ?>
			<form method="post" action="">
				<div class="form-group">
					<div class="form-group">
						<label class="col-md-2 control-label" for="password">Old password</label>
						<div class="col-md-10">
							<input type="password" class="form-control" id="old_password" name="old_password">
						</div>
					</div>
					<div class="form-group">&nbsp;</div>
					<div class="form-group">
						<label class="col-md-2 control-label" for="password">New password</label>
						<div class="col-md-10">
							<input type="password" class="form-control" id="password" name="password">
						</div>
					</div>
					<div class="form-group">&nbsp;</div>
					<div class="form-group">
						<label class="col-md-2 control-label" for="confirm_password">Confirm password</label>
						<div class="col-md-10">
							<input type="password" class="form-control" id="confirm_password" name="confirm_password">
						</div>
					</div>
					<div class="form-group">&nbsp;</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-10">
							<button class="btn btn-primary" type="submit" tabindex="3">
								Change password			
							</button>
						</div>
					</div>
				</form>
				<div class="form-group">&nbsp;</div>
			</div>
		</div>
	</div>
