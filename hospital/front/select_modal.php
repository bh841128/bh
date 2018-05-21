<div id="select_modal_xianxinbingbingzhong" class="modal login_modal" tabindex="-1" role="dialog" style="z-index:10000">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:1000px;">
            <div class="modal-header">
                    <h5 class="modal-title" style="text-align:left">设备查询</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="right:5px;width:30px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="container">
                <div class="form-horizontal" style="margin:0px;" tag="param-container">
                    <table class="control-table padding-10">
                        <tr>
                            <td>
                                <div class="control-label control-label-120">负责人：</div>
                            </td>
                            <td>
                                <input type="text" class="form-control input-sm"  style="width:100px" json-name="负责人" value="">
                            </td>
                            <td>
                                <div class="control-label" style="width:60px;padding-left:5px">类型：</div>
                            </td>
                            <td>
                                <select class="form-control input-sm" style="width:100px" json-name="类型">
                                    <option value="0">running</option>
                                    <option value="1">updating</option>
                                    <option value="2">dead</option>
                                </select>
                            </td>
                            <td>
                                <div class="control-label" style="width:60px;padding-left:5px">状态：</div>
                            </td>
                            <td>
                                <select class="form-control input-sm" style="width:100px" json-name="状态">
                                    <option value="0">running</option>
                                    <option value="1">updating</option>
                                    <option value="2">dead</option>
                                </select>
                            </td>
                            <td>
                                <div class="control-label" style="width:50px;padding-left:5px">sn：</div>
                            </td>
                            <td style="text-align:center;">
                                <input type="text" class="form-control input-sm"  style="width:200px;" json-name="sn" value="">
                            </td>
                            <td style="text-align:center;width:100px;"><button type="button" class="btn btn-primary" tag="ok" style="width:100px;margin-left:20px;margin-right:10px;">查询</button></td>
                        </tr>
                        
                    </table>
                </div>
                <div class="box-body table-responsive" tag="search-table-wrapper" style="text-align:center;width:100%;height:500px;overflow-x:scroll;overflow-y:scroll;">
                </div>
                <div class="form-horizontal" style="margin:0px;text-align:center">
                    <button type="button" class="btn btn-primary" tag="button_ok" style="width:100px;">确认</button>
                </div>
            </div>
        </div>
    </div>
</div>