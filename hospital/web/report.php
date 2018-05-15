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
                    <div class="report-chart" style="position:relative;width:100%;height:700px;margin-top:20px">
                        <div class="report-chart-title" style="text-align:center">
                            <h3>少儿先天性心脏病月录入量统计</h3>
                            <h4 style="padding-top:10px">总量：1234</h4>
                        </div>
                        <div style="position: absolute;top:20px;right:10px;">
                            <select class="form-control input-sm" style="width:100px">
                                <option value="2018">2018</option>
                            </select>
                        </div>
                        <div class="report-chart-container" style="height:500px;" id="report-chart">

                        </div>
                        <div class="report-chart-footer" style="text-align:left;">
                            <div class="form-horizontal">
                                <table class="control-table padding-20">
                                    <tr>
                                        <td>
                                            <div style="padding-left:200px">
                                                <select class="form-control input-sm" style="width:150px">
                                                    <option value="医院">医院</option>
                                                </select>
                                            </div>

                                        </td>
                                        <td>
                                            <div style="height:13px;width:13px;margin-left:20px;margin-right:10px;background-color:rgb(86,187,251)"></div>
                                        </td>
                                        <td>阜外医院</td>
                                        <td>
                                            <div style="height:13px;width:13px;margin-left:20px;margin-right:10px;background-color:rgb(255,129,73)"></div>
                                        </td>
                                        <td>其他</td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                    </div>
            </section>
            </div>
            <!-- /.content-wrapper -->
        </div>
        <?php require(WEB_PAGE_PATH."footer.php"); ?>
        <?php require(WEB_PAGE_PATH."login_modal.php"); ?>
        <?php require(WEB_PAGE_PATH."js.php"); ?>
        
        <script type="text/javascript">
            initPage();
        </script>
    </div>

</body>

</html>