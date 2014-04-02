
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
         <p><i class="icon-time"></i> <?=trans('PostedOn')?> <?=$blog->created_at;?> <?=trans('By')?> <?=$blog->fullname;?></p>
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
   			<strong><?=trans('Resource')?> :</strong><?=$blog->resource_link?>
   		</p>          
     <hr>
     <p id="vote"><?=trans('NumerOfVotes')?> <span id="countvote"><?=$blog->voteup-$blog->votedown;?></span> 
		<?php
		if (!$this->session->userdata("post_blog_vote")){
		echo '<br><b><i>'.trans('LoginToVote').' </i></b>';
		}
		else {	?>			
		<span style="display: inline-block;" onclick="contentvote('blogs','1','blog','<?=$blog->id?>','countvote')" class="up"></span>
		<span style="display: inline-block;" onclick="contentvote('blogs','0','blog','<?=$blog->id?>','countvote')" class="down"></span>
		<?
		}
	echo '</p>
		<!-- the comment box -->
  <div class="well">            
	<h4>'.$blog->blog_comments.' '.trans('Comments').'</h4>';
	
	if ($blog->blog_comments>0){
	foreach ($blog_comments as $comment){
		echo '<h4><b>'.$comment->fullname.'</b>
				<small>	'.$comment->created_at.'
		|| Numer of votes <span id="commentcountvote'.$comment->id.'">';
	 	echo $comment->voteup-$comment->votedown.'</span> ';
	if (!$this->session->userdata("post_image_vote")){
		echo '<br>(<i>'.trans('LoginToVote').'</i>)';
		}
		else {	?>			
		<span style="display: inline-block;" onclick="contentvote('blogs','1','blogcomment','<?=$comment->id?>','commentcountvote<?=$comment->id?>')" class="up"></span>
		<span style="display: inline-block;" onclick="contentvote('blogs','0','blogcomment','<?=$comment->id?>','commentcountvote<?=$comment->id?>')" class="down"></span>
		<?
		}
	echo '</small>
				</h4><p>'.$comment->content.'</p>';
		}
	}
	else {
	echo '<hr />';
	}
	echo '</div>';
	
	if (! $this->session->userdata("user_id")){
	echo trans('LoginToComment').'<br />
	<br />
	'.trans('Click').' <a href="'.base_url('user/login').'">here</a> '.trans('ToLogin').'
	<br>';
	}
	else if (!$this->session->userdata("post_blog_comment")){
	echo '<br><b><i>'.trans('PermissionToComment').'</i></b>';
	}
	else {
	echo '<div class="new_comment">
		<h4>'.trans('AddComment').' </h4>
		<form method="post" action="">
			<div class="form-group">			
				<div class="col-md-12">';
				$this -> form_builder -> textarea('comment', 'Comment', "", 'wysihtml5');
				echo '</div>
				<label id="characterLeft"></label>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-success">'.trans('Submit').'</button>
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