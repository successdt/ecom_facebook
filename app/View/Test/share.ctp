<table>
	<thead>
		<tr>
			<th>Mã số dự thưởng</th>
			<th>Tên</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$i = 0;
		foreach($shared as $user): ?>
			<tr>
				<td><?php echo $i++; ?></td>
				<td><?php echo $this->Html->link($user['name'], 'https://www.facebook.com/profile.php?id=' . $user['id']) ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>