<?php
/* @var $this PaymentTypeController */
/* @var $dataProvider CActiveDataProvider */

?>

<!---- POPUP MENUES -->

<div id="PaymentType-popup" class="popup_menu" form-dragable="true">
    <div id="exit"><span class="glyphicon glyphicon-remove"></span></div>
    <div class="row">
        <div class="col-sm-16">
            <h2 id="PaymentType-formtitle" >Insert A New Record</h2>
            <div class="cus-form">
                <form action="<?php echo Yii::app()->createUrl('PaymentType/create') ?>" method="post" id="PaymentType-form">
                    <div class="row">
                        <div class="col-sm-16">
                            <label>Your Column Name</label>
                            <input type="text" id="name" name="name" class="form-control" />
                        </div>
                    </div>
                    <div class="row btn-row">
                        <div class="col-sm-16">
                            <button id="PaymentType-submitbtn" class="btn btn-default">Create</button>
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
        
        $("#PaymentType-form").ajaxForm({
            beforeSend: function () {
                
                return $("#PaymentType-form").validate({
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
                $("#PaymentType-form").resetForm();
                $("#PaymentType-add").attr("disabled", false);
                $.fn.yiiListView.update('PaymentType-list');                
                $("#PaymentType-popup").fadeOut();
                
            }
        });
        
    });    
    
    $(document).on("click","#PaymentType-add",function(){
        $("#PaymentType-formtitle").html("Insert A New Record");
        $("#PaymentType-submitbtn").html("Create");
        $("#PaymentType-form").resetForm();
        $("#PaymentType-form").attr("action", "<?php echo Yii::app()->createUrl('PaymentType/create') ?>");
        $("#PaymentType-popup").show();
    });    
    
    $(document).on("click",".PaymentType-update",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        $("#PaymentType-formtitle").html("Update This Record");
        $("#PaymentType-submitbtn").html("Update");
        
        //Handle JSON DATA to Update FORM
        $.getJSON("<?php echo Yii::app()->createUrl('PaymentType/jsondata') ?>/" + id).done(function(data) {
            $.each(data, function(i, item) {
                $("#PaymentType-form #" + i).val(item);
            });
            $("#PaymentType-form").attr("action", "<?php echo Yii::app()->createUrl('PaymentType/update') ?>/" + id);
        });        
        
        $("#PaymentType-popup").show();
    });
    
    $(document).on("click",".PaymentType-delete",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        var confirmdata = confirm("Are you sure, you want to delete this record ?");
        if(confirmdata == true){
        $.ajax({
            url : "<?php echo Yii::app()->createUrl('PaymentType/delete') ?>/"+id,
            type:"POST"
        }).done(function(data){
            $.fn.yiiListView.update('PaymentType-list'); 
        });
        }
    });
    
     $(document).on("click","#PaymentType-search_btn",function(){
        var searchtxt = $("#PaymentType-search_txt").val();
        $.fn.yiiListView.update('PaymentType-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#PaymentType-pages").val()
            }
        });
    });
    
     $(document).on("keyup","#PaymentType-search_txt",function(){
        var searchtxt = $("#PaymentType-search_txt").val();
        $.fn.yiiListView.update('PaymentType-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#PaymentType-pages").val()
            }
        });
    });
    
    $(document).on("change","#PaymentType-pages",function(){
        
        $.fn.yiiListView.update('PaymentType-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: $("#PaymentType-search_txt").val(),
                pages : $("#PaymentType-pages").val()
            }
        });
    });
    
    
</script>
<!-- //END SCRIPT -->



<div class="row">
    <div class="col-sm-16">
        <h2 class="header_topic" style="font-size: 20px;">Payment Types<br/>
            <span style="font-size: 14px; line-height: 16px;">Manage Payment Types with this Section. </span></h2>
    </div>
</div>

<div class="inner_nav">
<div class="row">
    <div class="col-sm-2">        
        <button id="PaymentType-add" data-model="PaymentType" class="btn btn-default btn-block btn-sm">Add <span class="glyphicon glyphicon-plus"></span></button>
    </div>
    <div class="col-sm-7">
        <div class="input-group">
            <input type="text" class="form-control" id="PaymentType-search_txt" name="search" placeholder="Search PaymentType ...." />
            
            <span class="input-group-btn">
                <button id="PaymentType-search_btn" class="btn btn-default">Search <span class="glyphicon glyphicon-search"></span></button>
            </span>
        </div>
    </div>
    <div class="col-sm-2 col-sm-push-5">
        <select id="PaymentType-pages" class="form-control">
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
    'id' => 'PaymentType-list',
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
