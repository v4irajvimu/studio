<?php
/* @var $this CustomerController */
/* @var $data Customer */
?>


<div class="row datarow">

<div class='col-sm-2 cells'>
	<?php echo $data['code']; ?>
</div>
<div class='col-sm-3 cells'>
	<?php echo $data['name']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['nic']; ?>
</div>
<div class='col-sm-3 cells'>
	<?php echo $data['email']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['tp_mobile']."<br>".$data['tp_fixed']; ?>
</div>
<div class='col-sm-1 cells'>
	<?php echo $data['visits']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['updated']; ?>
</div>

    
    <div class='col-sm-1 cells btn-cog text-right'>
        <a class="Customer-update" href="#" data-id="<?php echo $data['id']; ?>" model="Customer" controler="CustomerController" data-toggle="tooltip" data-placement="top" title="Update"><span class="glyphicon glyphicon-cog"></span></a>
        <a class="Customer-delete" href="#" data-id="<?php echo $data['id']; ?>" model="Customer" controler="CustomerController" data-toggle="tooltip" data-placement="top" title="Delete"><span class="glyphicon glyphicon-remove"></span></a>
    </div>

</div>
