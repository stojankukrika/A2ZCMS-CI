<div id="content" class="col-lg-10 col-sm-11 ">
	<div class="row">
		<div class="page-header">
			<h1><?=trans('PageManagement')?> </h1>
		</div>
		<div class="pull-right">
			<a class="btn btn-small btn-info iframe cboxElement" href="<?=base_url("admin/pages/create")?>">
				<span class="icon-plus-sign icon-white"></span> <?=trans('Create')?></a>
		</div>
		<?php if (!empty($content['page'])) { ?>
   
    <table class="table table-hover">
		<thead>
	        <tr>
	          <th><?=trans('Title')?></th>
	          <th><?=trans('Create')?></th>
	          <th><?=trans('Votes')?></th>
	          <th><?=trans('Hits')?></th>
	          <th><?=trans('SidebarPosition')?></th>
	          <th><?=trans('CreatedAt')?></th>
	          <th><?=trans('Actions')?></th>
	        </tr>
      	</thead>
      	<tbody>
        <?php foreach ($content['page'] as $item) {
            echo '<tr>
		            <td>'.$item->title.'</td>
					<td>'.(($item->status=='1')?'<i class="icon-eye-open"></i>':'<i class="icon-eye-close"></i>').'</td>
					<td>'.($item->voteup - $item->votedown).'</td>
					<td>'.$item->hits.'</td>
					<td>'.(($item->sidebar=='1')?trans('Right'):trans('Left')).'</td>
					<td>'.$item->created_at.'</td>
					<td class="">      
						<a class="btn btn-link btn-sm" href="'.base_url("admin/pages/change/".$item->id).'"><i class="icon-exchange"></i></a>        
						<a class="iframe btn btn-sm btn-default cboxElement" href="'.base_url("admin/pages/create/".$item->id).'"><i class="icon-edit "></i></a>
						<a class="iframe btn btn-sm btn-danger cboxElement" href="'.base_url("admin/pages/delete/".$item->id).'"><i class="icon-trash "></i></a>
		            </td>
               </tr>';
  		} ?>
    	</tbody>
	</table>
   <div class="dataTables_paginate paging_bootstrap">
            <?php echo $content['pagination']->create_links(); ?>
    </div>
<?php } else { ?>
    <div class="item_list_empty">
        <?=trans('NoItemsFound')?>
    </div>
<?php } ?>
	</div>
</div>
<script>
	$(".iframe").colorbox({width:"50%", height:"80%", iframe:true});
</script>