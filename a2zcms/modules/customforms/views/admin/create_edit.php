<!-- Tabs -->
<ul class="nav nav-tabs">
	<li class="active">
		<a href="#tab-general" data-toggle="tab">General</a>
	</li>
	<li class="">
		<a href="#tab-dates" data-toggle="tab">Fields</a>
	</li>
</ul>
<!-- ./ tabs -->

<form class="form-horizontal" enctype="multipart/form-data"  method="post" action="" autocomplete="off">
	<!-- Tabs Content -->
	<div class="tab-content">
		<!-- General tab -->
		<div class="tab-pane active" id="tab-general">
			<!-- Title -->
			<div class="form-group">
				<div class="col-md-12">
					<label class="control-label" for="title">Title</label>
					<input class="form-control" type="text" name="title" id="title" value="<?=(isset($content['customform_edit']->title))?$content['customform_edit']->title:""?>" />
				</div>
			</div>
			<!-- ./ title -->

			<!-- Recievers -->
			<div class="form-group">
				<div class="col-md-12">
					<label class="control-label" for="recievers">Recievers 
						<small>(Disassemble the different recievers ​​with a semicolon)</small></label>
					<input class="form-control" type="text" name="recievers" id="recievers" value="<?=(isset($content['customform_edit']->recievers))?$content['customform_edit']->recievers:""?>" />
				</div>
			</div>
			<!-- ./ resource recievers -->
			<!-- Content -->
			<div class="form-group">
				<div class="col-md-12">
					<label class="control-label" for="message">Message</label>
					<textarea class="form-control full-width wysihtml5" name="message" value="message" rows="10">
						<?=(isset($content['customform_edit']->message))?$content['customform_edit']->message:""?>
					</textarea>
				</div>
			</div>
			<!-- ./ content -->
		</div>
		<!-- ./ general tab -->
		
		<!-- Dates tab -->
		<div class="tab-pane" id="tab-dates">
			<a class="btn btn-link" id="add" href="#"><i class="icon-plus-sign"></i> Add filed</a>
			<div id="fields">
				<div class="row responsive-utilities-test">
					<div class="col-md-10 col-xs-10" id="form_fields">
						<label class="control-label"><b>** Disassemble the different values in options ​​with a semicolon **</b></label>
						<div class="clearfix"></div>
						<ul id="sortable1">
							<input type="hidden" value="<?=isset($content['customformfields_count'])?$content['customformfields_count']:0?>" name="count" id="count">
							<input type="hidden" value="" name="pagecontentorder" id="pagecontentorder">
							<?php $id=1;
							if(!empty($content['customformfields'])){
								foreach($content['customformfields'] as $item) { ?>								
									<li class="ui-state-default" name="formf" value="<?=$item->id?>" id="formf<?=$item->id?>">
										<label class="control-label" for="name">Fild name</label>
										<input type="text" id="name<?=$item->id?>" value="<?=$item->name?>" name="name<?=$item->id?>">
										<div>
											<label class="control-label" for="mandatory">Mandatory </label>
											<select name="mandatory<?=$item->custom_form_id?>" id="mandatory<?=$item->id?>"> 
												<option value="1" <?=($item->mandatory=='1')?"selected":"";?>>No</option>
										  		<option value="2" <?=($item->mandatory=='2')?"selected":"";?>>Yes</option>
										  		<option value="3" <?=($item->mandatory=='3')?"selected":"";?>>Only numbers</option>
										  		<option value="4" <?=($item->mandatory=='4')?"selected":"";?>>Valid email</option>
											</select>
											<label class="control-label" for="type">Type </label>
											<select name="type<?=$item->custom_form_id?>" id="type<?=$item->id?>"> 
												<option value="1" <?=($item->type=='1')?"selected":"";?>>Input field</option>
												<option value="2" <?=($item->type=='2')?"selected":"";?>>Text area</option>
												<option value="3" <?=($item->type=='3')?"selected":"";?>>Select</option>
												<option value="4" <?=($item->type=='4')?"selected":"";?>>Radio</option>
												<option value="5" <?=($item->type=='5')?"selected":"";?>>Upload</option>
												<option value="6" <?=($item->type=='6')?"selected":"";?>>Checkbox</option>
											</select>
										</div>
											<label class="control-label" for="options"> Options</label>
											<input type="text" name="options<?=$item->id?>" value="<?=$item->options?>" id="options<?=$item->id?>">
										<a class="btn btn-default btn-sm btn-small remove"><span class="icon-trash"><input type="hidden" value="<?=$item->id?>" class="remove" name="remove"></span></a>
										
									</li>
									<?php $id++;
									}
								}?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- ./ dates tab -->
	</div>
	<!-- ./ tabs content -->
	<!-- Form Actions -->	
	<div class="form-group">
		<div class="col-md-12">
			<button type="reset" class="btn btn-link close_popup">
				<span class="icon-remove"></span>  Cancel
			</button>
			<button type="reset" class="btn btn-default">
				<span class="icon-refresh"></span> Reset
			</button>
			<button type="submit" class="btn btn-success">
				<span class="icon-ok"></span> Save
			</button>
		</div>
	</div>
	<!-- ./ form actions -->
</form>
<div class="hidden" id ="addfield">
	<li id="formf" class="ui-state-default" name="formf" value="formf">
		<label class="control-label" for="name">Fild name</label>
		<input id="name" type="text" value="" name="name">
		<div>
			<label class="control-label" for="mandatory">Mandatory </label>
			<select id="mandatory" name="mandatory"> 
				<option value="1">No</option>
		  		<option value="2">Yes</option>
		  		<option value="3">Only numbers</option>
		  		<option value="4">Valid email</option>
			</select>
			<label class="control-label" for="type">Type </label>
			<select id="type" name="type"> 
				<option value="1">Input field</option>
				<option value="2">Text area</option>
				<option value="3">Select</option>
				<option value="4">Radio</option>
				<option value="5">Upload</option>
				<option value="6">Checkbox</option>
			</select>
		</div>		
		<label class="control-label" for="options"> Options </label>
		<input  id="options" type="text" name="options" value="">
		<a class="btn btn-default btn-sm btn-small remove">
			<span class="icon-trash">
			</span>
		</a>									
	</li>
</div>


<script type="text/javascript">
var clicked = 0;
$('.remove').click(function(){
	clicked = $(this).children().children().val();
	$.ajax({
            url : "<?=base_url('admin/customforms/deleteitem/' . ((isset($content['customform_edit']->id))?$content['customform_edit']->id:""));?>"
            , type : "post"
            , data : { id : clicked }
            , success : function(resp){
            	 if( resp == 0){
            	 	$("#formf"+clicked).remove();
            	 	//window.location.replace("");
                }
            }
        	});
});
 	 
	$(function() {
		var formfild =$('#addfield').html();
		$("#add").click(function(){
			var count = 0;
			
			count = parseInt( $('#count').val(), 10) + 1;;
			
			formfild = formfild.split('<li id="formf" class="ui-state-default" name="formf" value="formf">').join('<li id="formf'+count+'" class="ui-state-default" name="formf'+count+'" value="'+count+'" >');
			formfild = formfild.split('<input id="name" value="" name="name" type="text">').join('<input id="name'+count+'" value="" name="name'+count+'" type="text">');
			formfild = formfild.split('<select id="mandatory" name="mandatory">').join('<select id="mandatory'+count+'" name="mandatory'+count+'">');
			formfild = formfild.split('<select id="type" name="type">').join('<select id="type'+count+'" name="type'+count+'">');
			formfild = formfild.split('<input id="options" name="options" value="" type="text">').join('<input id="options'+count+'" name="options'+count+'" value="" type="text">');
			formfild = formfild.split('<a class="btn btn-default btn-sm btn-small remove">').join('<a class="btn btn-default btn-sm btn-small remove id-'+count+'">');


			$("#sortable1").append(formfild);
			$('#count').val(count);
			
			$('.id-'+count).children().append('<input class="remove" type="hidden" name="remove" value="'+count+'">');
			
		})
		$( "#sortable1" ).sortable();
		
		$('.btn-success').click(function(){
		 	var neworder = new Array();
	        $('#sortable1 li').each(function() { 
	            var name  = $(this).children('[name^="name"]').attr("value");
	            var mandatory  = $(this).children().children('[name^="mandatory"]').attr("value");
	            var type  = $(this).children().children('[name^="type"]').attr("value");
	            var options  = $(this).children().children('[name^="options"]').attr("value");
	            neworder.push(name);
	            neworder.push(mandatory);
	            neworder.push(type);
	            neworder.push(options);
	        });
	        $('#pagecontentorder').val(neworder);
        });
	});
</script>
<style>
ul
{
    list-style-type: none;
}
</style>
