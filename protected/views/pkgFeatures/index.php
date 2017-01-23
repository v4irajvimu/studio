<?php
/* @var $this PkgFeaturesController */
/* @var $dataProvider CActiveDataProvider */

?>

<!---- POPUP MENUES -->

<div id="PkgFeatures-popup" class="popup_menu" form-dragable="true">
    <div id="exit"><span class="glyphicon glyphicon-remove"></span></div>
    <div class="row">
        <div class="col-sm-16">
            <h2 id="PkgFeatures-formtitle" >Insert A New Record</h2>
            <div class="cus-form">
                <form data-parsley-validate action="<?php echo Yii::app()->createUrl('PkgFeatures/create') ?>" method="post" id="PkgFeatures-form">
                    <div class="row">
                        <div class="col-sm-9">
                            <label>Name</label>
                            <input type="text" id="name" name="name" class="form-control" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <label>Description: </label>
                            <textarea type="text" id="desc" name="desc" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>Cost: </label>
                            <input type="text" id="cost" name="cost" class="form-control" pattern="^[0-9]*\.[0-9]{2}$" placeholder="0.00" required/>
                        </div>
                        <div class="col-sm-3">
                            <label>Selling: </label>
                            <input type="text" id="selling" name="selling" class="form-control" pattern="^[0-9]*\.[0-9]{2}$"placeholder="0.00" required/>
                        </div>
                    </div>
                    <div class="row btn-row">
                        <div class="col-sm-16">
                            <button id="PkgFeatures-submitbtn" class="btn btn-default">Create</button>
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
        
        $("#PkgFeatures-form").ajaxForm({
            beforeSend: function () {
                
                return $("#PkgFeatures-form").validate({
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
                $("#PkgFeatures-form").resetForm();
                $("#PkgFeatures-add").attr("disabled", false);
                $.fn.yiiListView.update('PkgFeatures-list');                
                $("#PkgFeatures-popup").fadeOut();
                
            }
        });
        
    });    
    
    $(document).on("click","#PkgFeatures-add",function(){
        $("#PkgFeatures-formtitle").html("Insert A New Record");
        $("#PkgFeatures-submitbtn").html("Create");
        $("#PkgFeatures-form").resetForm();
        $("#PkgFeatures-form").attr("action", "<?php echo Yii::app()->createUrl('PkgFeatures/create') ?>");
        $("#PkgFeatures-popup").show();
    });    
    
    $(document).on("click",".PkgFeatures-update",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        $("#PkgFeatures-formtitle").html("Update This Record");
        $("#PkgFeatures-submitbtn").html("Update");
        
        //Handle JSON DATA to Update FORM
        $.getJSON("<?php echo Yii::app()->createUrl('PkgFeatures/jsondata') ?>/" + id).done(function(data) {
            $.each(data, function(i, item) {
                $("#PkgFeatures-form #" + i).val(item);
            });
            $("#PkgFeatures-form").attr("action", "<?php echo Yii::app()->createUrl('PkgFeatures/update') ?>/" + id);
        });        
        
        $("#PkgFeatures-popup").show();
    });
    
    $(document).on("click",".PkgFeatures-delete",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        var confirmdata = confirm("Are you sure, you want to delete this record ?");
        if(confirmdata == true){
        $.ajax({
            url : "<?php echo Yii::app()->createUrl('PkgFeatures/delete') ?>/"+id,
            type:"POST"
        }).done(function(data){
            $.fn.yiiListView.update('PkgFeatures-list'); 
        });
        }
    });
    
     $(document).on("click","#PkgFeatures-search_btn",function(){
        var searchtxt = $("#PkgFeatures-search_txt").val();
        $.fn.yiiListView.update('PkgFeatures-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#PkgFeatures-pages").val()
            }
        });
    });
    
     $(document).on("keyup","#PkgFeatures-search_txt",function(){
        var searchtxt = $("#PkgFeatures-search_txt").val();
        $.fn.yiiListView.update('PkgFeatures-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#PkgFeatures-pages").val()
            }
        });
    });
    
    $(document).on("change","#PkgFeatures-pages",function(){
        
        $.fn.yiiListView.update('PkgFeatures-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: $("#PkgFeatures-search_txt").val(),
                pages : $("#PkgFeatures-pages").val()
            }
        });
    });
    
    
</script>
<!-- //END SCRIPT -->



<div class="row">
    <div class="col-sm-16">
        <h2 class="header_topic" style="font-size: 20px;">PACKAGE FEATURES<br/>
            <span style="font-size: 14px; line-height: 16px;">Manage Package Features with this Section. </span></h2>
    </div>
</div>

<div class="inner_nav">
<div class="row">
    <div class="col-sm-2">        
        <button id="PkgFeatures-add" data-model="PkgFeatures" class="btn btn-default btn-block btn-sm">Add <span class="glyphicon glyphicon-plus"></span></button>
    </div>
    <div class="col-sm-7">
        <div class="input-group">
            <input type="text" class="form-control" id="PkgFeatures-search_txt" name="search" placeholder="Search Package Features ...." />
            
            <span class="input-group-btn">
                <button id="PkgFeatures-search_btn" class="btn btn-default">Search <span class="glyphicon glyphicon-search"></span></button>
            </span>
        </div>
    </div>
    <div class="col-sm-2 col-sm-push-5">
        <select id="PkgFeatures-pages" class="form-control">
            <option value="10">10 Pages</option>
            <option value="50">50 Pages</option>
            <option value="100">100 Pages</option>
        </select>
    </div>
</div>
</div>


<div class="container-fluid">

    <div class="row">
        <div class="col-sm-3 headerdiv">Name</div>
        <div class="col-sm-5 headerdiv">Description</div>
        <div class="col-sm-2 headerdiv">Cost (LKR)</div>
        <div class="col-sm-2 headerdiv">Selling (LKR)</div>
        <div class="col-sm-2 headerdiv">Created</div>
        <div class="col-sm-1 headerdiv">Hits</div>
        <div class="col-sm-1 headerdiv">&nbsp;</div>
    </div>


<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    'enablePagination' => true,
    'summaryText' => false,
    'id' => 'PkgFeatures-list',
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
