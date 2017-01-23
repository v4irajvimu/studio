<?php
/* @var $this ItemsController */
/* @var $dataProvider CActiveDataProvider */

?>

<!---- POPUP MENUES -->

<div id="Items-popup" class="popup_menu" form-dragable="true">
    <div id="exit"><span class="glyphicon glyphicon-remove"></span></div>
    <div class="row">
        <div class="col-sm-16">
            <h2 id="Items-formtitle" >Insert A New Record</h2>
            <div class="cus-form">
                <form data-parsley-validate action="<?php echo Yii::app()->createUrl('Items/create') ?>" method="post" id="Items-form">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Item Name: </label>
                            <input type="text" id="name" name="name" class="form-control" required/>
                        </div>
                        <div class="col-sm-5">
                            <label>Supplier: </label>
                            <select id="supplier_id" name="supplier_id" class="form-control" required>
                                <?php
                                $supllier_det = Supplier::model()->findAllByAttributes(
                                                array(
                                                    'online' => '1'
                                                ),
                                                array(
                                                    'order' => 'created desc'
                                                ));
                                foreach ($supllier_det as $value) {
                                    echo '<option value="'.$value->id.'">'.$value->name.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-3">
                            <label>Cost: </label>
                            <input type="text" id="cost" name="cost" class="form-control" pattern="^[0-9]*\.[0-9]{2}$" required/>
                        </div>
                        <div class="col-sm-3">
                            <label>Selling: </label>
                            <input type="text" id="selling" name="selling" class="form-control" pattern="^[0-9]*\.[0-9]{2}$" required/>
                        </div>
                        <div class="col-sm-3">
                            <label>Min Price: </label>
                            <input type="text" id="min_price" name="min_price" class="form-control" pattern="^[0-9]*\.[0-9]{2}$" required/>
                        </div>
                        <div class="col-sm-3">
                            <label>Max Price: </label>
                            <input type="text" id="max_price" name="max_price" class="form-control" pattern="^[0-9]*\.[0-9]{2}$" required/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label>Reorder Level: </label>
                            <input type="number" id="reorder_level" name="reorder_level" class="form-control"  required/>
                        </div>
                    </div>
                    <div class="row btn-row">
                        <div class="col-sm-16">
                            <button id="Items-submitbtn" class="btn btn-default">Create</button>
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
        
        $("#Items-form").ajaxForm({
            beforeSend: function () {
                
                return $("#Items-form").validate({
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
                $("#Items-form").resetForm();
                $("#Items-add").attr("disabled", false);
                $.fn.yiiListView.update('Items-list');                
                $("#Items-popup").fadeOut();
                
            }
        });
        
    });    
    
    $(document).on("click","#Items-add",function(){
        $("#Items-formtitle").html("Insert A New Record");
        $("#Items-submitbtn").html("Create");
        $("#Items-form").resetForm();
        $("#Items-form").attr("action", "<?php echo Yii::app()->createUrl('Items/create') ?>");
        $("#Items-popup").show();
    });    
    
    $(document).on("click",".Items-update",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        $("#Items-formtitle").html("Update This Record");
        $("#Items-submitbtn").html("Update");
        
        //Handle JSON DATA to Update FORM
        $.getJSON("<?php echo Yii::app()->createUrl('Items/jsondata') ?>/" + id).done(function(data) {
            $.each(data, function(i, item) {
                $("#Items-form #" + i).val(item);
            });
            $("#Items-form").attr("action", "<?php echo Yii::app()->createUrl('Items/update') ?>/" + id);
        });        
        
        $("#Items-popup").show();
    });
    
    $(document).on("click",".Items-delete",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        var confirmdata = confirm("Are you sure, you want to delete this record ?");
        if(confirmdata == true){
        $.ajax({
            url : "<?php echo Yii::app()->createUrl('Items/delete') ?>/"+id,
            type:"POST"
        }).done(function(data){
            $.fn.yiiListView.update('Items-list'); 
        });
        }
    });
    
     $(document).on("click","#Items-search_btn",function(){
        var searchtxt = $("#Items-search_txt").val();
        $.fn.yiiListView.update('Items-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#Items-pages").val()
            }
        });
    });
    
     $(document).on("keyup","#Items-search_txt",function(){
        var searchtxt = $("#Items-search_txt").val();
        $.fn.yiiListView.update('Items-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#Items-pages").val()
            }
        });
    });
    
    $(document).on("change","#Items-pages",function(){
        
        $.fn.yiiListView.update('Items-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: $("#Items-search_txt").val(),
                pages : $("#Items-pages").val()
            }
        });
    });
    
    
</script>
<!-- //END SCRIPT -->



<div class="row">
    <div class="col-sm-16">
        <h2 class="header_topic" style="font-size: 20px;">ITEMS<br/>
            <span style="font-size: 14px; line-height: 16px;">Manage Items with this Section. </span></h2>
    </div>
</div>

<div class="inner_nav">
<div class="row">
    <div class="col-sm-2">        
        <button id="Items-add" data-model="Items" class="btn btn-default btn-block btn-sm">Add <span class="glyphicon glyphicon-plus"></span></button>
    </div>
    <div class="col-sm-7">
        <div class="input-group">
            <input type="text" class="form-control" id="Items-search_txt" name="search" placeholder="Search Items ...." />
            
            <span class="input-group-btn">
                <button id="Items-search_btn" class="btn btn-default">Search <span class="glyphicon glyphicon-search"></span></button>
            </span>
        </div>
    </div>
    <div class="col-sm-2 col-sm-push-5">
        <select id="Items-pages" class="form-control">
            <option value="10">10 Pages</option>
            <option value="50">50 Pages</option>
            <option value="100">100 Pages</option>
        </select>
    </div>
</div>
</div>


<div class="container-fluid">

    <div class="row">
        <div class="col-sm-3 headerdiv">Name</div>
        <div class="col-sm-2 headerdiv">Cost</div>
        <div class="col-sm-2 headerdiv">Selling</div>
        <div class="col-sm-2 headerdiv">Min</div>
        <div class="col-sm-2 headerdiv">Price</div>
        <div class="col-sm-1 headerdiv">R/O</div>
        <div class="col-sm-3 headerdiv">Supplier</div>
        <div class="col-sm-1 headerdiv">&nbsp;</div>
    </div>


<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    'enablePagination' => true,
    'summaryText' => false,
    'id' => 'Items-list',
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
