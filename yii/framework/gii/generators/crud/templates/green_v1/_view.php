<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $data <?php echo $this->getModelClass(); ?> */
?>


<div class="row datarow">

    <?php
    $count = 0;
    foreach ($this->tableSchema->columns as $column) {       
        if (!$column->isPrimaryKey && $column->name != 'online' && $column->name != 'created'  ) {
            echo "<div class='col-sm-2 cells'>\n\t<?php echo \$data['{$column->name}']; ?>\n</div>\n";
        }        
    }
    ?>
    
    <div class='col-sm-1 cells btn-cog text-right'>
        <a class="<?php echo $this->getModelClass(); ?>-update" href="#" data-id="<?php echo "<?php echo \$data['{$this->tableSchema->primaryKey}']; ?>"; ?>" model="<?php echo $this->getModelClass(); ?>" controler="<?php echo $this->getControllerClass(); ?>" data-toggle="tooltip" data-placement="top" title="Update"><span class="glyphicon glyphicon-cog"></span></a>
        <a class="<?php echo $this->getModelClass(); ?>-delete" href="#" data-id="<?php echo "<?php echo \$data['{$this->tableSchema->primaryKey}']; ?>"; ?>" model="<?php echo $this->getModelClass(); ?>" controler="<?php echo $this->getControllerClass(); ?>" data-toggle="tooltip" data-placement="top" title="Delete"><span class="glyphicon glyphicon-remove"></span></a>
    </div>

</div>
