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
                ykeys: [g_global_data.hospital.name, '其他'],
                labels: [g_global_data.hospital.name, '其他'],
                hideHover: 'auto'
            });
            $("#foot_hospital_name").html(g_global_data.hospital.name);
            $("#year-select").change(function(){
                var year = $("#year-select").val();
                queryReportTable(year);
            })
        }
        initPage(init_hospital_end);
        function init_hospital_end(){
            initBar();
            queryReportTable((new Date()).getFullYear());
        }
        function queryReportTable(year){
            function onQueryReportTableRet(rsp){
                if (rsp.ret != 0){
                    alert("查询数据错误，请稍后再试");
                    return;
                }
                var data = [];
                for (var i = 0; i < rsp.msg.length; i++){
                    var record =  rsp.msg[i];
                    data.push({
                        hospital_id:record["hospital_id"],
                        month:record["mon"],
                        num:record["count(*)"]
                    })
                }
                showReportBar(data);
            }
            ajaxRemoteRequest("hospital/records-table",{year:year},onQueryReportTableRet);
        }
        function showReportBar(data){
            var the_hospital = g_global_data.hospital;
            var report_data_tmp = {};
            for (var i = 1; i <= 12; i++){
                report_data_tmp[i] = {};
                report_data_tmp[i][the_hospital.name] = 0;
                report_data_tmp[i]["其他"] = 0;
            }
            var total_num = 0;
            for (var i = 0; i < data.length; i++){
                var record_num = parseInt(data[i].num);
                total_num += record_num;
                var month = parseInt(data[i]["month"],10);
                if (data[i].hospital_id == the_hospital.id){
                    report_data_tmp[month][the_hospital.name]+=record_num;
                }
                else{
                    report_data_tmp[month]["其他"]+=record_num;
                }
            }

            var report_data = [];
            for (var i = 1; i <= 12; i++){
                var report_record = {};
                var yuefen = i>=10?i+"":"0"+i;
                report_record["y"] = yuefen+"月份";
                report_record[the_hospital.name] = report_data_tmp[i][the_hospital.name];
                report_record["其他"] = report_data_tmp[i]["其他"];
                report_data.push(report_record);
            }
            console.dir(report_data);
            $("#report-sub-title").html("总量："+total_num);
            g_report_bar.setData(report_data);
        }
        //{ y: '01月份', "阜外医院": 1000, "其他": 900 },

        
        
    </script>
</body>

</html>