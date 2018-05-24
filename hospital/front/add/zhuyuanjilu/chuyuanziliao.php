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
                    <div class="control-label" style="width:124px">出院时状态：</div>
                </td>
                <td>
                    <lable class="radio-inline">
                        <input type="radio" name="chuyuanzhuangtai" value="0" checked json-name="出院时状态">存活</lable>
                    <lable class="radio-inline">
                        <input type="radio" name="chuyuanzhuangtai" value="1" json-name="出院时状态">死亡</lable>
                    <lable class="radio-inline">
                        <input type="radio" name="chuyuanzhuangtai" value="2" json-name="出院时状态">自动出院</lable>
                </td>
            </tr>
        </table>
        <table class="control-table padding-20" tag="死亡日期" style="display:none">
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
        <table class="control-table padding-20" tag="死亡主要原因" style="display:none">
            <tr>
                <td>
                    <div class="control-label" style="width:124px">死亡主要原因：</div>
                </td>
                <td>
                    <div class="input-group">
                        <select class="form-control input-sm" style="width:300px" json-name="死亡主要原因">
                            <option value="心脏原因">心脏原因</option>
                            <option value="神经系统原因">神经系统原因</option>
                            <option value="肾脏原因">肾脏原因</option>
                            <option value="血管原因">血管原因</option>
                            <option value="感染原因">感染原因</option>
                            <option value="肺部原因">肺部原因</option>
                            <option value="其他原因">其他原因</option>
                        </select>
                    </div>
                </td>
            </tr>
        </table>
        <table class="control-table padding-20" tag="自动出院日期" style="display:none">
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
        <table class="control-table padding-20" tag="自动出院主要原因" style="display:none">
            <tr>
                <td>
                    <div class="control-label" style="width:124px">自动出院原因：</div>
                </td>
                <td>
                    <div class="input-group">
                        <select class="form-control input-sm" style="width:300px" json-name="自动出院主要原因">
                            <option value="心脏原因">心脏原因</option>
                            <option value="神经系统原因">神经系统原因</option>
                            <option value="肾脏原因">肾脏原因</option>
                            <option value="血管原因">血管原因</option>
                            <option value="感染原因">感染原因</option>
                            <option value="肺部原因">肺部原因</option>
                            <option value="经济原因">经济原因</option>
                            <option value="其他原因">其他原因</option>
                        </select>
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
    </div>
</div>