<?php
require_once(__DIR__."/../config/front_config.php");
?>
<!DOCTYPE html>
<html>
<head>
    <?php require(WEB_PAGE_PATH."head.php"); ?>
</head>
<body class="hold-transition">
    <?php require(WEB_PAGE_PATH."header.php"); ?>
    <div class="top-hr"></div>
    <div class="top-wrapper">
        <div class="content-wrapper bread-content-wrapper">
            <section class="content-header">
                <div class="hospital-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Forms</a></li>
                        <li class="active">General Elements</li>
                    </ol>
                </div>
            </section>
        </div>
        <?php require(WEB_PAGE_PATH."aside.php"); ?>
        <?php require(WEB_PAGE_PATH."footer.php"); ?>
        <?php require(WEB_PAGE_PATH."login_modal.php"); ?>
    </div>
    <?php require(WEB_PAGE_PATH."js.php"); ?>
    <script type="text/javascript">
        var g_hospital = new hospital();
        g_hospital.init();
    </script>
</body>

</html>