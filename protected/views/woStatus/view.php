<?php
/* @var $this WoStatusController */
/* @var $model WoStatus */

$this->breadcrumbs=array(
	'Wo Statuses'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List WoStatus', 'url'=>array('index')),
	array('label'=>'Create WoStatus', 'url'=>array('create')),
	array('label'=>'Update WoStatus', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete WoStatus', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage WoStatus', 'url'=>array('admin')),
);
?>

<h1>View WoStatus #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'online',
		'created',
	),
)); ?>
