<div id="content" class="col-lg-10 col-sm-11 ">
	<div class="row">
		<div class="page-header">
			<h1>List of users</h1>
		</div>
		<div class="pull-right">
			<a class="btn btn-small btn-info iframe cboxElement" href="<?=base_url("admin/users/create")?>">
				<span class="icon-plus-sign icon-white"></span> Create</a>
		</div>
		<?php if (!empty($content['users'])) { ?>
			   
		<table class="table table-hover">
			<thead>
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Username</th>
          <th>Email</th>
          <th>Active</th>
          <th>Confirmed</th>
          <th>Last login</th>
          <th>Created at</th>          
          <th>Actions</th>
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
            <?=$content['pagination']->create_links(); ?>
    </div>
<?php } else { ?>
    <div class="item_list_empty">
        No items found. 
    </div>
<?php } ?>
	</div>
</div>
<script>
	$(".iframe").colorbox({
					iframe : true,
					width : "50%",
					height : "80%"
				});
</script>