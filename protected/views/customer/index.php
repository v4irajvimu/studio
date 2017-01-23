<?php
/* @var $this CustomerController */
/* @var $dataProvider CActiveDataProvider */

?>

<!---- POPUP MENUES -->

<div id="Customer-popup" class="popup_menu" form-dragable="true">
    <div id="exit"><span class="glyphicon glyphicon-remove"></span></div>
    <div class="row">
        <div class="col-sm-16">
            <h2 id="Customer-formtitle" >Insert A New Record</h2>
            <div class="cus-form">
                <form data-parsley-validate action="<?php echo Yii::app()->createUrl('Customer/create') ?>" method="post" id="Customer-form">
                    <div class="row">
                        <div class="col-sm-3">
                            <label>Customer Code: </label>
                            <input value="<?=$code?>" type="text" id="code" name="code" class="form-control" readonly required/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Customer Name: </label>
                            <input type="text" id="name" name="name" class="form-control" required/>
                        </div>
                        <div class="col-sm-4">
                            <label>NIC: </label>
                            <input type="text" id="nic" name="nic" class="form-control" required/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Address: </label>
                            <textarea id="address" name="address" class="form-control" required></textarea>
                        </div>
                        <div class="col-sm-4">
                            <label>Gender: </label>
                            <select id="gender" name="gender" class="form-control" required>
                                <option value="MALE">Male</option>
                                <option value="FEMALE">Female</option>
                                <option value="OTHER">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-9">
                            <label>Email: </label>
                            <input type="email" id="email" name="email" class="form-control" required/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <label>Fixed Line: </label>
                            <input type="text" id="tp_fixed" name="tp_fixed" class="form-control" placeholder="+947xxxxxxxx" pattern="\+\d{11}" required />
                        </div>
                        <div class="col-sm-5">
                            <label>Mobile: </label>
                            <input type="text" id="tp_mobile" name="tp_mobile" class="form-control" placeholder="+947xxxxxxxx" pattern="\+\d{11}" required />
                        </div>
                    </div>
                    <div class="row btn-row">
                        <div class="col-sm-16">
                            <button id="Customer-submitbtn" class="btn btn-default">Create</button>
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
        
        $("#Customer-form").ajaxForm({
            beforeSend: function () {
                
                return $("#Customer-form").validate({
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
                $("#Customer-form").resetForm();
                $("#Customer-add").attr("disabled", false);
                $.fn.yiiListView.update('Customer-list');                
                $("#Customer-popup").fadeOut();
                
            }
        });
        
    });    
    
    $(document).on("click","#Customer-add",function(){
        $("#Customer-formtitle").html("Insert A New Record");
        $("#Customer-submitbtn").html("Create");
        $("#Customer-form").resetForm();
        $("#Customer-form").attr("action", "<?php echo Yii::app()->createUrl('Customer/create') ?>");
        $("#Customer-popup").show();
    });    
    
    $(document).on("click",".Customer-update",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        $("#Customer-formtitle").html("Update This Record");
        $("#Customer-submitbtn").html("Update");
        
        //Handle JSON DATA to Update FORM
        $.getJSON("<?php echo Yii::app()->createUrl('Customer/jsondata') ?>/" + id).done(function(data) {
            $.each(data, function(i, item) {
                $("#Customer-form #" + i).val(item);
            });
            $("#Customer-form").attr("action", "<?php echo Yii::app()->createUrl('Customer/update') ?>/" + id);
        });        
        
        $("#Customer-popup").show();
    });
    
    $(document).on("click",".Customer-delete",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        var confirmdata = confirm("Are you sure, you want to delete this record ?");
        if(confirmdata == true){
        $.ajax({
            url : "<?php echo Yii::app()->createUrl('Customer/delete') ?>/"+id,
            type:"POST"
        }).done(function(data){
            $.fn.yiiListView.update('Customer-list'); 
        });
        }
    });
    
     $(document).on("click","#Customer-search_btn",function(){
        var searchtxt = $("#Customer-search_txt").val();
        $.fn.yiiListView.update('Customer-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#Customer-pages").val()
            }
        });
    });
    
     $(document).on("keyup","#Customer-search_txt",function(){
        var searchtxt = $("#Customer-search_txt").val();
        $.fn.yiiListView.update('Customer-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#Customer-pages").val()
            }
        });
    });
    
    $(document).on("change","#Customer-pages",function(){
        
        $.fn.yiiListView.update('Customer-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: $("#Customer-search_txt").val(),
                pages : $("#Customer-pages").val()
            }
        });
    });
    
    
</script>
<!-- //END SCRIPT -->



<div class="row">
    <div class="col-sm-16">
        <h2 class="header_topic" style="font-size: 20px;">Customers<br/>
            <span style="font-size: 14px; line-height: 16px;">Manage Customers with this Section. </span></h2>
    </div>
</div>

<div class="inner_nav">
<div class="row">
    <div class="col-sm-2">        
        <button id="Customer-add" data-model="Customer" class="btn btn-default btn-block btn-sm">Add <span class="glyphicon glyphicon-plus"></span></button>
    </div>
    <div class="col-sm-7">
        <div class="input-group">
            <input type="text" class="form-control" id="Customer-search_txt" name="search" placeholder="Search Customer ...." />
            
            <span class="input-group-btn">
                <button id="Customer-search_btn" class="btn btn-default">Search <span class="glyphicon glyphicon-search"></span></button>
            </span>
        </div>
    </div>
    <div class="col-sm-2 col-sm-push-5">
        <select id="Customer-pages" class="form-control">
            <option value="10">10 Pages</option>
            <option value="50">50 Pages</option>
            <option value="100">100 Pages</option>
        </select>
    </div>
</div>
</div>


<div class="container-fluid">

    <div class="row">
        <div class="col-sm-2 headerdiv">Code</div>
        <div class="col-sm-3 headerdiv">Name</div>
        <div class="col-sm-2 headerdiv">NIC</div>
        <div class="col-sm-3 headerdiv">Email</div>
        <div class="col-sm-2 headerdiv">Contact</div>
        <div class="col-sm-1 headerdiv">Visits</div>
        <div class="col-sm-2 headerdiv">Updated</div>
        <div class="col-sm-1 headerdiv">&nbsp;</div>
    </div>


<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    'enablePagination' => true,
    'summaryText' => false,
    'id' => 'Customer-list',
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
