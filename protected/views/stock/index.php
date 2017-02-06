<?php
/* @var $this StockController */
/* @var $dataProvider CActiveDataProvider */

?>

<!---- POPUP MENUES -->
<script>
$(document).ready(function () {
  getItemList();

  cal_grand_total();
});
$(document).on("keyup", "#item_search", function () {
  getItemList();
});
$(document).on("click", ".item_row", function () {
  $('#item_modal').modal('toggle');
  item_add_grid($(this));
});
$(document).on("click", ".delete_row", function (e) {
  e.preventDefault();
  delete_rows($(this));
});
$(document).on("keyup",".qty",function(){
  var row = $(this).closest('tr');
  var cost = row.find('.cost').val();
  var amount = parseFloat((isNaN(cost))?0:cost) * parseFloat(($(this).val() !=='')?$(this).val():0);
  row.find('.amount').val(amount);
  cal_grand_total();
});

function item_add_grid(thisObj){

  var items_id = thisObj.attr('data-id');
  var name = thisObj.attr('data-name');
  var cost = thisObj.attr('data-cost');
  var selling = thisObj.attr('data-selling');
  var min_price = thisObj.attr('data-min_price');
  var max_price = thisObj.attr('data-max_price');
  var supplier_id = thisObj.attr('data-supplier_id');
  var row_id = -1;
  var item_exists = false;

  $(".cl").each(function(){
    row_id = parseFloat($(this).attr('row_id'));
    if($("#item_id_"+row_id).val() == items_id){
      $("#item_qty_"+row_id).focus();
      item_exists = true;
      return false;
    }
  });

  if(!item_exists){
    var tbl_row='';
    var tbl_row_id = row_id+1;

    tbl_row += '<tr class="cl" row_id="'+tbl_row_id+'" id="row_'+tbl_row_id+'">';
    tbl_row += '<td>';
    tbl_row += '<input readonly type="text" id="item_name_'+tbl_row_id+'" name="woItem['+tbl_row_id+'][name]" value="'+name+'" class="form-control"/>';
    tbl_row += '<input type="hidden" id="item_id_'+tbl_row_id+'" name="woItem['+tbl_row_id+'][items_id]" value="'+items_id+'" class="form-control"/>';
    tbl_row += '<input  type="hidden" id="item_supplier_id_'+tbl_row_id+'" name="woItem['+tbl_row_id+'][supplier_id]" value="'+supplier_id+'" class="selling form-control"/>';
    tbl_row += '<input  type="hidden" id="item_selling_'+tbl_row_id+'" name="woItem['+tbl_row_id+'][selling]" value="'+selling+'" class="selling form-control"/>';
    tbl_row += '<input  type="hidden" id="item_min_price_'+tbl_row_id+'" name="woItem['+tbl_row_id+'][min_price]" value="'+min_price+'" class="form-control"/>';
    tbl_row += '<input  type="hidden" id="item_max_price_'+tbl_row_id+'" name="woItem['+tbl_row_id+'][max_price]" value="'+max_price+'" class="form-control"/>';
    tbl_row += '</td>';
    tbl_row += '<td>';
    tbl_row += '<input readonly type="text" id="item_cost_'+tbl_row_id+'" name="woItem['+tbl_row_id+'][cost]" value="'+cost+'" class="cost form-control"/>';
    tbl_row += '</td>';
    tbl_row += '<td>';
    tbl_row += '<input readonly type="text" id="item_selling_'+tbl_row_id+'" name="woItem['+tbl_row_id+'][selling]" value="'+selling+'" class="selling form-control"/>';
    tbl_row += '</td>';
    tbl_row += '<td>';
    tbl_row += '<input  type="text" id="item_qty_'+tbl_row_id+'" name="woItem['+tbl_row_id+'][qty]" value="1" class="qty form-control"/>';
    tbl_row += '</td>';
    tbl_row += '<td>';
    tbl_row += '<input readonly type="text" id="item_amount_'+tbl_row_id+'" name="woItem['+tbl_row_id+'][amount]" value="'+cost+'" class="amount form-control"/>';
    tbl_row += '</td>';
    tbl_row += '<td>';
    tbl_row += '<a href="#" style="display: none;" class="btn btn-danger btn-md delete_row" ><span class="glyphicon glyphicon-trash"></span></a>';
    tbl_row += '</td>';
    tbl_row += '<a href="#" data-toggle="modal" data-target="#item_modal" class="btn btn-info form-control" >';
    tbl_row += '<span class="glyphicon glyphicon-plus"></span>';
    tbl_row += '</a>';
    tbl_row += '</td>';
    tbl_row += '</tr>';

    $("#item_body").append(tbl_row);
    $(".delete_row").show();
    $("#item_qty_"+tbl_row_id).focus();
  }
  cal_grand_total();
}
function delete_rows(thisObj){

  var start_row = thisObj.parents('tr').attr('row_id');
  var row_count=0;

  // get row count alert(start_row);
  $(".cl").each(function(){
    row_count++;
  });
  //alert("#item_id_"+i+1);
  var last_row=start_row-1;
  for(var i=start_row; i<row_count; i++){
    last_row++;
    var k =parseFloat(i)+1;
    $("#item_id_"+i).val($("#item_id_"+k).val());
    $("#item_name_"+i).val($("#item_name_"+k).val());
    $("#item_cost_"+i).val($("#item_cost_"+k).val());
    $("#item_selling_"+i).val($("#item_selling_"+k).val());
    $("#item_min_price_"+i).val($("#item_min_price_"+k).val());
    $("#item_max_price_"+i).val($("#item_max_price_"+k).val());
    $("#item_qty_"+i).val($("#item_qty_"+k).val());
    $("#item_amount_"+i).val($("#item_amount_"+k).val());
  }
  cal_grand_total();
  $("#row_"+last_row).remove();
  var bfr_lst = parseFloat(last_row)-1;
  $("#row_"+bfr_lst).child('a').hide();

}

function getItemList() {
  var search = $("#item_search").val();
  $.post("<?= Yii::app()->createUrl('WrkOrder/item_list') ?>", {
    search: search
  }, function (r) {
    $("#item_list").html(r);
  }, "text");
}

function cal_grand_total(){
  var grandTot = 0;
  //var radio = $('input[name=discount_type_id]:checked');
  var discount = 0;

  $(".amount").each(function(){
    var a = ($(this).val()!=='')?$(this).val():0;
    grandTot += parseFloat(a);
  });
  // if(radio.val() == '1'){
  //   var percentage = parseFloat($("#discount_percentage").val());
  //   discount = grandTot  * (((isNaN(percentage))?0:parseFloat(percentage))/100);
  //   $("#discount").val(discount);
  // }
  // else{
  //   discount = parseFloat(($("#discount").val() !== '')?$("#discount").val():0);
  // }

  grandTot -= discount;

  $("#total").val(grandTot);
}

</script>
<div id="Stock-popup" class="popup_menu" form-dragable="true">
    <div id="exit"><span class="glyphicon glyphicon-remove"></span></div>
    <div class="row">
        <div class="col-sm-16">
            <h2 id="Stock-formtitle" >Insert A New Record</h2>
            <div class="cus-form">
                <form action="<?php echo Yii::app()->createUrl('Stock/create') ?>" method="post" id="Stock-form">
                  <div class="row">
                    <a href="#" data-toggle="modal" data-target="#item_modal" class="btn btn-info btn-md form-control" >
                      <span class="glyphicon glyphicon-plus"></span> Insert Items
                    </a>
                  </div>
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th class="col-sm-4">Name</th>
                        <th class="col-sm-2">Cost</th>
                        <th class="col-sm-2">Selling</th>
                        <th class="col-sm-1">Qty.</th>
                        <th class="col-sm-2">Amount</th>
                        <th class="col-sm-1">Action</th>
                      </tr>
                    </thead>
                    <tbody id="item_body"></tbody>
                  </table>
                  <table id="tbl_total" class="table table-striped">
                    <thead>
                      <tr>
                        <th class="col-sm-4">&nbsp;</th>
                        <th class="col-sm-2">&nbsp;</th>
                        <th class="col-sm-2">&nbsp;</th>
                        <th class="col-sm-1">&nbsp;</th>
                        <th class="col-sm-2">&nbsp;</th>
                        <th class="col-sm-1">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                        <tr >
                          <td></td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td style="border-bottom: 1px double black;">
                            <input readonly type="text" id="total" name="total" class="form-control"/>
                          </td>
                          <td></td>
                        </tr>
                      </tbody>
                    </table>
                    <div class="row btn-row">
                        <div class="col-sm-16">
                            <button id="Stock-submitbtn" class="btn btn-primary form-control">Create</button>
                        </div>
                    </div>
                    <!-- Modal Item list-->
                    <div id="item_modal" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">ITEMS LIST</h4>
                          </div>
                          <div class="modal-body">
                            <input  type="text" id="item_search" class="form-control" />
                            <table class="table table-fixed">
                              <thead>
                                <tr>
                                  <th class="col-sm-6">Item</th>
                                  <th class="col-sm-2">Cost</th>
                                  <th class="col-sm-2">Selling</th>
                                  <th class="col-sm-2">&emsp;</th>
                                </tr>
                              </thead>
                              <tbody id="item_list"></tbody>
                            </table>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>
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

        $("#Stock-form").ajaxForm({
            beforeSend: function () {

                return $("#Stock-form").validate({
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
                $("#Stock-form").resetForm();
                $("#Stock-add").attr("disabled", false);
                $.fn.yiiListView.update('Stock-list');
                $("#Stock-popup").fadeOut();

            }
        });

    });

    $(document).on("click","#Stock-add",function(){
        $("#Stock-formtitle").html("Insert A New Record");
        $("#Stock-submitbtn").html("Create");
        $("#Stock-form").resetForm();
        $("#Stock-form").attr("action", "<?php echo Yii::app()->createUrl('Stock/create') ?>");
        $("#Stock-popup").show();
    });

    $(document).on("click",".Stock-update",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        $("#Stock-formtitle").html("Update This Record");
        $("#Stock-submitbtn").html("Update");

        //Handle JSON DATA to Update FORM
        $.getJSON("<?php echo Yii::app()->createUrl('Stock/jsondata') ?>/" + id).done(function(data) {
            $.each(data, function(i, item) {
                $("#Stock-form #" + i).val(item);
            });
            $("#Stock-form").attr("action", "<?php echo Yii::app()->createUrl('Stock/update') ?>/" + id);
        });

        $("#Stock-popup").show();
    });

    $(document).on("click",".Stock-delete",function(e){
        e.preventDefault();
        var id = $(this).attr("data-id");
        var confirmdata = confirm("Are you sure, you want to delete this record ?");
        if(confirmdata == true){
        $.ajax({
            url : "<?php echo Yii::app()->createUrl('Stock/delete') ?>/"+id,
            type:"POST"
        }).done(function(data){
            $.fn.yiiListView.update('Stock-list');
        });
        }
    });

     $(document).on("click","#Stock-search_btn",function(){
        var searchtxt = $("#Stock-search_txt").val();
        $.fn.yiiListView.update('Stock-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#Stock-pages").val()
            }
        });
    });

     $(document).on("keyup","#Stock-search_txt",function(){
        var searchtxt = $("#Stock-search_txt").val();
        $.fn.yiiListView.update('Stock-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages : $("#Stock-pages").val()
            }
        });
    });

    $(document).on("change","#Stock-pages",function(){

        $.fn.yiiListView.update('Stock-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: $("#Stock-search_txt").val(),
                pages : $("#Stock-pages").val()
            }
        });
    });


</script>
<!-- //END SCRIPT -->



<div class="row">
    <div class="col-sm-16">
        <h2 class="header_topic" style="font-size: 20px;">Stocks<br/>
            <span style="font-size: 14px; line-height: 16px;">Manage Stocks with this Section. </span></h2>
    </div>
</div>

<div class="inner_nav">
<div class="row">
    <div class="col-sm-2">
        <button id="Stock-add" data-model="Stock" class="btn btn-default btn-block btn-sm">Add <span class="glyphicon glyphicon-plus"></span></button>
    </div>
    <div class="col-sm-7">
        <div class="input-group">
            <input type="text" class="form-control" id="Stock-search_txt" name="search" placeholder="Search Stock ...." />

            <span class="input-group-btn">
                <button id="Stock-search_btn" class="btn btn-default">Search <span class="glyphicon glyphicon-search"></span></button>
            </span>
        </div>
    </div>
    <div class="col-sm-2 col-sm-push-5">
        <select id="Stock-pages" class="form-control">
            <option value="10">10 Pages</option>
            <option value="50">50 Pages</option>
            <option value="100">100 Pages</option>
        </select>
    </div>
</div>
</div>


<div class="container-fluid">

    <div class="row">
        <div class="col-sm-5 headerdiv">Item Name</div>
        <div class="col-sm-4 headerdiv">Supplier Name</div>
        <div class="col-sm-2 headerdiv">Avl. Qty.</div>
        <div class="col-sm-2 headerdiv">Cost</div>
        <div class="col-sm-2 headerdiv">Selling</div>
        <div class="col-sm-1 headerdiv">&nbsp;</div>
    </div>


<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    'enablePagination' => true,
    'summaryText' => false,
    'id' => 'Stock-list',
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
