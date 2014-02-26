 <br>
 <?php
 if(empty($showImages)){
	 	if(!empty($showGallery)){
		 	echo '<div class="row">';
			foreach($showGallery as $item){
				echo '<div class="col-lg-4 col-md-4">
						<h3><a href="'.base_url('galleries/item/'.$item->id).'">'.$item->title.'</a></h3>
				</div>';
			}
			echo '</div>';
		}
  }
  else {  
 	 if(!empty($showGallery)){
 	echo '<div class="row">';
		foreach($showGallery as $item){		
			echo '<h3><a href="'.base_url('galleries/item/'.$item->id).'">'.$item->title.'</a></h3>
				<p>';
			  	foreach ($showImages[$item->id] as $img){
			  	echo '<div class="col-lg-3 col-md-3">
			  		<img src="'.base_url().'data/gallery/'.$item->folderid.'/thumbs/'.$img->content.'" />				  	
	     	 	</div>';
				}
	            echo '</p>';
		}			
	echo '</div>';
	 }	
  }	
 echo '<hr>';
 	