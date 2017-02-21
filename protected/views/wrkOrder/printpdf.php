
<?php
ob_clean();
$mPDF1 = Yii::app()->ePdf->mpdf('', array(180, 140), 0, 'Arial', 5, 5, 20, 4, 2, 2, 'P');


$model = Appointment::model()->findByPk($appoinment_id);
$prescription = Prescription::model()->findByAttributes(array('appointment_id'=>$appoinment_id));
$pre_drugs = Yii::app()->db->createCommand("SELECT * FROM prescribed_drugs WHERE prescription_id ='".$prescription->id."'")->queryAll();
//$pre_drugs = PrescribedDrugs::model()->findByAttributes(array('prescription_id'=>$prescription->id));
$payment = Payment::model()->findByAttributes(array('appointment_id'=>$appoinment_id));
    ob_start();?>

<div class="row">
    <h2>
        Appointment : <?= $model->id ?> | <?= $model->name ?>
    </h2>
</div>
<?php
//print_r();

?>
    <div class="panel-group">
   <div class="panel panel-success">
        <div class="panel-heading">Prescription</div>
        <div class="panel-body">
            <div class="row">
            <div class="col-sm-5">
                <label>Appointment Date : </label> <strong><?= $model->eff_date ?></strong>
                
            </div>
            <div class="col-sm-5">
                <label>Next Date : </label><strong><?= $prescription->next_date ?></strong>
                
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <label>Diagnosis : </label><strong><?= $prescription->diagnosis ?></strong>
                
            </div>
        </div>
        <div class="row">
            <div class="col-sm-10">
                <label>Details : </label><strong><?= $prescription->description ?></strong>
                
            </div>
        </div>
        </div>
    </div>
        <hr>
    <div class="panel panel-success">
        <div class="panel-heading">Prescription Drugs</div>
        <div class="panel-body">
            <div class="row">
                <style>
                    table, th, td {
    border: 1px solid black;
}
                </style>
            <table class="table table-striped" >
                <thead>
                    <tr>
                        <th>Drug</th>
                        <th>Dosage</th>
                        <th>Frequency</th>
                        <th>Amount</th>
                        <th>Cost</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php
//                    var_dump($pre_drugs);
//                      die();   
                    foreach ($pre_drugs as $value) {
                        ?>
                    <tr>
                            <td>
                                <strong>
                                    <?php 
                                    $dr = Drug::model()->findByPk($value['drug_id']);
                                    echo $dr->name;
                                        ?>
                                </strong>
                            </td>
                            <td>
                                <strong><?= $value['dosage_new'] ?></strong>
                                </td>
                            <td><strong><?= $value['frequency'] ?></strong>
                                </td>
                                <td>
                                <strong><?= $value['dosage'] ?></strong>
                                </td>
                            <td>

                                <strong><?= $value['amount'] ?></strong>
                                </td>
                        </tr>
                    <?php
                    }
                    ?>
                    
                </tbody>
            </table>
        </div>
        </div>
    </div>
        <hr>
    <div class="panel panel-success">
        <div class="panel-heading">Make Payment</div>
        <div class="panel-body">
            <div class="row">
            <div class="col-sm-5">
                <label>Total Bill : </label>
                <strong><?=$payment->total; ?></strong>(Drugs + Service Charge)
                

            </div>
                <div class="col-sm-5">
                <label>Paid Amount : </label>
                <strong><?=$payment->paid; ?></strong>
                

            </div>
            <div class="col-sm-5">
                <label>Balance : </label>
                <strong><?=$payment->balance; ?></strong>
                

            </div>
            <div class="col-sm-5">
                <label>Date : </label>
                <strong><?=$payment->eff_date; ?></strong>
                

            </div>
            <div class="col-sm-10">
                <label>Remark : </label>
                <strong><?=$payment->paid_for; ?></strong>

            </div>
        </div>
            <br>
            <div class="row btn-row">
                        <div class="col-sm-2">
                            
                        </div>
                        
                    </div>
        </div>
    </div>
</div>
<?php
   
    $outputImages = ob_get_contents();
    ob_end_clean();

    $mPDF1->addPage();
    $mPDF1->WriteHTML($outputImages);
    $mPDF1->SetHTMLFooter("<p class='footer' style='textalign:center;' >This is a computer generated copy, Slip Created @ " . date("Y-m-d H:i:s") . "</p>");

    # Outputs ready PDF  


//$mPDF1->Output("slips/$emp_id".".pdf","D");
$mPDF1->Output();
?><?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

