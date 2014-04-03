<h4><?=trans('NewGaleries')?></h4>
  <div class="row">
    <div class="col-lg-12">
      <ul class="list-unstyled">
      	<?php
      		foreach($newGalleries as $item){
         		echo '<li><a href="'.base_url('galleries/item/'.$item->id).'">'.$item->title.'</a></li>';
         		}
		?>
      </ul>
     </div>
  </div>