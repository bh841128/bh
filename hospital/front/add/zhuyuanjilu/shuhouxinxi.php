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
                    <div class="control-label" style="width:154px">当天进出监护室内：</div>
                </td>
                <td>
                    <lable class="radio-inline">
                        <input type="radio" name="dangtianjinchujianhushinei" value="1" checked json-name="当天进出监护室内">是</lable>
                    <lable class="radio-inline">
                        <input type="radio" name="dangtianjinchujianhushinei" value="0" json-name="当天进出监护室内">否</lable>
                </td>
            </tr>
        </table>
        <div tag="dangtianjinchujianhushinei" style="padding-left:40px">
            <table class="control-table padding-20">
                <tr>
                    <td>
                        <div class="control-label" style="width:124px">出监护室日期：</div>
                    </td>
                    <td>
                        <div class="input-group date">
                            <input type="text" class="form-control input-sm" tag="datepicker" style="width:160px" json-name="出监护室日期">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </td>
                    <td>
                        <div class="control-label" style="width:180px">术后监护室停留时间：</div>
                    </td>
                    <td>
                        <input type="text" class="form-control input-sm" style="width:120px" placeholder="术后监护室停留时间" json-name="术后监护室停留时间">
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
                        <input type="text" class="form-control input-sm" style="width:120px" placeholder="累计有创辅助通气时间" json-name="累计有创辅助通气时间">
                    </td>
                    <td>
                        <span>（天）</span>
                    </td>
                </tr>
            </table>
        </div>
        <table class="control-table padding-20">
            <tr>
                <td>
                    <div class="control-label" style="width:238px">围手术期血液制品输入（累计）：</div>
                </td>
                <td>
                    <lable class="radio-inline">
                        <input type="radio" name="weishoushuqixueyezhipinshuru" value="1" checked json-name="围手术期血液制品输入（累计）">是</lable>
                    <lable class="radio-inline">
                        <input type="radio" name="weishoushuqixueyezhipinshuru" value="0" json-name="围手术期血液制品输入（累计）">否</lable>
                </td>
            </tr>
        </table>
        <div tag="weishoushuqixueyezhipinshuru">
            <table class="control-table padding-20">
                <tr>
                    <td>
                        <div class="control-label" style="width:124px">红细胞：</div>
                    </td>
                    <td>
                        <input type="text" class="form-control input-sm" style="width:100px" placeholder="红细胞" json-name="红细胞">
                    </td>
                    <td>
                        <span>（单位）</span>
                    </td>
                    <td>
                        <div class="control-label" style="width:124px">新鲜冰冻血浆：</div>
                    </td>
                    <td>
                        <input type="text" class="form-control input-sm" style="width:100px" placeholder="新鲜冰冻血浆" json-name="新鲜冰冻血浆">
                    </td>
                    <td>
                        <span>（毫升）</span>
                    </td>
                    <td>
                        <div class="control-label" style="width:124px">血浆冷沉淀：</div>
                    </td>
                    <td>
                        <input type="text" class="form-control input-sm" style="width:100px" placeholder="血浆冷沉淀" json-name="血浆冷沉淀">
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
                        <input type="text" class="form-control input-sm" style="width:100px" placeholder="血小板" json-name="血小板">
                    </td>
                    <td>
                        <span>（单位）</span>
                    </td>
                    <td>
                        <div class="control-label" style="width:124px">自体血：</div>
                    </td>
                    <td>
                        <input type="text" class="form-control input-sm" style="width:100px" placeholder="自体血" json-name="自体血">
                    </td>
                    <td>
                        <span>（毫升）</span>
                    </td>
                </tr>
            </table>
        </div>
        <table class="control-table padding-20">
            <tr>
                <td>
                    <div class="control-label" style="width:124px">术后并发症：</div>
                </td>
                <td>
                    <lable class="radio-inline">
                        <input type="radio" name="shuhoubingfazheng-r" value="1" checked json-name="是否术后并发症" checked>是</lable>
                    <lable class="radio-inline">
                        <input type="radio" name="shuhoubingfazheng-r" value="0" json-name="是否术后并发症">否</lable>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <textarea class="form-control input-sm" style="width:400px" rows="5" placeholder="术后并发症" json-name="术后并发症" tag="shuhoubingfazheng"></textarea>
                </td>
            </tr>
            <tr>
                <td>其他：</td>
                <td>
                    <textarea class="form-control input-sm" style="width:400px" rows="5" placeholder="术后并发症-其他" json-name="术后并发症-其他" tag="shuhoubingfazheng"></textarea>
                </td>
            </tr>
        </table>
    </div>
</div>