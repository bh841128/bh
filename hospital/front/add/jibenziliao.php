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
<div class="form-horizontal">
    <div class="form-group">
        <table class="control-table">
            <tr>
                <td>
                    <div class="control-label control-label-100">病案号：</div>
                </td>
                <td>
                    <input type="text" class="form-control input-sm" placeholder="病案号">
                </td>
                <td>
                    <div class="control-label control-label-100">姓名：</div>
                </td>
                <td>
                    <input type="text" class="form-control input-sm" placeholder="姓名">
                </td>
                <td>
                    <div class="control-label control-label-100">性别：</div>
                </td>
                <td>
                    <lable class="radio-inline">
                        <input type="radio" name="xingbie" value="1" checked>男</lable>
                    <lable class="radio-inline">
                        <input type="radio" name="xingbie" value="2">女</lable>
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
                    <select class="form-control input-sm" tag="minzu"></select>
                </td>
                <td>
                    <div class="control-label control-label-100">出生日期：</div>
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
    </div>
    <div class="form-group" tag="address">
        <table class="control-table">
            <tr>
                <td>
                    <div class="control-label control-label-100">详细地址：</div>
                </td>
                <td style="padding-left:5px">
                    <select class="form-control input-sm" style="width:250px" tag="address-shengfen"></select>
                </td>
                <td style="padding-left:15px">
                    <select class="form-control input-sm" style="width:250px" tag="address-chengshi"></select>
                </td>
                <td style="padding-left:15px">
                    <select class="form-control input-sm" style="width:250px" tag="address-quxian"></select>
                </td>
            </tr>
        </table>
        <table class="control-table" style="margin-top:15px">
            <tr></tr>
            <td>
                <div class="control-label control-label-100"></div>
            </td>
            <td style="padding-left:5px">
                <input type="text" class="form-control input-sm" style="width:475px" placeholder="详细地址" tag="address-xiangxidizhi">
            </td>
            <td style="padding-left:35px">
                <div class="checkbox">
                    <lable>
                        <input type="checkbox" tag="address-nodetail-checkbox">不能提供</lable>
                </div>
            </td>
            <td style="padding-left:15px">
                <input type="text" class="form-control input-sm" style="width:200px" placeholder="原因" tag="address-nodetail-yuanyi" disabled>
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
<div class="form-horizontal">
    <div class="form-group">
        <table class="control-table">
            <tr>
                <td>
                    <div class="control-label control-label-180">姓名：</div>
                </td>
                <td>
                    <input type="text" class="form-control input-sm" placeholder="姓名">
                </td>
                <td>
                    <div class="control-label control-label-110">与患者关系：</div>
                </td>
                <td>
                    <lable class="radio-inline">
                        <input type="radio" name="yuhuanzheguanxi" value="1" checked>父亲</lable>
                    <lable class="radio-inline">
                        <input type="radio" name="yuhuanzheguanxi" value="2">母亲</lable>
                    <lable class="radio-inline">
                        <input type="radio" name="yuhuanzheguanxi" value="3">其他</lable>
                </td>
            </tr>
        </table>
    </div>
    <div class="form-group">
        <table class="control-table">
            <tr></tr>
            <td>
                <div class="control-label control-label-180">
                    <span class="red_star">*&nbsp;</span>联系电话：</div>
            </td>
            <td>
                <input type="text" class="form-control input-sm" placeholder="联系人电话">
            </td>
            <td style="padding-left:35px">
                <div class="checkbox">
                    <lable>
                        <input type="checkbox">不能提供</lable>
                </div>
            </td>
            <td style="padding-left:15px">
                <input type="text" class="form-control input-sm" style="width:200px" placeholder="原因" tag="address-nodetail-yuanyi" disabled>
            </td>
            </tr>
        </table>
        <table class="control-table">
            <tr></tr>
            <td>
                <div class="control-label control-label-180">
                    <span class="red_star">*&nbsp;</span>联系人电话(号码二)：</div>
            </td>
            <td>
                <input type="text" class="form-control input-sm" placeholder="联系人电话">
            </td>
            <td style="padding-left:35px">
                <div class="checkbox">
                    <lable>
                        <input type="checkbox">不能提供</lable>
                </div>
            </td>
            </tr>
        </table>
    </div>
</div>
<div class="form-horizontal">
    <div style="text-align:left;margin-top:30px;">
        <button type="button" class="btn btn-primary" style="width:200px;margin-left:300px">保存信息</button>
    </div>
</div>