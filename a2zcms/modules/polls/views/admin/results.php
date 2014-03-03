<div id="content" class="col-lg-10 col-sm-11 ">
	<div class="row">
		<div class="page-header">
			<h1>Results of voting in poll: <b><?=$content['poll']->title?></b></h1>
		</div>
		<div class="pull-right">
			<a class="btn btn-small btn-info" href="<?=base_url("admin/polls/index")?>">
				<span class="icon-share-alt icon-white"></span> Back</a>
		</div>
		<?php if (!empty($content['pollOptions'])) { ?>
			   
		<table class="table table-hover">
			<thead>
        <tr>
          <th>Answer</th>
          <th>Votes</th>
          <th>Percentage</th>
        </tr>
	      </thead>
	      <tbody>
			<?
			foreach ($content['pollOptions'] as $item) {
				echo '<tr>
				<td>'.$item->title.'</td>
				<td>'.$item->votes.'</td>
				<td>'.$item->percentage.'</td>
				</tr>';
			}
			?>
	    	</tbody>
		</table>
<?php } else { ?>
    <div class="item_list_empty">
        No items found. 
    </div>
<?php } ?>
	</div>
</div>