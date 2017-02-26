<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<script>
    $(document).ready(function(){
        var page = $(location).attr('href').split("/").splice(4,5);
        $("#"+page).addClass("active_");
    });
//$(document).on("click", ".side_nav a", function(){
//    //alert('sdsd');
//    var this_ = $(this);
//    $(".side_nav a").removeClass("active"); 
//    this_.addClass("active");    
//});
</script>
<div class="row">
    <div class="col-sm-3">

        <div class="side_nav">
             <h3><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/icons/trans.png" width="38px" /> Transactions</h3>
            <ul>
                <li><a id="wrkOrder"  href="<?php echo Yii::app()->createUrl("wrkOrder"); ?>">Work Order</a></li>
                <li><a id="reservation"  href="<?php echo Yii::app()->createUrl("reservation"); ?>">Reservation</a></li>
            </ul>
        </div>
        <div class="side_nav">
            <h3><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/icons/stock.png" width="38px" /> Stock</h3>
            <ul>
                <li><a id="supplier" href="<?php echo Yii::app()->createUrl("supplier"); ?>" >Supplier Management</a></li>
                <li><a id="stock" href="<?php echo Yii::app()->createUrl("stock"); ?>">Stock Management</a></li>
            </ul>
        </div>
        <div class="side_nav">
            <h3><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/icons/general.png" width="38px" /> General</h3>
            <ul>
                <li><a id="customer"  href="<?php echo Yii::app()->createUrl("customer"); ?>" >Customer Management</a></li>
                <li><a id="items" href="<?php echo Yii::app()->createUrl("items"); ?>">Item Management</a></li>
                <li><a id="package" href="<?php echo Yii::app()->createUrl("package"); ?>">Package Management</a></li>
                <li><a id="pkgFeatures" href="<?php echo Yii::app()->createUrl("pkgFeatures"); ?>">Package Features</a></li>
            </ul>
        </div>
        <div class="side_nav">
            <h3><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/icons/basic_settings.png" width="38px" /> Users Settings</h3>
            <ul>
                <li><a id="users" href="<?php echo Yii::app()->createUrl("users"); ?>" >Users</a></li>
                <li><a id="userLogs" href="<?php echo Yii::app()->createUrl("userLogs"); ?>" >Users Logs</a></li>
            </ul>
        </div>
        
        <div class="side_nav">
            <h3><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/icons/dev_settings.png" width="38px" /> Dev. Settings</h3>
            <ul>
                <li><a id="userLevels" href="<?php echo Yii::app()->createUrl("userLevels"); ?>" >User Level</a></li>
                <li><a id="company" href="<?php echo Yii::app()->createUrl("company"); ?>" >Company Setting</a></li>
            </ul>
        </div>

<!--        <div class="side_nav">
            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/icons/settings.png" width="38px" /> Basic Settings.
            <ul>
                
            </ul>
        </div>-->

    </div>
    <div class="col-sm-13">
        <?php echo $content; ?>
    </div>
</div>



<?php $this->endContent(); ?>