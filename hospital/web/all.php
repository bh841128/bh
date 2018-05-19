<?php
require_once(__DIR__."/../config/front_config.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>中国少儿先天性心脏病外科手术数据库</title>
    <?php require(WEB_PAGE_PATH."css.php"); ?>
</head>
<body>
    <?php require(WEB_PAGE_PATH."header.php"); ?>
    <div class="top-hr"></div>
    <div class="top-wrapper">
        <div class="top-wrapper2">
            <?php require(WEB_PAGE_PATH."aside.php"); ?>
            <div class="hospital-wrapper">
                <?php require(WEB_PAGE_PATH."breadcrumb.php"); ?>
                <div class="hospital-content-wrapper" id="content-wrapper-add-jibenziliao" style="display:none">
                    <?php require(WEB_PAGE_PATH."add/jibenziliao_page.php"); ?>
                </div>
                <div class="hospital-content-wrapper" id="content-wrapper-add-zhuyuanjilu" style="display:none">
                    <?php require(WEB_PAGE_PATH."add/zhuyuanjilu_page.php"); ?>
                </div>
                <div class="hospital-content-wrapper" id="content-wrapper-upload-upload" style="display:none">
                    <?php require(WEB_PAGE_PATH."upload/upload_page.php"); ?>
                </div>
                <div class="hospital-content-wrapper" id="content-wrapper-query-query" style="display:none">
                    <?php require(WEB_PAGE_PATH."query/query_page.php"); ?>
                </div>
                <div class="hospital-content-wrapper" id="content-wrapper-export-export" style="display:none">
                    <?php require(WEB_PAGE_PATH."export/export_page.php"); ?>
                </div>
                <div class="hospital-content-wrapper" id="content-wrapper-report-report">
                    <?php require(WEB_PAGE_PATH."report/report_page.php"); ?>
                </div>
            </div>
            <?php require(WEB_PAGE_PATH."login_modal.php"); ?>
        </div>
        <?php require(WEB_PAGE_PATH."footer.php"); ?>
    </div>
    <?php require(WEB_PAGE_PATH."js.php"); ?>
    <script type="text/javascript">
        var g_hospital = new hospital();
        g_hospital.init();
    </script>
</body>

</html>