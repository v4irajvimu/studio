<?php
/* @var $this ReservationHasPkgFeaturesController */
/* @var $data ReservationHasPkgFeatures */
?>


<div class="row datarow">

    <div class='col-sm-2 cells'>
	<?php echo $data['reservation_id']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['pkg_features_id']; ?>
</div>
    
    <div class='col-sm-1 cells btn-cog text-right'>
        <a class="ReservationHasPkgFeatures-update" href="#" data-id="<?php echo $data['id']; ?>" model="ReservationHasPkgFeatures" controler="ReservationHasPkgFeaturesController" data-toggle="tooltip" data-placement="top" title="Update"><span class="glyphicon glyphicon-cog"></span></a>
        <a class="ReservationHasPkgFeatures-delete" href="#" data-id="<?php echo $data['id']; ?>" model="ReservationHasPkgFeatures" controler="ReservationHasPkgFeaturesController" data-toggle="tooltip" data-placement="top" title="Delete"><span class="glyphicon glyphicon-remove"></span></a>
    </div>

</div>
