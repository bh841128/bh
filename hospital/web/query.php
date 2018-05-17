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

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" id="content-query">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1 class="gray-font">数据查询</h1>
            </section>
            <!-- Main content -->
            <section class="content container-fluid main-container">
                <div class="tab-content">
                    <div class="tab-pane form-step fade active in">
                        <?php require(WEB_PAGE_PATH."query/query.php"); ?>
                    </div>
                </div>
            </section>
        </div>
        <?php require(WEB_PAGE_PATH."footer.php"); ?>
        <?php require(WEB_PAGE_PATH."login_modal.php"); ?>
    </div>
    <div style="display:none;">
        <form id="post_edit_form" method="POST" action"/index.php">
            <input type="hidden" name="patient_id" value="">
            <input type="hidden" name="operation_type" value="">
        </form>
    </div>
    <?php require(WEB_PAGE_PATH."js.php"); ?>
    <script src="/web/js/query.js"></script>
    <script type="text/javascript">
        initPage();
        
        var options = {
            "show_fields":["序号","病案号","姓名","性别", "出生日期", "联系人", "联系电话", "医院", "上传时间", "状态"],
            "operations":"编辑,删除",
            "table_wrapper":$("#query-table-wrapper"),
            "page_nav_wrapper":$("#query-page-nav")
        }
        var g_patient_query = new patient_query();
        g_patient_query.init(options);

        function queryDefaultPage(){
            var query_params = g_patient_query.parseQueryParam($("#query_param_form"));
            query_params.page = 1;
            query_params.size = 10;
            g_patient_query.queryData(query_params);
        }
        
        $("input[tag='datetimepicker']").val("");
        $("#content-query button[tag='query']").click(function(){
            queryDefaultPage();
        })
        queryDefaultPage();
    </script>
</body>

</html>