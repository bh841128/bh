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
            <section class="content container-fluid" style="min-height:650px">
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
    <script type="text/javascript">
        initPage();
    </script>
</body>

</html>