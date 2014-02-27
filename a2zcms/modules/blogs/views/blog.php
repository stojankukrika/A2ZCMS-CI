
<?php $this->load->view('includes/header'); ?>

<div class="container">
	<div class="row">
		
		<?php $this->load->module('menu/menu');
		echo $this->menu->mainmenu('top');
		if(!empty($content['left_content'])) {
		 	echo '<div class="col-xs-6 col-lg-4"><br><br>';
		 	foreach ($content['left_content'] as $item)
			 {
			 	if($item['content']!="")
			 	echo '<div class="well">'.$item['content'].'</div>';
			 }
			 echo "</div>"; 
		}
		if(empty($content['right_content']) && empty($content['left_content'])) {
		echo '<div class="col-xs-12 col-sm-12 col-lg-12"><br>';
		}
		else {
			echo '<div class="col-xs-12 col-sm-6 col-lg-8"><br>';
		}
		?>
		<div class="page-header">
		<h3><?=$blog->title?></h3>
	</div>
         <p><i class="icon-time"></i> Posted on <?=$blog->created_at;?> by <?=$blog->user_id;?></p>
          <hr>
          <?php 
          if($blog->image) { ?>
          <img src="../blog/<?=$blog->image;?>" class="img-responsive">
          <hr>
         <? } ?>
          <p>
			<?= $blog->content?>
			</p>
   		<p>
   			<strong>Resource :</strong><?=$blog->resource_link?>
   		</p>          
     <hr>
     <p id="vote">Numer of votes <span id="countvote"><?=$blog->voteup-$blog->votedown;?></span> 
		<?php
		if (!$this->session->userdata("post_blog_vote")){
		echo '<br><b><i>You need to be logged in and have permission to add vote. </i></b>';
		}
		else {	?>			
		<span style="display: inline-block;" onclick="contentvote('1','blog','<?=$blog->id?>')" class="up"></span>
		<span style="display: inline-block;" onclick="contentvote('0','blog','<?=$blog->id?>')" class="down"></span>
		<?
		}
	echo '</p>
		<!-- the comment box -->
  <div class="well">            
	<h4>'.$blog->blog_comments.' comments</h4>';
	
	if ($blog->blog_comments>0){
	foreach ($blog_comments as $comment){
		echo '<h4><b>'.$comment->user_id.'</b>
				<small>	'.$comment->created_at.'</small>
				</h4><p>'.$comment->content.'</p>';
		}
	}
	else {
	echo '<hr />';
	}
	echo '</div>';
	
	if (! $this->session->userdata("user_id")){
	echo 'To add comment you need to login.
	<br />
	<br />
	Click <a href="'.base_url('user/login').'">here</a> to login
	<br>';
	}
	else if (!$this->session->userdata("post_blog_comment")){
	echo '<br><b><i>You do not have a permittion to add comment</i></b>';
	}
	else {
	echo '<div class="new_comment">
		<h4>Add comment </h4>
		<form method="post" action="">
			<div class="form-group">
				<textarea class="form-control" name="comment" id="comment" placeholder="comment" rows="7"></textarea>
				<label id="characterLeft"></label>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-success">Submit</button>
			</div>
		</form>
	</div>';
	}
     echo '</div>';
		if(!empty($content['right_content'])) {
			echo '<div class="col-xs-6 col-lg-4"><br><br>';
			foreach ($content['right_content'] as $item)
			 {
			 	if($item['content']!="")
			 	echo '<div class="well">'.$item['content'].'</div>';
			 }
			  echo "</div>"; 
			}
		?>
	</div>
</div>
<?php $this->load->view('includes/footer'); ?>