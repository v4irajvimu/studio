<?php
/* @var $this ReservationController */
/* @var $dataProvider CActiveDataProvider */

?>

<!---- POPUP MENUES -->

<div id="Reservation-popup" class="popup_menu" form-dragable="true">
    <div id="exit"><span class="glyphicon glyphicon-remove"></span></div>
    <div class="row">
        <div class="col-sm-16">
            <h2 id="Reservation-formtitle" >Insert A New Record</h2>
            <div class="cus-form">
                <form action="<?php echo Yii::app()->createUrl('Reservation/create') ?>" method="post" id="Reservation-form">
                    <div class="row">
                        <div class="col-sm-16">
                            <label>Your Column Name</label>
                            <input type="text" id="name" name="name" class="form-control" />
                        </div>
                    </div>
                    <div class="row btn-row">
                        <div class="col-sm-16">
                            <button id="Reservation-submitbtn" class="btn btn-default">Create</button>
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
        
        $("#Reservation-form").ajaxForm({
            beforeSend: function () {
                
                return $("#Reservation-form").validate({
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
                $("#Reservation-form").resetForm();
                $("#Reservation-add").attr("disabled", false);
                $.fn.yiiListView.update('Reservation-list');                
                $("#Reservation-popup").fadeOut();
                
            }
        });
        
    });    

    $(document).on("click",".accept",function(){
        var id = $(this).attr('data-id');
        $.post("<?php echo Yii::app()->createUrl('Reservation/accept') ?>", {
              id:id
            }, function(r){
             $.fn.yiiListView.update('Reservation-list'); 
           },"text");
    });


    $(document).on("click",".reject",function(){
        var id = $(this).attr('data-id');
        $.post("<?php echo Yii::app()->createUrl('Reservation/reject') ?>", {
          id:id
        }, function(r){
         $.fn.yiiListView.update('Reservation-list'); 
       },"text");
    });
    
    $(document).on("click","#Reservation-add",function(){
        $("#Reservation-formtitle").html("Insert A New Record");
        $("#Reservation-submitbtn").html("Create");
        $("#Reservation-form").resetForm();
        $("#Reservation-form").attr("action", "<?php echo Yii::app()->createUrl('Reservation/create') ?>");
        $("#Reservation-popup").show();
    });    
    
    $(document).on("click",".Reservation-update",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        $("#Reservation-formtitle").html("Update This Record");
        $("#Reservation-submitbtn").html("Update");
        
        //Handle JSON DATA to Update FORM
        $.getJSON("<?php echo Yii::app()->createUrl('Reservation/jsondata') ?>/" + id).done(function(data) {
            $.each(data, function(i, item) {
                $("#Reservation-form #" + i).val(item);
            });
            $("#Reservation-form").attr("action", "<?php echo Yii::app()->createUrl('Reservation/update') ?>/" + id);
        });        
        
        $("#Reservation-popup").show();
    });
    
    $(document).on("click",".Reservation-delete",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        var confirmdata = confirm("Are you sure, you want to delete this record ?");
        if(confirmdata == true){
        $.ajax({
            url : "<?php echo Yii::app()->createUrl('Reservation/delete') ?>/"+id,
            type:"POST"
        }).done(function(data){
            $.fn.yiiListView.update('Reservation-list'); 
        });
        }
    });
    
     $(document).on("click","#Reservation-search_btn",function(){
        var searchtxt = $("#Reservation-search_txt").val();
        $.fn.yiiListView.update('Reservation-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#Reservation-pages").val()
            }
        });
    });
    
     $(document).on("keyup","#Reservation-search_txt",function(){
        var searchtxt = $("#Reservation-search_txt").val();
        $.fn.yiiListView.update('Reservation-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#Reservation-pages").val()
            }
        });
    });
    
    $(document).on("change","#Reservation-pages",function(){
        
        $.fn.yiiListView.update('Reservation-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: $("#Reservation-search_txt").val(),
                pages : $("#Reservation-pages").val()
            }
        });
    });
    
    
</script>
<!-- //END SCRIPT -->



<div class="row">
    <div class="col-sm-16">
        <h2 class="header_topic" style="font-size: 20px;">Reservations<br/>
            <span style="font-size: 14px; line-height: 16px;">Manage Reservations with this Section. </span></h2>
    </div>
</div>

<div class="inner_nav">
<div class="row">
    <!-- <div class="col-sm-2">        
        <button id="Reservation-add" data-model="Reservation" class="btn btn-default btn-block btn-sm">Add <span class="glyphicon glyphicon-plus"></span></button>
    </div> -->
    <div class="col-sm-9">
        <div class="input-group">
            <input type="text" class="form-control" id="Reservation-search_txt" name="search" placeholder="Search Reservation ...." />
            
            <span class="input-group-btn">
                <button id="Reservation-search_btn" class="btn btn-default">Search <span class="glyphicon glyphicon-search"></span></button>
            </span>
        </div>
    </div>
    <div class="col-sm-2 col-sm-push-5">
        <select id="Reservation-pages" class="form-control">
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
        <div class="col-sm-5 headerdiv">Package</div>
        <div class="col-sm-4 headerdiv">Customer</div>
        <div class="col-sm-2 headerdiv">Date</div>
        <div class="col-sm-2 headerdiv">Total</div>
        <div class="col-sm-1 headerdiv">&nbsp;</div>
    </div>


<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    'enablePagination' => true,
    'summaryText' => false,
    'id' => 'Reservation-list',
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
