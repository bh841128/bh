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
                <div class="hospital-content-wrapper">
                    <section class="content container-fluid main-container">
                        <ul class="nav nav-tabs" id="nav-tab" role="tablist">
                            <li class="active">
                                <a class="nav-item nav-link" id="nav-tab-jibenziliao" data-toggle="tab" href="#tab-jibenziliao" role="tab" aria-selected="true">基本资料</a>
                            </li>
                            <li class="">
                                <a class="nav-item nav-link" id="nav-tab-zhuyuanjilu" data-toggle="tab" href="#tab-zhuyuanjilu" role="tab" aria-selected="true">住院记录</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane form-step fade active in" id="tab-jibenziliao" role="tabpanel" aria-labelledby="nav-tab-jibenziliao">
                                <?php require(WEB_PAGE_PATH."add/jibenziliao.php"); ?>
                            </div>
                            <div class="tab-pane form-step fade" id="tab-zhuyuanjilu" role="tabpanel" aria-labelledby="nav-tab-zhuyuanjilu">
                            <?php require(WEB_PAGE_PATH."add/zhuyuanjilu.php"); ?>
                            </div>
                    </section>
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