<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
$labeltxt = $this->pluralize($this->class2name($this->modelClass));
$label = $this->modelClass;
$lableLower = strtolower($label);
$labelUpper = strtoupper($label);

?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */


$this->menu = array(
    array("label" => "<span class='glyphicon glyphicon-arrow-left'></span> Go Back", "url" => "<?php echo strtolower($label); ?>" )
);

?>

<script type="text/javascript">

    function PrintElem(elem){
        Popup($(elem).html(),"<?php echo $labelUpper; ?> - <?php echo "<?php"; ?> echo $model->code; ?>");
    } 
    
    function Popup(data,title) {

                    var mywindow = window.open('', title, 'height=400,width=600');
                    mywindow.document.write('<html><head><title>'+ title +'</title>');
                    mywindow.document.write('</head><body >');
                    mywindow.document.write(data);
                    mywindow.document.write('</body></html>');

                    mywindow.document.close(); // necessary for IE >= 10
                    mywindow.focus(); // necessary for IE >= 10

                    mywindow.print();
                    mywindow.close();
                    return true;
    }    
    
</script>

<div class="row ">
    <div class="col-sm-16 text-right">
        <div class="btnArea">
            <div class="row">
                <div class="col-sm-8 text-left">
                    <h3 style="font-size: 13px; padding: 7px 5px; padding-top: 9px; margin: 0px; color: #4f4f4f; ">Print Preview</h3>
                </div>
                <div class="col-sm-8 text-right">
                    <a href="<?php echo "<?php"; ?> echo Yii::app()->createUrl("<?php echo $lableLower ?>/print") ?>/<?php echo "<?php"; ?> echo $model->id; ?>?mode=email" class="btn btn-default pdfgen" >Send Mail to The Customer</a>
                    <a href="<?php echo "<?php"; ?> echo Yii::app()->createUrl("<?php echo $lableLower ?>/print") ?>/<?php echo "<?php"; ?> echo $model->id; ?>?mode=pdf" class="btn btn-default pdfgen" >Download PDF</a>
                    <button class="btn btn-default" onclick="PrintElem('#print_area');">Print</button>
                </div>
            </div>
        </div>
    </div>
</div>
    
    <?php echo "<?php"; ?>

        ob_start();  
        
    ?>

    <!-- Bootstrap CSS 3.1.1 -->
    <link rel="stylesheet" type="text/css" href="<?php echo "<?php"; ?> echo Yii::app()->theme->baseUrl; ?>/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo "<?php"; ?> echo Yii::app()->theme->baseUrl; ?>/css/bootstrap-theme.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo "<?php"; ?> echo Yii::app()->theme->baseUrl; ?>/css/style.css" />

    <div class="row mainRow">


        <table cellspacing='0' cellpadding='0' width='100%'>
            <tr>

                <td width="350px" style="text-align: left;">
                    <img src="<?php echo "<?php"; ?> echo Yii::app()->theme->baseUrl; ?>/images/logo.jpg" class="img-responsive" />
                    <div class="info">
                        <p class="address smtxt"><?php echo "<?php"; ?> echo Yii::app()->params['address']; ?></p>
                        <p class="email smtxt"><?php echo "<?php"; ?> echo Yii::app()->params['email']; ?></p>
                        <p class="contact smtxt"><?php echo "<?php"; ?> echo Yii::app()->params['contact']; ?></p>
                    </div>
                </td>

                <td>
                    <h2 class="mainheader text-left"><?php echo $labelUpper; ?></h2>
                </td>

                <td width="120px" style="text-align: center;">
                    <img width="120px" src="https://chart.googleapis.com/chart?chs=120x120&cht=qr&chl=<?php echo "<?php"; ?>echo $model->code; ?>"/>
                    <h4 class="text-center code"><?php echo "<?php"; ?> echo $model->code; ?></h4>
                </td>


            </tr>



        </table>

        <div class="detailbox">
            <table cellspacing='0' cellpadding='0' width='100%'>
                <tr>
                    <td>
                        <h3>Code</h3>
                        <h2><?php echo "<?php"; ?> echo $model->code; ?></h2>
                    </td>
                    <td>
                        <h3>Supplier Name</h3>
                        <h2><?php echo "<?php"; ?> echo Supplier::model()->findByPk($model->supplier_id)->name; ?></h2>
                    </td>

                    <td>
                        <h3>Process Date</h3>
                        <h2><?php echo "<?php"; ?> echo $model->date; ?></h2>
                    </td>

                    <td>
                        <h3>Remark</h3>
                        <h2><?php echo "<?php"; ?> echo $model->remark; ?></h2>
                    </td>
                </tr>
            </table>
        </div>

        <div class="grid_box">
            <table cellspacing='0' cellpadding='0' width='100%'>
                <tr>
                    <th></th>
                    <th>Code</th>
                    <th>Description</th>
                    <th style="text-align: right;">Cost</th>
                    <th style="text-align: right;">Qty</th>
                    <th style="text-align: right;">Total</th>
                </tr>

                <?php echo "<?php"; ?>
                
                $list = Yii::app()->db->createCommand("SELECT * FROM <?php echo $lableLower; ?>_items WHERE <?php echo $lableLower; ?>_id = '" . $model->id . "' ORDER BY id DESC")->queryAll();
                
                $num = 1;
                $totalAmount = 0;
                foreach ($list as $value) {
                     
                    $items = Items::model()->findByPk($value['items_id']);
                    $total = $value['qty'] * $value['cost'];
                    $totalAmount += $total;
                    
                    ?>
                    <tr>
                        <td><?php echo "<?php"; ?> echo $num; ?></td>
                        <td><?php echo "<?php"; ?> echo $items->code; ?></td>
                        <td><?php echo "<?php"; ?> echo $items->description; ?></td>
                        <td style="text-align: right;"><?php echo "<?php"; ?> echo $value['cost']; ?></td>
                        <td style="text-align: right;"><?php echo "<?php"; ?> echo $value['qty']; ?></td>
                        <td style="text-align: right;"><?php echo "<?php"; ?> echo number_format($total,2); ?></td>
                    </tr>

                    <?php echo "<?php"; ?>
                    
                    $num += 1;
                    
                }
                ?>
                    
                    <tr>
                        <td colspan="5" style="text-align: right;">Total</td>
                        <td width="200px"  style="text-align: right; font-size: 18px; font-weight: bold;"> (LKR) <?php echo "<?php"; ?> echo number_format($totalAmount,2); ?></td>
                    </tr>

            </table>
        </div>
        
        <div style="text-align: right; padding: 40px 10px;">
            <div style="text-align: left; font-size: 12px; width: 400px; padding-top: 90px;">
                ....................................................
                <h5>Authorized Signature</h5>
            </div>
        </div>


    </div>

<?php echo "<?php"; ?>
    
    $outputImages = ob_get_contents();
    ob_end_clean();
    
    $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4', 0, 'Arial', 4, 4, 4, 4, 2, 2, 'P');


    $mPDF1->addPage();
    $mPDF1->WriteHTML($outputImages);
    $mPDF1->SetHTMLFooter("<p class='footer'>Most Advanced Online Sales & Distribution System by Prologics IT </p>");
  

if($mode == 'pdf'){ 

    # Outputs ready PDF
    $mPDF1->Output($model->code,"D");
    
}elseif($mode == 'email'){
    
    $content = $mPDF1->Output('', 'S');

    $content = chunk_split(base64_encode($content));
    $mailto = 'chaturalanthana@gmail.com'; //Mailto here
    $from_name = 'Chatura Lanthana'; //Name of sender mail
    $from_mail = 'chaturalanthana@gmail.com'; //Mailfrom here
    $subject = 'Purchesing Order FROM SS Marketings';
    $message = 'mailmessage';
    $filename = $model->code . date("d-m-Y_H-i", time()); //Your Filename with local date and time
    
    //Headers of PDF and e-mail
    $boundary = "XYZ-" . date("dmYis") . "-ZYX";

    $header = "--$boundary\r\n";
    $header .= "Content-Transfer-Encoding: 8bits\r\n";
    $header .= "Content-Type: text/html; charset=ISO-8859-1\r\n\r\n"; // or utf-8
    $header .= "$message\r\n";
    $header .= "--$boundary\r\n";
    $header .= "Content-Type: application/pdf; name=\"" . $filename . "\"\r\n";
    $header .= "Content-Disposition: attachment; filename=\"" . $filename . "\"\r\n";
    $header .= "Content-Transfer-Encoding: base64\r\n\r\n";
    $header .= "$content\r\n";
    $header .= "--$boundary--\r\n";

    $header2 = "MIME-Version: 1.0\r\n";
    $header2 .= "From: " . $from_name . " \r\n";
    $header2 .= "Return-Path: $from_mail\r\n";
    $header2 .= "Content-type: multipart/mixed; boundary=\"$boundary\"\r\n";
    $header2 .= "$boundary\r\n";

    $result = mail($mailto, $subject, $header, $header2, "-r" . $from_mail);
    if($result){ 
    
    ?>
            <script type="text/javascript">
                    showResponse("Mail Sent! Successfully to the <?php echo "<?php"; ?>  echo $mailto; ?> ");
            </script>
            
    <?php echo "<?php"; ?>       
            
    }else{
    ?>
            <script type="text/javascript">
                    showResponse("Error Occured When Sending to <?php echo "<?php"; ?>  echo $mailto; ?> ");
            </script>
            
    <?php echo "<?php"; ?>
    }
    

}


?>

<div id="print_area">
    <?php echo "<?php"; ?> echo $outputImages ?>
</div>