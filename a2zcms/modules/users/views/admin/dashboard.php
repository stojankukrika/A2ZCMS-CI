<div id="content" class="col-lg-10 col-sm-11 ">
	<div class="row">
		<div class="page-header">
			<h1>List of users</h1>
		</div>
		<table class="table table-hover">
			<thead>
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Username</th>
          <th>Email</th>
          <th>Activated</th>
          <th>Last login</th>
          <th>Created at</th>          
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
		<?
		foreach ($content as $item) {
			echo '<tr>
			<td>'.$item->name.'</td>
			<td>'.$item->surname.'</td>
			<td>'.$item->email.'</td>
			<td>'.$item->username.'</td>
			<td>'.$item->active.'</td>
			<td>'.$item->last_login.'</td>
			<td>'.$item->created_at.'</td>
			<td class="">
				<a class="btn btn-sm btn-link" href="#"><i class="icon-signal "></i></a>                               
				<a class="iframe btn btn-sm btn-default cboxElement" href="#"><i class="icon-edit "></i></a>
            </td>
			</tr>';
		}
		?>
		</tbody>
		</table>
	</div>
</div>
