<?php
/* @var $this PkgFeaturesController */
/* @var $model PkgFeatures */

$this->breadcrumbs=array(
	'Pkg Features'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List PkgFeatures', 'url'=>array('index')),
	array('label'=>'Create PkgFeatures', 'url'=>array('create')),
	array('label'=>'Update PkgFeatures', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PkgFeatures', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PkgFeatures', 'url'=>array('admin')),
);
?>

<h1>View PkgFeatures #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'desc',
		'online',
		'created',
		'cost',
		'selling',
		'hits',
	),
)); ?>
