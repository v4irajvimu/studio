<?php
/* @var $this PackageHasPkgFeaturesController */
/* @var $dataProvider CActiveDataProvider */

?>

<!---- POPUP MENUES -->

<div id="PackageHasPkgFeatures-popup" class="popup_menu" form-dragable="true">
    <div id="exit"><span class="glyphicon glyphicon-remove"></span></div>
    <div class="row">
        <div class="col-sm-16">
            <h2 id="PackageHasPkgFeatures-formtitle" >Insert A New Record</h2>
            <div class="cus-form">
                <form action="<?php echo Yii::app()->createUrl('PackageHasPkgFeatures/create') ?>" method="post" id="PackageHasPkgFeatures-form">
                    <div class="row">
                        <div class="col-sm-16">
                            <label>Your Column Name</label>
                            <input type="text" id="name" name="name" class="form-control" />
                        </div>
                    </div>
                    <div class="row btn-row">
                        <div class="col-sm-16">
                            <button id="PackageHasPkgFeatures-submitbtn" class="btn btn-default">Create</button>
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
        
        $("#PackageHasPkgFeatures-form").ajaxForm({
            beforeSend: function () {
                
                return $("#PackageHasPkgFeatures-form").validate({
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
                $("#PackageHasPkgFeatures-form").resetForm();
                $("#PackageHasPkgFeatures-add").attr("disabled", false);
                $.fn.yiiListView.update('PackageHasPkgFeatures-list');                
                $("#PackageHasPkgFeatures-popup").fadeOut();
                
            }
        });
        
    });    
    
    $(document).on("click","#PackageHasPkgFeatures-add",function(){
        $("#PackageHasPkgFeatures-formtitle").html("Insert A New Record");
        $("#PackageHasPkgFeatures-submitbtn").html("Create");
        $("#PackageHasPkgFeatures-form").resetForm();
        $("#PackageHasPkgFeatures-form").attr("action", "<?php echo Yii::app()->createUrl('PackageHasPkgFeatures/create') ?>");
        $("#PackageHasPkgFeatures-popup").show();
    });    
    
    $(document).on("click",".PackageHasPkgFeatures-update",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        $("#PackageHasPkgFeatures-formtitle").html("Update This Record");
        $("#PackageHasPkgFeatures-submitbtn").html("Update");
        
        //Handle JSON DATA to Update FORM
        $.getJSON("<?php echo Yii::app()->createUrl('PackageHasPkgFeatures/jsondata') ?>/" + id).done(function(data) {
            $.each(data, function(i, item) {
                $("#PackageHasPkgFeatures-form #" + i).val(item);
            });
            $("#PackageHasPkgFeatures-form").attr("action", "<?php echo Yii::app()->createUrl('PackageHasPkgFeatures/update') ?>/" + id);
        });        
        
        $("#PackageHasPkgFeatures-popup").show();
    });
    
    $(document).on("click",".PackageHasPkgFeatures-delete",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        var confirmdata = confirm("Are you sure, you want to delete this record ?");
        if(confirmdata == true){
        $.ajax({
            url : "<?php echo Yii::app()->createUrl('PackageHasPkgFeatures/delete') ?>/"+id,
            type:"POST"
        }).done(function(data){
            $.fn.yiiListView.update('PackageHasPkgFeatures-list'); 
        });
        }
    });
    
     $(document).on("click","#PackageHasPkgFeatures-search_btn",function(){
        var searchtxt = $("#PackageHasPkgFeatures-search_txt").val();
        $.fn.yiiListView.update('PackageHasPkgFeatures-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#PackageHasPkgFeatures-pages").val()
            }
        });
    });
    
     $(document).on("keyup","#PackageHasPkgFeatures-search_txt",function(){
        var searchtxt = $("#PackageHasPkgFeatures-search_txt").val();
        $.fn.yiiListView.update('PackageHasPkgFeatures-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#PackageHasPkgFeatures-pages").val()
            }
        });
    });
    
    $(document).on("change","#PackageHasPkgFeatures-pages",function(){
        
        $.fn.yiiListView.update('PackageHasPkgFeatures-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: $("#PackageHasPkgFeatures-search_txt").val(),
                pages : $("#PackageHasPkgFeatures-pages").val()
            }
        });
    });
    
    
</script>
<!-- //END SCRIPT -->



<div class="row">
    <div class="col-sm-16">
        <h2 class="header_topic" style="font-size: 20px;">Package Has Pkg Features<br/>
            <span style="font-size: 14px; line-height: 16px;">Manage Package Has Pkg Features with this Section. </span></h2>
    </div>
</div>

<div class="inner_nav">
<div class="row">
    <div class="col-sm-2">        
        <button id="PackageHasPkgFeatures-add" data-model="PackageHasPkgFeatures" class="btn btn-default btn-block btn-sm">Add <span class="glyphicon glyphicon-plus"></span></button>
    </div>
    <div class="col-sm-7">
        <div class="input-group">
            <input type="text" class="form-control" id="PackageHasPkgFeatures-search_txt" name="search" placeholder="Search PackageHasPkgFeatures ...." />
            
            <span class="input-group-btn">
                <button id="PackageHasPkgFeatures-search_btn" class="btn btn-default">Search <span class="glyphicon glyphicon-search"></span></button>
            </span>
        </div>
    </div>
    <div class="col-sm-2 col-sm-push-5">
        <select id="PackageHasPkgFeatures-pages" class="form-control">
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
    'id' => 'PackageHasPkgFeatures-list',
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
