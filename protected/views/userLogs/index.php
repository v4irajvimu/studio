<?php
/* @var $this UserLogsController */
/* @var $dataProvider CActiveDataProvider */

?>

<!---- POPUP MENUES -->

<div id="UserLogs-popup" class="popup_menu" form-dragable="true">
    <div id="exit"><span class="glyphicon glyphicon-remove"></span></div>
    <div class="row">
        <div class="col-sm-16">
            <h2 id="UserLogs-formtitle" >Insert A New Record</h2>
            <div class="cus-form">
                <form action="<?php echo Yii::app()->createUrl('UserLogs/create') ?>" method="post" id="UserLogs-form">
                    <div class="row">
                        <div class="col-sm-16">
                            <label>Your Column Name</label>
                            <input type="text" id="name" name="name" class="form-control" />
                        </div>
                    </div>
                    <div class="row btn-row">
                        <div class="col-sm-16">
                            <button id="UserLogs-submitbtn" class="btn btn-default">Create</button>
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
        
        $("#UserLogs-form").ajaxForm({
            beforeSend: function () {
                
                return $("#UserLogs-form").validate({
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
                $("#UserLogs-form").resetForm();
                $("#UserLogs-add").attr("disabled", false);
                $.fn.yiiListView.update('UserLogs-list');                
                $("#UserLogs-popup").fadeOut();
                
            }
        });
        
    });    
    
    $(document).on("click","#UserLogs-add",function(){
        $("#UserLogs-formtitle").html("Insert A New Record");
        $("#UserLogs-submitbtn").html("Create");
        $("#UserLogs-form").resetForm();
        $("#UserLogs-form").attr("action", "<?php echo Yii::app()->createUrl('UserLogs/create') ?>");
        $("#UserLogs-popup").show();
    });    
    
    $(document).on("click",".UserLogs-update",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        $("#UserLogs-formtitle").html("Update This Record");
        $("#UserLogs-submitbtn").html("Update");
        
        //Handle JSON DATA to Update FORM
        $.getJSON("<?php echo Yii::app()->createUrl('UserLogs/jsondata') ?>/" + id).done(function(data) {
            $.each(data, function(i, item) {
                $("#UserLogs-form #" + i).val(item);
            });
            $("#UserLogs-form").attr("action", "<?php echo Yii::app()->createUrl('UserLogs/update') ?>/" + id);
        });        
        
        $("#UserLogs-popup").show();
    });
    
    $(document).on("click",".UserLogs-delete",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        var confirmdata = confirm("Are you sure, you want to delete this record ?");
        if(confirmdata == true){
        $.ajax({
            url : "<?php echo Yii::app()->createUrl('UserLogs/delete') ?>/"+id,
            type:"POST"
        }).done(function(data){
            $.fn.yiiListView.update('UserLogs-list'); 
        });
        }
    });
    
     $(document).on("click","#UserLogs-search_btn",function(){
        var searchtxt = $("#UserLogs-search_txt").val();
        $.fn.yiiListView.update('UserLogs-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#UserLogs-pages").val()
            }
        });
    });
    
     $(document).on("keyup","#UserLogs-search_txt",function(){
        var searchtxt = $("#UserLogs-search_txt").val();
        $.fn.yiiListView.update('UserLogs-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#UserLogs-pages").val()
            }
        });
    });
    
    $(document).on("change","#UserLogs-pages",function(){
        
        $.fn.yiiListView.update('UserLogs-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: $("#UserLogs-search_txt").val(),
                pages : $("#UserLogs-pages").val()
            }
        });
    });
    
    
</script>
<!-- //END SCRIPT -->



<div class="row">
    <div class="col-sm-16">
        <h2 class="header_topic" style="font-size: 20px;">USER LOGS<br/>
            <span style="font-size: 14px; line-height: 16px;">Manage User Logs with this Section. </span></h2>
    </div>
</div>

<div class="inner_nav">
<div class="row">
    <div class="col-sm-2">        
        <button disabled="" id="UserLogs-add" data-model="UserLogs" class="btn btn-default btn-block btn-sm">Add <span class="glyphicon glyphicon-plus"></span></button>
    </div>
    <div class="col-sm-7">
        <div class="input-group">
            <input type="text" class="form-control" id="UserLogs-search_txt" name="search" placeholder="Search UserLogs ...." />
            
            <span class="input-group-btn">
                <button id="UserLogs-search_btn" class="btn btn-default">Search <span class="glyphicon glyphicon-search"></span></button>
            </span>
        </div>
    </div>
    <div class="col-sm-2 col-sm-push-5">
        <select id="UserLogs-pages" class="form-control">
            <option value="10">10 Pages</option>
            <option value="50">50 Pages</option>
            <option value="100">100 Pages</option>
        </select>
    </div>
</div>
</div>


<div class="container-fluid">

    <div class="row">
        <div class="col-sm-4 headerdiv">User</div>
        <div class="col-sm-9 headerdiv">Action</div>
        <div class="col-sm-2 headerdiv">Performed At.</div>
        <div class="col-sm-1 headerdiv">&nbsp;</div>
    </div>


<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    'enablePagination' => true,
    'summaryText' => false,
    'id' => 'UserLogs-list',
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
