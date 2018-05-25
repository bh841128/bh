<section class="content container-fluid main-container" id="jibenziliao-section">
    <ul class="nav nav-tabs" role="tablist">
        <li class="active">
            <a class="nav-item nav-link" id="nav-tab-jibenziliao" data-toggle="tab" href="#tab-jibenziliao" role="tab" aria-selected="true">基本资料</a>
        </li>
        <li class="">
            <a class="nav-item nav-link" id="nav-tab-zhuyuanjilu" data-toggle="tab" href="#tab-zhuyuanjilu" role="tab" aria-selected="true">住院记录</a>
        </li>
    </ul>
    <div class="tab-content" style="padding-top:20px">
        <div class="tab-pane form-step fade active in" id="tab-jibenziliao" role="tabpanel" aria-labelledby="nav-tab-jibenziliao">
            <?php require(WEB_PAGE_PATH."add/jibenziliao.php"); ?>
        </div>
        <div class="tab-pane form-step fade" id="tab-zhuyuanjilu" role="tabpanel" aria-labelledby="nav-tab-zhuyuanjilu">
        <?php require(WEB_PAGE_PATH."add/zhuyuanjilu.php"); ?>
    </div>
</section>