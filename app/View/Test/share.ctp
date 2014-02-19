<style>
	.item.active {
		background: #91FF91;
	}
</style>
<table>
	<tr>
		<td>Số lượng người trúng thưởng:</td>
		<td><input type="number" value="1" name="number_user" id="number_user" /></td>
	</tr>
	<tr>
		<td></td>
		<td><input id="choose" type="submit" value="Chọn"/></td>
	</tr>
</table>
<table>
	<thead>
		<tr>
			<th>Mã số dự thưởng</th>
			<th>Tên</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$i = 1;
		foreach($shared as $id => $user): ?>
			<tr>
				<td class="item item-<?php echo $i ?>"><?php echo $id; ?></td>
				<td class="item item-<?php echo $i ?>"><?php echo $this->Html->link($user['fb_name'], 'https://www.facebook.com/profile.php?id=' . $user['fb_id']) ?></td>
				<?php $i++; ?>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<script type="text/javascript">
$(document).ready(function(){
	$('#choose').click(function(){
		var number = $('#number_user').val();
		var choose = Array();
		var i = 0;
		$('.item').removeClass('active');
		while(i < number){
			var rand = Math.floor((Math.random() * <?php echo $i ?>) + 1);
			if(choose.indexOf(rand) == -1){
				choose.push(rand);
				i++;	
			}
		}
		for(var i = 0; i < number; i++){
			$('.item-' + choose[i]).addClass('active');
		}
	});
});
</script>