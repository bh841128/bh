<div class="form-horizontal" id="query_param_form">
    <table class="control-table padding-20">
        <tr>
            <td>
                <div class="control-label" style="width:100px">姓名：</div>
            </td>
            <td>
                <input type="text" class="form-control input-sm" style="width:120px" placeholder="" json-name="姓名" value="葡萄">
            </td>
            <td>
                <div class="control-label" style="width:80px;padding-left:5px;">病案号：</div>
            </td>
            <td>
                <input type="text" class="form-control input-sm" style="width:180px" placeholder="" json-name="病案号" value="182">
            </td>
            <td>
                <div class="control-label" style="width:60px;padding-left:5px;">性别：</div>
            </td>
            <td>
                <select class="form-control input-sm" style="width:148px" json-name="性别">
                    <option value="男">男</option>
                    <option value="女" selected>女</option>
                </select>
            </td>
            <td>
                <div class="control-label" style="width:70px;padding-left:5px;">联系人：</div>
            </td>
            <td>
                <input type="text" class="form-control input-sm" style="width:150px" placeholder="" json-name="联系人" value="联系人ee">
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td>
                <div class="control-label" style="width:100px;padding-left:5px;">联系电话：</div>
            </td>
            <td>
                <input type="text" class="form-control input-sm" style="width:120px" placeholder="" json-name="联系电话" value="136956">
            </td>
            <td>
                <div class="control-label" style="width:80px;padding-left:5px;">上传时间：</div>
            </td>
            <td>
                <div class="input-group date">
                    <input type="text" class="form-control input-sm" tag="datetimepicker" style="width:140px" json-name="上传时间-开始">
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
                    <input type="text" class="form-control input-sm" tag="datetimepicker" style="width:140px" json-name="上传时间-结束">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </td>
            <td>
                <div class="control-label" style="width:70px;padding-left:5px;">状态：</div>
            </td>
            <td>
                <select class="form-control input-sm" style="width:150px" json-name="状态">
                    <option value="未上传">未上传</option>
                    <option value="已上传" selected>已上传</option>
                </select>
            </td>
        </tr>
    </table>
</div>
<div class="form-horizontal">
    <div style="text-align:right;margin-top:10px;">
        <button type="button" class="btn btn-primary" tag="query" style="width:100px;border-radius:20px;">
            <span class="glyphicon glyphicon-search"></span>查询</button>
    </div>
</div>
<div class="box-body table-responsive" id="query-table-wrapper">
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
<nav aria-label="Page navigation" style="text-align:center" id="query-page-nav">
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
