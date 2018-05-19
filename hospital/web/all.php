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
                <?php require(WEB_PAGE_PATH."breadcrumb.php"); ?>
                <div class="hospital-content-wrapper" id="content-wrapper-add-jibenziliao" style="display:none">
                    <?php require(WEB_PAGE_PATH."add/jibenziliao_page.php"); ?>
                </div>
                <div class="hospital-content-wrapper" id="content-wrapper-add-zhuyuanjilu">
                    <?php require(WEB_PAGE_PATH."add/zhuyuanjilu_page.php"); ?>
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