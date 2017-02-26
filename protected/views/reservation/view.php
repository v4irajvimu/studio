<?php
/* @var $this PackageController */
/* @var $model Package */

$this->breadcrumbs=array(
	'Packages'=>array('index'),
	$model->code,
);

$this->menu=array(
	array('label'=>'List Package', 'url'=>array('index')),
	array('label'=>'Create Package', 'url'=>array('create')),
	array('label'=>'Update Package', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Package', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Package', 'url'=>array('admin')),
);
?>

<h1>View Package Features</h1>
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Description</th>
            <th>Cost</th>
            <th>Selling</th>
        </tr>
    </thead>
    <tbody>
        <?php
    $sql = "SELECT pf.* FROM reservation_has_pkg_features ph JOIN pkg_features pf ON pf.id = ph.pkg_features_id WHERE ph.reservation_id='$model->id'";
    $pkg_feature_det = Yii::app()->db->createCommand($sql)->queryAll();
    
//    print_r($pkg_feature_det);
//    die();
    $count=0;
    foreach ($pkg_feature_det as $value) {
        $count++;
        ?>
        <tr>
            <td><?=$count; ?></td>
            <td><?=$value['name']?></td>
            <td><?=$value['desc']?></td>
            <td><?=$value['cost']?></td>
            <td><?=$value['selling']?></td>
        </tr>
<?php
    
}

?>
        
    </tbody>
</table>

