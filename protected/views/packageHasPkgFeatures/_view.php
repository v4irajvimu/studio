<?php
/* @var $this PackageHasPkgFeaturesController */
/* @var $data PackageHasPkgFeatures */
?>


<div class="row datarow">

    <div class='col-sm-2 cells'>
	<?php echo $data['cost']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['selling']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['pkg_features_id']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['package_id']; ?>
</div>
    
    <div class='col-sm-1 cells btn-cog text-right'>
        <a class="PackageHasPkgFeatures-update" href="#" data-id="<?php echo $data['id']; ?>" model="PackageHasPkgFeatures" controler="PackageHasPkgFeaturesController" data-toggle="tooltip" data-placement="top" title="Update"><span class="glyphicon glyphicon-cog"></span></a>
        <a class="PackageHasPkgFeatures-delete" href="#" data-id="<?php echo $data['id']; ?>" model="PackageHasPkgFeatures" controler="PackageHasPkgFeaturesController" data-toggle="tooltip" data-placement="top" title="Delete"><span class="glyphicon glyphicon-remove"></span></a>
    </div>

</div>
