<?php
/* @var $this UsersController */
/* @var $dataProvider CActiveDataProvider */

?>

<!---- POPUP MENUES -->

<div id="Users-popup" class="popup_menu" form-dragable="true">
    <div id="exit"><span class="glyphicon glyphicon-remove"></span></div>
    <div class="row">
        <div class="col-sm-16">
            <h2 id="Users-formtitle" >Insert A New Record</h2>
            <div class="cus-form">
                <form action="<?php echo Yii::app()->createUrl('Users/create') ?>" method="post" id="Users-form">
                    <div class="row">
                        <div class="col-sm-16">
                            <label>Your Column Name</label>
                            <input type="text" id="name" name="name" class="form-control" />
                        </div>
                    </div>
                    <div class="row btn-row">
                        <div class="col-sm-16">
                            <button id="Users-submitbtn" class="btn btn-default">Create</button>
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
        
        $("#Users-form").ajaxForm({
            beforeSend: function () {
                
                return $("#Users-form").validate({
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
                $("#Users-form").resetForm();
                $("#Users-add").attr("disabled", false);
                $.fn.yiiListView.update('Users-list');                
                $("#Users-popup").fadeOut();
                
            }
        });
        
    });    
    
    $(document).on("click","#Users-add",function(){
        $("#Users-formtitle").html("Insert A New Record");
        $("#Users-submitbtn").html("Create");
        $("#Users-form").resetForm();
        $("#Users-form").attr("action", "<?php echo Yii::app()->createUrl('Users/create') ?>");
        $("#Users-popup").show();
    });    
    
    $(document).on("click",".Users-update",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        $("#Users-formtitle").html("Update This Record");
        $("#Users-submitbtn").html("Update");
        
        //Handle JSON DATA to Update FORM
        $.getJSON("<?php echo Yii::app()->createUrl('Users/jsondata') ?>/" + id).done(function(data) {
            $.each(data, function(i, item) {
                $("#Users-form #" + i).val(item);
            });
            $("#Users-form").attr("action", "<?php echo Yii::app()->createUrl('Users/update') ?>/" + id);
        });        
        
        $("#Users-popup").show();
    });
    
    $(document).on("click",".Users-delete",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        var confirmdata = confirm("Are you sure, you want to delete this record ?");
        if(confirmdata == true){
        $.ajax({
            url : "<?php echo Yii::app()->createUrl('Users/delete') ?>/"+id,
            type:"POST"
        }).done(function(data){
            $.fn.yiiListView.update('Users-list'); 
        });
        }
    });
    
     $(document).on("click","#Users-search_btn",function(){
        var searchtxt = $("#Users-search_txt").val();
        $.fn.yiiListView.update('Users-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#Users-pages").val()
            }
        });
    });
    
     $(document).on("keyup","#Users-search_txt",function(){
        var searchtxt = $("#Users-search_txt").val();
        $.fn.yiiListView.update('Users-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#Users-pages").val()
            }
        });
    });
    
    $(document).on("change","#Users-pages",function(){
        
        $.fn.yiiListView.update('Users-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: $("#Users-search_txt").val(),
                pages : $("#Users-pages").val()
            }
        });
    });
    
    
</script>
<!-- //END SCRIPT -->



<div class="row">
    <div class="col-sm-16">
        <h2 class="header_topic" style="font-size: 20px;">Users<br/>
            <span style="font-size: 14px; line-height: 16px;">Manage Users with this Section. </span></h2>
    </div>
</div>

<div class="inner_nav">
<div class="row">
    <div class="col-sm-2">        
        <button id="Users-add" data-model="Users" class="btn btn-default btn-block btn-sm">Add <span class="glyphicon glyphicon-plus"></span></button>
    </div>
    <div class="col-sm-7">
        <div class="input-group">
            <input type="text" class="form-control" id="Users-search_txt" name="search" placeholder="Search Users ...." />
            
            <span class="input-group-btn">
                <button id="Users-search_btn" class="btn btn-default">Search <span class="glyphicon glyphicon-search"></span></button>
            </span>
        </div>
    </div>
    <div class="col-sm-2 col-sm-push-5">
        <select id="Users-pages" class="form-control">
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
    'id' => 'Users-list',
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
