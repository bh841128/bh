<section class="content-header">
    <div class="gray-font" style="font-size:18px;">
        <table>
            <tr>
                <td style="vertical-align:middle;">
                    <div class="circle"></div>
                </td>
                <td>患者基本资料</td>
            </tr>
        </table>
        </span>
    </div>
</section>
<div class="form-horizontal" id="huanzhe-jibenziliao">
    <div class="form-group">
        <table class="control-table">
            <tr>
                <td>
                    <div class="control-label control-label-100">病案号：</div>
                </td>
                <td>
                    <input type="text" class="form-control input-sm" placeholder="病案号" json-name="病案号" value="263">
                </td>
                <td>
                    <div class="control-label control-label-100">姓名：</div>
                </td>
                <td>
                    <input type="text" class="form-control input-sm" placeholder="姓名" json-name="姓名" value="1+1">
                </td>
                <td>
                    <div class="control-label control-label-100">性别：</div>
                </td>
                <td>
                    <lable class="radio-inline">
                        <input type="radio" name="xingbie" value="1" checked json-name="性别">男</lable>
                    <lable class="radio-inline">
                        <input type="radio" name="xingbie" value="2" json-name="性别">女</lable>
                </td>
            </tr>
        </table>
    </div>
    <div class="form-group">
        <table class="control-table">
            <tr>
                <td>
                    <div class="control-label control-label-100">民族：</div>
                </td>
                <td>
                    <select class="form-control input-sm" tag="minzu" json-name="民族"></select>
                </td>
                <td>
                    <div class="control-label control-label-100">出生日期：</div>
                </td>
                <td>
                    <div class="input-group date">
                        <input type="text" class="form-control input-sm" tag="datepicker" style="width:160px" json-name="出生日期">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>

                </td>
            </tr>
        </table>
    </div>
    <div class="form-group" tag="address">
        <table class="control-table">
            <tr>
                <td>
                    <div class="control-label control-label-100">详细地址：</div>
                </td>
                <td style="padding-left:5px">
                    <select class="form-control input-sm" style="width:250px" tag="address-shengfen" json-name="省份"></select>
                </td>
                <td style="padding-left:15px">
                    <select class="form-control input-sm" style="width:250px" tag="address-chengshi" json-name="城市"></select>
                </td>
                <td style="padding-left:15px">
                    <select class="form-control input-sm" style="width:250px" tag="address-quxian" json-name="区县"></select>
                </td>
            </tr>
        </table>
        <table class="control-table" style="margin-top:15px">
            <tr>
            <td>
                <div class="control-label control-label-100"></div>
            </td>
            <td style="padding-left:5px">
                <input type="text" class="form-control input-sm" style="width:475px" placeholder="详细地址" json-name="详细地址" value="地瓜山">
            </td>
            <td style="padding-left:35px">
                <div class="checkbox">
                    <lable>
                        <input type="checkbox" json-name="详细地址-不能提供">不能提供</lable>
                </div>
            </td>
            <td style="padding-left:15px">
                <input type="text" class="form-control input-sm" style="width:200px" placeholder="原因" disabled init_disabled="1" json-name="详细地址-不能提供-原因">
            </td>
            </tr>
        </table>
    </div>
</div>
<section class="content-header">
    <div class="gray-font" style="font-size:18px;">
        <table>
            <tr>
                <td style="vertical-align:middle;">
                    <div class="circle"></div>
                </td>
                <td>联系人基本资料</td>
            </tr>
        </table>
        </span>
    </div>
</section>
<div class="form-horizontal" id="lianxiren-jibenziliao">
    <div class="form-group">
        <table class="control-table">
            <tr>
                <td>
                    <div class="control-label control-label-180">姓名：</div>
                </td>
                <td>
                    <input type="text" class="form-control input-sm" placeholder="姓名" json-name="联系人姓名" value="">
                </td>
                <td>
                    <div class="control-label control-label-110">与患者关系：</div>
                </td>
                <td>
                    <lable class="radio-inline">
                        <input type="radio" name="yuhuanzheguanxi" value="父亲" checked json-name="与患者关系">父亲</lable>
                    <lable class="radio-inline">
                        <input type="radio" name="yuhuanzheguanxi" value="母亲" json-name="与患者关系">母亲</lable>
                    <lable class="radio-inline">
                        <input type="radio" name="yuhuanzheguanxi" value="其他" json-name="与患者关系">其他</lable>
                </td>
            </tr>
        </table>
    </div>
    <div class="form-group">
        <table class="control-table">
            <tr>
            <td>
                <div class="control-label control-label-180">
                    <span class="">&nbsp;</span>联系电话：</div>
            </td>
            <td>
                <input type="text" class="form-control input-sm" placeholder="联系人电话" json-name="联系人电话" value="96325">
            </td>
            <td style="padding-left:35px">
                <div class="checkbox">
                    <lable>
                        <input type="checkbox" value="1" json-name="联系人电话-不能提供">不能提供</lable>
                </div>
            </td>
            <td style="padding-left:15px">
                <input type="text" class="form-control input-sm" init_disabled="1" disabled style="width:200px" placeholder="原因" disabled json-name="联系人电话-不能提供-原因">
            </td>
            </tr>
        </table>
        <table class="control-table">
            <tr>
                <td>
                    <div class="control-label control-label-180">联系人电话(号码二)：</div>
                </td>
                <td>
                    <input type="text" class="form-control input-sm" placeholder="联系人电话" json-name="联系人电话(号码二)" value="">
                </td>
                <td style="padding-left:35px">
                    <div class="checkbox">
                        <lable>
                            <input type="checkbox" value="1" json-name="联系人电话(号码二)-不能提供">不能提供</lable>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="control-label control-label-180">联系人电话(号码三)：</div>
                </td>
                <td>
                    <input type="text" class="form-control input-sm" placeholder="联系人电话" json-name="联系人电话(号码三)" value="">
                </td>
                <td style="padding-left:35px">
                    <div class="checkbox">
                        <lable>
                            <input type="checkbox" value="1" json-name="联系人电话(号码三)-不能提供">不能提供</lable>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="form-horizontal" style="margin-top:40px">
    <div class="form-group errormsg active" style="width:700px;margin-left:20px;margin-bottom:20px;"><div class="msg-wrap"><div class="msg-error"><b></b></div></div></div>
    <div style="text-align:left;margin-top:0px;">
        <button type="button" class="btn btn-primary" style="width:200px;margin-left:120px" tag="jibenziliao-baocun">保存信息</button>
    </div>
</div>