<?php
/* @var $this WrkOrderHasItemsController */
/* @var $data WrkOrder */
?>


<div class="row datarow">

    <div class='col-sm-2 cells'>
	<?php echo $data['name']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['code']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['eff_date']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['wo_type']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['delivery_date']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['remark']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['wo_status_id']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['customer_id']; ?>
</div>
    
    <div class='col-sm-1 cells btn-cog text-right'>
        <a class="WrkOrder-update" href="#" data-id="<?php echo $data['id']; ?>" model="WrkOrder" controler="WrkOrderHasItemsController" data-toggle="tooltip" data-placement="top" title="Update"><span class="glyphicon glyphicon-cog"></span></a>
        <a class="WrkOrder-delete" href="#" data-id="<?php echo $data['id']; ?>" model="WrkOrder" controler="WrkOrderHasItemsController" data-toggle="tooltip" data-placement="top" title="Delete"><span class="glyphicon glyphicon-remove"></span></a>
    </div>

</div>
