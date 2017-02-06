<?php
$items_id = $model->id;
$items_det = Items::model()->findByPk($items_id);
$sql = "";
?>
<h4>Items Movement For <?=$items_det->name?></h4>
<table class="table table-hover">
	<thead>
		<tr>
			<th>Trans Type</th>
			<th>Cost</th>
			<th>Selling</th>
			<th>Qty. In</th>
			<th>Qty. Out</th>
			<th>WO Code</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Trans Type</td>
			<td>Cost</td>
			<td>Selling</td>
			<td>Qty. In</td>
			<td>Qty. Out</td>
			<td>WO Code</td>
		</tr>
	</tbody>
</table>
