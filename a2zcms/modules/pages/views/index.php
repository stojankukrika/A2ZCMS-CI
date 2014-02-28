<?php 
if(isset($page)){
echo '<div class="row">';
 	if($page->showtitle=='1') 
	echo '<h1>'.$page->title.'</h1>';

	if($page->showdate=='1') 
	echo '<p><i class="icon-time"></i>Posted on '.$page->created_at.'</p>';

	echo '<hr>';
	if($page->image)
		echo '<img src="../page/'.$page->image.'" class="img-responsive">
  	<hr>';
  	echo '<p>
		'.$page->content.'
	</p>';
	if($page->showtags=='1') 
	echo '<p id="tags">Tags: '.$page->tags.'</p>';
	if($page->showvote=='1'){
	echo '<p id="vote">Num of votes <span id="countvote">';
	echo $page->voteup-$page->votedown;
	echo '</span>'; 
		if (!$this->session->userdata("user_id")){
		echo '<br><b><i>You need to be logged in or have permission to add vote. </i></b>';
		}	
		else{ ?>		
		<span style="display: inline-block;" onclick="contentvote('pages','1','page',<?=$page->id;?>,'countvote')" class="up"></span>
		<span style="display: inline-block;" onclick="contentvote('pages','0','page',<?=$page->id;?>,'countvote')" class="down"></span>
		<?}
	echo '</p>';
	}
	echo '<hr></div>';
}
?> 
