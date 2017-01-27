<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
$labeltxt = $this->pluralize($this->class2name($this->modelClass));
$label = $this->modelClass;

?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $dataProvider CActiveDataProvider */

?>


<!-- POPUP WARNING --->
<div id="<?php echo $label; ?>-warning" class="popup_menu warining_popup" form-dragable="false" >
    <div id="exit"><span class="glyphicon glyphicon-remove"></span></div>
    <div class="row">
        <div class="col-sm-16">
            <h1>Please Confirm Before Change !</h1>
            <p>If you select Pending, then this record changed to Pending mode and you can Edit. but if you select Cancel then this record will deactivated for all transactions but keep the details</p>
            
            <form action="<?php echo "<?php echo Yii::app()->createUrl('". $this->modelClass ."/changestatus') ?>"  ?>" method="post" id="<?php echo $label; ?>-warningform">
            <div class="row">
                <div class="col-sm-6">
                    <input type="hidden" id="warining-id" name="id" value="" />
                    <select name="status" id="valForStatus" class="form-control">
                        <option value="pending">Change to Pending Status</option>
                        <option value="cancled">Cancel This record</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <button id="warning_confirm" class="btn btn-default btn-green">OK Confirm!</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

<!---- POPUP MENUES -->

<div id="<?php echo $label; ?>-popup" class="popup_menu" form-dragable="true">
    <div id="exit"><span class="glyphicon glyphicon-remove"></span></div>
    <div class="row">
        <div class="col-sm-16">
            <h2 id="<?php echo $label; ?>-formtitle" >Insert A New Record</h2>
            <div class="cus-form">
                <form action="<?php echo "<?php echo Yii::app()->createUrl('". $this->modelClass ."/create') ?>"  ?>" method="post" id="<?php echo $label; ?>-form">
                    <div class="row">
                        <div class="col-sm-16">
                            <label>Your Column Name</label>
                            <input type="text" id="name" name="name" class="form-control" />
                        </div>
                    </div>
                    <div class="row btn-row">
                        <div class="col-sm-16">
                            <button id="<?php echo $label; ?>-submitbtn" class="btn btn-default">Create</button>
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
        
        $("#<?php echo $label; ?>-warningform").ajaxForm({
            beforeSend: function () {                
                return $("#<?php echo $label; ?>-warningform").validate().form();                
            },
            success: showResponse,
            complete: function () {
                $("#<?php echo $label; ?>-warningform").resetForm();
                $.fn.yiiListView.update('<?php echo $label; ?>-list');                
                $("#<?php echo $label; ?>-warning").fadeOut();                
            }
        });
        
        
        $("#<?php echo $label; ?>-form").ajaxForm({
            beforeSend: function () {
                
                return $("#<?php echo $label; ?>-form").validate({
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
                $("#<?php echo $label; ?>-form").resetForm();
                $("#<?php echo $label; ?>-add").attr("disabled", false);
                $.fn.yiiListView.update('<?php echo $label; ?>-list');                
                $("#<?php echo $label; ?>-popup").fadeOut();
                
            }
        });
        
        
        
    });    
    
    $(document).on("click","#<?php echo $label; ?>-add",function(){
        $("#<?php echo $label; ?>-formtitle").html("Insert A New Record");
        $("#<?php echo $label; ?>-submitbtn").html("Create");
        $("#<?php echo $label; ?>-form").resetForm();
        $("#<?php echo $label; ?>-form").attr("action", "<?php echo "<?php echo Yii::app()->createUrl('". $this->modelClass ."/create') ?>"  ?>");
        $("#<?php echo $label; ?>-popup").show();
    });    
    
    $(document).on("click",".<?php echo $this->modelClass; ?>-update",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        $("#<?php echo $label; ?>-formtitle").html("Update This Record");
        $("#<?php echo $label; ?>-submitbtn").html("Update");
        
        //Handle JSON DATA to Update FORM
        $.getJSON("<?php echo "<?php echo Yii::app()->createUrl('". $this->modelClass ."/jsondata') ?>"; ?>/" + id).done(function(data) {
            $.each(data, function(i, item) {
                $("#<?php echo $label; ?>-form #" + i).val(item);
            });
            $("#<?php echo $label; ?>-form").attr("action", "<?php echo "<?php echo Yii::app()->createUrl('". $this->modelClass ."/update') ?>"; ?>/" + id);
        });        
        
        $("#<?php echo $label; ?>-popup").show();
    });
    
    
    $(document).on("click",".<?php echo $this->modelClass; ?>-approved",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        $.ajax({
            url : "<?php echo "<?php echo Yii::app()->createUrl('". $this->modelClass ."/approved') ?>"; ?>/"+id,
            type:"POST",
            success: showResponse
        }).done(function(data){
            $.fn.yiiListView.update('<?php echo $label; ?>-list'); 
        });
    });
    
    $(document).on("click",".<?php echo $this->modelClass; ?>-change",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        $("#<?php echo $this->modelClass; ?>-warning #warining-id").val(id);
        $("#<?php echo $this->modelClass; ?>-warning").slideDown();
    });
    
    
    $(document).on("click",".<?php echo $this->modelClass; ?>-delete",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        var confirmdata = confirm("Are you sure, you want to delete this record ?");
        if(confirmdata == true){
        $.ajax({
            url : "<?php echo "<?php echo Yii::app()->createUrl('". $this->modelClass ."/delete') ?>"; ?>/"+id,
            type:"POST",
            success : showResponse
        }).done(function(data){
            $.fn.yiiListView.update('<?php echo $label; ?>-list'); 
        });
        }
    });
    
     $(document).on("click","#<?php echo $label; ?>-search_btn",function(){
        var searchtxt = $("#<?php echo $label; ?>-search_txt").val();
        $.fn.yiiListView.update('<?php echo $label; ?>-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#<?php echo $label; ?>-pages").val()
            }
        });
    });
    
     $(document).on("keyup","#<?php echo $label; ?>-search_txt",function(){
        var searchtxt = $("#<?php echo $label; ?>-search_txt").val();
        $.fn.yiiListView.update('<?php echo $label; ?>-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#<?php echo $label; ?>-pages").val()
            }
        });
    });
    
    $(document).on("change","#<?php echo $label; ?>-pages",function(){
        
        $.fn.yiiListView.update('<?php echo $label; ?>-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: $("#<?php echo $label; ?>-search_txt").val(),
                pages : $("#<?php echo $label; ?>-pages").val()
            }
        });
    });
    
    
</script>
<!-- //END SCRIPT -->



<div class="row">
    <div class="col-sm-16">
        <h2 class="header_topic" style="font-size: 20px;"><?php echo $labeltxt; ?><br/>
            <span style="font-size: 14px; line-height: 16px;">Manage <?php echo $labeltxt; ?> with this Section. </span></h2>
    </div>
</div>


<?php echo "<?php"; ?> 

$isError = Yii::app()->user->getState('error');
if($isError == "true"){    
    echo "<script>showResponse(\"". Yii::app()->user->getState('errortxt') ."\");</script>"; 
    Yii::app()->user->setState('error', false);
} 
?>

<div class="inner_nav">
<div class="row">
    <div class="col-sm-2">        
        <button id="<?php echo $label; ?>-add" data-model="<?php echo $label; ?>" class="btn btn-default btn-block btn-sm">Add <span class="glyphicon glyphicon-plus"></span></button>
    </div>
    <div class="col-sm-7">
        <div class="input-group">
            <input type="text" class="form-control" id="<?php echo $label; ?>-search_txt" name="search" placeholder="Search By Code...." />
            
            <span class="input-group-btn">
                <button id="<?php echo $label; ?>-search_btn" class="btn btn-default">Search <span class="glyphicon glyphicon-search"></span></button>
            </span>
        </div>
    </div>
    <div class="col-sm-2 col-sm-push-5">
        <select id="<?php echo $label; ?>-pages" class="form-control">
            <option value="10">10 Pages</option>
            <option value="50">50 Pages</option>
            <option value="100">100 Pages</option>
        </select>
    </div>
</div>
</div>


<div class="container-fluid">

    <div class="row">
        <div class="col-sm-3 headerdiv">Code</div>
        <div class="col-sm-5 headerdiv">Supplier</div>
        <div class="col-sm-2 headerdiv">Date</div>
        <div class="col-sm-5 headerdiv">Remark</div>
        <div class="col-sm-1 headerdiv">&nbsp;</div>
    </div>


<?php echo "<?php"; ?> $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    'enablePagination' => true,
    'summaryText' => false,
    'id' => '<?php echo $label; ?>-list',
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
