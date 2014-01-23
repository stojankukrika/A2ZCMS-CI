<div class="row">
  <div class="col-xs-12 col-sm-6 col-lg-8">
	<br>
	<div class="row"> 
		<div class="span12">
			<table class="table">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Username</th>
						<th>Email</th>
					</tr>
				</thead>
				<tbod>
					<?php foreach($users as $user): ?>
					<tr>
						<td><?php echo $user->id; ?></td>
						<td><a href="<?php echo base_url('users/'.$user->username); ?>"><?php echo $user->name.' '.$user->surname; ?></a></td>
						<td><?php echo $user->username; ?></td>
						<td><?php echo $user->email; ?></td>
					</tr>
					<?php endforeach; ?>
				</tbod>
			</table>			
		</div>
	</div>
</div>
</div>
