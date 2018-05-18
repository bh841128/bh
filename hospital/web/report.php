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
    <div class="top-hr"></div>
    <div class="wrapper top-wrapper">
        <?php require(WEB_PAGE_PATH."aside.php"); ?>
        <div class="content-wrapper" id="content-report">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1 class="gray-font">月报表</h1>
            </section>
            <!-- Main content -->
            <section class="content container-fluid main-container">
                <div class="tab-content">
                    <?php require(WEB_PAGE_PATH."report/report.php"); ?>
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
        function initBar(){
            g_report_bar = new Morris.Bar({
                element: 'report-chart',
                resize: true,
                data: [
                ],
                barColors: ['rgb(86,187,251)', '#f56954'],
                xkey: 'y',
                ykeys: ['阜外医院', '其他'],
                labels: ['阜外医院', '其他'],
                hideHover: 'auto'
            });
        }
        initPage(init_hospital_end);
        function init_hospital_end(){
            queryReportTable((new Date()).getFullYear());
        }
        function queryReportTable(year){
            function onQueryReportTableRet(rsp){
                console.dir(rsp);
            }
            ajaxRemoteRequest("hospital/records-table",{year:year},onQueryReportTableRet);
        }
        //{ y: '01月份', "阜外医院": 1000, "其他": 900 },

        
        
    </script>
</body>

</html>