<?php
/* @var $this StockController */
/* @var $dataProvider CActiveDataProvider */

?>

<!---- POPUP MENUES -->

<div id="Stock-popup" class="popup_menu" form-dragable="true">
    <div id="exit"><span class="glyphicon glyphicon-remove"></span></div>
    <div class="row">
        <div class="col-sm-16">
            <h2 id="Stock-formtitle" >Insert A New Record</h2>
            <div class="cus-form">
                <form action="<?php echo Yii::app()->createUrl('Stock/create') ?>" method="post" id="Stock-form">
                    <div class="row">
                        <div class="col-sm-16">
                            <label>Your Column Name</label>
                            <input type="text" id="name" name="name" class="form-control" />
                        </div>
                    </div>
                    <div class="row btn-row">
                        <div class="col-sm-16">
                            <button id="Stock-submitbtn" class="btn btn-default">Create</button>
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
        
        $("#Stock-form").ajaxForm({
            beforeSend: function () {
                
                return $("#Stock-form").validate({
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
                $("#Stock-form").resetForm();
                $("#Stock-add").attr("disabled", false);
                $.fn.yiiListView.update('Stock-list');                
                $("#Stock-popup").fadeOut();
                
            }
        });
        
    });    
    
    $(document).on("click","#Stock-add",function(){
        $("#Stock-formtitle").html("Insert A New Record");
        $("#Stock-submitbtn").html("Create");
        $("#Stock-form").resetForm();
        $("#Stock-form").attr("action", "<?php echo Yii::app()->createUrl('Stock/create') ?>");
        $("#Stock-popup").show();
    });    
    
    $(document).on("click",".Stock-update",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        $("#Stock-formtitle").html("Update This Record");
        $("#Stock-submitbtn").html("Update");
        
        //Handle JSON DATA to Update FORM
        $.getJSON("<?php echo Yii::app()->createUrl('Stock/jsondata') ?>/" + id).done(function(data) {
            $.each(data, function(i, item) {
                $("#Stock-form #" + i).val(item);
            });
            $("#Stock-form").attr("action", "<?php echo Yii::app()->createUrl('Stock/update') ?>/" + id);
        });        
        
        $("#Stock-popup").show();
    });
    
    $(document).on("click",".Stock-delete",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        var confirmdata = confirm("Are you sure, you want to delete this record ?");
        if(confirmdata == true){
        $.ajax({
            url : "<?php echo Yii::app()->createUrl('Stock/delete') ?>/"+id,
            type:"POST"
        }).done(function(data){
            $.fn.yiiListView.update('Stock-list'); 
        });
        }
    });
    
     $(document).on("click","#Stock-search_btn",function(){
        var searchtxt = $("#Stock-search_txt").val();
        $.fn.yiiListView.update('Stock-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#Stock-pages").val()
            }
        });
    });
    
     $(document).on("keyup","#Stock-search_txt",function(){
        var searchtxt = $("#Stock-search_txt").val();
        $.fn.yiiListView.update('Stock-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#Stock-pages").val()
            }
        });
    });
    
    $(document).on("change","#Stock-pages",function(){
        
        $.fn.yiiListView.update('Stock-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: $("#Stock-search_txt").val(),
                pages : $("#Stock-pages").val()
            }
        });
    });
    
    
</script>
<!-- //END SCRIPT -->



<div class="row">
    <div class="col-sm-16">
        <h2 class="header_topic" style="font-size: 20px;">Stocks<br/>
            <span style="font-size: 14px; line-height: 16px;">Manage Stocks with this Section. </span></h2>
    </div>
</div>

<div class="inner_nav">
<div class="row">
    <div class="col-sm-2">        
        <button id="Stock-add" data-model="Stock" class="btn btn-default btn-block btn-sm">Add <span class="glyphicon glyphicon-plus"></span></button>
    </div>
    <div class="col-sm-7">
        <div class="input-group">
            <input type="text" class="form-control" id="Stock-search_txt" name="search" placeholder="Search Stock ...." />
            
            <span class="input-group-btn">
                <button id="Stock-search_btn" class="btn btn-default">Search <span class="glyphicon glyphicon-search"></span></button>
            </span>
        </div>
    </div>
    <div class="col-sm-2 col-sm-push-5">
        <select id="Stock-pages" class="form-control">
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
    'id' => 'Stock-list',
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
