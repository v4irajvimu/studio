<?php
/* @var $this SupplierController */
/* @var $dataProvider CActiveDataProvider */

?>

<!---- POPUP MENUES -->

<div id="Supplier-popup" class="popup_menu" form-dragable="true">
    <div id="exit"><span class="glyphicon glyphicon-remove"></span></div>
    <div class="row">
        <div class="col-sm-16">
            <h2 id="Supplier-formtitle" >Insert A New Record</h2>
            <div class="cus-form">
                <form action="<?php echo Yii::app()->createUrl('Supplier/create') ?>" data-parsley-validate method="post" id="Supplier-form">
                    <div class="row">
                        <div class="col-sm-10">
                            <label>Supplier Name: </label>
                            <input type="text" id="name" name="name" class="form-control" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-10">
                            <label>Address: </label>
                            <textarea id="address" name="address" class="form-control" required></textarea>
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
                    <div class="row">
                        <div class="col-sm-5">
                            <label>Email: </label>
                            <input type="email" id="email" name="email" class="form-control" required/>
                        </div>
                    </div>
                    <div class="row btn-row">
                        <div class="col-sm-16">
                            <button id="Supplier-submitbtn" class="btn btn-primary">Create</button>
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
        
        $("#Supplier-form").ajaxForm({
            beforeSend: function () {
                
                return $("#Supplier-form").validate({
                    rules : {
                        name : {
                            //required : true,
                        },
                        address : {
                            //required : true,
                        },
                        tp_mobile : {
                            //required : true,
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
                $("#Supplier-form").resetForm();
                $("#Supplier-add").attr("disabled", false);
                $.fn.yiiListView.update('Supplier-list');                
                $("#Supplier-popup").fadeOut();
                
            }
        });
        
    });    
    
    $(document).on("click","#Supplier-add",function(){
        $("#Supplier-formtitle").html("Insert A New Record");
        $("#Supplier-submitbtn").html("Create");
        $("#Supplier-form").resetForm();
        $("#Supplier-form").attr("action", "<?php echo Yii::app()->createUrl('Supplier/create') ?>");
        $("#Supplier-popup").show();
    });    
    
    $(document).on("click",".Supplier-update",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        $("#Supplier-formtitle").html("Update This Record");
        $("#Supplier-submitbtn").html("Update");
        
        //Handle JSON DATA to Update FORM
        $.getJSON("<?php echo Yii::app()->createUrl('Supplier/jsondata') ?>/" + id).done(function(data) {
            $.each(data, function(i, item) {
                $("#Supplier-form #" + i).val(item);
            });
            $("#Supplier-form").attr("action", "<?php echo Yii::app()->createUrl('Supplier/update') ?>/" + id);
        });        
        
        $("#Supplier-popup").show();
    });
    
    $(document).on("click",".Supplier-delete",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        var confirmdata = confirm("Are you sure, you want to delete this record ?");
        if(confirmdata == true){
        $.ajax({
            url : "<?php echo Yii::app()->createUrl('Supplier/delete') ?>/"+id,
            type:"POST"
        }).done(function(data){
            $.fn.yiiListView.update('Supplier-list'); 
        });
        }
    });
    
     $(document).on("click","#Supplier-search_btn",function(){
        var searchtxt = $("#Supplier-search_txt").val();
        $.fn.yiiListView.update('Supplier-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#Supplier-pages").val()
            }
        });
    });
    
     $(document).on("keyup","#Supplier-search_txt",function(){
        var searchtxt = $("#Supplier-search_txt").val();
        $.fn.yiiListView.update('Supplier-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#Supplier-pages").val()
            }
        });
    });
    
    $(document).on("change","#Supplier-pages",function(){
        
        $.fn.yiiListView.update('Supplier-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: $("#Supplier-search_txt").val(),
                pages : $("#Supplier-pages").val()
            }
        });
    });
    
    
</script>
<!-- //END SCRIPT -->



<div class="row">
    <div class="col-sm-16">
        <h2 class="header_topic" style="font-size: 20px;">Suppliers<br/>
            <span style="font-size: 14px; line-height: 16px;">Manage Suppliers with this Section. </span></h2>
    </div>
</div>

<div class="inner_nav">
<div class="row">
    <div class="col-sm-2">        
        <button id="Supplier-add" data-model="Supplier" class="btn btn-default btn-block btn-sm">Add <span class="glyphicon glyphicon-plus"></span></button>
    </div>
    <div class="col-sm-7">
        <div class="input-group">
            <input type="text" class="form-control" id="Supplier-search_txt" name="search" placeholder="Search Supplier ...." />
            
            <span class="input-group-btn">
                <button id="Supplier-search_btn" class="btn btn-default">Search <span class="glyphicon glyphicon-search"></span></button>
            </span>
        </div>
    </div>
    <div class="col-sm-2 col-sm-push-5">
        <select id="Supplier-pages" class="form-control">
            <option value="10">10 Pages</option>
            <option value="50">50 Pages</option>
            <option value="100">100 Pages</option>
        </select>
    </div>
</div>
</div>


<div class="container-fluid">

    <div class="row">
        <div class="col-sm-3 headerdiv">Supplier Name</div>
        <div class="col-sm-3 headerdiv">Address</div>
        <div class="col-sm-3 headerdiv">Email</div>
        <div class="col-sm-2 headerdiv">Fixed Line</div>
        <div class="col-sm-2 headerdiv">Mobile</div>
        <div class="col-sm-2 headerdiv">Created</div>
        <div class="col-sm-1 headerdiv">&nbsp;</div>
    </div>


<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    'enablePagination' => true,
    'summaryText' => false,
    'id' => 'Supplier-list',
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
