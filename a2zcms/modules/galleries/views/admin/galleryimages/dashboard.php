<div id="content" class="col-lg-10 col-sm-11 ">
	<div class="row">
		<div class="page-header">
			<h1>Galleries Image Management</h1>
		</div>
		<div class="pull-right">
			<a class="btn btn-small btn-info iframe cboxElement" href="<?=base_url("admin/galleries/create")?>">
				<span class="icon-plus-sign icon-white"></span> Create</a>
		</div>
		<div class="clearfix"></div>
		<div class="form-group">
			<div class="col-md-12">
				<div class="control-group lesser-inputs ">	
					<label for="useravatheight" class="control-label">Choose gallery</label>	
					<div class="controls">
						<select name="galleryid" id="galleryid" class="form-control">
							<option value=""> </option>
							<?php
							foreach ($content['gallery'] as $gallery) {
								echo "<option value='".$gallery->id."'>".$gallery->title."</option>";
							}
							?>
						</select>
					</div>
				</div>				
				<div id="pictures" name="pictures" class="row"></div>
			</div>
		</div>			
	</div>
</div>
<script>
	$(".iframe").colorbox({
					iframe : true,
					width : "50%",
					height : "70%"
				});
$(function(){
	$("select[name='galleryid']").change(function() {;
		var galleryid = $(this).val();
		$( "#pictures" ).empty();
		if(galleryid>0){
			$.ajax({
				url: 'imageforgallery/'+galleryid,
				type: "GET",
				success: function(r){
					 var response = JSON.parse(r);
					$.each(response, function(key, value){
					    $( "#pictures" ).append( '<div class="col-sm-2 col-xs-6" style="margin-bottom:30px"><img alt="" src="<?=base_url('/data');?>/gallery/'+value.folderid+'/thumbs/'+value.content+'"'
						+ 'class="img-thumbnail"><div class="image-bar"> <i class="icon-eye-open"></i> '+value.hits+' <i class="icon-heart"></i> '+parseInt(parseInt(value.voteup)-parseInt(value.votedown)) 
						+ '<a class="iframe cboxElement" href="<?=base_url()?>admin/galleries/galleryimages_delete/'+value.id+'"><i class="icon-trash"></i></a></div></div>');
			
					});
				}
			});
		}
		else {
			$('#pictures').empty();
			}
	})
})
</script>