<?php
/* @var $this WrkOrderController */
/* @var $model WrkOrder */

$this->breadcrumbs=array(
	'Wrk Orders'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List WrkOrder', 'url'=>array('index')),
	array('label'=>'Create WrkOrder', 'url'=>array('create')),
	array('label'=>'Update WrkOrder', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete WrkOrder', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage WrkOrder', 'url'=>array('admin')),
);
?>

<h1>View WrkOrder #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'code',
		'eff_date',
		'wo_type',
		'delivery_date',
		'remark',
		'wo_status_id',
		'customer_id',
	),
)); ?>
