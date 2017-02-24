
<?php
$wo_det = WrkOrder::model()->findByPk($wo_id);
$wo_items = $wo_det->wrkOrderHasItems;
$discount=0;

$sql="SELECT SUM(p.`amount`) AS paid, pt.`name` FROM `payments` p JOIN `payment_type` pt ON pt.`id`=p.`payment_type_id` WHERE p.online = '1' AND p.wrk_order_id = '$wo_id' GROUP BY p.`payment_type_id` ";
$payments = Yii::app()->db->createCommand($sql)->queryAll();
$tot = 0;
$paid=0;
ob_clean();
$mPDF1 = Yii::app()->ePdf->mpdf('', array(180, 140), 0, 'Arial', 5, 5, 20, 4, 2, 2, 'P');

    ob_start();?>
    <table style="width:500px;  text-align: center;">
    <tr>
        <td colspan="3" style="font-weight:bold; font-size:20px;">
            MANGALAA STUDIO & BEAUTY SALON
        </td>
    </tr>
    <tr>
        <td colspan="3">
            Dandugamma Junction, Sevanagala.
        </td>
    </tr>
    <tr>
        <td colspan="3" style="background-color:orange; color:white;">
             +94717502687 , +94772995390 , +94712923500
        </td>
    </tr>
    <tr>
        <td colspan="3">
             www.facebook.com/mangalastudio <br> mangalaastudio@hotmail.com
        </td>
    </tr>
    <tr>
        <td colspan="2" style="width:70%; text-align:left;">
             <strong>Name: <?=$wo_det->customer->name?></strong> 
        </td>
        <td style="width:30%; text-align:right;">
             <strong>Date: <?=date('Y-m-d')?></strong>
        </td>
    </tr>
    <tr style="background-color:orange; color:white; ">
        <td style="width:10%; font-weight:bold; border: 1px solid black;">Qty.</td>
        <td style="width:70%; font-weight:bold; border: 1px solid black;">Description</td>
        <td style="width:20%; font-weight:bold; border: 1px solid black;">Amount (LKR)</td>
    </tr>
    <?php
    foreach ($wo_items as $value) {
        $tot += floatval($value->amount);
        ?>
        <tr style="border: 1px solid black;">
            <td style="width:10%;  border: 1px solid black;"><?=$value->qty?></td>
            <td style="width:70%;  border: 1px solid black;text-align:left;"><?=$value->name?></td>
            <td style="width:20%;  border: 1px solid black; text-align:left;"><?=$value->amount?></td>
        </tr>
        <?php
    }
    ?>
        <tr style="border: 1px solid black;">
            <td style="width:10%;  border: 1px solid black;"> </td>
            <td style="width:70%;  border: 1px solid black;text-align:right; font-weight:bold;"> Total </td>
            <td style="width:20%;  border: 1px solid black; text-align:right;font-weight:bold;"><?=$tot?></td>
        </tr>
    <?php

    if(count($payments) >0){
        foreach ($payments as $value) {
            $paid += floatval($value['paid']);
            ?>
            <tr style="border: 1px solid black;">
                <td style="width:10%;  border: 1px solid black;"> </td>
                <td style="width:70%;  border: 1px solid black; text-align:left;"><?=$value['name']?></td>
                <td style="width:20%;  border: 1px solid black;text-align:left;">(<?=$value['paid']?>)</td>
            </tr>
            <?php
        }

        ?>
            <tr style="border: 1px solid black;">
                <td style="width:10%;  border: 1px solid black;"> </td>
                <td style="width:70%;  border: 1px solid black;text-align:right; font-weight:bold;">Total paid</td>
                <td style="width:20%;  border: 1px solid black;text-align:right; font-weight:bold;">(<?=$paid?>)</td>
            </tr>
        <?php
    }

    if($wo_det->discount > 0){
        $discount = floatval($wo_det->discount);
        ?>
        <tr style="border: 1px solid black;">
                <td style="width:10%;  border: 1px solid black;"> </td>
                <td style="width:70%;  border: 1px solid black;text-align:right; font-weight:bold;">Discount</td>
                <td style="width:20%;  border: 1px solid black;text-align:right; font-weight:bold;">(<?=$wo_det->discount?>)</td>
            </tr>
        <?php
    }
    ?>

    <tr>
        <td colspan="2" style="width:60%; text-align:left; background-color:orange; color:white;">
             Days
        </td>
        <td style="width:40%; text-align:right;font-weight:bold;">
             Balance : <?=number_format(($tot - $paid-$discount),2)?>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="width:50%; text-align:left;">
             <strong>Membership No.: <?=$wo_det->customer->code?></strong> 
        </td>
        <td style="width:50%; text-align:right;">
             <strong>Deliver Date: <?=$wo_det->delivery_date?></strong> 
        </td>
    </tr>
    <tr>
        <td colspan="3" style="font-weight:bold; font-size:10px; color:orange;">
             * Avoid Responsibility Bills after 3 Months.   <br>
             * Non Refundable. 
        </td>
    </tr>
</table>

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

