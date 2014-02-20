<div id="content" class="col-lg-10 col-sm-11 ">
	<div class="row">
		<p>
			<?php
			echo form_open('');
			echo '<div class="box">
			<div class="box-header">
				<h2><i class="icon-th"></i><span class="break"></span>Settings Management</h2>
				<ul id="myTab" class="nav tab-menu nav-tabs">';
			foreach ($content['settingsgroup'] as $group) {
				echo '<li><a href="#' . $group -> groupname . '">' . ucfirst($group -> groupname) . '</a></li>';
			}
			echo '</ul>
			</div>
			<div class="box-content">
				<div class="tab-content" id="myTabContent">'.$content['settingstable'].'</div>
			<div class="form-group">
					<div class="col-md-12">
						<button type="reset" class="btn btn-link close_popup">
							<span class="icon-remove"></span> Cancel
						</button>
						<button type="reset" class="btn btn-default">
							<span class="icon-refresh"></span> Reset
						</button>
						<button type="submit" class="btn btn-success">
							<span class="icon-ok"></span> Save
						</button>
					</div>
				</div>
			</div></div>';
			?>
		</p>
	</div>
</div>
<script>
	$(function() {
		$("#tabs").tabs();
		$('#useravatwidth,#useravatheight,#shortmsg,#pageitem').keyup(function() {
			this.value = this.value.replace(/[^0-9\.]/g, '');
		});
		$("input[id^='pageitem'],input[id^='useravat'],input[id^='minpassword']").spinner(5);
	}); 
</script>