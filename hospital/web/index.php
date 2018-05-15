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
        <div class="content-wrapper" id="content-add">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1 class="gray-font">新增资料</h1>
            </section>
            <!-- Main content -->
            <section class="content container-fluid" style="min-height:650px">
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
        <div class="content-wrapper" id="content-zyjl" style="display:none">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1 class="gray-font">新增住院记录</h1>
                </section>
                <!-- Main content -->
                <section class="content container-fluid" style="min-height:650px">
                    <ul class="nav nav-tabs" id="nav-tab-xinzeng-zyjl" role="tablist">
                        <li class="active">
                            <a class="nav-item nav-link" id="nav-tab-zyjl-riqi" data-toggle="tab" href="#tab-zyjl-riqi" role="tab" aria-selected="true">日期</a>
                        </li>
                        <li class="">
                            <a class="nav-item nav-link" id="nav-tab-zyjl-shuqianxinxi" data-toggle="tab" href="#tab-zyjl-shuqianxinxi" role="tab" aria-selected="true">术前信息</a>
                        </li>
                        <li class="">
                            <a class="nav-item nav-link" id="nav-tab-zyjl-shoushuxinxi" data-toggle="tab" href="#tab-zyjl-shoushuxinxi" role="tab" aria-selected="true">手术信息</a>
                        </li>
                        <li class="">
                            <a class="nav-item nav-link" id="nav-tab-zyjl-shuhouxinxi" data-toggle="tab" href="#tab-zyjl-shuhouxinxi" role="tab" aria-selected="true">术后信息</a>
                        </li>
                        <li class="">
                            <a class="nav-item nav-link" id="nav-tab-zyjl-chuyuanziliao" data-toggle="tab" href="#tab-zyjl-chuyuanziliao" role="tab"
                                aria-selected="true">出院资料</a>
                        </li>
                    </ul>
                    <div class="tab-content" style="margin-top:20px">
                        <div class="tab-pane form-step fade active in" id="tab-zyjl-riqi" role="tabpanel" aria-labelledby="nav-tab-zyjl-riqi">
                            <?php require(WEB_PAGE_PATH."add/zhuyuanjilu/riqi.php"); ?>
                            <?php require(WEB_PAGE_PATH."add/zhuyuanjilu/save_upload.php"); ?>
                        </div>
                        <div class="tab-pane form-step fade" id="tab-zyjl-shuqianxinxi" role="tabpanel" aria-labelledby="nav-tab-zyjl-shuqianxinxi">
                            <?php require(WEB_PAGE_PATH."add/zhuyuanjilu/shuqianxinxi.php"); ?>
                            <?php require(WEB_PAGE_PATH."add/zhuyuanjilu/save_upload.php"); ?>
                        </div>
                        <div class="tab-pane form-step fade" id="tab-zyjl-shoushuxinxi" role="tabpanel" aria-labelledby="nav-tab-zyjl-shoushuxinxi">
                            <?php require(WEB_PAGE_PATH."add/zhuyuanjilu/shoushuxinxi.php"); ?>
                            <?php require(WEB_PAGE_PATH."add/zhuyuanjilu/save_upload.php"); ?>
                        </div>
                        <div class="tab-pane form-step fade" id="tab-zyjl-shuhouxinxi" role="tabpanel" aria-labelledby="nav-tab-zyjl-shuhouxinxi">
                            <?php require(WEB_PAGE_PATH."add/zhuyuanjilu/shuhouxinxi.php"); ?>
                            <?php require(WEB_PAGE_PATH."add/zhuyuanjilu/save_upload.php"); ?>
                        </div>
                        <div class="tab-pane form-step fade" id="tab-zyjl-chuyuanziliao" role="tabpanel" aria-labelledby="nav-tab-zyjl-chuyuanziliao">
                            <?php require(WEB_PAGE_PATH."add/zhuyuanjilu/chuyuanziliao.php"); ?>
                            <?php require(WEB_PAGE_PATH."add/zhuyuanjilu/save_upload.php"); ?>
                        </div>
                    </div>
                </section>
        </div>
        <?php require(WEB_PAGE_PATH."footer.php"); ?>
        <?php require(WEB_PAGE_PATH."login_modal.php"); ?>
        <?php require(WEB_PAGE_PATH."js.php"); ?>
        
        <script type="text/javascript">
            initPage();
            $("#add-zhuyuanjilu").click(function(){
                $("#content-add").hide();
                $("#content-zyjl").show();
            })
        </script>
    </div>

</body>

</html>
