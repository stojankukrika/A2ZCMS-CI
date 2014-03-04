<?php 
echo '<div class="row"><h2>Password protected</h2>
	<form class="form-inline" method="post" action="'.base_url('pages/index/'.$page->id).'">
		<div class="input-group">
		      <input type="password" name="pagepass" class="form-control" value="" 
		      placeholder="Enter password to show page" />
		      <span class="input-group-btn">
		        <button class="btn btn btn-success" name="pageprotect" type="submit">Enter</button>
		      </span>
		    </div>
		<input type="hidden" name="pageid" value="'.$page->id.'" />		
		</form>
</div>';
?> 
