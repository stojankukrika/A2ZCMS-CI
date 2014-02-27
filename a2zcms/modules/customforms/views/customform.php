
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
if(!empty($showCustomFormId)){
 echo '<div class="row">
  	<div class="col-lg-12 col-md-12"><div class="page-header">
		<h3>'.$showCustomFormId->title.'</h3>
	</div>
	<form action="" method="post" enctype="multipart/form-data">';
				foreach($showCustomFormFildId as $field){
						echo '<div class="col-lg-6 form-group">'.$field->name.'</div>
						<div class="col-lg-6 form-group">';
								switch ($field->type) {
									case '1':
										echo '<input type="text" class="form-control" name="'.url_title($field->name, 'dash', true).'" value=""/>';
								 		break;
									case '2':
										echo '<textarea  class="form-control" rows="6" name="'.url_title($field->name, 'dash', true).'" /></textarea>';
								  		break;
									case '3':
										 echo '<select class="form-control" name="'.url_title($field->name, 'dash', true).'">';
							            		$options = rtrim($field->options, ";");
												$options = explode(';', $options);
												foreach ($options as $value) {
													echo "<option value='".url_title($value, 'dash', true)."'>".$value."</option>";
												}
							            echo '</select>';
							            break;
									case '4':
										$options = rtrim($field->options,";");
										$options = explode(';', $options);
										foreach ($options as $value) {
											echo "<input  class='form-control' type='radio' name='".url_title($field->name, 'dash', true)."' value='".url_title($value, 'dash', true)."'>".$value."<br>";
										}
										break;
									case '5':
										echo '<input type="file"  class="form-control" name="'.url_title($field->name, 'dash', true).'" value="">';
										break;
									case '6':
										$options = rtrim($field->options,";");
										$options = explode(';', $options);
										foreach ($options as $value) {
											echo "<input  class='form-control' type='checkbox' name='".Str::slug($field->name)."' value='".Str::slug($value)."'>".$value."<br>";
										}
										break;
								}					
						echo '</div>';
						}
				echo '<input class="btn btn-primary" type="submit" value="Submit">
				</form>';
	echo '</div>	
</div> 
<hr>';
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
