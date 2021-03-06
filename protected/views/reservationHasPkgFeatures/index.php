<?php
/* @var $this ReservationHasPkgFeaturesController */
/* @var $dataProvider CActiveDataProvider */

?>

<!---- POPUP MENUES -->

<div id="ReservationHasPkgFeatures-popup" class="popup_menu" form-dragable="true">
    <div id="exit"><span class="glyphicon glyphicon-remove"></span></div>
    <div class="row">
        <div class="col-sm-16">
            <h2 id="ReservationHasPkgFeatures-formtitle" >Insert A New Record</h2>
            <div class="cus-form">
                <form action="<?php echo Yii::app()->createUrl('ReservationHasPkgFeatures/create') ?>" method="post" id="ReservationHasPkgFeatures-form">
                    <div class="row">
                        <div class="col-sm-16">
                            <label>Your Column Name</label>
                            <input type="text" id="name" name="name" class="form-control" />
                        </div>
                    </div>
                    <div class="row btn-row">
                        <div class="col-sm-16">
                            <button id="ReservationHasPkgFeatures-submitbtn" class="btn btn-default">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--- POPUP MENU END -->

<!--- Script -->
<script>
    
    $(document).ready(function(){
        
        $("#ReservationHasPkgFeatures-form").ajaxForm({
            beforeSend: function () {
                
                return $("#ReservationHasPkgFeatures-form").validate({
                    rules : {
                        name : {
                            required : true,
                        }
                    },
                    messages : {
                        name : {
                            max : "Customize Your Error"
                        }
                    }
                }).form();
                
            },
            success: showResponse,
            complete: function () {
                $("#ReservationHasPkgFeatures-form").resetForm();
                $("#ReservationHasPkgFeatures-add").attr("disabled", false);
                $.fn.yiiListView.update('ReservationHasPkgFeatures-list');                
                $("#ReservationHasPkgFeatures-popup").fadeOut();
                
            }
        });
        
    });    
    
    $(document).on("click","#ReservationHasPkgFeatures-add",function(){
        $("#ReservationHasPkgFeatures-formtitle").html("Insert A New Record");
        $("#ReservationHasPkgFeatures-submitbtn").html("Create");
        $("#ReservationHasPkgFeatures-form").resetForm();
        $("#ReservationHasPkgFeatures-form").attr("action", "<?php echo Yii::app()->createUrl('ReservationHasPkgFeatures/create') ?>");
        $("#ReservationHasPkgFeatures-popup").show();
    });    
    
    $(document).on("click",".ReservationHasPkgFeatures-update",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        $("#ReservationHasPkgFeatures-formtitle").html("Update This Record");
        $("#ReservationHasPkgFeatures-submitbtn").html("Update");
        
        //Handle JSON DATA to Update FORM
        $.getJSON("<?php echo Yii::app()->createUrl('ReservationHasPkgFeatures/jsondata') ?>/" + id).done(function(data) {
            $.each(data, function(i, item) {
                $("#ReservationHasPkgFeatures-form #" + i).val(item);
            });
            $("#ReservationHasPkgFeatures-form").attr("action", "<?php echo Yii::app()->createUrl('ReservationHasPkgFeatures/update') ?>/" + id);
        });        
        
        $("#ReservationHasPkgFeatures-popup").show();
    });
    
    $(document).on("click",".ReservationHasPkgFeatures-delete",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        var confirmdata = confirm("Are you sure, you want to delete this record ?");
        if(confirmdata == true){
        $.ajax({
            url : "<?php echo Yii::app()->createUrl('ReservationHasPkgFeatures/delete') ?>/"+id,
            type:"POST"
        }).done(function(data){
            $.fn.yiiListView.update('ReservationHasPkgFeatures-list'); 
        });
        }
    });
    
     $(document).on("click","#ReservationHasPkgFeatures-search_btn",function(){
        var searchtxt = $("#ReservationHasPkgFeatures-search_txt").val();
        $.fn.yiiListView.update('ReservationHasPkgFeatures-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#ReservationHasPkgFeatures-pages").val()
            }
        });
    });
    
     $(document).on("keyup","#ReservationHasPkgFeatures-search_txt",function(){
        var searchtxt = $("#ReservationHasPkgFeatures-search_txt").val();
        $.fn.yiiListView.update('ReservationHasPkgFeatures-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#ReservationHasPkgFeatures-pages").val()
            }
        });
    });
    
    $(document).on("change","#ReservationHasPkgFeatures-pages",function(){
        
        $.fn.yiiListView.update('ReservationHasPkgFeatures-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: $("#ReservationHasPkgFeatures-search_txt").val(),
                pages : $("#ReservationHasPkgFeatures-pages").val()
            }
        });
    });
    
    
</script>
<!-- //END SCRIPT -->



<div class="row">
    <div class="col-sm-16">
        <h2 class="header_topic" style="font-size: 20px;">Reservation Has Pkg Features<br/>
            <span style="font-size: 14px; line-height: 16px;">Manage Reservation Has Pkg Features with this Section. </span></h2>
    </div>
</div>

<div class="inner_nav">
<div class="row">
    <div class="col-sm-2">        
        <button id="ReservationHasPkgFeatures-add" data-model="ReservationHasPkgFeatures" class="btn btn-default btn-block btn-sm">Add <span class="glyphicon glyphicon-plus"></span></button>
    </div>
    <div class="col-sm-7">
        <div class="input-group">
            <input type="text" class="form-control" id="ReservationHasPkgFeatures-search_txt" name="search" placeholder="Search ReservationHasPkgFeatures ...." />
            
            <span class="input-group-btn">
                <button id="ReservationHasPkgFeatures-search_btn" class="btn btn-default">Search <span class="glyphicon glyphicon-search"></span></button>
            </span>
        </div>
    </div>
    <div class="col-sm-2 col-sm-push-5">
        <select id="ReservationHasPkgFeatures-pages" class="form-control">
            <option value="10">10 Pages</option>
            <option value="50">50 Pages</option>
            <option value="100">100 Pages</option>
        </select>
    </div>
</div>
</div>


<div class="container-fluid">

    <div class="row">
        <div class="col-sm-15 headerdiv">Your Column Name</div>
        <div class="col-sm-1 headerdiv">&nbsp;</div>
    </div>


<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    'enablePagination' => true,
    'summaryText' => false,
    'id' => 'ReservationHasPkgFeatures-list',
    'emptyTagName' => 'p',
    'emptyText' => '<span class="glyphicon glyphicon-file"></span> No Records  ',
    'itemsTagName' => 'div',
    'itemsCssClass' => 'container-fluid',
    'pagerCssClass' => 'pagination-div',
    'pager' => array(
    "header" => "",
    "htmlOptions" => array(
        "class" => "pagination pagination-sm"
        ),
        'selectedPageCssClass' => 'active',
        'nextPageLabel' => 'Next',
        'lastPageLabel' => 'Last',
        'prevPageLabel' => 'Previous',
        'firstPageLabel' => 'First',
        'maxButtonCount' => 10
        ),
    )); ?>

</div>
