<?php 
echo '<div class="row"><h2>'.trans('PasswordProtected').'</h2>
	<form class="form-inline" method="post" action="'.base_url('pages/index/'.$page->id).'">
		<div class="input-group">
		      <input type="password" name="pagepass" class="form-control" value="" 
		      placeholder="'.trans('EnterPasswordToShowPage').'" />
		      <span class="input-group-btn">
		        <button class="btn btn btn-success" name="pageprotect" type="submit">'.trans('Enter').'</button>
		      </span>
		    </div>
		<input type="hidden" name="pageid" value="'.$page->id.'" />		
		</form>
</div>';
?> 
