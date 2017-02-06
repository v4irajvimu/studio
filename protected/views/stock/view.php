<?php
$items_id = $model->id;
$items_det = Items::model()->findByPk($items_id);
$sql = "SELECT s.`trans_type_id`,tt.`name` AS trans_type,s.`items_id`,i.`name` AS items_name,s.`supplier_id`,
  			sp.`name` AS supplier_name,s.`qty_in`,s.`qty_out`,s.`eff_date`,s.`cost`,s.`selling`,s.`amount`,s.`wo_type`,
  			wo.`code`,s.`created`
				FROM `stock` s
			  JOIN trans_type tt ON tt.`id` = s.`trans_type_id`
			  JOIN items i ON i.`id` = s.`items_id`
			  JOIN supplier sp ON sp.id= s.`supplier_id`
			  LEFT JOIN `wrk_order` wo ON wo.`id` = s.`wrk_order_id`
				WHERE s.`items_id` = '$items_id'";

$det = Yii::app()->db->createCommand($sql)->queryAll();
?>
<h4>Items Movement For <?=$items_det->name?></h4>
<div style="height:100%; overflow:scrol;">
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>Suplier Name</th>
				<th>Trans Type</th>
				<th>WO Type</th>
				<th>WO Code</th>
				<th>Cost</th>
				<th>Selling</th>
				<th>Qty. In</th>
				<th>Qty. Out</th>
				<th>Created</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($det as $value) {
				?>
				<tr>
					<td><?=$value['supplier_name']?></td>
					<td><?=$value['trans_type']?></td>
					<td><?=$value['wo_type']?></td>
					<td><?=$value['code']?></td>
					<td><?=$value['cost']?></td>
					<td><?=$value['selling']?></td>
					<td><?=$value['qty_in']?></td>
					<td><?=$value['qty_out']?></td>
					<td><?=$value['created']?></td>
				</tr>
				<?php
			}
			?>

		</tbody>
	</table>

</div>
