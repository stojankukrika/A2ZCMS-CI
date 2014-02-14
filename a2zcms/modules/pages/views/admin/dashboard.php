<div id="content" class="col-lg-10 col-sm-11 ">
	<div class="row">
		<div class="page-header">
			<h1>Page Management </h1>
		</div>
		<div class="pull-right">
			<a class="btn btn-small btn-info iframe cboxElement" href="<?=base_url("admin/pages/create")?>">
				<span class="icon-plus-sign icon-white"></span> Create</a>
		</div>
		<?php if ($content['page']->result_count() > 0) { ?>
   
    <table class="table table-hover">
		<thead>
	        <tr>
	          <th>Title</th>
	          <th>Status</th>
	          <th>Votes</th>
	          <th>Hits</th>
	          <th>Sidebar Position</th>
	          <th>Created at</th>
	          <th>Actions</th>
	        </tr>
      	</thead>
      	<tbody>
        <?php foreach ($content['page'] as $item) {
            echo '<tr>
		            <td>'.$item->title.'</td>
					<td>'.(($item->status=='1')?'<i class="icon-eye-open"></i>':'<i class="icon-eye-close"></i>').'</td>
					<td>'.($item->voteup - $item->votedown).'</td>
					<td>'.$item->hits.'</td>
					<td>'.(($item->sidebar=='1')?'Right':'Left').'</td>
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