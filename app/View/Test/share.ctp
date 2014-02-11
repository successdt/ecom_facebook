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
		foreach($shared as $id => $name): ?>
			<tr>
				<td><?php echo $i++; ?></td>
				<td><?php echo $this->Html->link($name, 'https://www.facebook.com/profile.php?id=' . $id) ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>