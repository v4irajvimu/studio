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
    
    $(document).on("click",".<?php echo $this->modelClass; ?>-delete",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        var confirmdata = confirm("Are you sure, you want to delete this record ?");
        if(confirmdata == true){
        $.ajax({
            url : "<?php echo "<?php echo Yii::app()->createUrl('". $this->modelClass ."/delete') ?>"; ?>/"+id,
            type:"POST"
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

<div class="inner_nav">
<div class="row">
    <div class="col-sm-2">        
        <button id="<?php echo $label; ?>-add" data-model="<?php echo $label; ?>" class="btn btn-default btn-block btn-sm">Add <span class="glyphicon glyphicon-plus"></span></button>
    </div>
    <div class="col-sm-7">
        <div class="input-group">
            <input type="text" class="form-control" id="<?php echo $label; ?>-search_txt" name="search" placeholder="Search <?php echo $label; ?> ...." />
            
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
        <div class="col-sm-15 headerdiv">Your Column Name</div>
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
