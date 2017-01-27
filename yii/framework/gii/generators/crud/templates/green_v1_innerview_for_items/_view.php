<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $data <?php echo $this->getModelClass(); ?> */

$item = Items::model()->findByPk($data['items_id']);

$totalValuation = $data['qty'] * $data['cost'];
$totalMarket = $data['qty'] * $data['selling'];


?>


<div class="row datarow">

    <div class='col-sm-2 cells'>
        <?php echo "<?php"; ?> echo $item->code; ?>
    </div>
    <div class='col-sm-5 cells'>
        <?php echo "<?php"; ?> echo $item->description; ?>
    </div>
    <div class='col-sm-2 cells text-right textInput' key='cost' data-id="<?php echo "<?php"; ?> echo $data['id']; ?>" val="<?php echo "<?php"; ?> echo $data['cost']; ?>" valintext="<?php echo "<?php"; ?> echo number_format($data['cost'],2); ?>">
        <?php echo "<?php"; ?> echo number_format($data['cost'],2); ?>
    </div>
    <div class='col-sm-2 cells text-right textInput' key='selling' data-id="<?php echo "<?php"; ?> echo $data['id']; ?>" val="<?php echo "<?php"; ?> echo $data['selling']; ?>" valintext="<?php echo "<?php"; ?> echo number_format($data['selling'],2); ?>">
        <?php echo "<?php"; ?> echo number_format($data['selling'],2); ?>
    </div>
    <div class='col-sm-2 cells text-right textInput' key='qty' data-id="<?php echo "<?php"; ?> echo $data['id']; ?>" val="<?php echo "<?php"; ?> echo $data['qty']; ?>" valintext="<?php echo "<?php"; ?> echo number_format($data['qty'],2); ?>">
        <?php echo "<?php"; ?> echo number_format($data['qty'],2); ?>
    </div>
    <div class='col-sm-2 cells text-right'>
        <?php echo "<?php"; ?> echo number_format($totalValuation,2); ?>
    </div>

    <div class='col-sm-1 cells btn-cog text-right'>        
        <a class="SoItems-delete" href="#" data-id="<?php echo "<?php"; ?> echo $data['id']; ?>" model="SoItems" controler="SoItemsController" data-toggle="tooltip" data-placement="top" title="Delete"><span class="glyphicon glyphicon-remove"></span></a>
    </div>

</div>
