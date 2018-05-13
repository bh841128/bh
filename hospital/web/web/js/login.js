function userLogin(){
	this.init = function(){
		initIEPlaceholder();

		$("button[tag='login_button']").click(function(){
			onLoginSubmit();
		})
	}

	/////////////////////////////////////////
	function onLoginSubmit(){
		var login_name_control = $("input[name='login_name']");
		var login_password_control = $("input[name='login_name']");
		var login_name_value = getTrimInputValue(login_name_control);
		if (login_name_value == ""){
			showErrorTooltip(login_name_control);
			return;
		}
	}
	function onLoginRet(){

	}
}
