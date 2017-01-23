<?php
/* @var $this PaymentsController */
/* @var $data Payments */
?>


<div class="row datarow">

    <div class='col-sm-2 cells'>
	<?php echo $data['name']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['remark']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['amount']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['payment_type_id']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['wrk_order_id']; ?>
</div>
    
    <div class='col-sm-1 cells btn-cog text-right'>
        <a class="Payments-update" href="#" data-id="<?php echo $data['id']; ?>" model="Payments" controler="PaymentsController" data-toggle="tooltip" data-placement="top" title="Update"><span class="glyphicon glyphicon-cog"></span></a>
        <a class="Payments-delete" href="#" data-id="<?php echo $data['id']; ?>" model="Payments" controler="PaymentsController" data-toggle="tooltip" data-placement="top" title="Delete"><span class="glyphicon glyphicon-remove"></span></a>
    </div>

</div>
