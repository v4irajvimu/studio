<?php
/* @var $this PagesController */
/* @var $data Pages */
?>


<div class="row datarow">

    <div class='col-sm-4 cells'>
        <?php
        $epaper_details = Epaper::model()->findByPk($data['epaper_id']);
        echo $epaper_details->name;
        ?>
    </div>
    <div class='col-sm-4 cells'>
        <?php echo $data['thumb']; ?>
    </div>
    <div class='col-sm-2 cells'>
        <?php echo $data['page_number']; ?>
    </div>
    <div class='col-sm-2 cells'>
        <?php echo $data['eff_year']; ?>
    </div>
    <div class='col-sm-2 cells'>
        <?php echo $data['eff_month']; ?>
    </div>
    <div class='col-sm-1 cells'>
        <?php echo $data['publication_number']; ?>
    </div>

    <div class='col-sm-1 cells btn-cog text-right'>
        <a class="Pages-update" href="#" data-id="<?php echo $data['id']; ?>" model="Pages" controler="PagesController" data-toggle="tooltip" data-placement="top" title="Update"><span class="glyphicon glyphicon-cog"></span></a>
        <a class="Pages-delete" href="#" data-id="<?php echo $data['id']; ?>" model="Pages" controler="PagesController" data-toggle="tooltip" data-placement="top" title="Delete"><span class="glyphicon glyphicon-remove"></span></a>
    </div>

</div>
