<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>中国少儿先天性心脏病外科手术数据库</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./lib/bootstrap/dist/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="./lib/adminlte/css/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="./lib/adminlte/css/ionicons.min.css">
    <link rel="stylesheet" href="./lib/adminlte/css/AdminLTE.min.css">
    <link rel="stylesheet" href="./css/public.css">
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="container-fluid" style="width:1200px;margin-left:auto;margin-right:auto">
        <header class="main-header">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-left:0px;margin-bottom:0px;">
                <a href="#" class="logo" style="width:500px">
                    <img src="./img/top-banner.png" />
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

        <footer style="margin-top:20px">
            <div class="copyright">
                <p>保险业务经营许可证：269633000000800 小雨伞保险经纪有限公司：9112011608300716X9</p>
                <p>版权所有 ©
                    <span id="footerYear">2018</span> 小雨伞保险经纪有限公司
                    <a href="http://www.miibeian.gov.cn" target="_blank" rel="nofollow">津ICP备17005385号-3</a>
                </p>
                <div>
                    <a target="_blank" href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=12019202000239" style="display:inline-block;text-decoration:none;height:20px;line-height:20px;">
                        <img src="./img/beian.png" style="float:left;">
                        <p style="float:left;height:20px;line-height:20px;margin: 0px 0px 0px 5px; color:#939393;">津公网安备 12019202000239号</p>
                    </a>
                </div>
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->



    <script src="./lib/jquery.min.js"></script>
    <script src="./lib/jquery.placeholder.js"></script>
    <script src="./lib/jquery.cookie.js"></script>
    <script src="./lib/jquery.md5.js"></script>
    <script src="./lib/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="./lib/adminlte/js/adminlte.min.js"></script>
    <script src="./js/public.js"></script>
    <script src="./js/login.js"></script>
    <script type="text/javascript">
        var g_userLogin = new userLogin();
        g_userLogin.init();
    </script>
    </div>

</body>

</html>