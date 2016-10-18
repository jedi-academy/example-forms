<table>
	<tr>
		<th>#</th>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Username</th>
	</tr>
	<?php foreach ($contacts as $record)
	{ ?>
		<tr>
			<td><?= $record->id ?></td>
			<td><?= $record->firstname ?></td>
			<td><?= $record->lastname ?></td>
			<td><?= $record->username ?></td>
		</tr>
<?php } ?>
</table>