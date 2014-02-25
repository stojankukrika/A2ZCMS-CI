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
	echo '<p id="tags"><i class="icon-tags"></i>'.$page->tags.'</p>';
	echo '<hr></div>';
}
?> 
