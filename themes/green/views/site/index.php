

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
            categories: Highcharts.getOptions().lang.shortMonths
        },
        yAxis: {
            title: {
                text: null
            }
        },
        series: [{
            name: 'Sales',
            data: [2, 3, null, 4, 0, 5, 1, 4, 6, 3]
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
            data: [
            ['Cash', 8],
            ['Credit', 3]
            ]
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