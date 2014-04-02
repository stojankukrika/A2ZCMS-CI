<div id="content" class="col-lg-10 col-sm-11 ">
	<div class="row">
		<div class="page-header">
			<h1>List users for role:<b> <?=$content['role']->name?></b></h1>
		</div>
		<div class="pull-right">
			<a class="btn btn-small btn-info" href="<?=base_url("admin/users/index")?>">
				<span class="icon-share-alt icon-white"></span> <?=trans('Back')?></a>
		</div>
		<?php if (!empty($content['users'])) { ?>
			   
		<table class="table table-hover">
			<thead>
        <tr>
         <th><?=trans('FirstName')?></th>
          <th><?=trans('LastName')?></th>
          <th><?=trans('Username')?></th>
          <th><?=trans('Email')?></th>
           <th><?=trans('Active')?></th>
          <th><?=trans('Confirmed')?></th>
          <th><?=trans('LastLogin')?></th>
          <th><?=trans('CreatedAt')?></th>
	      <th><?=trans('Actions')?></th>
        </tr>
      </thead>
      <tbody>
		<?
		foreach ($content['users'] as $item) {
			echo '<tr>
			<td>'.$item->name.'</td>
			<td>'.$item->surname.'</td>
			<td>'.$item->email.'</td>
			<td>'.$item->username.'</td>
			<td>'.$item->active.'</td>
			<td>'.$item->confirmed.'</td>
			<td>'.$item->last_login.'</td>
			<td>'.$item->created_at.'</td>
			<td class="">
				<a class="btn btn-sm btn-link" href="'.base_url("admin/users/listlogins/".$item->id).'"><i class="icon-signal "></i></a>                               
				<a class="iframe btn btn-sm btn-default cboxElement" href="'.base_url("admin/users/create/".$item->id).'"><i class="icon-edit "></i></a>
				<a class="iframe btn btn-sm btn-danger cboxElement" href="'.base_url("admin/users/delete/".$item->id).'"><i class="icon-trash "></i></a>
            </td>
			</tr>';
		}
		?>
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