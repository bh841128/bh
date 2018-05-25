<section class="content container-fluid main-container" id="zhuyuanjilu-section">
    <ul class="nav nav-tabs" role="tablist">
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
        <div class="tab-pane form-step fade active in" id="tab-zyjl-riqi" role="tabpanel" aria-labelledby="nav-tab-zyjl-riqi" style="padding-top:20px">
            <?php require(WEB_PAGE_PATH."add/zhuyuanjilu/riqi.php"); ?>
            <?php require(WEB_PAGE_PATH."add/zhuyuanjilu/save_upload.php"); ?>
        </div>
        <div class="tab-pane form-step fade" id="tab-zyjl-shuqianxinxi" role="tabpanel" aria-labelledby="nav-tab-zyjl-shuqianxinxi">
            <div class="form-group errormsg active"><div class="msg-wrap"><div class="msg-error"><b></b></div></div></div>
            <?php require(WEB_PAGE_PATH."add/zhuyuanjilu/shuqianxinxi.php"); ?>
            <?php require(WEB_PAGE_PATH."add/zhuyuanjilu/save_upload.php"); ?>
        </div>
        <div class="tab-pane form-step fade" id="tab-zyjl-shoushuxinxi" role="tabpanel" aria-labelledby="nav-tab-zyjl-shoushuxinxi">
            <div class="form-group errormsg active"><div class="msg-wrap"><div class="msg-error"><b></b></div></div></div>
            <?php require(WEB_PAGE_PATH."add/zhuyuanjilu/shoushuxinxi.php"); ?>
            <?php require(WEB_PAGE_PATH."add/zhuyuanjilu/save_upload.php"); ?>
        </div>
        <div class="tab-pane form-step fade" id="tab-zyjl-shuhouxinxi" role="tabpanel" aria-labelledby="nav-tab-zyjl-shuhouxinxi" style="padding-top:20px">
            <?php require(WEB_PAGE_PATH."add/zhuyuanjilu/shuhouxinxi.php"); ?>
            <?php require(WEB_PAGE_PATH."add/zhuyuanjilu/save_upload.php"); ?>
        </div>
        <div class="tab-pane form-step fade" id="tab-zyjl-chuyuanziliao" role="tabpanel" aria-labelledby="nav-tab-zyjl-chuyuanziliao" style="padding-top:20px">
            <?php require(WEB_PAGE_PATH."add/zhuyuanjilu/chuyuanziliao.php"); ?>
            <?php require(WEB_PAGE_PATH."add/zhuyuanjilu/save_upload.php"); ?>
        </div>
    </div>
</section>