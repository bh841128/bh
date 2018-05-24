<div class="form-horizontal" id="export_query_param_form">
    <table class="control-table padding-20">
        <tr>
            <td>
                <div class="control-label" style="width:80px">姓名：</div>
            </td>
            <td>
                <input type="text" class="form-control input-sm" style="width:100px" placeholder="" json-name="患者姓名">
            </td>
            <td>
                <div class="control-label" style="width:70px;padding-left:5px;">病案号：</div>
            </td>
            <td>
                <input type="text" class="form-control input-sm" style="width:100px" placeholder="" json-name="病案号" json_type="string">
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
                    <input type="text" class="form-control input-sm" tag="datetimepicker" style="width:140px" json-name="上传时间-开始">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </td>
        </tr>
    </table>
</div>
<div class="form-horizontal">
    <div style="text-align:right;margin-top:10px;">
            <a class="btn btn-primary" style="width:100px;border-radius:20px;" href="#" target="_blank" tag="export">
                    <span class="glyphicon glyphicon-export"></span>&nbsp;导出</button>&nbsp;&nbsp;&nbsp;&nbsp;</a>
        <button type="button" class="btn btn-primary" style="width:100px;border-radius:20px;" tag="query">
            <span class="glyphicon glyphicon-search"></span>&nbsp;查询</button>
    </div>
</div>
<div class="box-body table-responsive" id="export-query-patient-table-wrapper">
    <table class="table table-bordered table-hover table-center" style="text-align:center">
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
        </tbody>
    </table>
</div>
<nav aria-label="Page navigation example" style="text-align:center"  id="export-query-patient-page-nav"></nav>