<?php
/* @var $this WrkOrderController */
/* @var $data WrkOrder */
?>


<div class="row datarow">

    <div class='col-sm-2 cells'>
	<?php echo $data['code']; ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo $data['delivery_date']; ?>
</div>
<div class='col-sm-2 cells'>
   <?=$data['cust_name']?>;
</div>
<div class='col-sm-2 cells'>
	<?php
  $tot = floatval($data['total']) + floatval($data['discount']);
  echo number_format($tot,2);
  ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo number_format($data['discount'],2); ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo number_format($data['total'] ,2);  ?>
</div>
<div class='col-sm-2 cells'>
	<?php echo number_format($data['paid'] ,2);  ?>
</div>
<div class='col-sm-1 cells'>
	<?php
  $bal = floatval($data['total']) - floatval($data['paid']);
  echo number_format($bal,2);
   ?>
</div>


    <div class='col-sm-1 cells btn-cog text-right'>
      <?php
      if($data['status'] == "PENDING"){
        ?>
        <a class="" target="_blank" href="<?php echo Yii::app()->createUrl("wrkOrder") ?>/payment/<?php echo $data['id']; ?>" data-id="<?php echo $data['id']; ?>" data-balance="<?=$bal?>" data-toggle="tooltip" data-placement="top" title="Payments"><span class="glyphicon glyphicon-usd"></span></a>
        <a class="WrkOrder-update" href="#" data-id="<?php echo $data['id']; ?>" model="WrkOrder" controler="WrkOrderController" data-toggle="tooltip" data-placement="top" title="Update"><span class="glyphicon glyphicon-cog"></span></a>
        <a class="WrkOrder-delete" href="#" data-id="<?php echo $data['id']; ?>" model="WrkOrder" controler="WrkOrderController" data-toggle="tooltip" data-placement="top" title="Delete"><span class="glyphicon glyphicon-remove"></span></a>
        <?php
      }
      elseif ($data['status'] =="HALF PAID") {
        ?>
        <a class="" target="_blank" href="<?php echo Yii::app()->createUrl("wrkOrder") ?>/payment/<?php echo $data['id']; ?>" data-id="<?php echo $data['id']; ?>" data-balance="<?=$bal?>" data-toggle="tooltip" data-placement="top" title="Payments"><span class="glyphicon glyphicon-usd"></span></a>
        <?php
      }
      else{
        ?>
        <a class=""  href="#" ><span class="glyphicon glyphicon-ok"></span></a>
        <?php
      }

       ?>

    </div>

</div>
