<?php
/* @var $this WoStatusController */
/* @var $dataProvider CActiveDataProvider */

?>

<!---- POPUP MENUES -->

<div id="WoStatus-popup" class="popup_menu" form-dragable="true">
    <div id="exit"><span class="glyphicon glyphicon-remove"></span></div>
    <div class="row">
        <div class="col-sm-16">
            <h2 id="WoStatus-formtitle" >Insert A New Record</h2>
            <div class="cus-form">
                <form action="<?php echo Yii::app()->createUrl('WoStatus/create') ?>" method="post" id="WoStatus-form">
                    <div class="row">
                        <div class="col-sm-16">
                            <label>Your Column Name</label>
                            <input type="text" id="name" name="name" class="form-control" />
                        </div>
                    </div>
                    <div class="row btn-row">
                        <div class="col-sm-16">
                            <button id="WoStatus-submitbtn" class="btn btn-default">Create</button>
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
        
        $("#WoStatus-form").ajaxForm({
            beforeSend: function () {
                
                return $("#WoStatus-form").validate({
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
                $("#WoStatus-form").resetForm();
                $("#WoStatus-add").attr("disabled", false);
                $.fn.yiiListView.update('WoStatus-list');                
                $("#WoStatus-popup").fadeOut();
                
            }
        });
        
    });    
    
    $(document).on("click","#WoStatus-add",function(){
        $("#WoStatus-formtitle").html("Insert A New Record");
        $("#WoStatus-submitbtn").html("Create");
        $("#WoStatus-form").resetForm();
        $("#WoStatus-form").attr("action", "<?php echo Yii::app()->createUrl('WoStatus/create') ?>");
        $("#WoStatus-popup").show();
    });    
    
    $(document).on("click",".WoStatus-update",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        $("#WoStatus-formtitle").html("Update This Record");
        $("#WoStatus-submitbtn").html("Update");
        
        //Handle JSON DATA to Update FORM
        $.getJSON("<?php echo Yii::app()->createUrl('WoStatus/jsondata') ?>/" + id).done(function(data) {
            $.each(data, function(i, item) {
                $("#WoStatus-form #" + i).val(item);
            });
            $("#WoStatus-form").attr("action", "<?php echo Yii::app()->createUrl('WoStatus/update') ?>/" + id);
        });        
        
        $("#WoStatus-popup").show();
    });
    
    $(document).on("click",".WoStatus-delete",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        var confirmdata = confirm("Are you sure, you want to delete this record ?");
        if(confirmdata == true){
        $.ajax({
            url : "<?php echo Yii::app()->createUrl('WoStatus/delete') ?>/"+id,
            type:"POST"
        }).done(function(data){
            $.fn.yiiListView.update('WoStatus-list'); 
        });
        }
    });
    
     $(document).on("click","#WoStatus-search_btn",function(){
        var searchtxt = $("#WoStatus-search_txt").val();
        $.fn.yiiListView.update('WoStatus-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#WoStatus-pages").val()
            }
        });
    });
    
     $(document).on("keyup","#WoStatus-search_txt",function(){
        var searchtxt = $("#WoStatus-search_txt").val();
        $.fn.yiiListView.update('WoStatus-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#WoStatus-pages").val()
            }
        });
    });
    
    $(document).on("change","#WoStatus-pages",function(){
        
        $.fn.yiiListView.update('WoStatus-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: $("#WoStatus-search_txt").val(),
                pages : $("#WoStatus-pages").val()
            }
        });
    });
    
    
</script>
<!-- //END SCRIPT -->



<div class="row">
    <div class="col-sm-16">
        <h2 class="header_topic" style="font-size: 20px;">Wo Statuses<br/>
            <span style="font-size: 14px; line-height: 16px;">Manage Wo Statuses with this Section. </span></h2>
    </div>
</div>

<div class="inner_nav">
<div class="row">
    <div class="col-sm-2">        
        <button id="WoStatus-add" data-model="WoStatus" class="btn btn-default btn-block btn-sm">Add <span class="glyphicon glyphicon-plus"></span></button>
    </div>
    <div class="col-sm-7">
        <div class="input-group">
            <input type="text" class="form-control" id="WoStatus-search_txt" name="search" placeholder="Search WoStatus ...." />
            
            <span class="input-group-btn">
                <button id="WoStatus-search_btn" class="btn btn-default">Search <span class="glyphicon glyphicon-search"></span></button>
            </span>
        </div>
    </div>
    <div class="col-sm-2 col-sm-push-5">
        <select id="WoStatus-pages" class="form-control">
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
    'id' => 'WoStatus-list',
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
