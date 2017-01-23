<?php
/* @var $this StockController */
/* @var $data Stock */
?>


<div class="row datarow">

    <div class='col-sm-2 cells'>
	<?php echo $data['trans_type_id']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['items_id']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['supplier_id']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['qty_in']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['qty_out']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['eff_date']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['cost']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['selling']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['amount']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['remark']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['wo_type']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['wrk_order_id']; ?>
</div>
    
    <div class='col-sm-1 cells btn-cog text-right'>
        <a class="Stock-update" href="#" data-id="<?php echo $data['id']; ?>" model="Stock" controler="StockController" data-toggle="tooltip" data-placement="top" title="Update"><span class="glyphicon glyphicon-cog"></span></a>
        <a class="Stock-delete" href="#" data-id="<?php echo $data['id']; ?>" model="Stock" controler="StockController" data-toggle="tooltip" data-placement="top" title="Delete"><span class="glyphicon glyphicon-remove"></span></a>
    </div>

</div>
