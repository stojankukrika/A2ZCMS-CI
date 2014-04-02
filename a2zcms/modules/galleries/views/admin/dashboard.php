<div id="content" class="col-lg-10 col-sm-11 ">
	<div class="row">
		<div class="page-header">
			<h1><?=trans('GalleriesManagement')?></h1>
		</div>
		<div class="pull-right">
			<a class="btn btn-small btn-info iframe cboxElement" href="<?=base_url("admin/galleries/create")?>">
				<span class="icon-plus-sign icon-white"></span> <?=trans('Create')?></a>
		</div>
		<?php if (!empty($content['gallery'])) { ?>
   
    <table class="table table-hover">
		<thead>
	        <tr>
	          <th><?=trans('Title')?></th>
	          <th><?=trans('Views')?></th>
	          <th># <?=trans('OfImages')?></th>
	          <th># <?=trans('OfComments')?></th>
	          <th><?=trans('CreatedAt')?></th>
	          <th><?=trans('Actions')?></th>
	        </tr>
      	</thead>
      	<tbody>
        <?php foreach ($content['gallery'] as $item) {
            echo '<tr>
		            <td>'.$item->title.'</td>
					<td>'.$item->hits.'</td>
					<td><a class="btn btn-link btn-sm" href="'.base_url("admin/galleries/listimages/".$item->id).'">'.$item->countimages.'</a></td>
					<td><a class="btn btn-link btn-sm" href="'.base_url("admin/galleries/listcomments/".$item->id).'">'.$item->countcomments.'</a></td>
					<td>'.$item->created_at.'</td>
					<td class="">      
						<a class="btn btn-info btn-sm iframe cboxElement" href="'.base_url("admin/galleries/upload/".$item->id).'"><i class="icon-picture "></i></a>        
						<a class="iframe btn btn-sm btn-default cboxElement" href="'.base_url("admin/galleries/create/".$item->id).'"><i class="icon-edit "></i></a>
						<a class="iframe btn btn-sm btn-danger cboxElement" href="'.base_url("admin/galleries/delete/".$item->id).'"><i class="icon-trash "></i></a>
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
	$(".iframe").colorbox({
					iframe : true,
					width : "50%",
					height : "70%"
				});
</script>