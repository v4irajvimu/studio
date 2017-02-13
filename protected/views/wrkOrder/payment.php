<?php
$wrkOder_det = $model;

 ?>
 <div class="row">
   <div class="col-sm-16">
     <h2 id="WrkOrder-formtitle" >MAKE PAYMENT FRO WORK ORDER : <?=$wrkOder_det->code;?></h2>
     <div class="cus-form">
       <form data-parsley-validate action="<?php echo Yii::app()->createUrl('Payment/create') ?>" method="post" id="WrkOrder-form">
         <div class="row">
                 <div class="col-sm-4">
                   <label>Work Order Type: </label>
                   <select id="payment_type_id" name="payment_type_id" class="form-control">
                     <option value="">-- Select Payment Type --</option>
                     <option value="1">ADVANCE PAYMENT</option>
                     <option value="2">FULL PAYMETN</option>
                     <option value="3">INSTALLMENT PAYMENT</option>
                   </select>
                 </div>
               </div>
               <div class="row">
                 <div class="col-sm-6">
                   <label>Name: </label>
                   <input type="text" id="name" name="name" value="<?=$wrkOder_det->code." | ".$wrkOder_det->customer_name?>" class="form-control" required/>
                 </div>
               </div>
               <div class="row">
                 <div class="col-sm-8">
                   <label>Remark: </label>
                   <textarea  type="text" id="remark" name="remark" class="form-control"></textarea>
                 </div>
               </div>
               <!-- Modal Customer list-->

               <div class="row">
                 <div class="col-sm-3">
                   <label>Amount: </label>
                   <input type="text" id="amount" name="amount" value="" class="form-control " required/>
                   <!--  wrk_order_id -->
                   <input type="hidden" id="wrk_order_id" name="wrk_order_id" value="<?=$wrkOder_det->id?>" class="form-control " />
                 </div>
               </div>

               <div class="row btn-row">
                 <div class="col-sm-2">
                   <button id="Payment-submitbtn" class="btn btn-primary form-control">PAY</button>
                 </div>
               </div>

             </div>

             </div>
           </div>
         </form>
       </div>
     </div>
   </div>
