<?php
/* @var $this StockController */
/* @var $data Stock */
?>


<div class="row datarow">

    <div class='col-sm-5 cells'>
	<?php echo $data['items_name']; ?>
</div>
<div class='col-sm-4 cells'>
	<?php echo $data['supplier_name']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['avl_qty']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['cost']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['selling']; ?>
</div>


    <div class='col-sm-1 cells btn-cog text-right'>
        <a href="<?php echo Yii::app()->createUrl("stock") ?>/<?php echo $data['items_id']; ?>" data-id="<?php echo $data['items_id']; ?>" model="Package" controler="PackageController" data-toggle="tooltip" data-placement="top" title="Details" target="_blank"><span class="glyphicon glyphicon-eye-open"></span></a>
      </div>
</div>
