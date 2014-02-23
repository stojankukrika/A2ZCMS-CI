	<div class="row">
		<div class="span6 offset3">
			<div class="page-header">
				<h3>Forgot password</h3>
			</div>
			<form method="post" action="">
				<div class="form-group">
						<label class="col-md-2 control-label" for="username">Username</label>
						<div class="col-md-10">
							<input type="text" class="form-control" id="username" value="<?php echo set_value('username'); ?>" name="username">
						</div>
					</div>	
					<div class="form-group">&nbsp;</div>				
					<div class="form-group">
						<label class="col-md-2 control-label" for="email">Email</label>
						<div class="col-md-10">
							<input type="text" class="form-control" id="email" value="<?php echo set_value('email'); ?>" name="email">
						</div>
					</div>					
					<div class="form-group">&nbsp;</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-10">
							<button class="btn btn-primary" type="submit" tabindex="3">
								Return password				
							</button>
						</div>
					</div>
				</form>
				<div class="form-group">&nbsp;</div>
			</div>
		</div>
	</div>
