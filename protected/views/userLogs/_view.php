<?php
/* @var $this UserLogsController */
/* @var $data UserLogs */
?>


<div class="row datarow">

    <div class='col-sm-2 cells'>
	<?php echo $data['name']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['users_id']; ?>
</div>
    
    <div class='col-sm-1 cells btn-cog text-right'>
        <a class="UserLogs-update" href="#" data-id="<?php echo $data['id']; ?>" model="UserLogs" controler="UserLogsController" data-toggle="tooltip" data-placement="top" title="Update"><span class="glyphicon glyphicon-cog"></span></a>
        <a class="UserLogs-delete" href="#" data-id="<?php echo $data['id']; ?>" model="UserLogs" controler="UserLogsController" data-toggle="tooltip" data-placement="top" title="Delete"><span class="glyphicon glyphicon-remove"></span></a>
    </div>

</div>
