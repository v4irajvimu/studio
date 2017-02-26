<?php
/* @var $this ReservationHasPkgFeaturesController */
/* @var $model ReservationHasPkgFeatures */

$this->breadcrumbs=array(
	'Reservation Has Pkg Features'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ReservationHasPkgFeatures', 'url'=>array('index')),
	array('label'=>'Create ReservationHasPkgFeatures', 'url'=>array('create')),
	array('label'=>'Update ReservationHasPkgFeatures', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ReservationHasPkgFeatures', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ReservationHasPkgFeatures', 'url'=>array('admin')),
);
?>

<h1>View ReservationHasPkgFeatures #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'reservation_id',
		'pkg_features_id',
	),
)); ?>
