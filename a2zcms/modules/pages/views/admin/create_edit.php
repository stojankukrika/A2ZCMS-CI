<!-- Tabs -->
<ul class="nav nav-tabs">
	<li class="active">
		<a href="#tab-general" data-toggle="tab">General</a>
	</li>
	<li class="">
		<a href="#tab-meta-data" data-toggle="tab">Meta data</a>
	</li>
	<li class="">
		<a href="#tab-css" data-toggle="tab">Page CSS</a>
	</li>
	<li class="">
		<a href="#tab-javascript" data-toggle="tab">Page Java Script</a>
	</li>
	<li class="">
		<a href="#tab-grid" data-toggle="tab">Page Grid</a>
	</li>
</ul>
<!-- ./ tabs -->
<form class="form-horizontal" method="post" action="" autocomplete="off">
	<!-- Tabs Content -->
	<div class="tab-content">
		<!-- General tab -->
		<div class="tab-pane active" id="tab-general">
			<!-- Name -->
			<div class="form-group">
				<label class="col-md-2 control-label" for="title">Name</label>
				<div class="col-md-10">
					<input class="form-control" type="text" name="title" id="title" value="<?=(isset($content['page_edit']->title))?$content['page_edit']->title:"";?>" />
				</div>
			</div>
			<!-- ./ name -->
		<!-- Show image -->
			<div class="form-group">
				<div class="col-lg-12">
					<label class="control-label" for="image">Image</label>
					<input name="image" type="file" class="uploader" id="image" value="Upload" /> 
				</div>
			</div>
			<!-- ./ show image -->
			<!-- Show Title -->
			<div class="form-group">
				<div class="col-lg-12">
					<?php
						$radios = '';
						$radios[] = (object) array('id' => 1, 'name' => 'Yes');
						$radios[] = (object) array('id' => 0, 'name' => 'No');
					
						$this -> form_builder -> radio('showtitle', 'Show Title', $radios, (isset($content['page_edit']->showtitle))?$content['page_edit']->showtitle:"1", 'form-control');							
					?>	
				</div>
			</div>
			<!-- ./ show title name -->
			
			<!-- Show Date -->
			<div class="form-group">
				<div class="col-lg-12">
					<?php
						$radios = '';
						$radios[] = (object) array('id' => 1, 'name' => 'Yes');
						$radios[] = (object) array('id' => 0, 'name' => 'No');
					
						$this -> form_builder -> radio('showdate', 'Show Date', $radios, (isset($content['page_edit']->showdate))?$content['page_edit']->showdate:"1", 'form-control');							
					?>	
				</div>
			</div>
			<!-- ./ show date -->
			
			<!-- Show Vote -->
			<div class="form-group">
				<div class="col-lg-12">
					<?php
						$radios = '';
						$radios[] = (object) array('id' => 1, 'name' => 'Yes');
						$radios[] = (object) array('id' => 0, 'name' => 'No');
					
						$this -> form_builder -> radio('showvote', 'Show Vote', $radios, (isset($content['page_edit']->showvote))?$content['page_edit']->showvote:"1", 'form-control');							
					?>	
				</div>
			</div>
			<!-- ./ show vote -->
			
			<!-- Show Tags -->
			<div class="form-group">
				<div class="col-lg-12">
					<?php
						$radios = '';
						$radios[] = (object) array('id' => 1, 'name' => 'Yes');
						$radios[] = (object) array('id' => 0, 'name' => 'No');
					
						$this -> form_builder -> radio('showtags', 'Show Tags', $radios, (isset($content['page_edit']->showtags))?$content['page_edit']->showtags:"1", 'form-control');							
					?>
				</div>
			</div>
			<!-- ./ show tags -->
			
			<!-- Show sidebar -->
			<div class="form-group">
				<div class="col-lg-12">
					<?php
						$radios = '';
						$radios[] = (object) array('id' => 0, 'name' => 'Left');
						$radios[] = (object) array('id' => 1, 'name' => 'Right');
					
						$this -> form_builder -> radio('sidebar', 'Sidebar Position', $radios, (isset($content['page_edit']->sidebar))?$content['page_edit']->sidebar:"1", 'form-control');							
					?>	
				</div>
			</div>
			<!-- ./ show sidebar -->

			<!-- Show Password Protected -->
			<div class="form-group">
				<div class="col-lg-12">
					<label class="control-label" for="passwordprotect">Password Protected</label>
					<input type="password" name="password" id="password" value="<?=(isset($content['page_edit']->password))?$content['page_edit']->password:""?>" class="form-control input-sm" />
				</div>
			</div>
			<!-- ./ show password -->
			
			<!-- Show tags -->
			<div class="form-group">
				<div class="col-lg-12">
					<label class="control-label" for="tags">Tags</label>
					<input type="text" name="tags" id="tags" value="<?=(isset($content['page_edit']->tags))?$content['page_edit']->tags:""?>" class="form-control input-sm" />
				</div>
			</div>
			<!-- ./ show tags -->
			
			<!-- Content -->
			<div class="form-group">
				<div class="col-lg-12">
					<label class="control-label" for="content">Content</label>
					<textarea class="full-width col-md-12 wysihtml5" name="content" value="content" rows="10" class="form-control"><?=(isset($content['page_edit']->content))?$content['page_edit']->content:""?></textarea>
				</div>
			</div>
			<!-- ./ content -->

			<!-- Status -->
			<div class="form-group">
				<div class="col-md-12">
					<?php
					$options[] = (object) array('id' => '1', 'name' => 'Active');
					$options[] = (object) array('id' => '0', 'name' => 'Inactive');
					$this -> form_builder -> option('status', 'Status', $options, (isset($content['page_edit']->status))?$content['page_edit']->status:"", 'form-control');							
					
					?>
				</div>
			</div>
			<!-- ./ Status -->
		</div>
		<!-- ./ general tab -->

		<!-- Meta Data tab -->
		<div class="tab-pane" id="tab-meta-data">
			<!-- Meta Title -->
			<div class="form-group">
				<div class="col-md-12">
					<label class="control-label" for="meta_title">Meta title</label>
					<input class="form-control" type="text" name="meta_title" id="meta_title" value="<?=(isset($content['page_edit']->meta_title))?$content['page_edit']->meta_title:""?>" />
				</div>
			</div>
			<!-- ./ meta title -->

			<!-- Meta Description -->
			<div class="form-group">
				<div class="col-md-12 controls">
					<label class="control-label" for="meta_description">Meta description</label>
					<input class="form-control" type="text" name="meta_description" id="meta_description" value="<?=(isset($content['page_edit']->meta_description))?$content['page_edit']->meta_description:""?>" />
				</div>
			</div>
			<!-- ./ meta description -->

			<!-- Meta Keywords -->
			<div class="form-group">
				<div class="col-md-12">
					<label class="control-label" for="meta_keywords">Meta Keywords</label>
					<input class="form-control" type="text" name="meta_keywords" id="meta_keywords" value="<?=(isset($content['page_edit']->meta_keywords))?$content['page_edit']->meta_keywords:""?>" />
				</div>
			</div>
			<!-- ./ meta keywords -->
		</div>
		<!-- ./ meta data tab -->	
		
		<!-- CSS tab -->
		<div class="tab-pane" id="tab-css">
			<!-- Content -->
			<div class="form-group">
				<div class="col-lg-12">
					<label class="control-label" for="page_css">Page CSS</label>
					<textarea class="full-width col-md-12 wysihtml5" name="page_css" value="page_css" rows="8" class="form-control"><?=(isset($content['page_edit']->page_css))?$content['page_edit']->page_css:""?></textarea>
				</div>
			</div>
			<!-- ./ content -->
		</div>
		<!-- ./ css tab -->
		
		<!-- Javascript tab -->
		<div class="tab-pane" id="tab-javascript">
			<!-- Content -->
			<div class="form-group">
				<div class="col-lg-12">
					<label class="control-label" for="page_javascript">Page Java Script</label>
					<textarea class="full-width col-md-12 wysihtml5" name="page_javascript" value="page_javascript" rows="8" class="form-control"><?=(isset($content['page_edit']->page_javascript))?$content['page_edit']->page_javascript:""?></textarea>
				</div>
			</div>
			<!-- ./ content -->
		</div>
		<!-- ./ Javascript tab -->
		
		<!-- Grid tab -->
		<div class="tab-pane" id="tab-grid">
			<!-- Content -->
			<?php
			$result = '';
				$result .='<div id="grids">
					<div class="row responsive-utilities-test hidden-on">
					<div class="col-md-8 col-xs-8">
						  	<label class="control-label" for="sortable1">Content</label><br>
						<ul id="sortable1">
							<input type="hidden" value="" name="pagecontentorder" id="pagecontentorder">';
								foreach($content['pluginfunction_content'] as $item){
								 $result .= '<li class="ui-state-default" name="pagecontent['.$item->id.']" value="'.$item->id.'">
									'.$item->title.'
									<div>';
										if(isset($item->sorts) && $item->sorts != "" || strpos($item->params,'sort') !== false){
										$result .= '<label class="control-label" for="sort">Sorting</label>
											<select name="pagecontent['.$item->id.'][sort]" id="sort'.$item->id.'"> 
											  <option value="ASC" '.((!isset($item->sorts) || (isset($item->sorts) && $item->sorts=="ASC"))?"selected":"").'>Ascending</option>
											  <option value="DESC" '.((isset($item->sorts) && $item->sorts=="DESC")?"selected":"").'>Descending</option>
											</select>';
										}
										if(isset($item->orders) && $item->orders != "" || strpos($item->params,'order') !== false){
										$result .= '<label class="control-label" for="order">Order</label>
											<select name="pagecontent['.$item->id.'][order]" id="order'.$item->id.'"> 
											  <option value="id" '. ((!isset($item->orders) || (isset($item->orders) && $item->orders=="id"))?"selected":"").'>ID</option>
											  <option value="views" '.((isset($item->orders) && $item->orders=="views")?"selected":"").'>Views</option>
											</select>';
										}
										if(isset($item->limits) && $item->limits != "" || strpos($item->params,'limit') !== false){
										$result .= '<label class="control-label" for="limit">Limit</label>
											<input type="text" name="pagecontent['.$item->id.'][limit]" value="'.((isset($item->limits) && $item->limits!="")?$item->limits:"0").'" id="limit'.$item->id.'">';
											}
										if(isset($item->ids) && $item->ids != "" || strpos($item->params,'id') !== false){
										$result .= '<div class="controls">
											<label class="control-label" for="id">Items</label>
											  <select id="id'.$item->id.'" name="pagecontent['.$item->id.'][id][]" class="form-control" multiple data-rel="chosen">';
												if(!empty($item->function_id)){
													foreach ($item->function_id as $items){
														foreach($items as $id){										
															if($id->id!="")
															$result .= '<option value="'.$id->id.'" '.((isset($item->ids) && strpos($item->ids,(string)$id->id) !== false)?'selected="selected"':'').'>'.$id->id.' '.$id->title.'</option>';
														}
													}
												}
											  $result .= '</select>
											</div>';
										}
										if(isset($item->grids) && $item->grids != "" || strpos($item->params,'grid') !== false){							
										$result .= '<div class="controls">
											<label class="control-label" for="selectError1">Select groups</label>
											  <select id="grid'.$item->id.'" name="pagecontent['.$item->id.'][grid][]" class="form-control" multiple data-rel="chosen">';
												if(!empty($item->function_grid)){
													foreach ($item->function_grid as $items){
														foreach($items as $id){
															if($id->id!="")
															$result .= '<option value="'.$id->id.'"'.((isset($item->grids) && strpos($item->grids,$id->id) !== false)?'selected="selected"':'').'>'.$id->title.'</option>';
														}
													}
												}
											  $result .= '</select>
											</div>';
										}										
									 $result .= '</div>
								</li>';
								}
						 $result .= '</ul>
					  </div>
					  <div class="col-md-4 col-xs-4">
					  	<label class="control-label" for="sortable2">Sidebar Widgets</label><br>
						<ul id="sortable2">';
							foreach($content['pluginfunction_slider'] as $item){
								 $result .= '<li class="ui-state-default"><input type="checkbox" '.((isset($item->order) && $item->order!='')?'checked':'') .' value="'.$item->id.'" name="pagesidebar[]"> '.$item->title.'</li>';
								 }
						$result .= '</ul>
					  </div>
					  </div>
			</div>
		</div>';
		echo $result;
	?>					
				
	</div>
	<!-- ./ tabs content -->

	<!-- Form Actions -->
	<div class="form-group">
		<div class="col-md-12">
			<button type="reset" class="btn btn-link close_popup">
				<span class="icon-remove"></span> Cancel
			</button>
			<button type="reset" class="btn btn-default">
				<span class="icon-refresh"></span> Reset
			</button>
			<button type="submit" class="btn btn-success">
				<span class="icon-ok"></span>Save
			</button>
		</div>
	</div>
	<!-- ./ form actions -->
</form>
<script type="text/javascript">
	$(function() {
		$( "#sortable1, #sortable2" ).sortable({
			items: "li:not(.ui-state-disabled)",
		});
		$('#tags').tagit();        
	});
	 $("input[id^='limit']").spinner(5);
	 $('.btn-success').click(function(){
	 	 var neworder = new Array();
        $('#sortable1 li').each(function() { 
            //get the id
            var id  = $(this).attr("value");
             neworder.push(id);

        });
        $('#pagecontentorder').val(neworder);
        $("select[id^='id'],select[id^='grid']").multiselect({selectedList: 0}) // 0-based index;
	 })
	
</script>
