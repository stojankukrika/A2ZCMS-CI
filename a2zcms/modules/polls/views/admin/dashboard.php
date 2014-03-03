<div id="content" class="col-lg-10 col-sm-11 ">
	<div class="row">
		<div class="page-header">
			<h1>Polls Management</h1>
		</div>
		<div class="pull-right">
			<a class="btn btn-small btn-info iframe cboxElement" href="<?=base_url("admin/polls/create")?>">
				<span class="icon-plus-sign icon-white"></span> Create</a>
		</div>
		<?php if (!empty($content['polls'])) { ?>
   
    <table class="table table-hover">
		<thead>
	        <tr>
	          <th>Title</th>
	          <th>Active</th>
	          <th>Created at</th>
	          <th>Actions</th>
	        </tr>
      	</thead>
      	<tbody>
        <?php foreach ($content['polls'] as $item) {
            echo '<tr>
		            <td>'.$item->title.'</td>
					<td>'.(($item->active=='1')?'Active':'Not active').'</td>
					<td>'.$item->created_at.'</td>
					<td class="">      
						<a class="btn btn-link btn-sm" href="'.base_url("admin/polls/change/".$item->id).'"><i class="icon-retweet "></i></a>        
						<a class="btn btn-warning btn-sm" href="'.base_url("admin/polls/results/".$item->id).'"><i class="icon-signal "></i></a>        
						<a class="iframe btn btn-sm btn-default cboxElement" href="'.base_url("admin/polls/create/".$item->id).'"><i class="icon-edit "></i></a>
						<a class="iframe btn btn-sm btn-danger cboxElement" href="'.base_url("admin/polls/delete/".$item->id).'"><i class="icon-trash "></i></a>
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
        No items found. 
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