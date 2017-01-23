<?php
/* @var $this PaymentsController */
/* @var $dataProvider CActiveDataProvider */

?>

<!---- POPUP MENUES -->

<div id="Payments-popup" class="popup_menu" form-dragable="true">
    <div id="exit"><span class="glyphicon glyphicon-remove"></span></div>
    <div class="row">
        <div class="col-sm-16">
            <h2 id="Payments-formtitle" >Insert A New Record</h2>
            <div class="cus-form">
                <form action="<?php echo Yii::app()->createUrl('Payments/create') ?>" method="post" id="Payments-form">
                    <div class="row">
                        <div class="col-sm-16">
                            <label>Your Column Name</label>
                            <input type="text" id="name" name="name" class="form-control" />
                        </div>
                    </div>
                    <div class="row btn-row">
                        <div class="col-sm-16">
                            <button id="Payments-submitbtn" class="btn btn-default">Create</button>
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
        
        $("#Payments-form").ajaxForm({
            beforeSend: function () {
                
                return $("#Payments-form").validate({
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
                $("#Payments-form").resetForm();
                $("#Payments-add").attr("disabled", false);
                $.fn.yiiListView.update('Payments-list');                
                $("#Payments-popup").fadeOut();
                
            }
        });
        
    });    
    
    $(document).on("click","#Payments-add",function(){
        $("#Payments-formtitle").html("Insert A New Record");
        $("#Payments-submitbtn").html("Create");
        $("#Payments-form").resetForm();
        $("#Payments-form").attr("action", "<?php echo Yii::app()->createUrl('Payments/create') ?>");
        $("#Payments-popup").show();
    });    
    
    $(document).on("click",".Payments-update",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        $("#Payments-formtitle").html("Update This Record");
        $("#Payments-submitbtn").html("Update");
        
        //Handle JSON DATA to Update FORM
        $.getJSON("<?php echo Yii::app()->createUrl('Payments/jsondata') ?>/" + id).done(function(data) {
            $.each(data, function(i, item) {
                $("#Payments-form #" + i).val(item);
            });
            $("#Payments-form").attr("action", "<?php echo Yii::app()->createUrl('Payments/update') ?>/" + id);
        });        
        
        $("#Payments-popup").show();
    });
    
    $(document).on("click",".Payments-delete",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        var confirmdata = confirm("Are you sure, you want to delete this record ?");
        if(confirmdata == true){
        $.ajax({
            url : "<?php echo Yii::app()->createUrl('Payments/delete') ?>/"+id,
            type:"POST"
        }).done(function(data){
            $.fn.yiiListView.update('Payments-list'); 
        });
        }
    });
    
     $(document).on("click","#Payments-search_btn",function(){
        var searchtxt = $("#Payments-search_txt").val();
        $.fn.yiiListView.update('Payments-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#Payments-pages").val()
            }
        });
    });
    
     $(document).on("keyup","#Payments-search_txt",function(){
        var searchtxt = $("#Payments-search_txt").val();
        $.fn.yiiListView.update('Payments-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#Payments-pages").val()
            }
        });
    });
    
    $(document).on("change","#Payments-pages",function(){
        
        $.fn.yiiListView.update('Payments-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: $("#Payments-search_txt").val(),
                pages : $("#Payments-pages").val()
            }
        });
    });
    
    
</script>
<!-- //END SCRIPT -->



<div class="row">
    <div class="col-sm-16">
        <h2 class="header_topic" style="font-size: 20px;">Payments<br/>
            <span style="font-size: 14px; line-height: 16px;">Manage Payments with this Section. </span></h2>
    </div>
</div>

<div class="inner_nav">
<div class="row">
    <div class="col-sm-2">        
        <button id="Payments-add" data-model="Payments" class="btn btn-default btn-block btn-sm">Add <span class="glyphicon glyphicon-plus"></span></button>
    </div>
    <div class="col-sm-7">
        <div class="input-group">
            <input type="text" class="form-control" id="Payments-search_txt" name="search" placeholder="Search Payments ...." />
            
            <span class="input-group-btn">
                <button id="Payments-search_btn" class="btn btn-default">Search <span class="glyphicon glyphicon-search"></span></button>
            </span>
        </div>
    </div>
    <div class="col-sm-2 col-sm-push-5">
        <select id="Payments-pages" class="form-control">
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
    'id' => 'Payments-list',
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
