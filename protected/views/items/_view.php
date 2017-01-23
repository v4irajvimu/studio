<?php
/* @var $this ItemsController */
/* @var $data Items */
?>


<div class="row datarow">

    <div class='col-sm-3 cells'>
	<?php echo $data['name']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['cost']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['selling']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['min_price']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['max_price']; ?>
</div>
<div class='col-sm-1 cells'>
	<?php echo $data['reorder_level']; ?>
</div>
<div class='col-sm-3 cells'>
	<?=Supplier::model()->findByPk($data['supplier_id'])->name;?>
</div>
    
    <div class='col-sm-1 cells btn-cog text-right'>
        <a class="Items-update" href="#" data-id="<?php echo $data['id']; ?>" model="Items" controler="ItemsController" data-toggle="tooltip" data-placement="top" title="Update"><span class="glyphicon glyphicon-cog"></span></a>
        <a class="Items-delete" href="#" data-id="<?php echo $data['id']; ?>" model="Items" controler="ItemsController" data-toggle="tooltip" data-placement="top" title="Delete"><span class="glyphicon glyphicon-remove"></span></a>
    </div>

</div>
