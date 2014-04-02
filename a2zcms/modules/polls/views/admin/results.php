<div id="content" class="col-lg-10 col-sm-11 ">
	<div class="row">
		<div class="page-header">
			<h1><?=trans('ResultsOfPoll')?>: <b><?=$content['poll']->title?></b></h1>
		</div>
		<div class="pull-right">
			<a class="btn btn-small btn-info" href="<?=base_url("admin/polls/index")?>">
				<span class="icon-share-alt icon-white"></span> <?=trans('Back')?></a>
		</div>
		<?php if (!empty($content['pollOptions'])) { ?>
			   
		<table class="table table-hover">
			<thead>
        <tr>
          <th><?=trans('Answer')?></th>
          <th><?=trans('Votes')?></th>
          <th><?=trans('Percentage')?></th>
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
        <?=trans('NoItemsFound')?>
    </div>
<?php } ?>
	</div>
</div>