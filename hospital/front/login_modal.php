<div id="id_login_frame" class="modal login_modal" tabindex="-1" role="dialog" style="z-index:10000">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:335px;">
            <div class="modal-header">
                    <h5 class="modal-title" style="text-align:center">修改密码</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="right:5px;width:30px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="container">
                <div class="form-horizontal" style="margin:0px;">
                    <table class="control-table padding-10">
                        <tr>
                            <td>
                                <div class="control-label" style="text-align:left;padding-left:0px;">原始密码：</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="password" class="form-control input-sm" placeholder="原始密码" tag="old_password" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="control-label" style="text-align:left;padding-left:0px;">新密码(8-20位，包含数字和小写字母)：</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="password" class="form-control input-sm" placeholder="新密码" tag="new_password" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="control-label" style="text-align:left;padding-left:0px;">再次输入新密码：</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="password" class="form-control input-sm" placeholder="再次输入新密码" tag="new_password_again" required>
                            </td>
                        </tr>
                        <tr><td><div class="msg-wrap errormsg"><div class="msg-error"><b></b></div></div></td></tr>
                        <tr><td style="text-align:center"><button type="button" class="btn btn-primary" tag="ok" style="width:100px;">保存</button></td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="id_login_pop_frame" class="modal login_modal" tabindex="-1" role="dialog" style="z-index:10000">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width:335px;">
            <div class="modal-header">
                <h5 class="modal-title" style="text-align:center">登录</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="right:5px;width:30px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="container">
                <div class="form-horizontal" style="margin:0px;">
                    <table class="control-table padding-10">
                        <tr>
                            <td>
                                <div class="control-label" style="text-align:left;padding-left:0px;">用户名：</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" class="form-control input-sm" placeholder="用户名" tag="username" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="control-label" style="text-align:left;padding-left:0px;">密码：</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="password" class="form-control input-sm" placeholder="密码" tag="password" required>
                            </td>
                        </tr>
                        <tr><td><div class="msg-wrap errormsg"><div class="msg-error"><b></b></div></div></td></tr>
                        <tr><td style="text-align:center"><button type="button" class="btn btn-primary" tag="ok" style="width:100px;">登录</button></td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="confirm_modal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" tag="title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p tag="msg"></p>
      </div>
      <div class="modal-footer">
        <button type="button" tag="button_ok" class="btn btn-primary">确定</button>
        <button type="button" tag="button_cancel" class="btn btn-secondary" data-dismiss="modal">取消</button>
      </div>
    </div>
  </div>
</div>