<?php
$sql = "SELECT wo.*,c.name AS cust_name,
          (SELECT IFNULL(SUM(amount),0) FROM payments p WHERE p.wrk_order_id = wo.id) AS paid,
          wos.name as status
          FROM wrk_order wo
          JOIN customer c ON c.id=wo.customer_id
          JOIN wo_status wos ON wos.id = wo.wo_status_id
          WHERE wo.id='".$model->id."' 
          ORDER BY wo.code ASC ";
$wrkOder_det = Yii::app()->db->createCommand($sql)->queryAll();

$bal = floatval($wrkOder_det[0]['total']) - floatval($wrkOder_det[0]['paid']);

$payment = Payments::model()->findAllByAttributes(array('wrk_order_id'=>$model->id));
?>

<script>
  $(document).ready(function(){
     $("#Payment-form").submit(function(e) { 
        e.preventDefault();
        if ( $(this).parsley().isValid() ) {
            var data = $(this).serializeArray();
            $.post("<?php echo Yii::app()->createUrl('Payments/create') ?>", 
            data,
            function(res){
                //location.reload();
            }, 
            "text");        
        }
      });
  });



  // $(document).on("click", "#Payment-submitbtn",function(e){
    
  // });
</script>

<div class="row">
 <div class="col-sm-11 ">
   <h4><span class="label label-primary">MAKE PAYMENT FOR WORK ORDER : <?=$wrkOder_det[0]['code'];?></span></h4>
   <div class="jumbotron" >
     <form data-parsley-validate id="Payment-form" action="<?php echo Yii::app()->createUrl('Payments/create') ?>" method="post">
       <div class="row">
         <div class="col-sm-10">
           <label>Work Order Type: </label>
           <select id="payment_type_id" name="payment_type_id" class="form-control" required>
             <option value="">-- Select Payment Type --</option>
             <option value="1">ADVANCE PAYMENT</option>
             <option value="2">FULL PAYMENT</option>
             <option value="3">INSTALLMENT PAYMENT</option>
           </select>
         </div>
       </div>
       <div class="row">
         <div class="col-sm-14">
           <label>Name: </label>
           <input readonly type="text" id="name" name="name" value="<?=$wrkOder_det[0]['code']." | ".$wrkOder_det[0]['customer_name']?>" class="form-control" required/>
         </div>
       </div>
       <div class="row">
         <div class="col-sm-14">
           <label>Remark: </label>
           <textarea  type="text" id="remark" name="remark" class="form-control" required></textarea>
         </div>
       </div>

       <div class="row">
         <div class="col-sm-6">
           <label>Amount: </label>
           <input type="text" id="amount" name="amount" value="<?=$bal?>" class="form-control " placeholder="0.00" pattern="^[0-9]*\.[0-9]{2}$" required/>
           <!--  wrk_order_id -->
           <input type="hidden" id="wrk_order_id" name="wrk_order_id" value="<?=$wrkOder_det[0]['id']?>" class="form-control " />
           <input type="hidden" id="created" name="created" value="<?=date('Y-m-d H:i:s')?>" class="form-control " />
           <input type="hidden" id="online" name="online" value="1" class="form-control " />
         </div>
       </div>
       <br>
       <div class="row btn-row">
        <label>&nbsp;&nbsp;&nbsp; </label>
         <div class="col-sm-2">
           <button id="Payment-submitbtn" class="btn btn-primary form-control">PAY</button>
         </div>
       </div>
     </form>
   </div>


 </div>
 <div class="col-sm-5">
  <div class="row">
    <a href="" style="text-decoration:none;">
        <h1 class="text-center"><span class="label label-primary glyphicon glyphicon-print">  PRINT BILL</span></h1>
    </a>
   
  </div>
  
  <div class="row">
    <h4><span class="label label-primary">PAYMENT HISTORY : <?=$wrkOder_det[0]['code'];?></span></h4>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Remark</th>
          <th>Amount</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $cnt=0;
        foreach ($payment as $value) {
          $cnt++;
          ?>
          <tr>
            <td><?=$cnt?></td>
            <td><?=$value['remark']?></td>
            <td><?=$value['amount']?></td>
            <td class="text-center"><a class="payment-cancel "  href="#" ><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>
          <?php
        }
        ?>
      </tbody>
    </table>
  </div>
  
 </div>
</div>
