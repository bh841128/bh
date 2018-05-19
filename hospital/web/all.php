<?php
require_once(__DIR__."/../config/front_config.php");
?>
<!DOCTYPE html>
<html>
<head>
    <?php require(WEB_PAGE_PATH."head.php"); ?>
</head>
<body>
    <?php require(WEB_PAGE_PATH."header.php"); ?>
    <div class="top-hr"></div>
    <div class="top-wrapper">
        <div class="top-wrapper2">
            <?php require(WEB_PAGE_PATH."aside.php"); ?>
            <div class="hospital-wrapper">
                <div class="bread-content-wrapper">
                    <section class="content-header">
                        <div class="hospital-breadcrumb">
                            <ol class="breadcrumb" id="breadcrumb">
                                <li bread-level="1" style="display:none"></li>
                                <li bread-level="2" style="display:none"></li>
                                <li bread-level="3" style="display:none"></li>
                            </ol>
                        </div>
                    </section>
                </div>
                <div class="hospital-content-wrapper">
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