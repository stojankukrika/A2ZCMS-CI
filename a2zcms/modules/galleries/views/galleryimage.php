
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
		<h3><a href="<?=base_url('galleries/item/'.$gallery->id)?>"><?=$gallery->title?></a></h3>
	</div>
     <?php
     echo '<div class="row">
     <img src="'.base_url().'/data/gallery/'.$gallery->folderid.'/'. $image->content .'" class="img-responsive"></div>';
	 echo '<p id="vote">Numer of votes <span id="countvote">';
	 	echo $image->voteup-$image->votedown.'</span> ';
	if (!$this->session->userdata("post_image_vote")){
		echo '<br><b><i>You need to be logged in or have permission to add vote. </i></b>';
		}
		else {	?>			
		<span style="display: inline-block;" onclick="contentvote('galleries','1','galleryimage','<?=$image->id?>','countvote')" class="up"></span>
		<span style="display: inline-block;" onclick="contentvote('galleries','0','galleryimage','<?=$image->id?>','countvote')" class="down"></span>
		<?
		}
	echo '</p>
		<!-- the comment box -->
  <div class="well">            
	<h4>'.$image->image_comments.' '.trans('Comments').' </h4>';
	
	if ($image->image_comments>0){
	foreach ($image_comments as $comment){
		echo '<h4><b>'.$comment->fullname.'</b> <small>'.$comment->created_at.'
		|| Numer of votes <span id="commentcountvote'.$comment->id.'">';
	 	echo $comment->voteup-$comment->votedown.'</span> ';
	if (!$this->session->userdata("post_image_vote")){
		echo '<br>(<i>'.trans('PermissionToComment').'</i>)';
		}
		else {	?>			
		<span style="display: inline-block;" onclick="contentvote('galleries','1','gallerycomment','<?=$comment->id?>','commentcountvote<?=$comment->id?>')" class="up"></span>
		<span style="display: inline-block;" onclick="contentvote('galleries','0','gallerycomment','<?=$comment->id?>','commentcountvote<?=$comment->id?>')" class="down"></span>
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
	else if (!$this->session->userdata("manage_gallery_imagecomments")){
	echo '<br><b><i>'.trans('PermissionToComment').'</i></b>';
	}
	else {
	echo '<div class="new_comment">
		<h4>'.trans('AddComment').' </h4>
		<form method="post" action="">
			<div class="form-group">
				';
				$this -> form_builder -> textarea('comment', trans('Comment'), "", 'wysihtml5');
				echo '</div>
				<label id="characterLeft"></label>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-success">'.trans('Submit').'</button>
			</div>
		</form>
	</div>';
	}
	 echo '<hr></div>';
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