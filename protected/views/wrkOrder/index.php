<?php
/* @var $this WrkOrderController */
/* @var $dataProvider CActiveDataProvider */
?>

<!-- POPUP MENUES -->
<script>
$(document).ready(function () {
  getCustomerList();
  getItemList();

  cal_grand_total();
});

$(document).on("keyup",".qty",function(){
  var row = $(this).closest('tr');
  var selling = row.find('.selling').val();
  var amount = parseFloat((isNaN(selling))?0:selling) * parseFloat(($(this).val() !=='')?$(this).val():0);
  row.find('.amount').val(amount);
  cal_grand_total();
});



$(document).on("click", ".cust_row", function () {
  $("#customer_name").val($(this).attr('data-name'));
  $("#customer_id").val($(this).attr('data-id'));
  $('#customer_modal').modal('toggle');
});
$(document).on("click", ".item_row", function () {
  $('#item_modal').modal('toggle');
  item_add_grid($(this));
});




$(document).on("keyup", "#cust_search", function () {
  getCustomerList();
});
$(document).on("keyup", "#item_search", function () {
  getItemList();
});
$(document).on("change", "#wo_type", function () {
  codeGen($(this).val());
});
$(document).on("click", ".delete_row", function (e) {
  e.preventDefault();
  delete_rows($(this));

});
// discount_type selection
$(document).on("change", ".discount_type", function (e) {
  var val = $('input[name=discount_type_id]:checked').val();
  if(val =='1'){
    $("#discount_percentage").show();
    $("#discount").attr('readonly','true');
    $("#discount").val('0');
    $("#discount_percentage").focus();
    cal_grand_total();
  }
  else{
    $("#discount_percentage").hide();
    $("#discount").removeAttr('readonly');
    $("#discount").val('0');
    $("#discount_percentage").val('0');
    cal_grand_total();
    $("#discount").focus();
  }
});

$(document).on("keyup","#discount_percentage , #discount", function(){
  cal_grand_total();
});

$(document).on("click",".is_wrok_done",function(e){
  e.preventDefault();
  var id = $(this).attr('data-id');
  $.post("<?= Yii::app()->createUrl('WrkOrder/workdone') ?>", {
    id: id
  }, function (r) {
    $.fn.yiiListView.update('WrkOrder-list');
  }, "text");

});
function item_add_grid(thisObj){

  var items_id = thisObj.attr('data-id');
  var name = thisObj.attr('data-name');
  var cost = thisObj.attr('data-cost');
  var selling = thisObj.attr('data-selling');
  var min_price = thisObj.attr('data-min_price');
  var max_price = thisObj.attr('data-max_price');
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
    tbl_row += '<input  type="hidden" id="item_cost_'+tbl_row_id+'" name="woItem['+tbl_row_id+'][cost]" value="'+cost+'" class="form-control"/>';
    tbl_row += '<input  type="hidden" id="item_min_price_'+tbl_row_id+'" name="woItem['+tbl_row_id+'][min_price]" value="'+min_price+'" class="form-control"/>';
    tbl_row += '<input  type="hidden" id="item_max_price_'+tbl_row_id+'" name="woItem['+tbl_row_id+'][max_price]" value="'+max_price+'" class="form-control"/>';
    tbl_row += '</td>';
    tbl_row += '<td>';
    tbl_row += '<input readonly type="text" id="item_selling_'+tbl_row_id+'" name="woItem['+tbl_row_id+'][selling]" value="'+selling+'" class="selling form-control"/>';
    tbl_row += '</td>';
    tbl_row += '<td>';
    tbl_row += '<input  type="text" id="item_qty_'+tbl_row_id+'" name="woItem['+tbl_row_id+'][qty]" value="1" class="qty form-control"/>';
    tbl_row += '</td>';
    tbl_row += '<td>';
    tbl_row += '<input  type="text" id="item_amount_'+tbl_row_id+'" name="woItem['+tbl_row_id+'][amount]" value="'+selling+'" class="amount form-control"/>';
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

function cal_grand_total(){
  var grandTot = 0;
  var radio = $('input[name=discount_type_id]:checked');
  var discount = 0;

  $(".amount").each(function(){
    var a = ($(this).val()!=='')?$(this).val():0;
    grandTot += parseFloat(a);
  });
  if(radio.val() == '1'){
    var percentage = parseFloat($("#discount_percentage").val());
    discount = grandTot  * (((isNaN(percentage))?0:parseFloat(percentage))/100);
    $("#discount").val(parseFloat(discount).toFixed(2));
  }
  else{
    discount = parseFloat(($("#discount").val() !== '')?$("#discount").val():0);
  }

  grandTot -= discount;

  $("#total").val(parseFloat(grandTot).toFixed(2));
}

function codeGen(wo_type) {
  $.post("<?= Yii::app()->createUrl('WrkOrder/codegen') ?>", {
    wo_type: wo_type
  }, function (r) {
    $("#code").val(r);
  }, "text");

  if(wo_type == 'CASH'){
    $("#is_wrok_done").val('1');
  }
  else{
    $("#is_wrok_done").val('0');
  }
}
function getCustomerList() {
  var search = $("#cust_search").val();
  $.post("<?= Yii::app()->createUrl('WrkOrder/cust_list') ?>", {
    search: search
  }, function (r) {
    $("#cust_list").html(r);
  }, "text");
}
function getItemList() {
  var search = $("#item_search").val();
  $.post("<?= Yii::app()->createUrl('WrkOrder/item_list') ?>", {
    search: search
  }, function (r) {
    $("#item_list").html(r);
  }, "text");
}
</script>




<div id="WrkOrder-popup" class="popup_menu" form-dragable="true">
  <div id="exit"><span class="glyphicon glyphicon-remove"></span></div>
  <div class="row">
    <div class="col-sm-16">
      <h2 id="WrkOrder-formtitle" >Insert A New Record</h2>
      <div class="cus-form">
        <form data-parsley-validate action="<?php echo Yii::app()->createUrl('WrkOrder/create') ?>" method="post" id="WrkOrder-form">
          <div data-wizard-init row>
            <ul class="steps">
              <li data-step="1">WO Details.</li>
              <li data-step="2">WO Items</li>
              <!-- <li data-step="3">Payments</li> -->
            </ul>
            <div class="steps-content">
              <div data-step="1">
                <div class="row">
                  <div class="col-sm-4">
                    <label>Work Order Type: </label>
                    <select id="wo_type" name="wo_type" class="form-control">
                      <option value="">-- Select WO Type --</option>
                      <option value="CASH">Cash Sale</option>
                      <option value="CREDIT">Credit Sale</option>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-4">
                    <label>Code: </label>
                    <input readonly type="text" id="code" name="code" class="form-control" required/>
                    <input  type="hidden" id="is_wrok_done" name="is_wrok_done" class="form-control" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-8">
                    <label>Customer: </label>
                    <input  type="text" id="customer_name" name="customer_name" class="form-control" required/>
                    <input  type="hidden" id="customer_id" name="customer_id" class="form-control" />
                  </div>
                  <div class="col-sm-1">
                    <label><br></label>
                    <a href="#" data-toggle="modal" data-target="#customer_modal" class="btn btn-info form-control" >
                      <span class="glyphicon glyphicon-plus"></span>
                    </a>
                  </div>
                </div>
                <!-- Modal Customer list-->
                <div id="customer_modal" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Customer List</h4>
                      </div>
                      <div class="modal-body">
                        <input  type="text" id="cust_search" name="" class="form-control" />
                        <table class="table table-fixed">
                          <thead>
                            <tr>
                              <th>Customer</th>
                              <th>NIC</th>
                              <th>Contact</th>
                              <th>&emsp;</th>
                            </tr>
                          </thead>
                          <tbody id="cust_list"></tbody>
                        </table>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-3">
                    <label>Delivery Date: </label>
                    <input type="text" id="delivery_date" name="delivery_date" value="<?= date('Y-m-d') ?>" class="form-control datepicker" required/>
                    <input type="hidden" id="eff_date" name="eff_date" value="<?= date('Y-m-d') ?>" class="form-control datepicker" required/>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-8">
                    <label>Remark: </label>
                    <textarea type="text" id="remark" name="remark" class="form-control" required></textarea>
                  </div>
                </div>
              </div>
              <div data-step="2">
                <div class="row">
                  <a href="#" data-toggle="modal" data-target="#item_modal" class="btn btn-info btn-md form-control" >
                    <span class="glyphicon glyphicon-plus"></span> Insert Items
                  </a>
                </div>
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th class="col-sm-4">Name</th>
                      <th class="col-sm-2">Selling</th>
                      <th class="col-sm-2">Qty.</th>
                      <th class="col-sm-2">Amount</th>
                      <th class="col-sm-2">Action</th>
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
                      <th class="col-sm-2">&nbsp;</th>
                      <th class="col-sm-2">&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Discount -->
                    <tr >
                      <td class="text-right">
                        <label class="radio-inline">
                          <input class="discount_type" id="1"  type="radio" name="discount_type_id" value="1">Percentage
                        </label>
                      </td>
                      <td>
                        <input   type="text" id="discount_percentage" name="discount_percentage" class="form-control"/>
                      </td>
                      <td>
                        <label class="radio-inline">
                          <input checked class="discount_type" id="2" type="radio" name="discount_type_id" value="2">Value
                        </label></td>
                        <td style="border-bottom: 1px double black; color:green;">
                          <input   type="text" id="discount" name="discount" class="form-control"/>
                        </td>
                        <td></td>
                      </tr>
                      <tr >
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
                      <button id="WrkOrder-submitbtn" class="btn btn-primary form-control">Create</button>
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
                </div>
                <!-- <div data-step="3">

                </div> -->

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

  $(document).ready(function () {

    $("#WrkOrder-form").ajaxForm({
      beforeSend: function () {

        return $("#WrkOrder-form").validate({
          rules: {
            name: {
              required: true,
            }
          },
          messages: {
            name: {
              max: "Customize Your Error"
            }
          }
        }).form();

      },
      success: showResponse,
      complete: function () {
        $("#WrkOrder-form").resetForm();
        $("#WrkOrder-add").attr("readonly", false);
        $.fn.yiiListView.update('WrkOrder-list');
        $("#WrkOrder-popup").fadeOut();

      }
    });

  });

  $(document).on("click", "#WrkOrder-add", function () {
    $("#WrkOrder-formtitle").html("Insert A New Record");
    $("#WrkOrder-submitbtn").html("Create");
    $("#WrkOrder-form").resetForm();
    $("#WrkOrder-form").attr("action", "<?php echo Yii::app()->createUrl('WrkOrder/create') ?>");
    $("#WrkOrder-popup").show();
  });

  $(document).on("click", ".WrkOrder-update", function (e) {
    e.preventDefault();
    var id = $(this).attr("data-id");
    $("#WrkOrder-formtitle").html("Update This Record");
    $("#WrkOrder-submitbtn").html("Update");

    //Handle JSON DATA to Update FORM
    $.getJSON("<?php echo Yii::app()->createUrl('WrkOrder/jsondata') ?>/" + id).done(function (data) {
      //alert(data.det.length);
      $.each(data.sum, function (i, item) {
        $("#WrkOrder-form #" + i).val(item);
      });
      $("#item_body").html('');
      for(var i=0; i<data.det.length;i++){
        tbl_row='';
        tbl_row += '<tr class="cl" row_id="'+i+'" id="row_'+i+'">';
        tbl_row += '<td>';
        tbl_row += '<input readonly type="text" id="item_name_'+i+'" name="woItem['+i+'][name]" value="'+data.det[i].name+'" class="form-control"/>';
        tbl_row += '<input type="hidden" id="item_id_'+i+'" name="woItem['+i+'][items_id]" value="'+data.det[i].items_id+'" class="form-control"/>';
        tbl_row += '<input  type="hidden" id="item_cost_'+i+'" name="woItem['+i+'][cost]" value="'+data.det[i].cost+'" class="form-control"/>';
        tbl_row += '<input  type="hidden" id="item_min_price_'+i+'" name="woItem['+i+'][min_price]" value="'+data.det[i].min_price+'" class="form-control"/>';
        tbl_row += '<input  type="hidden" id="item_max_price_'+i+'" name="woItem['+i+'][max_price]" value="'+data.det[i].max_price+'" class="form-control"/>';
        tbl_row += '</td>';
        tbl_row += '<td>';
        tbl_row += '<input readonly type="text" id="item_selling_'+i+'" name="woItem['+i+'][selling]" value="'+data.det[i].selling+'" class="selling form-control"/>';
        tbl_row += '</td>';
        tbl_row += '<td>';
        tbl_row += '<input  type="text" id="item_qty_'+i+'" name="woItem['+i+'][qty]" value="'+data.det[i].qty+'" class="qty form-control"/>';
        tbl_row += '</td>';
        tbl_row += '<td>';
        tbl_row += '<input  type="text" id="item_amount_'+i+'" name="woItem['+i+'][amount]" value="'+data.det[i].amount+'" class="amount form-control"/>';
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
        $("#item_qty_"+i).focus();
      }

      $("#WrkOrder-form").attr("action", "<?php echo Yii::app()->createUrl('WrkOrder/update') ?>/" + id);
      cal_grand_total();
    });

    $("#WrkOrder-popup").show();
  });

  $(document).on("click", ".WrkOrder-delete", function (e) {
    e.preventDefault();
    var id = $(this).attr("data-id");
    var confirmdata = confirm("Are you sure, you want to delete this record ?");
    if (confirmdata == true) {
      $.ajax({
        url: "<?php echo Yii::app()->createUrl('WrkOrder/delete') ?>/" + id,
        type: "POST"
      }).done(function (data) {
        $.fn.yiiListView.update('WrkOrder-list');
      });
    }
  });

  $(document).on("click", "#WrkOrder-search_btn", function () {
    var searchtxt = $("#WrkOrder-search_txt").val();
    $.fn.yiiListView.update('WrkOrder-list', {
      //this entire js section is taken from admin.php. w/only this line diff
      data: {
        val: searchtxt,
        pages: $("#WrkOrder-pages").val()
      }
    });
  });

  $(document).on("keyup", "#WrkOrder-search_txt", function () {
    var searchtxt = $("#WrkOrder-search_txt").val();
    $.fn.yiiListView.update('WrkOrder-list', {
      //this entire js section is taken from admin.php. w/only this line diff
      data: {
        val: searchtxt,
        pages: $("#WrkOrder-pages").val()
      }
    });
  });

  $(document).on("change", "#WrkOrder-pages", function () {

    $.fn.yiiListView.update('WrkOrder-list', {
      //this entire js section is taken from admin.php. w/only this line diff
      data: {
        val: $("#WrkOrder-search_txt").val(),
        pages: $("#WrkOrder-pages").val()
      }
    });
  });


  </script>
  <!-- //END SCRIPT -->



  <div class="row">
    <div class="col-sm-16">
      <h2 class="header_topic" style="font-size: 20px;">WORK ORDERS<br/>
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
        <div class="col-sm-2 headerdiv">Code</div>
        <div class="col-sm-2 headerdiv">Delivery Date</div>
        <div class="col-sm-2 headerdiv">Customer</div>
        <div class="col-sm-2 headerdiv">Gross(LKR)</div>
        <div class="col-sm-2 headerdiv">Discount(LKR)</div>
        <div class="col-sm-2 headerdiv">Net(LKR)</div>
        <div class="col-sm-2 headerdiv">Paid(LKR)</div>
        <div class="col-sm-1 headerdiv">Balance(LKR)</div>
        <div class="col-sm-1 headerdiv">&nbsp;</div>
      </div>


      <?php
      $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $dataProvider,
        'itemView' => '_view',
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
      ));
      ?>

    </div>
