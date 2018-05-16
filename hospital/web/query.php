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
    <?php require(WEB_PAGE_PATH."js.php"); ?>
    <script src="/web/js/query.js"></script>
    <script type="text/javascript">
        var g_patient_query = new patient_query();
        var g_query_data = {};
        function onGotoPage(page){

        }
        function onDeleteRecord(record_id){

        }
        function queryInfoRet(rsp){
            if (rsp.ret != 0){
                alert("查询失败，请稍候再试");
                return;
            }
            var data = rsp.msg;
            var options = {
                "show_fields":["序号","病案号","姓名","性别", "出生日期", "联系人", "联系电话", "医院", "上传时间", "状态"],
                "page_size":rsp.size,
                "cur_page":rsp.page,
                "total_num":rsp.total,
                "operations":"删除",
            }
            g_query_data.page_size = options.page_size;
            g_query_data.cur_page = options.cur_page;
            g_query_data.total_num = options.total_num;

            g_patient_query.fillTable(data, options, $("#query-table-wrapper"), $("#query-page-nav"));
        }
        initPage();
        
        $("#content-query button[tag='query']").click(function(){
            g_patient_query.query_patient({}, queryInfoRet);
        })
        g_patient_query.query_patient({}, queryInfoRet);
    </script>
</body>

</html>