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
                <h1 class="gray-font">上传资料</h1>
            </section>
            <!-- Main content -->
            <section class="content container-fluid" style="min-height:650px">
                <div class="tab-content">
                    <div class="tab-pane form-step fade active in" id="tab-zhuyuanjilu" role="tabpanel" aria-labelledby="nav-tab-zhuyuanjilu">
                            <div class="form-horizontal">
                                <div style="text-align:left;margin-top:10px;">
                                    <button type="button" class="btn btn-danger btn_upload">未上传(120)</button>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <button type="button" class="btn btn-primary btn_notupload">已上传(12000)</button>
                                </div>
                            </div>
                        <div class="form-horizontal">
                            <div style="text-align:right;margin-top:10px;">
                                <a type="button" class="btn" style="width:130px;border-radius:0px;font-size:16px"><span class="glyphicon glyphicon-arrow-up"></span>上传资料</a>
                                <a type="button" class="btn" style="width:130px;border-radius:0px;font-size:16px"><span class="glyphicon glyphicon-plus"></span>新增住院记录</a>
                            </div>
                        </div>
                        <div class="box-body table-responsive">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>序号</th>
                                        <th>入院日期</th>
                                        <th>出院日期</th>
                                        <th>手术日期</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>2018-05-10</td>
                                        <td>2018-05-10</td>
                                        <td>2018-05-10</td>
                                        <td style="width:150px">
                                            <button type="button" class="btn btn-link">详情</button>&nbsp;&nbsp;&nbsp;
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