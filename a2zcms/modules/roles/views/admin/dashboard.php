<div id="content" class="col-lg-10 col-sm-11 ">
	<div class="row">
		<div class="page-header">
			<h1><?=trans('RoleMenagement')?></h1>
		</div>
		<div class="pull-right">
			<a class="btn btn-small btn-info iframe cboxElement" href="<?=base_url("admin/roles/create")?>">
				<span class="icon-plus-sign icon-white"></span> <?=trans('Create')?> </a>
		</div>
		<?php if (!empty($content['role'])) { ?>
   
    <table class="table table-hover">
		<thead>
	        <tr>
	          <th><?=trans('Title')?></th>
	          <th># <?=trans('OfUsers')?></th>
	          <th><?=trans('CreatedAt')?></th>
	          <th><?=trans('Actions')?></th>
	        </tr>
      	</thead>
      	<tbody>
        <?php foreach ($content['role'] as $item) {
            echo '<tr>
		            <td>'.$item->name.'</td>
					<td>
					<a class="btn btn-link btn-sm" href="'.base_url("admin/users/listusersforrole/".$item->id).'">'.$item->countusers.'</a>
					</td>
					<td>'.$item->created_at.'</td>
					<td class="">              
						<a class="iframe btn btn-sm btn-default cboxElement" href="'.base_url("admin/roles/create/".$item->id).'"><i class="icon-edit "></i></a>
						<a class="iframe btn btn-sm btn-danger cboxElement" href="'.base_url("admin/roles/delete/".$item->id).'"><i class="icon-trash "></i></a>
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