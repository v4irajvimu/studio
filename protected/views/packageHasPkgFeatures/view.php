<?php
/* @var $this PackageHasPkgFeaturesController */
/* @var $model PackageHasPkgFeatures */

$this->breadcrumbs=array(
	'Package Has Pkg Features'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PackageHasPkgFeatures', 'url'=>array('index')),
	array('label'=>'Create PackageHasPkgFeatures', 'url'=>array('create')),
	array('label'=>'Update PackageHasPkgFeatures', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PackageHasPkgFeatures', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PackageHasPkgFeatures', 'url'=>array('admin')),
);
?>

<h1>View PackageHasPkgFeatures #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'cost',
		'selling',
		'created',
		'pkg_features_id',
		'package_id',
	),
)); ?>
