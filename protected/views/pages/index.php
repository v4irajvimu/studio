<?php
/* @var $this PagesController */
/* @var $dataProvider CActiveDataProvider */

?>

<!---- POPUP MENUES -->

<div id="Pages-popup" class="popup_menu" form-dragable="true">
    <div id="exit"><span class="glyphicon glyphicon-remove"></span></div>
    <div class="row">
        <div class="col-sm-16">
            <h2 id="Pages-formtitle" >Insert A New Record</h2>
            <div class="cus-form">
                <form enctype="multipart/form-data" action="<?php echo Yii::app()->createUrl('Pages/create') ?>" method="post" id="Pages-form">
                    <div class="row">
                        <div class="col-sm-5">
                            <label>E-Paper: </label>
                            <select id="epaper_id" name="epaper_id" class="form-control">
                                <?php
                                $epaper_det = Epaper::model()->findAll(array('order' => 'eff_date DESC'));
                                foreach ($epaper_det as $epaper) {
                                    echo '<option value="'.$epaper->id.'">'.$epaper->name.'</option>';
                                }
                                
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label>Page Number: </label>
                            <select id="page_number" name="page_number" class="form-control">
                                <?php
                                $epaper_det = Parameters::model()->findByAttributes(array('name'=>'pages'));
                                for ($i=1; $i <= $epaper_det['value']; $i++) {
                                    echo '<option value="'.$i.'">'.$i.' වැනි පිටුව.</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row btn-row">
                        <div class="col-sm-4">
                            <label>Image of the page: </label>
                            <input type="file" name="news_img" />
                        </div>
                    </div>
                    
                    <div class="row btn-row">
                        <div class="col-sm-16">
                            <button id="Pages-submitbtn" class="btn btn-default">Create</button>
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
        
        $("#Pages-form").ajaxForm({
            beforeSend: function () {
                
                return $("#Pages-form").validate({
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
                $("#Pages-form").resetForm();
                $("#Pages-add").attr("disabled", false);
                $.fn.yiiListView.update('Pages-list');                
                $("#Pages-popup").fadeOut();
                
            }
        });
        
    });    
    
    $(document).on("click","#Pages-add",function(){
        $("#Pages-formtitle").html("Insert A New Record");
        $("#Pages-submitbtn").html("Create");
        $("#Pages-form").resetForm();
        $("#Pages-form").attr("action", "<?php echo Yii::app()->createUrl('Pages/create') ?>");
        $("#Pages-popup").show();
    });    
    
    $(document).on("click",".Pages-update",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        $("#Pages-formtitle").html("Update This Record");
        $("#Pages-submitbtn").html("Update");
        
        //Handle JSON DATA to Update FORM
        $.getJSON("<?php echo Yii::app()->createUrl('Pages/jsondata') ?>/" + id).done(function(data) {
            $.each(data, function(i, item) {
                $("#Pages-form #" + i).val(item);
            });
            $("#Pages-form").attr("action", "<?php echo Yii::app()->createUrl('Pages/update') ?>/" + id);
        });        
        
        $("#Pages-popup").show();
    });
    
    $(document).on("click",".Pages-delete",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        var confirmdata = confirm("Are you sure, you want to delete this record ?");
        if(confirmdata == true){
        $.ajax({
            url : "<?php echo Yii::app()->createUrl('Pages/delete') ?>/"+id,
            type:"POST"
        }).done(function(data){
            $.fn.yiiListView.update('Pages-list'); 
        });
        }
    });
    
     $(document).on("click","#Pages-search_btn",function(){
        var searchtxt = $("#Pages-search_txt").val();
        $.fn.yiiListView.update('Pages-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#Pages-pages").val()
            }
        });
    });
    
     $(document).on("keyup","#Pages-search_txt",function(){
        var searchtxt = $("#Pages-search_txt").val();
        $.fn.yiiListView.update('Pages-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#Pages-pages").val()
            }
        });
    });
    
    $(document).on("change","#Pages-pages",function(){
        
        $.fn.yiiListView.update('Pages-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: $("#Pages-search_txt").val(),
                pages : $("#Pages-pages").val()
            }
        });
    });
    
    
</script>
<!-- //END SCRIPT -->



<div class="row">
    <div class="col-sm-16">
        <h2 class="header_topic" style="font-size: 20px;">Pages<br/>
            <span style="font-size: 14px; line-height: 16px;">Manage Pages with this Section. </span></h2>
    </div>
</div>

<div class="inner_nav">
<div class="row">
    <div class="col-sm-2">        
        <button id="Pages-add" data-model="Pages" class="btn btn-default btn-block btn-sm">Add <span class="glyphicon glyphicon-plus"></span></button>
    </div>
    <div class="col-sm-7">
        <div class="input-group">
            <input type="text" class="form-control" id="Pages-search_txt" name="search" placeholder="Search Pages ...." />
            
            <span class="input-group-btn">
                <button id="Pages-search_btn" class="btn btn-default">Search <span class="glyphicon glyphicon-search"></span></button>
            </span>
        </div>
    </div>
    <div class="col-sm-2 col-sm-push-5">
        <select id="Pages-pages" class="form-control">
            <option value="10">10 Pages</option>
            <option value="50">50 Pages</option>
            <option value="100">100 Pages</option>
        </select>
    </div>
</div>
</div>


<div class="container-fluid">

    <div class="row">
        <div class="col-sm-4 headerdiv">News Paper</div>
        <div class="col-sm-4 headerdiv">Image Name</div>
        <div class="col-sm-2 headerdiv">Page Number</div>
        <div class="col-sm-2 headerdiv">Year</div>
        <div class="col-sm-2 headerdiv">Month</div>
        <div class="col-sm-1 headerdiv">Issue</div>
        <div class="col-sm-1 headerdiv">&nbsp;</div>
    </div>


<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    'enablePagination' => true,
    'summaryText' => false,
    'id' => 'Pages-list',
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
