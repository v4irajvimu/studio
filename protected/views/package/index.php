<?php
/* @var $this PackageController */
/* @var $dataProvider CActiveDataProvider */
?>

<!---- POPUP MENUES -->

<div id="Package-popup" class="popup_menu" form-dragable="true">
    <div id="exit"><span class="glyphicon glyphicon-remove"></span></div>
    <div class="row">
        <div class="col-sm-16">
            <h2 id="Package-formtitle" >Insert A New Record</h2>
            <div class="cus-form">
                <form data-parsley-validate action="<?php echo Yii::app()->createUrl('Package/create') ?>" method="post" id="Package-form">
                    <div data-wizard-init row>
                        <ul class="steps">
                            <li data-step="1">Package Details.</li>
                            <li data-step="2">Package Features.</li>
                        </ul>
                        <div class="steps-content">
                            <div data-step="1">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <label>Name</label>
                                        <input type="text" id="name" name="name" class="form-control" required />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <label>Description: </label>
                                        <textarea type="text" id="desc" name="desc" class="form-control" required></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>From: </label>
                                        <input type="text" id="from" name="from" class="form-control datepicker"   required/>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>To: </label>
                                        <input type="text" id="to" name="to" class="form-control datepicker"  required/>
                                    </div>
                                </div>
                            </div>
                            <div data-step="2">
                                <div class="row">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="text"  id="feature_name" name="" class="form-control"/>
                                                    <input type="hidden"  id="feature_name" name="" class="form-control"/>
                                                </td>
                                                <td>
                                                    <input type="text"  id="feature_name" name="" class="form-control"/>
                                                </td>
                                                <td>
                                                    <input type="text" id="" name="" class="form-control" pattern="^[0-9]*\.[0-9]{2}$"placeholder="0.00" required/>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>Adjustment Charges: </label>
                                        <input type="number" step="0.01" id="adjustment_charge" name="adjustment_charge" class="form-control" pattern="^-?[0-9]\d*(\.\d+)?$"placeholder="0.00"   required/>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Total: </label>
                                        <input type="text" id="total" name="total" class="form-control" pattern="^[0-9]*\.[0-9]{2}$"placeholder="0.00" required/>
                                    </div>
                                </div>
                                <div class="row btn-row">
                                    <div class="col-sm-16">
                                        <button id="Package-submitbtn" class="btn btn-default">Create</button>
                                    </div>
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

    $(document).ready(function () {

        $("#Package-form").ajaxForm({
            beforeSend: function () {

                return $("#Package-form").validate({
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
                $("#Package-form").resetForm();
                $("#Package-add").attr("disabled", false);
                $.fn.yiiListView.update('Package-list');
                $("#Package-popup").fadeOut();

            }
        });

    });

    $(document).on("click", "#Package-add", function () {
        $("#Package-formtitle").html("Insert A New Record");
        $("#Package-submitbtn").html("Create");
        $("#Package-form").resetForm();
        $("#Package-form").attr("action", "<?php echo Yii::app()->createUrl('Package/create') ?>");
        $("#Package-popup").show();
    });

    $(document).on("click", ".Package-update", function (e) {
        e.preventDefault();
        var id = $(this).attr("data-id");
        $("#Package-formtitle").html("Update This Record");
        $("#Package-submitbtn").html("Update");

        //Handle JSON DATA to Update FORM
        $.getJSON("<?php echo Yii::app()->createUrl('Package/jsondata') ?>/" + id).done(function (data) {
            $.each(data, function (i, item) {
                $("#Package-form #" + i).val(item);
            });
            $("#Package-form").attr("action", "<?php echo Yii::app()->createUrl('Package/update') ?>/" + id);
        });

        $("#Package-popup").show();
    });

    $(document).on("click", ".Package-delete", function (e) {
        e.preventDefault();
        var id = $(this).attr("data-id");
        var confirmdata = confirm("Are you sure, you want to delete this record ?");
        if (confirmdata == true) {
            $.ajax({
                url: "<?php echo Yii::app()->createUrl('Package/delete') ?>/" + id,
                type: "POST"
            }).done(function (data) {
                $.fn.yiiListView.update('Package-list');
            });
        }
    });

    $(document).on("click", "#Package-search_btn", function () {
        var searchtxt = $("#Package-search_txt").val();
        $.fn.yiiListView.update('Package-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages: $("#Package-pages").val()
            }
        });
    });

    $(document).on("keyup", "#Package-search_txt", function () {
        var searchtxt = $("#Package-search_txt").val();
        $.fn.yiiListView.update('Package-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: searchtxt,
                pages: $("#Package-pages").val()
            }
        });
    });

    $(document).on("change", "#Package-pages", function () {

        $.fn.yiiListView.update('Package-list', {
            //this entire js section is taken from admin.php. w/only this line diff
            data: {
                val: $("#Package-search_txt").val(),
                pages: $("#Package-pages").val()
            }
        });
    });


</script>
<!-- //END SCRIPT -->



<div class="row">
    <div class="col-sm-16">
        <h2 class="header_topic" style="font-size: 20px;">Packages<br/>
            <span style="font-size: 14px; line-height: 16px;">Manage Packages with this Section. </span></h2>
    </div>
</div>

<div class="inner_nav">
    <div class="row">
        <div class="col-sm-2">        
            <button id="Package-add" data-model="Package" class="btn btn-default btn-block btn-sm">Add <span class="glyphicon glyphicon-plus"></span></button>
        </div>
        <div class="col-sm-7">
            <div class="input-group">
                <input type="text" class="form-control" id="Package-search_txt" name="search" placeholder="Search Package ...." />

                <span class="input-group-btn">
                    <button id="Package-search_btn" class="btn btn-default">Search <span class="glyphicon glyphicon-search"></span></button>
                </span>
            </div>
        </div>
        <div class="col-sm-2 col-sm-push-5">
            <select id="Package-pages" class="form-control">
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


    <?php
    $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $dataProvider,
        'itemView' => '_view',
        'enablePagination' => true,
        'summaryText' => false,
        'id' => 'Package-list',
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
