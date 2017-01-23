<?php
/* @var $this PackageController */
/* @var $data Package */
?>


<div class="row datarow">

    <div class='col-sm-2 cells'>
	<?php echo $data['name']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['desc']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['from']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['to']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['users_id']; ?>
</div>
    
    <div class='col-sm-1 cells btn-cog text-right'>
        <a class="Package-update" href="#" data-id="<?php echo $data['id']; ?>" model="Package" controler="PackageController" data-toggle="tooltip" data-placement="top" title="Update"><span class="glyphicon glyphicon-cog"></span></a>
        <a class="Package-delete" href="#" data-id="<?php echo $data['id']; ?>" model="Package" controler="PackageController" data-toggle="tooltip" data-placement="top" title="Delete"><span class="glyphicon glyphicon-remove"></span></a>
    </div>

</div>
