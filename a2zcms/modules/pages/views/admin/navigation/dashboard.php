<div id="content" class="col-lg-10 col-sm-11 ">
	<div class="row">
		<div class="page-header">
			<h1><?=trans('NavigationManagement')?></h1>
		</div>
		<div class="pull-right">
			<a class="btn btn-small btn-info iframe cboxElement" href="<?=base_url("admin/pages/navigation_create")?>">
				<span class="icon-plus-sign icon-white"></span> Create</a>
		</div>
		<?php if (!empty($content['navigation'])) { ?>
   
    <table class="table table-hover">
		<thead>
	        <tr>
	          <th><?=trans('Title')?></th>
	          <th><?=trans('LinkType')?></th>
	          <th><?=trans('Page')?></th>
	          <th><?=trans('NavigationGroup')?></th>
	          <th><?=trans('CreatedAt')?></th>
	          <th><?=trans('Actions')?></th>
	        </tr>
      	</thead>
      	<tbody>
        <?php foreach ($content['navigation'] as $item) {
            echo '<tr>
		            <td>'.$item->title.'</td>		            
					<td>'.$item->link_type.'</td>
					<td>'.$item->page.'</td>
					<td>'.$item->navigationgroup.'</td>	
					<td>'.$item->created_at.'</td>
					<td class="">      
						<a class="iframe btn btn-sm btn-default cboxElement" href="'.base_url("admin/pages/navigation_create/".$item->id).'"><i class="icon-edit "></i></a>
						<a class="iframe btn btn-sm btn-danger cboxElement" href="'.base_url("admin/pages/navigation_delete/".$item->id).'"><i class="icon-trash "></i></a>
		            	<input id="row" type="hidden" value="'.$item->id.'" name="row">
		            </td>
               </tr>';
  		} ?>
    	</tbody>
	</table>
<?php } else { ?>
    <div class="item_list_empty">
        <?=trans('NoItemsFound')?>
    </div>
<?php } ?>
	</div>
</div>
<script>
	$(".iframe").colorbox({
					iframe : true,
					width : "50%",
					height : "70%"
				});
	var startPosition;
	var endPosition;
	$(".table tbody").sortable({
		cursor : "move",
		start : function(event, ui) {
			startPosition = ui.item.prevAll().length + 1;
		},
		update : function(event, ui) {
			endPosition = ui.item.prevAll().length + 1;
			var navigationList = "";
			$('.table #row').each(function(i) {
				navigationList = navigationList + ',' + $(this).val();
			});
			$.getJSON("<?=base_url('admin/pages/navigation_reorder');?>", {
				list : navigationList
			});
		}
	});
</script>