<?php
/* @var $this PackageController */
/* @var $model Package */

$this->breadcrumbs=array(
	'Packages'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Package', 'url'=>array('index')),
	array('label'=>'Create Package', 'url'=>array('create')),
	array('label'=>'Update Package', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Package', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Package', 'url'=>array('admin')),
);
?>

<h1>View Package #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'desc',
		'from',
		'to',
		'online',
		'created',
		'users_id',
	),
)); ?>
