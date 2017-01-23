<?php
/* @var $this WrkOrderController */
/* @var $dataProvider CActiveDataProvider */

?>

<!---- POPUP MENUES -->

<div id="WrkOrder-popup" class="popup_menu" form-dragable="true">
    <div id="exit"><span class="glyphicon glyphicon-remove"></span></div>
    <div class="row">
        <div class="col-sm-16">
            <h2 id="WrkOrder-formtitle" >Insert A New Record</h2>
            <div class="cus-form">
                <form action="<?php echo Yii::app()->createUrl('WrkOrder/create') ?>" method="post" id="WrkOrder-form">
                    <div class="row">
                        <div class="col-sm-16">
                            <label>Your Column Name</label>
                            <input type="text" id="name" name="name" class="form-control" />
                        </div>
                    </div>
                    <div class="row btn-row">
                        <div class="col-sm-16">
                            <button id="WrkOrder-submitbtn" class="btn btn-default">Create</button>
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
        
        $("#WrkOrder-form").ajaxForm({
            beforeSend: function () {
                
                return $("#WrkOrder-form").validate({
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
                $("#WrkOrder-form").resetForm();
                $("#WrkOrder-add").attr("disabled", false);
                $.fn.yiiListView.update('WrkOrder-list');                
                $("#WrkOrder-popup").fadeOut();
                
            }
        });
        
    });    
    
    $(document).on("click","#WrkOrder-add",function(){
        $("#WrkOrder-formtitle").html("Insert A New Record");
        $("#WrkOrder-submitbtn").html("Create");
        $("#WrkOrder-form").resetForm();
        $("#WrkOrder-form").attr("action", "<?php echo Yii::app()->createUrl('WrkOrder/create') ?>");
        $("#WrkOrder-popup").show();
    });    
    
    $(document).on("click",".WrkOrder-update",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        $("#WrkOrder-formtitle").html("Update This Record");
        $("#WrkOrder-submitbtn").html("Update");
        
        //Handle JSON DATA to Update FORM
        $.getJSON("<?php echo Yii::app()->createUrl('WrkOrder/jsondata') ?>/" + id).done(function(data) {
            $.each(data, function(i, item) {
                $("#WrkOrder-form #" + i).val(item);
            });
            $("#WrkOrder-form").attr("action", "<?php echo Yii::app()->createUrl('WrkOrder/update') ?>/" + id);
        });        
        
        $("#WrkOrder-popup").show();
    });
    
    $(document).on("click",".WrkOrder-delete",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        var confirmdata = confirm("Are you sure, you want to delete this record ?");
        if(confirmdata == true){
        $.ajax({
            url : "<?php echo Yii::app()->createUrl('WrkOrder/delete') ?>/"+id,
            type:"POST"
        }).done(function(data){
            $.fn.yiiListView.update('WrkOrder-list'); 
        });
        }
    });
    
     $(document).on("click","#WrkOrder-search_btn",function(){
        var searchtxt = $("#WrkOrder-search_txt").val();
        $.fn.yiiListView.update('WrkOrder-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#WrkOrder-pages").val()
            }
        });
    });
    
     $(document).on("keyup","#WrkOrder-search_txt",function(){
        var searchtxt = $("#WrkOrder-search_txt").val();
        $.fn.yiiListView.update('WrkOrder-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#WrkOrder-pages").val()
            }
        });
    });
    
    $(document).on("change","#WrkOrder-pages",function(){
        
        $.fn.yiiListView.update('WrkOrder-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: $("#WrkOrder-search_txt").val(),
                pages : $("#WrkOrder-pages").val()
            }
        });
    });
    
    
</script>
<!-- //END SCRIPT -->



<div class="row">
    <div class="col-sm-16">
        <h2 class="header_topic" style="font-size: 20px;">Wrk Orders<br/>
            <span style="font-size: 14px; line-height: 16px;">Manage Wrk Orders with this Section. </span></h2>
    </div>
</div>

<div class="inner_nav">
<div class="row">
    <div class="col-sm-2">        
        <button id="WrkOrder-add" data-model="WrkOrder" class="btn btn-default btn-block btn-sm">Add <span class="glyphicon glyphicon-plus"></span></button>
    </div>
    <div class="col-sm-7">
        <div class="input-group">
            <input type="text" class="form-control" id="WrkOrder-search_txt" name="search" placeholder="Search WrkOrder ...." />
            
            <span class="input-group-btn">
                <button id="WrkOrder-search_btn" class="btn btn-default">Search <span class="glyphicon glyphicon-search"></span></button>
            </span>
        </div>
    </div>
    <div class="col-sm-2 col-sm-push-5">
        <select id="WrkOrder-pages" class="form-control">
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
    'id' => 'WrkOrder-list',
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
