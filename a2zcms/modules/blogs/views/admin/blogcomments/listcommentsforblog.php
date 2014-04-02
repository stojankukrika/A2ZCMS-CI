<div id="content" class="col-lg-10 col-sm-11 ">
	<div class="row">
		<div class="page-header">
			<h1>List of blog comments - <?=$content['blog']->title?></h1>
		</div>
		<?php if (!empty($content['blogcomments'])) { ?>
			   
		<table class="table table-hover">
			<thead>
        <tr>
          <th><?=trans('Comment')?></th>
          <th><?=trans('CreatedAt')?></th>
          <th><?=trans('Actions')?></th>
        </tr>
      </thead>
      <tbody>
		<?
		foreach ($content['blogcomments'] as $item) {
			echo '<tr>
			<td>'.$item->content.'</td>
			<td>'.$item->created_at.'</td>
			<td class="">
				<a class="iframe btn btn-sm btn-danger cboxElement" href="'.base_url("admin/blogs/blogcomments_delete/".$item->id).'"><i class="icon-trash "></i></a>
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
					height : "80%"
				});
</script>