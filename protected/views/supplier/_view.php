<?php
/* @var $this SupplierController */
/* @var $data Supplier */
?>


<div class="row datarow">

    <div class='col-sm-3 cells'>
	<?php echo $data['name']; ?>
</div>
<div class='col-sm-3 cells'>
	<?php echo $data['address']; ?>
</div>
<div class='col-sm-3 cells'>
	<?php echo $data['email']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['tp_fixed']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['tp_mobile']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['created']; ?>
</div>
    
    <div class='col-sm-1 cells btn-cog text-right'>
        <a class="Supplier-update" href="#" data-id="<?php echo $data['id']; ?>" model="Supplier" controler="SupplierController" data-toggle="tooltip" data-placement="top" title="Update"><span class="glyphicon glyphicon-cog"></span></a>
        <a class="Supplier-delete" href="#" data-id="<?php echo $data['id']; ?>" model="Supplier" controler="SupplierController" data-toggle="tooltip" data-placement="top" title="Delete"><span class="glyphicon glyphicon-remove"></span></a>
    </div>

</div>
