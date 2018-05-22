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
                    <textarea class="form-control input-sm" style="width:400px" rows="5" placeholder="手术诊断" json-name="手术诊断" tag="shoushuzhenduan"></textarea>
                </td>
                <td style="padding-left:35px">
                    <div class="checkbox">
                        <lable>
                            <input type="checkbox" tag="address-nodetail-checkbox" json-name="与术前诊断一致">与术前诊断一致</lable>
                    </div>
                </td>
            </tr>
        </table>
        <table class="control-table  padding-20">
            <tr>
                <td>
                    <div class="control-label control-label-120">主要手术名称：</div>
                </td>

                <td>
                    <div class="input-group">
                        <textarea class="form-control input-sm" style="width:400px" rows="5" placeholder="主要手术名称" json-name="主要手术名称" tag="zhuyaoshoushumingcheng"></textarea>
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
                    <input type="text" class="form-control input-sm" style="width:100px"  placeholder="手术医生" json-name="手术医生">
                </td>
                <td>
                    <div class="control-label control-label-120">手术用时：</div>
                </td>
                <td>
                    <input type="text" class="form-control input-sm" style="width:100px"  placeholder="手术用时" json-name="手术用时">
                </td>
                <td>
                    <span>（分钟）</span>
                </td>
                <td>
                    <div class="control-label control-label-120">手术年龄：</div>
                </td>
                <td>
                    <input type="text" class="form-control input-sm" style="width:100px"  placeholder="手术年龄" json-name="手术年龄">
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
                        <input type="radio" name="shoushuzhuangtai" value="1" checked json-name="手术状态">择期手术</lable>
                    <lable class="radio-inline">
                        <input type="radio" name="shoushuzhuangtai" value="2" json-name="手术状态">急诊手术</lable>
                    <lable class="radio-inline">
                        <input type="radio" name="shoushuzhuangtai" value="3" json-name="手术状态">限期手术</lable>
                    <lable class="radio-inline">
                        <input type="radio" name="shoushuzhuangtai" value="4" json-name="手术状态">抢救</lable>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="control-label" style="width:124px">手术方式：</div>
                </td>
                <td>
                    <lable class="radio-inline">
                        <input type="radio" name="shoushufangshi" value="1" checked json-name="手术方式">经外途径介入</lable>
                    <lable class="radio-inline">
                        <input type="radio" name="shoushufangshi" value="2" json-name="手术方式">直视</lable>
                    <lable class="radio-inline">
                        <input type="radio" name="shoushufangshi" value="3" json-name="手术方式">杂交（镶嵌）</lable>
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
                        <select class="form-control input-sm" style="width:300px" json-name="手术路径">
                            <option value=""></option>
                            <option value="全胸骨正中切口">全胸骨正中切口</option>
                            <option value="部分胸骨切口">部分胸骨切口</option>
                            <option value="胸骨旁切口">胸骨旁切口</option>
                            <option value="左胸切口">左胸切口</option>
                            <option value="右胸切口">右胸切口</option>
                            <option value="腔镜辅助小切口">腔镜辅助小切口</option>
                            <option value="全腔镜切口">全腔镜切口</option>
                            <option value="机器人辅助">机器人辅助</option>
                        </select>
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
                        <input type="radio" name="yanchiguanxiong" value="1" checked json-name="延迟关胸">是</lable>
                    <lable class="radio-inline">
                        <input type="radio" name="yanchiguanxiong" value="0" json-name="延迟关胸">否</lable>
                </td>
            </tr>
        </table>
        <table class="control-table padding-20" tag="yanchiguanxiong">
            <tr>
                <td>
                    <div class="control-label" style="width:124px">延迟关胸时间：</div>
                </td>
                <td>
                    <input type="text" class="form-control input-sm" style="width:100px" placeholder="延迟关胸时间" json-name="延迟关胸时间">
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
                        <input type="radio" name="tiwaixunhuan" value="1" checked json-name="体外循环">是</lable>
                    <lable class="radio-inline">
                        <input type="radio" name="tiwaixunhuan" value="0" json-name="体外循环">否</lable>
                </td>
            </tr>
        </table>
        <table class="control-table padding-20" tag="tiwaixunhuan">
            <tr>
                <td>
                    <div class="control-label" style="width:124px">是否计划：</div>
                </td>
                <td>
                    <lable class="radio-inline">
                        <input type="radio" name="shifoujihua" value="1" checked json-name="是否计划">是-术前计划</lable>
                    <lable class="radio-inline">
                        <input type="radio" name="shifoujihua" value="0" json-name="是否计划">否-术中由非体外转为体外</lable>
                </td>
            </tr>
        </table>
        <table class="control-table padding-20">
            <tr>
                <td>
                    <div class="control-label" style="width:124px">停搏液：</div>
                </td>
                <td>
                    <lable class="radio-inline">
                        <input type="radio" name="tingboye" value="1" checked json-name="停搏液">是</lable>
                    <lable class="radio-inline">
                        <input type="radio" name="tingboye" value="0" json-name="停搏液">否</lable>
                </td>
            </tr>
        </table>
        <table class="control-table padding-20">
            <tr>
                <td>
                    <div class="control-label" style="width:124px">停搏液类型：</div>
                </td>
                <td>
                    <lable class="radio-inline">
                        <input type="radio" name="tingboyeleixing" value="1" checked json-name="停搏液类型">含血</lable>
                    <lable class="radio-inline">
                        <input type="radio" name="tingboyeleixing" value="0" json-name="停搏液类型">晶体</lable>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="control-label" style="width:124px">停搏液温度：</div>
                </td>
                <td>
                    <lable class="radio-inline">
                        <input type="radio" name="tingboyewendu" value="1" checked json-name="停搏液温度">温</lable>
                    <lable class="radio-inline">
                        <input type="radio" name="tingboyewendu" value="0" json-name="停搏液温度">冷</lable>
                </td>
            </tr>
        </table>
        <table class="control-table padding-20">
            <tr>
                <td>
                    <div class="control-label" style="width:124px">体外循环时间：</div>
                </td>
                <td>
                    <input type="text" class="form-control input-sm" style="width:100px" placeholder="体外循环时间" json-name="体外循环时间">
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
                    <input type="text" class="form-control input-sm" style="width:120px" placeholder="主动脉阻断时间" json-name="主动脉阻断时间">
                </td>
                <td>
                    <span>（分钟）</span>
                </td>
                <td style="padding-left:35px">
                    <div class="checkbox">
                        <lable>
                            <input type="checkbox" tag="address-nodetail-checkbox" json-name="主动脉阻断时间-不能提供">不能提供</lable>
                    </div>
                </td>
                <td style="padding-left:15px">
                    <input type="text" class="form-control input-sm" style="width:400px" placeholder="输入原因" tag="address-nodetail-yuanyi" disabled json-name="主动脉阻断时间-不能提供-原因">
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
                        <input type="radio" name="ercihuoduocitiwaixunhuan" value="1" checked json-name="是否二次或多次体外循环">是</lable>
                    <lable class="radio-inline">
                        <input type="radio" name="ercihuoduocitiwaixunhuan" value="2" json-name="是否二次或多次体外循环">否</lable>
                </td>
                <td>
                    <div class="control-label" style="width:80px">原因：</div>
                </td>
                <td>
                    <div class="input-group">
                        <select class="form-control input-sm" style="width:300px" json-name="是否二次或多次体外循环-原因">
                            <option value=""></option>
                            <option value="残余畸形">残余畸形</option>
                            <option value="增加循环辅助时间">增加循环辅助时间</option>
                            <option value="出血">出血</option>
                        </select>
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
                        <input type="radio" name="shendiwentingxunhuan" value="1" checked json-name="深低温停循环">是</lable>
                    <lable class="radio-inline">
                        <input type="radio" name="shendiwentingxunhuan" value="2" json-name="深低温停循环">否</lable>
                </td>
                <td>
                    <div class="control-label" style="width:160px">深低温停循环时间：</div>
                </td>
                <td>
                    <input type="text" class="form-control input-sm" style="width:120px" placeholder="深低温停循环时间" json-name="深低温停循环时间">
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
                        <input type="radio" name="dancenaoguanzhu" value="1" checked json-name="单侧脑灌注">是</lable>
                    <lable class="radio-inline">
                        <input type="radio" name="dancenaoguanzhu" value="2" json-name="单侧脑灌注">否</lable>
                </td>
                <td>
                    <div class="control-label" style="width:160px">单侧脑灌注时间：</div>
                </td>
                <td>
                    <input type="text" class="form-control input-sm" style="width:120px" placeholder="单侧脑灌注时间" json-name="单侧脑灌注时间">
                </td>
                <td>
                    <span>（分钟）</span>
                </td>
            </tr>
        </table>
    </div>
</div>