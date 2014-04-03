<h4><?=trans('NewBlogs')?></h4>
  <div class="row">
    <div class="col-lg-12">
      <ul class="list-unstyled">
      	<?php
      		foreach($newBlogs as $item){
         		echo '<li><a href="'.base_url('blogs/item/'.$item->slug).'">'.$item->title.'</a></li>';
         		}
		?>
      </ul>
     </div>
  </div>