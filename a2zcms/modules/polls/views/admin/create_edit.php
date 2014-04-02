<!-- Tabs -->
<ul class="nav nav-tabs">
	<li class="active">
		<a href="#tab-general" data-toggle="tab"><?=trans('General')?></a>
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
				<div class="col-lg-12">
					<?
						$this -> form_builder -> text('poll', trans('Title'), (isset($content['poll_edit']->title))?$content['poll_edit']->title:"", 'form-control');
					?>
				</div>
			</div>
			<!-- ./ name -->
			<a class="btn btn-link" id="add" href="#"><i class="icon-plus-sign"></i> <?=trans('AddFiled')?></a>
			<div id="fields">
				<div class="row responsive-utilities-test">
					<div class="col-md-10 col-xs-10" id="form_fields">
						<ul id="sortable1">
							<input type="hidden" value="<?=isset($content['poll_options_count'])?$content['poll_options_count']:0?>" name="count" id="count">
							<input type="hidden" value="" name="pagecontentorder" id="pagecontentorder">
							<div class="clearfix"></div>
							<?php $id=1;
							if(!empty($content['poll_options'])){
								foreach($content['poll_options'] as $item) { ?>								
									<li class="ui-state-default" name="formf" value="<?=$item->id?>" id="formf<?=$item->id?>">
										<label class="control-label" for="name"><?=trans('AnswerTitle')?></label>
										<input id="id<?=$item->id?>" type="hidden" value="<?=$item->id?>" name="id<?=$item->id?>">
										<input id="title<?=$item->id?>" type="text" value="<?=$item->title?>" name="title<?=$item->id?>">	
										<a class="btn btn-default btn-sm btn-small remove"><span class="icon-trash"><input type="hidden" 
											value="<?=$item->id?>" class="remove" name="remove"></span></a>										
									</li>
									<?php $id++;
									}
								}?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- ./ General tab -->
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
		<label class="control-label" for="name"><?=trans('AnswerTitle')?></label>
		<input id="title" type="text" value="" name="title">		
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
            url : "<?=base_url('admin/polls/deleteitem/' . ((isset($content['poll_edit']->id))?$content['poll_edit']->id:""));?>"
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
			formfild = formfild.split('<input id="title" value="" name="title" type="text">').join('<input id="title'+count+'" value="" name="title'+count+'" type="text">');
			formfild = formfild.split('<a class="btn btn-default btn-sm btn-small remove">').join('<a class="btn btn-default btn-sm btn-small remove id-'+count+'">');


			$("#sortable1").append(formfild);
			$('#count').val(count);
			
			$('.id-'+count).children().append('<input class="remove" type="hidden" name="remove" value="'+count+'">');
			
		})
		$( "#sortable1" ).sortable();
		
		$('.btn-success').click(function(){
		 	var neworder = new Array();
	        $('#sortable1 li').each(function() { 
	        	var title  = $(this).children('[name^="title"]').attr("value");
	        	neworder.push(title);
	            var id  = $(this).children('[name^="id"]').attr("value");
	            neworder.push(id);
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