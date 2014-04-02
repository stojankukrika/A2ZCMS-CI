<!-- Tabs -->
<ul class="nav nav-tabs">
	<li class="active">
		<a href="#tab-general" data-toggle="tab"><?=trans('General')?></a>
	</li>
	<li class="">
		<a href="#tab-dates" data-toggle="tab"><?=trans('Fields')?></a>
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
				<?
					$this -> form_builder -> text('title', trans('Title'), isset($content['customform_edit']->title)?$content['customform_edit']->title:"", 'form-control');
				?>
				</div>
			</div>
			<!-- ./ title -->

			<!-- Recievers -->
			<div class="form-group">
				<div class="col-md-12">
				<?
					$this -> form_builder -> text('recievers', trans('Recievers'), isset($content['customform_edit']->recievers)?$content['customform_edit']->recievers:"", 'form-control');
				?>
				<small>(<?=trans('RecieversDesc')?>)</small>
				</div>
			</div>
			<!-- ./ resource recievers -->
			<!-- Content -->
			<div class="form-group">
				<div class="col-md-12">
					<div class="col-md-12">
						<?
							$this -> form_builder -> textarea('message', trans('Message'), isset($content['customform_edit']->message)?$content['customform_edit']->message:"", 'wysihtml5');
						?>
					</div>
				</div>
			</div>
			<!-- ./ content -->
		</div>
		<!-- ./ general tab -->
		
		<!-- Dates tab -->
		<div class="tab-pane" id="tab-dates">
			<a class="btn btn-link" id="add" href="#"><i class="icon-plus-sign"></i> <?=trans('AddFiled')?></a>
			<div id="fields">
				<div class="row responsive-utilities-test">
					<div class="col-md-10 col-xs-10" id="form_fields">
						<label class="control-label"><b>** <?=trans('AddFiledDesc')?> **</b></label>
						<div class="clearfix"></div>
						<ul id="sortable1">
							<input type="hidden" value="<?=isset($content['customformfields_count'])?$content['customformfields_count']:0?>" name="count" id="count">
							<input type="hidden" value="" name="pagecontentorder" id="pagecontentorder">
							<?php $id=1;
							if(!empty($content['customformfields'])){
								foreach($content['customformfields'] as $item) { ?>								
									<li class="ui-state-default" name="formf" value="<?=$item->id?>" id="formf<?=$item->id?>">
										<?
											$this -> form_builder -> text('name'.$item->id, trans('FildName'), $item->name, '');
										?><div>
											<label class="control-label" for="mandatory"><?=trans('Mandatory')?> </label>
											<select name="mandatory<?=$item->customform_id?>" id="mandatory<?=$item->id?>"> 
												<option value="1" <?=($item->mandatory=='1')?"selected":"";?>><?=trans('No')?></option>
										  		<option value="2" <?=($item->mandatory=='2')?"selected":"";?>><?=trans('Yes')?></option>
										  		<option value="3" <?=($item->mandatory=='3')?"selected":"";?>><?=trans('OnlyNumbers')?></option>
										  		<option value="4" <?=($item->mandatory=='4')?"selected":"";?>><?=trans('ValidEmail')?></option>
											</select>
											<label class="control-label" for="type"><?=trans('Type')?> </label>
											<select name="type<?=$item->customform_id?>" id="type<?=$item->id?>"> 
												<option value="1" <?=($item->type=='1')?"selected":"";?>><?=trans('InputField')?></option>
												<option value="2" <?=($item->type=='2')?"selected":"";?>><?=trans('TextArea')?></option>
												<option value="3" <?=($item->type=='3')?"selected":"";?>><?=trans('Select')?></option>
												<option value="4" <?=($item->type=='4')?"selected":"";?>><?=trans('Radio')?></option>
												<option value="5" <?=($item->type=='5')?"selected":"";?>><?=trans('Upload')?></option>
												<option value="6" <?=($item->type=='6')?"selected":"";?>><?=trans('Checkbox')?></option>
											</select>
										</div>
											<label class="control-label" for="options"> <?=trans('Options')?></label>
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
			<button type="reset" class="btn btn-warning close_popup">
				<span class="icon-remove"></span> <?=trans('Cancel')?>
			</button>
			<button type="reset" class="btn btn-default">
				<span class="icon-refresh"></span> <?=trans('Reset')?>
			</button>
			<button type="submit" class="btn btn-success">
				<span class="icon-ok"></span><?=trans('Save')?>
			</button>
		</div>
	</div>
	<!-- ./ form actions -->
</form>
<div class="hidden" id ="addfield">
	<li id="formf" class="ui-state-default" name="formf" value="formf">
		<label class="control-label" for="name"><?=trans('FildName')?></label>
		<input id="name" type="text" value="" name="name">
		<div>
			<label class="control-label" for="mandatory"><?=trans('Mandatory')?> </label>
			<select id="mandatory" name="mandatory"> 
				<option value="1"><?=trans('No')?></option>
		  		<option value="2"><?=trans('Yes')?></option>
		  		<option value="3"><?=trans('OnlyNumbers')?></option>
		  		<option value="4"><?=trans('ValidEmail')?></option>
			</select>
			<label class="control-label" for="type"><?=trans('Type')?> </label>
			<select id="type" name="type"> 
				<option value="1"><?=trans('InputField')?></option>
				<option value="2"><?=trans('TextArea')?></option>
				<option value="3"><?=trans('Select')?></option>
				<option value="4"><?=trans('Radio')?></option>
				<option value="5"><?=trans('Upload')?></option>
				<option value="6"><?=trans('Checkbox')?></option>
			</select>
		</div>		
		<label class="control-label" for="options"> <?=trans('Options')?> </label>
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
