<?php
/* @var $this WoStatusController */
/* @var $data WoStatus */
?>


<div class="row datarow">

    <div class='col-sm-2 cells'>
	<?php echo $data['name']; ?>
</div>
    
    <div class='col-sm-1 cells btn-cog text-right'>
        <a class="WoStatus-update" href="#" data-id="<?php echo $data['id']; ?>" model="WoStatus" controler="WoStatusController" data-toggle="tooltip" data-placement="top" title="Update"><span class="glyphicon glyphicon-cog"></span></a>
        <a class="WoStatus-delete" href="#" data-id="<?php echo $data['id']; ?>" model="WoStatus" controler="WoStatusController" data-toggle="tooltip" data-placement="top" title="Delete"><span class="glyphicon glyphicon-remove"></span></a>
    </div>

</div>
