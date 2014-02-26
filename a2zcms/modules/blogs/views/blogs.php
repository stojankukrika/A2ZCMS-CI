<br>
<?php
	if(!empty($showBlogs)){
 echo '<div class="row">
  	<div class="col-lg-12 col-md-12">';
	foreach($showBlogs as $item){
		echo '<h3><a href="'.base_url('blogs/item/'.$item->slug).'">'.$item->title.'</a></h3>';
		 if($item->image){
          echo '<img src="'.base_url().'/data/blog/thumbs/'.$item->image.'" class="img-responsive">';
		 }
		echo '<p>'.$item->content.'</p>';
	}
	echo '</div>
</div>
<hr>';
	}