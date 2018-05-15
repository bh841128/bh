<?php
require_once(__DIR__."/../config/front_config.php");
?>
<!DOCTYPE html>
<html>
<head>
    <?php require(WEB_PAGE_PATH."head.php"); ?>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <?php require(WEB_PAGE_PATH."header.php"); ?>
    <div style="width:100%;height:2px;background-color:RGB(50,160,220);margin-bottom:20px"></div>
    <div class="wrapper" style="width:1200px;margin-left:auto;margin-right:auto">
        <?php require(WEB_PAGE_PATH."aside.php"); ?>
        <div class="content-wrapper" id="content-report">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1 class="gray-font">月报表</h1>
            </section>
            <!-- Main content -->
            <section class="content container-fluid" style="min-height:650px">
                <div class="tab-content">
                    <?php require(WEB_PAGE_PATH."export/export.php"); ?>
                </div>
            </section>
        </div>
        <?php require(WEB_PAGE_PATH."footer.php"); ?>
        <?php require(WEB_PAGE_PATH."login_modal.php"); ?>
    </div>
    <?php require(WEB_PAGE_PATH."js.php"); ?>
    <script src="/web/lib/adminlte/js/raphael.min.js"></script>
    <script src="/web/lib/adminlte/js/morris.min.js"></script>
    <script type="text/javascript">
        initPage();
        var bar = new Morris.Bar({
            element: 'report-chart',
            resize: true,
            data: [
                { y: '01月份', "阜外医院": 1000, "其他": 900 },
                { y: '02月份', "阜外医院": 100, "其他": 90 },
                { y: '03月份', "阜外医院": 200, "其他": 40 },
                { y: '04月份', "阜外医院": 200, "其他": 40 },
                { y: '05月份', "阜外医院": 2000, "其他": 400 },
                { y: '06月份', "阜外医院": 200, "其他": 40 },
                { y: '07月份', "阜外医院": 200, "其他": 40 },
                { y: '08月份', "阜外医院": 200, "其他": 40 },
                { y: '09月份', "阜外医院": 600, "其他": 220 },
                { y: '10月份', "阜外医院": 200, "其他": 40 },
                { y: '11月份', "阜外医院": 200, "其他": 40 },
                { y: '12月份', "阜外医院": 700, "其他": 240 }
            ],
            barColors: ['rgb(86,187,251)', '#f56954'],
            xkey: 'y',
            ykeys: ['阜外医院', '其他'],
            labels: ['阜外医院', '其他'],
            hideHover: 'auto'
        });
    </script>
</body>

</html>