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

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" id="content-upload">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1 class="gray-font">数据查询</h1>
            </section>
            <!-- Main content -->
            <section class="content container-fluid" style="min-height:650px">
                <div class="tab-content">
                    <div class="tab-pane form-step fade active in" id="tab-zhuyuanjilu" role="tabpanel" aria-labelledby="nav-tab-zhuyuanjilu">
                        <div class="form-horizontal">
                            <table class="control-table padding-20">
                                <tr>
                                    <td>
                                        <div class="control-label" style="width:80px">姓名：</div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control input-sm" style="width:100px" placeholder="">
                                    </td>
                                    <td>
                                        <div class="control-label" style="width:70px;padding-left:5px;">病案号：</div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control input-sm" style="width:100px" placeholder="">
                                    </td>
                                    <td>
                                        <div class="control-label" style="width:60px;padding-left:5px;">性别：</div>
                                    </td>
                                    <td>
                                        <select class="form-control input-sm" style="width:100px"></select>
                                    </td>
                                    <td>
                                        <div class="control-label" style="width:70px;padding-left:5px;">联系人：</div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control input-sm" style="width:270px" placeholder="">
                                    </td>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                    <td>
                                        <div class="control-label" style="width:100px;padding-left:5px;">联系电话：</div>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control input-sm" style="width:120px" placeholder="">
                                    </td>
                                    <td>
                                        <div class="control-label" style="width:80px;padding-left:5px;">上传时间：</div>
                                    </td>
                                    <td>
                                        <div class="input-group date">
                                            <input type="text" class="form-control input-sm" tag="datetimepicker" style="width:140px">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control-label" style="width:30px;padding-left:5px;padding-right:6px;">至</div>
                                    </td>
                                    <td>
                                        <div class="input-group date">
                                            <input type="text" class="form-control input-sm" tag="datetimepicker" style="width:140px">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="control-label" style="width:60px;padding-left:5px;">状态：</div>
                                    </td>
                                    <td>
                                        <select class="form-control input-sm" style="width:100px"></select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="form-horizontal">
                            <div style="text-align:right;margin-top:10px;">
                                <button type="button" class="btn btn-primary" style="width:100px;border-radius:20px;">
                                    <span class="glyphicon glyphicon-search"></span>查询</button>
                            </div>
                        </div>
                        <div class="box-body table-responsive">
                            <table id="example2" class="table table-bordered table-hover table-center" style="text-align:center">
                                <thead>
                                    <tr>
                                        <th>序号</th>
                                        <th>病案号</th>
                                        <th>姓名</th>
                                        <th>性别</th>
                                        <th>出生日期</th>
                                        <th>联系人</th>
                                        <th>联系电话</th>
                                        <th>医院</th>
                                        <th>上传时间</th>
                                        <th>状态</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>2018-05-10</td>
                                        <td>2018-05-10</td>
                                        <td>2018-05-10</td>
                                        <td>2018-05-10</td>
                                        <td>2018-05-10</td>
                                        <td>2018-05-10</td>
                                        <td>2018-05-10</td>
                                        <td>2018-05-10</td>
                                        <td>2018-05-10</td>
                                        <td style="width:80px">
                                            <button type="button" class="btn btn-link">删除</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <nav aria-label="Page navigation example" style="text-align:center">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#">共8条</a>
                                </li>
                                <li class="page-item">
                                    <div style="position:relative;float:left;margin-left:5px;">
                                        <div class="input-group">
                                            <input type="text" class="form-control" style="width:50px">
                                        </div>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">跳转</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" style="margin-left:5px">首页</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" style="margin-left:5px">&lt;</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" style="margin-left:5px">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" style="margin-left:5px">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" style="margin-left:5px">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" style="margin-left:5px">...</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" style="margin-left:5px">43</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" style="margin-left:5px">44</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" style="margin-left:5px">45</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" style="margin-left:5px">&gt;</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" style="margin-left:5px">尾页</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" style="margin-left:5px">共45页</a>
                                </li>
                            </ul>
                        </nav>
                        </div>
                    </div>
            </section>
            </div>
            <!-- /.content-wrapper -->
        </div>
        <?php require(WEB_PAGE_PATH."footer.php"); ?>
        <?php require(WEB_PAGE_PATH."login_modal.php"); ?>
        <?php require(WEB_PAGE_PATH."js.php"); ?>
        
        <script type="text/javascript">
            initPage();
        </script>
    </div>

</body>

</html>