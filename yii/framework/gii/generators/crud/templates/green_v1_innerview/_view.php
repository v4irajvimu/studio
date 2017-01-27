<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $data <?php echo $this->getModelClass(); ?> */

 $change = true;
 
?>


<div class="row datarow <?php echo "<?php echo \$data['status']; ?>" ?>">

    <?php
       
    echo "<div class='col-sm-3 cells'>\n\t<?php echo \$data['code']; ?>\n</div>\n";
    echo "<div class='col-sm-5 cells'>\n\t<?php echo \$data['supplier_id']; ?>\n</div>\n";
    echo "<div class='col-sm-2 cells'>\n\t<?php echo \$data['date']; ?>\n</div>\n";
    echo "<div class='col-sm-5 cells'>\n\t<?php echo \$data['remark']; ?>\n</div>\n";
    
    ?>
    
    
    <div class='col-sm-1 cells btn-cog text-right'>
        
        
        
        <?php echo "<?php if(\$data['status'] != 'approved'){  ?>"; ?>  
        
            <a class="<?php echo $this->getModelClass(); ?>-approved" href="#" data-id="<?php echo "<?php echo \$data['{$this->tableSchema->primaryKey}']; ?>"; ?>" model="<?php echo $this->getModelClass(); ?>" controler="<?php echo $this->getControllerClass(); ?>" data-toggle="tooltip" data-placement="top" title="Approved"><span style="color: #82bd36;" class="glyphicon glyphicon-check"></span></a>
        
        <?php echo "<?php }elseif(\$change){ ?>"; ?>
            
            <a class="<?php echo $this->getModelClass(); ?>-change" href="#" data-id="<?php echo "<?php echo \$data['{$this->tableSchema->primaryKey}']; ?>"; ?>" model="<?php echo $this->getModelClass(); ?>" controler="<?php echo $this->getControllerClass(); ?>" data-toggle="tooltip" data-placement="top" title="Change Status"><span style="color: #c32020;" class="glyphicon glyphicon-fast-backward"></span></a>
        
        <?php echo "<?php }else{ ?>"; ?>
            
            
        
        <?php echo "<?php } ?>"; ?>
            
        <?php echo "<?php"; ?> 
        
        if($data['is_completed'] == 1){
            ?>
            <a target="_blank" href="<?php echo "<?php echo Yii::app()->createUrl('". $this->getModelClass() ."'); ?>" ?>/print/<?php echo "<?php echo \$data['{$this->tableSchema->primaryKey}']; ?>"; ?>" data-id="<?php echo "<?php echo \$data['{$this->tableSchema->primaryKey}']; ?>"; ?>" model="<?php echo $this->getModelClass(); ?>" controler="<?php echo $this->getControllerClass(); ?>" data-toggle="tooltip" data-placement="top" title="Print"><span class="glyphicon glyphicon-print"></span></a>
        
        <?php echo "<?php"; ?> 
        }else{
        
            ?>
            <a href="<?php echo "<?php echo Yii::app()->createUrl('". $this->getModelClass() ."'); ?>/<?php echo \$data['{$this->tableSchema->primaryKey}']; ?>" ?>" data-id="<?php echo "<?php echo \$data['{$this->tableSchema->primaryKey}']; ?>"; ?>" model="<?php echo $this->getModelClass(); ?>" controler="<?php echo $this->getControllerClass(); ?>" data-toggle="tooltip" data-placement="top" title="Update"><span class="glyphicon glyphicon-share-alt"></span></a>
            <a class="<?php echo $this->getModelClass(); ?>-delete" href="#" data-id="<?php echo "<?php echo \$data['{$this->tableSchema->primaryKey}']; ?>"; ?>" model="<?php echo $this->getModelClass(); ?>" controler="<?php echo $this->getControllerClass(); ?>" data-toggle="tooltip" data-placement="top" title="Delete"><span class="glyphicon glyphicon-remove"></span></a>
        <?php echo "<?php"; ?> 
        }
        ?>
        
    </div>

</div>
