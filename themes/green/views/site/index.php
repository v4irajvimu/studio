<?php
$sql_stock ="SELECT SUM(IFNULL(s.qty_in,0) - IFNULL (s.qty_out,0)) AS qty, i.`name` FROM `stock` s JOIN items i ON i.id=s.`items_id` GROUP BY `items_id` ";

$stock_det = Yii::app()->db->createCommand($sql_stock)->queryAll();
$categories ="[";
$data="[";
foreach ($stock_det as $value) {
    $categories .="'".$value['name']."',";
    $data .=$value['qty'].",";
}

$categories = rtrim($categories,",")."]";
$data = rtrim($data,',')."]";

// Toral Sales

$sql_sales = "SELECT SUM(IFNULL(total,0)) AS amount, wo_type FROM `wrk_order` GROUP BY wo_type";
$sales_det = Yii::app()->db->createCommand($sql_sales)->queryAll();

$sales_data ="[
            ['Cash', 8],
            ['Credit', 3]
            ]";
$sales_data ="[";
foreach ($sales_det as $value) {
    $sales_data.="['".$value['wo_type']."', ".$value['amount']."],";
}
$sales_data = rtrim($sales_data,",")."]";
?>

<script type="text/javascript">
$(document).ready(function(){
    Highcharts.chart('stockvalue', {
        chart: {
            type: 'column',
            options3d: {
                enabled: true,
                alpha: 10,
                beta: 25,
                depth: 70
            }
        },
        title: {
            text: 'STOCK VALUATION'
        },
        subtitle: {
            text: ''
        },
        plotOptions: {
            column: {
                depth: 25
            }
        },
        xAxis: {
            categories: <?=$categories?>
        },
        yAxis: {
            title: {
                text: null
            }
        },
        series: [{
            name: 'Sales',
            data: <?=$data?>
        }],
        credits: {
            enabled: false
        },
        exporting: { enabled: false }
    });


    Highcharts.chart('totalsales', {
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
        title: {
            text: 'TOTAL SALES'
        },
        subtitle: {
            text: ''
        },
        plotOptions: {
            pie: {
                innerSize: 100,
                depth: 45
            }
        },
        series: [{
            name: 'Sales Type',
            data: <?=$sales_data?>
        }],
        credits: {
            enabled: false
        },
        exporting: { enabled: false }
    });
});


</script>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3" id="left-dash">
            <div class="row">
                <div class="main-tile">
                    <div class="title-midle">
                        <a id="wrkOrder"  href="<?php echo Yii::app()->createUrl("wrkOrder"); ?>">
                            <div class="link-box text-center">
                                <div style="margin-top:20px;">
                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/icons/trans.png" width="50px" /> WORK ORDER
                                </div>
                            </div>
                            
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="main-tile">
                    <div class="title-midle">
                        <a id="stock" href="<?php echo Yii::app()->createUrl("stock"); ?>">
                            <div class="link-box text-center">
                                <div style="margin-top:20px;">
                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/icons/stock.png" width="50px" /> STOCK 
                                </div>
                            </div>
                            
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="main-tile">
                    <div class="title-midle">
                        <a id="stock" href="<?php echo Yii::app()->createUrl("customer"); ?>">
                            <div class="link-box text-center">
                                <div style="margin-top:20px;">
                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/icons/user.png" width="50px" /> CUSTOMER 
                                </div>
                            </div>
                            
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="main-tile">
                    <div class="title-midle">
                        <a id="stock" href="<?php echo Yii::app()->createUrl("items"); ?>">
                            <div class="link-box text-center">
                                <div style="margin-top:20px;">
                                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/icons/magazine.png" width="50px" /> CUSTOMER 
                                </div>
                            </div>
                            
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-13">
            <div class="row">
                <div class="col-sm-6">
                    <div class="chart-box"  id="totalsales"></div>
                </div>
                <div class="col-sm-10">
                    <div  class="chart-box" id="stockvalue"></div>
                </div>
            </div>
        </div>
    </div>
</div>