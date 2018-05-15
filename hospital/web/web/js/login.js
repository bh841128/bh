function userLogin(){
	this.init = function(){
		initIEPlaceholder();

		$("button[tag='login_button']").click(function(){
			onLogin();
		})

		$("input[name='login_name'],input[name='login_password']").one( "focus", function() {
			hideAllErrorMsgs();
		});
	}

	/////////////////////////////////////////
	function onLogin(){
		var login_name_control = $("input[name='login_name']");
		var login_password_control = $("input[name='login_password']");
		var errormsg_wrap = $(".errormsg");
		var login_name_value = getTrimInputValue(login_name_control);
		if (login_name_value == ""){
			showErrorMsg(errormsg_wrap, "用户名不能为空");
			return;
		}
		var login_password_value = login_password_control.val();
		
		if (login_password_value == ""){
			showErrorMsg(errormsg_wrap, "密码不能为空");
			return;
		}
		sendLoginInner(login_name_value, login_password_value);
	}
	function sendLoginInner(username, password){
		//md5(md5($username)."".$password);
		//var md5_pass = $.md5($.md5(username)+""+password);
		ajaxRemoteRequest("hospital/loginin",{"username":username, "password":password},onLoginRet);
	}
	function onLoginRet(rsp){
		var ret = rsp.ret;
		if (ret != 0){
			showErrorMsg($(".errormsg"), "登录失败，用户名或者密码错误");
			return;
		}
		//并跳转到主页面
		window.location.href="/hospital/index.html";
	}
}
