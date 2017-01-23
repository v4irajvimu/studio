<?php
/* @var $this UserLogsController */
/* @var $model UserLogs */

$this->breadcrumbs=array(
	'User Logs'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List UserLogs', 'url'=>array('index')),
	array('label'=>'Create UserLogs', 'url'=>array('create')),
	array('label'=>'Update UserLogs', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete UserLogs', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UserLogs', 'url'=>array('admin')),
);
?>

<h1>View UserLogs #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'created',
		'users_id',
	),
)); ?>
