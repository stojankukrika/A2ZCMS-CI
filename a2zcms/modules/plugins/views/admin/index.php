<div id="content" class="col-lg-10 col-sm-11 ">
	<div class="row">
		<div class="page-header">
			<h1>Plugins</h1>
			<br><b>
					* Reorder plugins causes a change in the admin navigation<br>
					** After install some plugin, you need to add role to some user group that 
							they can access to that plugin. User get that roles after first login to website.
				</b>
		</div>
    <table class="table table-hover">
		<thead>
	        <tr>
	          <th>Title</th>
	          <th>Name</th>
	          <th>Installed at</th>
	          <th>Actions</th>
	        </tr>
      	</thead>
      	<tbody>
        <?php foreach ($content['navigation'] as $item) {
            echo '<tr>
		            <td>'.$item->title.'</td>		            
					<td>'.$item->name.'</td>
					<td>'.$item->created_at.'</td>
					<td class="">';
					if(isset($item->not_installed))      
						echo '<a class="iframe btn btn-sm btn-default cboxElement" href="'.base_url("admin/".$item->name."/install").'"><i class="icon-plus-sign "></i></a>';
					else if(isset($item->can_uninstall) && $item->can_uninstall=='1')
						echo'<a class="iframe btn btn-sm btn-danger cboxElement" href="'.base_url("admin/".$item->name."/uninstall").'"><i class="icon-remove "></i></a>';
						echo '<input id="row" type="hidden" value="'.$item->id.'" name="row">
		            </td>
               </tr>';
  		} ?>
    	</tbody>
	</table>
	</div>
</div>
<script>
	$(".iframe").colorbox({
					iframe : true,
					width : "50%",
					height : "50%"
				});
	var startPosition;
	var endPosition;
	$(".table tbody").sortable({
		cursor : "move",
		start : function(event, ui) {
			startPosition = ui.item.prevAll().length + 1;
		},
		update : function(event, ui) {
			endPosition = ui.item.prevAll().length + 1;
			var navigationList = "";
			$('.table #row').each(function(i) {
				navigationList = navigationList + ',' + $(this).val();
			});
			$.getJSON("<?=base_url('admin/plugins/plugin_reorder');?>", {
				list : navigationList
			});			
		}
	});
</script>