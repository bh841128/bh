<?php
require_once(__DIR__."/../config/front_config.php");
?>
<!DOCTYPE html>
<html>
<head>
    <?php require(WEB_PAGE_PATH."head.php"); ?>
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="container-fluid" style="width:1200px;margin-left:auto;margin-right:auto">
        <header class="main-header">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-left:0px;margin-bottom:0px;">
                <a href="#" class="logo" style="width:500px">
                    <img src="/web/img/top-banner.png" />
                </a>
                <div class="navbar-custom-menu login">
                    <ul class="nav navbar-nav">
                        <li style="margin-right:30px"><button type="button" class="btn btn-primary">中文版</button><li>
                        <li><button type="button" class="btn btn-primary">英文版</button><li>
                    </ul>
                </div>
            </nav>
        </header>
    </div>
    <div class="wrapper" style="width:1200px;margin-left:auto;margin-right:auto">
        <div style="background-color:rgb(140,200,234);height:600px;text-align:center;">
            <div class="login-wrapper">
                <div class="login-wrapper2">
                    <div class="login-wrapper3">
                        <div class="form-group" style="margin-bottom:30px"><h2 style="color:rgb(85,173,220);">欢迎登录</h2></div>
                        <div class="form-group errormsg"><div class="msg-wrap"><div class="msg-error"><b></b>请输入验证码</div></div></div>
                        <div class="form-group"><input class="form-control" type="text" name="login_name" value="chaos" placeholder="请输入用户名" tooltip_msg="用户名不能为空"></div>
                        <div class="form-group" style="margin-bottom:50px;"><input class="form-control" type="password" value="fff" name="login_password" placeholder="请输入密码" tooltip_msg="密码不能为空"/></div>
                        <div class="form-group" style="margin-bottom:50px;"><button type="button" class="btn btn-primary" tag="login_button">登录</button></div>
                    </div>
                </div>
            </div>
        </div>

        <?php require(WEB_PAGE_PATH."footer.php"); ?>
        <?php require(WEB_PAGE_PATH."js.php"); ?>
        <script type="text/javascript">
            var g_userLogin = new userLogin();
            g_userLogin.init();
        </script>
    </div>
</body>

</html>