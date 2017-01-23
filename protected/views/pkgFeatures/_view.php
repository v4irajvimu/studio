<?php
/* @var $this PkgFeaturesController */
/* @var $data PkgFeatures */
?>


<div class="row datarow">

    <div class='col-sm-3 cells'>
	<?php echo $data['name']; ?>
</div>
<div class='col-sm-5 cells'>
	<?php echo $data['desc']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['cost']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['selling']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['created']; ?>
</div>
<div class='col-sm-1 cells'>
	<?php echo $data['hits']; ?>
</div>
    
    <div class='col-sm-1 cells btn-cog text-right'>
        <a class="PkgFeatures-update" href="#" data-id="<?php echo $data['id']; ?>" model="PkgFeatures" controler="PkgFeaturesController" data-toggle="tooltip" data-placement="top" title="Update"><span class="glyphicon glyphicon-cog"></span></a>
        <a class="PkgFeatures-delete" href="#" data-id="<?php echo $data['id']; ?>" model="PkgFeatures" controler="PkgFeaturesController" data-toggle="tooltip" data-placement="top" title="Delete"><span class="glyphicon glyphicon-remove"></span></a>
    </div>

</div>
