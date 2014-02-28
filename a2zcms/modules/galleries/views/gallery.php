
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
		<h3><?=$gallery->title?></h3>
	</div>
         <p><i class="icon-time"></i> Posted on 
         	<?=$gallery->created_at;?> by <?=$gallery->fullname;?></p>
          <hr> 
    <div class="row"> 
     <? foreach ($gallery_images as $item){
	 echo '<div class="col-md-3 portfolio-item">
      	<a href="'.base_url('galleries/galleryimage/'.$gallery->id.'/'.$item->id).'">
      		<img src="'.base_url().'/data/gallery/'.$gallery->folderid.'/thumbs/'. $item->content .'" height="85px" width="150px" class="img-responsive">
      	</a>
      </div>';
      }	
	 echo '</div>
     <hr></div>';
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