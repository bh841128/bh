function userLogin(){
	this.init = function(){
		initIEPlaceholder();

		$("button[tag='login_button']").click(function(){
			onLoginSubmit();
		})

		$("input[name='login_name'],input[name='login_password']").one( "focus", function() {
			hideAllErrorMsgs();
		});
	}

	/////////////////////////////////////////
	function onLoginSubmit(){
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
		onLogin(login_name_value, login_password_value,onLoginRet);
	}
	function onLoginRet(rsp){
		var ret = rsp.ret;
		if (ret != 0){
			showErrorMsg($(".errormsg"), "登录失败，用户名或者密码错误");
			return;
		}
		//并跳转到主页面
		gotoPage("index");
	}
	//////////////////////////////////////////////////////
}
