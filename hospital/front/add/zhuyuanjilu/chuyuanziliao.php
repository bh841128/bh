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
                        <input type="radio" name="chuyuanzhuangtai" value="1" checked json-name="出院状态">存活</lable>
                    <lable class="radio-inline">
                        <input type="radio" name="chuyuanzhuangtai" value="2" json-name="出院状态">死亡</lable>
                    <lable class="radio-inline">
                        <input type="radio" name="chuyuanzhuangtai" value="3" json-name="出院状态">自动出院</lable>
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
                        <input type="text" class="form-control input-sm" tag="datepicker" style="width:160px" json-name="死亡日期">
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
                        <select class="form-control input-sm" style="width:300px" json-name="死亡原因"></select>
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
                    <input type="text" class="form-control input-sm" style="width:100px" placeholder="术后住院时间" json-name="术后住院时间">
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
                        <input type="text" class="form-control input-sm" tag="datepicker" style="width:160px" json-name="自动出院日期">
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
                        <select class="form-control input-sm" style="width:300px" json-name="自动出院原因"></select>
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
                    <input type="text" class="form-control input-sm" style="width:100px" placeholder="治疗费用" json-name="治疗费用">
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
                    <input type="text" class="form-control input-sm" style="width:400px" placeholder="备注" json-name="备注">
                </td>
            </tr>
        </table>

    </div>
</div>