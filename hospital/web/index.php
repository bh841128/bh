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
                        <li class="">
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
                        <li class="active">
                            <a class="nav-item nav-link" id="nav-tab-zyjl-chuyuanziliao" data-toggle="tab" href="#tab-zyjl-chuyuanziliao" role="tab"
                                aria-selected="true">出院资料</a>
                        </li>
                    </ul>
                    <div class="tab-content" style="margin-top:20px">
                        <div class="tab-pane form-step fade" id="tab-zyjl-riqi" role="tabpanel" aria-labelledby="nav-tab-zyjl-riqi">
                            <?php require(WEB_PAGE_PATH."add/zhuyuanjilu/riqi.php"); ?>
                            <?php require(WEB_PAGE_PATH."add/zhuyuanjilu/save_upload.php"); ?>
                        </div>
                        <div class="tab-pane form-step fade" id="tab-zyjl-shuqianxinxi" role="tabpanel" aria-labelledby="nav-tab-zyjl-shuqianxinxi">
                            <?php require(WEB_PAGE_PATH."add/zhuyuanjilu/shuqianxinxi.php"); ?>
                            <?php require(WEB_PAGE_PATH."add/zhuyuanjilu/save_upload.php"); ?>
                        </div>
                        <div class="tab-pane form-step fade" id="tab-zyjl-shoushuxinxi" role="tabpanel" aria-labelledby="nav-tab-zyjl-shoushuxinxi">
                            <section class="content-header">
                                <div class="gray-font" style="font-size:18px;">
                                    <table>
                                        <tr>
                                            <td style="vertical-align:middle;">
                                                <div class="circle"></div>
                                            </td>
                                            <td>手术信息</td>
                                        </tr>
                                    </table>
                                    </span>
                                </div>
                            </section>
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <table class="control-table  padding-20">
                                        <tr>
                                            <td>
                                                <div class="control-label control-label-120" style="width:120px">手术诊断：</div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input-sm" style="width:400px" placeholder="">
                                            </td>
                                            <td style="padding-left:35px">
                                                <div class="checkbox">
                                                    <lable>
                                                        <input type="checkbox" tag="address-nodetail-checkbox">与术前诊断一致</lable>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="control-table  padding-20">
                                        <tr>
                                            <td>
                                                <div class="control-label control-label-120">其他：</div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" class="form-control input-sm" style="width:400px">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="control-label control-label-120">其他手术名称：</div>
                                            </td>

                                            <td>
                                                <div class="input-group">
                                                    <input type="text" class="form-control input-sm" style="width:400px">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="control-label control-label-120">其他：</div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" class="form-control input-sm" style="width:400px">
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="control-table padding-20">
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:124px">手术医生：</div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input-sm" style="width:100px" placeholder="">
                                            </td>
                                            <td>
                                                <div class="control-label control-label-120">手术用时：</div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input-sm" style="width:100px" placeholder="">
                                            </td>
                                            <td>
                                                <span>（分钟）</span>
                                            </td>
                                            <td>
                                                <div class="control-label control-label-120">手术年龄：</div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input-sm" style="width:100px" placeholder="">
                                            </td>
                                            <td>
                                                <span>（岁/月）</span>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="control-table padding-20">
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:124px">手术状态：</div>
                                            </td>
                                            <td>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="shoushuzhuangtai" value="1" checked>择期手术</lable>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="shoushuzhuangtai" value="2">急诊手术</lable>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="shoushuzhuangtai" value="3" checked>限期手术</lable>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="shoushuzhuangtai" value="4">抢救</lable>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:124px">手术方式：</div>
                                            </td>
                                            <td>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="shoushufangshi" value="1" checked>经外途径介入</lable>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="shoushufangshi" value="2">直视</lable>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="shoushufangshi" value="3" checked>杂交（镶嵌）</lable>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="control-table  padding-20">
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:124px">手术路径：</div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <select class="form-control input-sm" style="width:300px"></select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="control-label control-label-120">其他：</div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" class="form-control input-sm" style="width:300px">
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="control-table padding-20">
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:124px">延迟关胸：</div>
                                            </td>
                                            <td>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="yanchiguanxiong" value="1" checked>是</lable>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="yanchiguanxiong" value="2">否</lable>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:124px">延迟关胸天数：</div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input-sm" style="width:100px" placeholder="">
                                            </td>
                                            <td>
                                                <span>（天）</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                            </div>
                            <section class="content-header" style="padding-top:0px">
                                <div class="gray-font" style="font-size:18px;">
                                    <table>
                                        <tr>
                                            <td style="vertical-align:middle;">
                                                <div class="circle"></div>
                                            </td>
                                            <td>体外循环情况</td>
                                        </tr>
                                    </table>
                                    </span>
                                </div>
                            </section>
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <table class="control-table padding-20">
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:124px">体外循环：</div>
                                            </td>
                                            <td>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="tiwaixunhuan" value="1" checked>是</lable>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="tiwaixunhuan" value="2">否</lable>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:124px">是否计划：</div>
                                            </td>
                                            <td>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="shifoujihua" value="1" checked>是-术前计划</lable>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="shifoujihua" value="2">否-术中由非体外转为体外</lable>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:124px">停搏液：</div>
                                            </td>
                                            <td>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="tingboye" value="1" checked>是</lable>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="tingboye" value="2">否</lable>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:124px">停搏液类型：</div>
                                            </td>
                                            <td>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="tingboyeleixing" value="1" checked>含血</lable>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="tingboyeleixing" value="2">晶体</lable>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:124px">停搏液温度：</div>
                                            </td>
                                            <td>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="tingboyewendu" value="1" checked>温</lable>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="tingboyewendu" value="2">冷</lable>
                                            </td>
                                        </tr>

                                    </table>
                                    <table class="control-table padding-20">
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:124px">体外循环时间：</div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input-sm" style="width:100px" placeholder="">
                                            </td>
                                            <td>
                                                <span>（分钟）</span>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="control-table padding-20">
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:150px">主动脉阻断时间：</div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input-sm" style="width:100px" placeholder="">
                                            </td>
                                            <td>
                                                <span>（分钟）</span>
                                            </td>
                                            <td style="padding-left:35px">
                                                <div class="checkbox">
                                                    <lable>
                                                        <input type="checkbox" tag="address-nodetail-checkbox">不能提供</lable>
                                                </div>
                                            </td>
                                            <td style="padding-left:15px">
                                                <input type="text" class="form-control input-sm" style="width:400px" placeholder="输入原因" tag="address-nodetail-yuanyi" disabled>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="control-table padding-20">
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:200px">是否二次或多次体外循环：</div>
                                            </td>
                                            <td>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="ercihuoduocitiwaixunhuan" value="1" checked>是</lable>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="ercihuoduocitiwaixunhuan" value="2">否</lable>
                                            </td>
                                            <td>
                                                <div class="control-label" style="width:80px">原因：</div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <select class="form-control input-sm" style="width:300px"></select>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="control-table padding-20">
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:124px">深低温停循环：</div>
                                            </td>
                                            <td>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="shendiwentingxunhuan" value="1" checked>是</lable>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="shendiwentingxunhuan" value="2">否</lable>
                                            </td>
                                            <td>
                                                <div class="control-label" style="width:160px">深低温停循环时间：</div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input-sm" style="width:100px" placeholder="">
                                            </td>
                                            <td>
                                                <span>（分钟）</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:124px">单侧脑灌注：</div>
                                            </td>
                                            <td>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="dancenaoguanzhu" value="1" checked>是</lable>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="dancenaoguanzhu" value="2">否</lable>
                                            </td>
                                            <td>
                                                <div class="control-label" style="width:160px">单侧脑灌注时间：</div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input-sm" style="width:100px" placeholder="">
                                            </td>
                                            <td>
                                                <span>（分钟）</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="form-horizontal">
                                    <div style="text-align:left;margin-left:100px;margin-top:30px;">
                                        <button type="button" class="btn btn-primary" style="width:100px">保存</button>&nbsp;&nbsp;
                                        <button type="button" class="btn btn-primary" style="width:100px">上传</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane form-step fade" id="tab-zyjl-shuhouxinxi" role="tabpanel" aria-labelledby="nav-tab-zyjl-shuhouxinxi">
                            <section class="content-header">
                                <div class="gray-font" style="font-size:18px;">
                                    <table>
                                        <tr>
                                            <td style="vertical-align:middle;">
                                                <div class="circle"></div>
                                            </td>
                                            <td>术后信息</td>
                                        </tr>
                                    </table>
                                </div>
                            </section>
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <table class="control-table padding-20">
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:124px">术后住院时间：</div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input-sm" style="width:100px" placeholder="">
                                            </td>
                                            <td>
                                                <span>（天）</span>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="control-table padding-20">
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:154px">当天进出监护室内：</div>
                                            </td>
                                            <td>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="dangtianjinchujianhushinei" value="1" checked>是</lable>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="dangtianjinchujianhushinei" value="2">否</lable>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="control-table padding-20">
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:124px">出监护室日期：</div>
                                            </td>
                                            <td>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control input-sm" tag="datepicker" style="width:160px">
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="control-label" style="width:180px">术后监护室停留时间：</div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input-sm" style="width:100px" placeholder="">
                                            </td>
                                            <td>
                                                <span>（天）</span>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="control-table padding-20">
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:180px">累计有创辅助通气时间：</div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input-sm" style="width:100px" placeholder="">
                                            </td>
                                            <td>
                                                <span>（天）</span>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="control-table padding-20">
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:238px">围手术期血液制品输入（累计）：</div>
                                            </td>
                                            <td>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="weishoushuqixueyezhipinshuru" value="1" checked>是</lable>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="weishoushuqixueyezhipinshuru" value="2">否</lable>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="control-table padding-20">
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:124px">红细胞：</div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input-sm" style="width:100px" placeholder="">
                                            </td>
                                            <td>
                                                <span>（单位）</span>
                                            </td>
                                            <td>
                                                <div class="control-label" style="width:124px">新鲜冰冻血浆：</div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input-sm" style="width:100px" placeholder="">
                                            </td>
                                            <td>
                                                <span>（毫升）</span>
                                            </td>
                                            <td>
                                                <div class="control-label" style="width:124px">血浆冷沉淀：</div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input-sm" style="width:100px" placeholder="">
                                            </td>
                                            <td>
                                                <span>（单位）</span>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="control-table padding-20">
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:124px">血小板：</div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input-sm" style="width:100px" placeholder="">
                                            </td>
                                            <td>
                                                <span>（单位）</span>
                                            </td>
                                            <td>
                                                <div class="control-label" style="width:124px">自体血：</div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input-sm" style="width:100px" placeholder="">
                                            </td>
                                            <td>
                                                <span>（毫升）</span>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="control-table padding-20">
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:124px">术后并发症：</div>
                                            </td>
                                            <td>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="shuhoubingfazheng" value="1" checked>是</lable>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="shuhoubingfazheng" value="2">否</lable>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="control-table padding-20">
                                        <tr>
                                            <td>
                                                <div class="input-group" style="margin-left:80px">
                                                    <select class="form-control input-sm" style="width:500px"></select>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="input-group" style="margin-left:80px">
                                                    <textarea class="form-control" style="width:500px" rows="5"></textarea>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="control-table padding-20">
                                        <tr>
                                            <td style="vertical-align:top">
                                                <div class="control-label" style="width:80px">其他：</div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <textarea class="form-control" style="width:500px" rows="5"></textarea>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="form-horizontal">
                                    <div style="text-align:left;margin-left:100px;margin-top:30px;">
                                        <button type="button" class="btn btn-primary" style="width:100px">保存</button>&nbsp;&nbsp;
                                        <button type="button" class="btn btn-primary" style="width:100px">上传</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane form-step fade active in" id="tab-zyjl-chuyuanziliao" role="tabpanel" aria-labelledby="nav-tab-zyjl-chuyuanziliao">
                            <section class="content-header">
                                <div class="gray-font" style="font-size:18px;">
                                    <table>
                                        <tr>
                                            <td style="vertical-align:middle;">
                                                <div class="circle"></div>
                                            </td>
                                            <td>出院资料</td>
                                        </tr>
                                    </table>
                                </div>
                            </section>
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <table class="control-table padding-20">
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:124px">出院状态：</div>
                                            </td>
                                            <td>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="chuyuanzhuangtai" value="1" checked>存活</lable>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="chuyuanzhuangtai" value="2">死亡</lable>
                                                <lable class="radio-inline">
                                                    <input type="radio" name="chuyuanzhuangtai" value="3">自动出院</lable>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="control-table padding-20">
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:124px">死亡日期：</div>
                                            </td>
                                            <td>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control input-sm" tag="datepicker" style="width:160px">
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="control-table padding-20">
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:124px">死亡原因：</div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <select class="form-control input-sm" style="width:300px"></select>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="control-table padding-20">
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:124px">术后住院时间：</div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input-sm" style="width:100px" placeholder="">
                                            </td>
                                            <td>
                                                <span>（天）</span>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="control-table padding-20">
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:124px">自动出院日期：</div>
                                            </td>
                                            <td>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control input-sm" tag="datepicker" style="width:160px">
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="control-table padding-20">
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:124px">自动出院原因：</div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <select class="form-control input-sm" style="width:300px"></select>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="control-table padding-20">
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:124px">治疗费用：</div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input-sm" style="width:100px" placeholder="">
                                            </td>
                                            <td>
                                                <span>（元）</span>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="control-table padding-20">
                                        <tr>
                                            <td>
                                                <div class="control-label" style="width:124px">备注：</div>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control input-sm" style="width:400px" placeholder="">
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                                <div class="form-horizontal">
                                    <div style="text-align:left;margin-left:100px;margin-top:30px;">
                                        <button type="button" class="btn btn-primary" style="width:100px">保存</button>&nbsp;&nbsp;
                                        <button type="button" class="btn btn-primary" style="width:100px">上传</button>
                                    </div>
                                </div>
                            </div>
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
