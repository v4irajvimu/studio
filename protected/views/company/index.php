<?php
/* @var $this CompanyController */
/* @var $dataProvider CActiveDataProvider */

?>

<!---- POPUP MENUES -->

<div id="Company-popup" class="popup_menu" form-dragable="true">
    <div id="exit"><span class="glyphicon glyphicon-remove"></span></div>
    <div class="row">
        <div class="col-sm-16">
            <h2 id="Company-formtitle" >Insert A New Record</h2>
            <div class="cus-form">
                <form action="<?php echo Yii::app()->createUrl('Company/create') ?>" method="post" id="Company-form">
                    <div class="row">
                        <div class="col-sm-16">
                            <label>Your Column Name</label>
                            <input type="text" id="name" name="name" class="form-control" />
                        </div>
                    </div>
                    <div class="row btn-row">
                        <div class="col-sm-16">
                            <button id="Company-submitbtn" class="btn btn-default">Create</button>
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
        
        $("#Company-form").ajaxForm({
            beforeSend: function () {
                
                return $("#Company-form").validate({
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
                $("#Company-form").resetForm();
                $("#Company-add").attr("disabled", false);
                $.fn.yiiListView.update('Company-list');                
                $("#Company-popup").fadeOut();
                
            }
        });
        
    });    
    
    $(document).on("click","#Company-add",function(){
        $("#Company-formtitle").html("Insert A New Record");
        $("#Company-submitbtn").html("Create");
        $("#Company-form").resetForm();
        $("#Company-form").attr("action", "<?php echo Yii::app()->createUrl('Company/create') ?>");
        $("#Company-popup").show();
    });    
    
    $(document).on("click",".Company-update",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        $("#Company-formtitle").html("Update This Record");
        $("#Company-submitbtn").html("Update");
        
        //Handle JSON DATA to Update FORM
        $.getJSON("<?php echo Yii::app()->createUrl('Company/jsondata') ?>/" + id).done(function(data) {
            $.each(data, function(i, item) {
                $("#Company-form #" + i).val(item);
            });
            $("#Company-form").attr("action", "<?php echo Yii::app()->createUrl('Company/update') ?>/" + id);
        });        
        
        $("#Company-popup").show();
    });
    
    $(document).on("click",".Company-delete",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        var confirmdata = confirm("Are you sure, you want to delete this record ?");
        if(confirmdata == true){
        $.ajax({
            url : "<?php echo Yii::app()->createUrl('Company/delete') ?>/"+id,
            type:"POST"
        }).done(function(data){
            $.fn.yiiListView.update('Company-list'); 
        });
        }
    });
    
     $(document).on("click","#Company-search_btn",function(){
        var searchtxt = $("#Company-search_txt").val();
        $.fn.yiiListView.update('Company-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#Company-pages").val()
            }
        });
    });
    
     $(document).on("keyup","#Company-search_txt",function(){
        var searchtxt = $("#Company-search_txt").val();
        $.fn.yiiListView.update('Company-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#Company-pages").val()
            }
        });
    });
    
    $(document).on("change","#Company-pages",function(){
        
        $.fn.yiiListView.update('Company-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: $("#Company-search_txt").val(),
                pages : $("#Company-pages").val()
            }
        });
    });
    
    
</script>
<!-- //END SCRIPT -->



<div class="row">
    <div class="col-sm-16">
        <h2 class="header_topic" style="font-size: 20px;">Companies<br/>
            <span style="font-size: 14px; line-height: 16px;">Manage Companies with this Section. </span></h2>
    </div>
</div>

<div class="inner_nav">
<div class="row">
    <div class="col-sm-2">        
        <button id="Company-add" data-model="Company" class="btn btn-default btn-block btn-sm">Add <span class="glyphicon glyphicon-plus"></span></button>
    </div>
    <div class="col-sm-7">
        <div class="input-group">
            <input type="text" class="form-control" id="Company-search_txt" name="search" placeholder="Search Company ...." />
            
            <span class="input-group-btn">
                <button id="Company-search_btn" class="btn btn-default">Search <span class="glyphicon glyphicon-search"></span></button>
            </span>
        </div>
    </div>
    <div class="col-sm-2 col-sm-push-5">
        <select id="Company-pages" class="form-control">
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
    'id' => 'Company-list',
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
