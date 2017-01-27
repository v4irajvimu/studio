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
/* @var $model <?php echo $this->getModelClass(); ?> */


$this->menu = array(
    array("label" => "<span class='glyphicon glyphicon-arrow-left'></span> Go Back", "url" => "<?php echo strtolower($label); ?>" )
);

?>



<!--- Script -->
<script>

    $(document).ready(function () {
        
        //RUN TOTAL
        grandTotal();

        $("#<?php echo $label; ?>-inner-form").ajaxForm({
            beforeSend: function () {

                return $("#<?php echo $label; ?>-inner-form").validate({
                    rules: {
                        iname: {
                            required: true
                        },
                        qty: {
                            required: true,
                            min: 0
                        }
                    },
                    messages: {
                        iname: {
                            required: "Oops ! No Item Selected"
                        },
                        qty: {
                            required: "No Qty",
                            min: "No Zeros"
                        }
                    }
                }).form();

            },
            success: showResponse,
            complete: function () {
                $("#<?php echo $label; ?>-inner-form").resetForm();
                $("#<?php echo $label; ?>-submitbtn").attr("disabled", false);
                $.fn.yiiListView.update('<?php echo $label; ?>-itemlist');
                $("#items_id").val("");
                $("#items_id").focus();
                grandTotal();
            }
        });

        //AUTOCOMPLETE SECTION
        /*  Chnage Source URL Before Test.  */
        $("#iname").autocomplete({
            source: "<?php echo "<?php echo Yii::app()->createUrl('". strtolower($label) ."/loaditems'); ?>" ?>/<?php echo "<?php"; ?> echo $model->id ?>",
            minLength: 2,
            dataType: 'json',
            focus: function (event, ui) {
                $(this).val("Select a Item");
                return false;
            },
            select: function (e, ui) {
                e.preventDefault() // <--- Prevent the value from being inserted.
                $(this).val(ui.item.label);

                var item_id = ui.item.value;

                $("#items_id").val(item_id);
                $("#qty").focus();
            }
        });

    });
    
    $(document).on("click", ".<?php echo $label; ?>Items-delete", function (e) {
        e.preventDefault();
        var id = $(this).attr("data-id");
        var confirmdata = confirm("Are you sure, you want to delete this record ?");
        if (confirmdata == true) {
            $.ajax({
                url: "<?php echo '<?php echo Yii::app()->createUrl("'. $label .'Items/delete") ?>'; ?>/" + id,
                type: "POST"
            }).done(function (data) {
                $.fn.yiiListView.update('<?php echo $label; ?>-itemlist');
            });
        }
    });


    $(document).on("focusout", "#iname", function () {

        if($(this).val() == ""){
            $("#items_id").val("");
            $("#selling").val("");
            $("#cost").val("");
            $("#qty").val("");
            $("#remark").val("");
        }

        //GET ITEM DETAILS FROM ITEM CONTROLLER
        var item_id = $("#items_id").val();
        if (item_id == "") {
            showResponse("Please Select a Item");
        } else {
            $.ajax({
                url: "<?php echo "<?php echo Yii::app()->createUrl('items/jsondata'); ?>" ?>/" + item_id,
                dataType: "json"
            }).done(function (data) {
                $("#selling").val(data.selling);
                $("#cost").val(data.cost);
            });
        }

    });
    
    
    $(document).on("focusout", "#remark_main", function () {
        var id = <?php echo "<?php echo \$model->id; ?>"; ?>;
        var text = $(this).val();
        $.ajax({
            url: "<?php echo "<?php echo Yii::app()->createUrl('". strtolower($label) ."/updateremark'); ?>" ?>/" + id,
            data : {
                text : text
            },
            type : "POST",        
            success : showResponse
        });   
    });
    
    
    $(document).on("mouseenter",".textInput",function(){
        var val = $(this).attr("val");
        $(this).html("<input type='text' name='qty' class='form-control textInputElem' value='"+ val +"' />");
        $(this).children("input").select();
    });
    
    $(document).on("mouseleave",".textInput",function(){
        var id = $(this).attr('data-id');
        var key = $(this).attr('key');
        var newVal = $(this).children("input").val();
        
        var oldVal = $(this).attr('val');
        var valintext = $(this).attr('valintext');
        
        if(oldVal !== newVal){
        
            $.ajax({
                url: "<?php echo "<?php"; ?> echo Yii::app()->createUrl('<?php echo strtolower($label); ?>Items/updatesingle'); ?>/" + id,
                data : {
                    newVal : newVal,
                    key : key
                },
                async: false,        
                type : "POST",        
                success : showResponse
            });
            
            $.fn.yiiListView.update('<?php echo $label; ?>-itemlist');
            grandTotal();
        }else{
            $(this).html(valintext);
        }
    });
    
    
    function grandTotal(){
        var id = <?php echo "<?php echo \$model->id; ?>"; ?>;
        $.ajax({
                url: "<?php echo "<?php echo Yii::app()->createUrl('". strtolower($label) ."/grandtotal'); ?>" ?>/" + id,                
                dataType: "json"                
            }).done(function (data) {
                $("#grand_total").html(data.total_formated);
            });
    }

</script>
<!-- //END SCRIPT -->

<section id="inner_header">
    <div class="row">
        <div class="col-sm-3 cells"><h4 class="labels">Code</h4># <?php echo "<?php echo \$model->code; ?>"; ?></div>
        <div class="col-sm-11 cells"><h4 class="labels">Name</h4> Name</div>
        <div class="col-sm-2 text-right cells"><h4 class="labels">Processed Date</h4><?php echo "<?php echo \$model->date; ?>" ?></div>
    </div>
</section>

<section id="inputform">
    <form action="<?php echo "<?php echo Yii::app()->createUrl('" . strtolower($label) . "Items/create') ?>"; ?>" method="post" id="<?php echo $label; ?>-inner-form">
        <div class="row">
            <div class="col-sm-4">
                <input type="hidden" name="<?php echo strtolower($label); ?>_id" id="<?php echo strtolower($label); ?>_id" value="<?php echo "<?php echo \$model->id; ?>"; ?>" />
                <input type="hidden" name="items_id" id="items_id" value="" />
                <input type="text" id="iname" name="iname" class="form-control" placeholder="Stock Keeping Unit (Item)" />
            </div>
            <div class="col-sm-2">
                <input type="text" id="cost" name="cost" class="form-control" placeholder="Cost 0.00" />
            </div>
            <div class="col-sm-2">
                <input type="text" id="selling" name="selling" class="form-control" placeholder="Selling 0.00" />
            </div>
            <div class="col-sm-1">
                <input type="number" id="qty" name="qty" class="form-control" placeholder="Qty"/>
            </div>
            <div class="col-sm-5">
                <input type="text" id="remark" name="remark" class="form-control" placeholder="Remarks..." />
            </div>
            <div class="col-sm-2">
                <button id="<?php echo $label; ?>-submitbtn" class="btn btn-default">Add <span class="glyphicon glyphicon-plus"></span></button>
            </div>
        </div>
    </form>
</section>


<section id="inner_grid">
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-2 headerdiv">Code</div>
            <div class="col-sm-5 headerdiv">Description</div>
            <div class="col-sm-2 headerdiv text-right">Cost</div>
            <div class="col-sm-2 headerdiv text-right">Selling</div>
            <div class="col-sm-2 headerdiv text-right">Qty</div>
            <div class="col-sm-2 headerdiv  text-right">Total</div>
            <div class="col-sm-1 headerdiv">&nbsp;</div>
        </div>
        
        <div class="innerSmlGrid">

<?php echo "<?php"; ?>

        $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $dataProvider,
        'itemView' => '/<?php echo strtolower($this->getModelClass()); ?>Items/_view',
        'enablePagination' => true,
        'summaryText' => false,
        'id' => '<?php echo $this->getModelClass(); ?>-itemlist',
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
        ));
        ?>




    </div>
    </div>
</section>

<section>
    <div class="row">
        <div class="col-sm-16">
            <label class="remark_label">Additional Remarks</label>
            <textarea name="remark_main" id="remark_main" rows="2" class="form-control"><?php echo "<?php echo \$model->remark; ?>" ?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">

        </div>
        <div class="col-sm-4 text-right">
            <div>
                <h2 class="total_header">Grand Total</h2>
                <h2 class="amount"><span id="grand_total">0.00</span> (LKR)</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">

        </div>
        <div class="col-sm-4 text-right">
            <div>
                <a href="<?php echo "<?php echo Yii::app()->createUrl('". strtolower($label) ."'); ?>" ?>" class="btn btn-default">Save Only</a>
                <a href="<?php echo "<?php echo Yii::app()->createUrl('". strtolower($label) ."/print/'.\$model->id); ?>"; ?>" class="btn btn-success">Confirm & Print</a>
            </div>
        </div>
    </div>
</section>
