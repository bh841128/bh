function formatDateNow(){
	function get2Num(a){
		return a<10?"0"+a:a+"";
	}
	var t = new Date();
	var today = t.getFullYear()+"-"+get2Num(t.getMonth()+1)+"-"+get2Num(t.getDate());
	return today;
	return today + " "+get2Num(t.getHours())+":"+get2Num(t.getMinutes())+":"+get2Num(t.getSeconds());
}
function initDatePicker(selector){
	var dateNow = formatDateNow();
	$(selector).val(dateNow);
	$(selector).datetimepicker({format: 'YYYY-MM-DD'});
	$('.input-group').find('.glyphicon-calendar').parent().on('click', function(){
	$(this).siblings(selector).trigger('focus');});
}
function initDateTimePicker(selector){
	var dateNow = formatDateNow();
	$(selector).val(dateNow);
	$(selector).datetimepicker({format: 'YYYY-MM-DD HH:mm:ss'});
	$('.input-group').find('.glyphicon-calendar').parent().on('click', function(){
	$(this).siblings(selector).trigger('focus');});
}
///////////////////////////////////////
function initMinzu(controls){
	var nations = ["汉族","蒙古族","回族","藏族","维吾尔族","苗族","彝族","壮族","布依族","朝鲜族","满族","侗族","瑶族","白族","土家族",
        "哈尼族","哈萨克族","傣族","黎族","傈僳族","佤族","畲族","高山族","拉祜族","水族","东乡族","纳西族","景颇族","柯尔克孜族",
        "土族","达斡尔族","仫佬族","羌族","布朗族","撒拉族","毛南族","仡佬族","锡伯族","阿昌族","普米族","塔吉克族","怒族", "乌孜别克族",
        "俄罗斯族","鄂温克族","德昂族","保安族","裕固族","京族","塔塔尔族","独龙族","鄂伦春族","赫哲族","门巴族","珞巴族","基诺族"];
    for ( var i=0;i<nations.length;i++) {
        var a=nations[i];
        setSelectOptions(controls, nations);
    }
}
///////////////////////////////////////////////
function getCurrentPage(){
	var page = window.location.pathname.replace(/.*\//,'');
	page = page.replace(/\.php/,'');
	if (page == ""){
		page = "index";
	}
	return;
}

function initAsideMenu(){
	$("#main-sidebar .tree-btn[page]").each(function(){
		var m_this = this;
		var page = $(this).attr("page");
		var isActive = $(this).hasClass("active");
		this.onclick = function(){
			if (isActive){
				return;
			}
			gotoPage(page);
		}
	})
	var page = getCurrentPage();
	$("#main-sidebar .tree-btn[page='"+page+"']").addClass("active");
}
///////////////////////////////////////////////
function initUserMenu(){
	$("#user_login_menu a[tag='change_password']").click(function(){
		onShowChangePwd();
	})
	$("#user_login_menu a[tag='signout']").click(function(){
		onLogout();
	})

	$("input[tag]").one( "focus", function() {
		hideAllErrorMsgs();
	});
}
///////////////////////////////////////////////
function initPage(){
	initAsideMenu();
	initUserMenu();
	initDatePicker("input[tag='datepicker']");
	initMinzu($("select[tag='minzu']"));
	initAddress($("div[tag='address']"));

	checkLogin(onCheckLoginRet);
	function onCheckLoginRet(rsp){
		if (rsp.ret != 0){
			gotoLoginPage();
		}
	}
}
/////////////////////////////////////////
function initAddress(controls){
	var shengfens = getAddressJsonTopData(g_address_data);
	controls.each(function(){
		var m_this = this;
		$("input[tag='address-nodetail-checkbox'").change(function(){
			if (this.checked){
				$("input[tag='address-nodetail-yuanyi'").removeAttr("disabled");
			}
			else{
				$("input[tag='address-nodetail-yuanyi'").attr("disabled","disabled");
			}
		})
		var address_shengfen = $(m_this).find("select[tag='address-shengfen']");
		var address_chengshi = $(m_this).find("select[tag='address-chengshi']");
		var address_quxian = $(m_this).find("select[tag='address-quxian']");
		setSelectOptions2(address_shengfen,[{"name":"选择省份","value":""}]);
		addSelectOptions2(address_shengfen, shengfens);
		setSelectOptions2(address_chengshi,[{"name":"选择城市","value":""}]);
		setSelectOptions2(address_quxian,[{"name":"选择区/县","value":""}]);
		address_shengfen.change(function(){
			setSelectOptions2(address_chengshi,[{"name":"选择城市","value":""}]);
			setSelectOptions2(address_quxian,[{"name":"选择区/县","value":""}]);

			var shengfen = $(this).val();
			if (shengfen == ""){
				return;
			}
			var shenfen_data = getAddressJsonByName(g_address_data, shengfen);
			if (typeof shenfen_data["citys"] == "undefined"){
				return;
			}
			var citys = getAddressJsonTopData(shenfen_data["citys"]);
			addSelectOptions2(address_chengshi,citys);
			if(citys.length == 1){
				selectSelectByValue(address_chengshi, citys[0]["value"]);
				onCityChange();
			}
		})
		address_chengshi.change(function(){
			onCityChange();
		})
		function onCityChange(){
			setSelectOptions2(address_quxian,[{"name":"选择区/县","value":""}]);

			var shengfen = address_shengfen.val();
			var city = address_chengshi.val();
			if (shengfen == "" || city == ""){
				return;
			}
			var shenfen_data = getAddressJsonByName(g_address_data, shengfen);
			if (typeof shenfen_data["citys"] == "undefined"){
				return;
			}
			
			var area_data = getAddressJsonByName(shenfen_data["citys"], city);
			if (typeof area_data["areas"] == "undefined"){
				return;
			}
			var areas = getAddressJsonTopData(area_data["areas"]);
			addSelectOptions2(address_quxian,areas);
		}
	})
}
/////////////////////////////////////////
function addSelectOptions(controls, values){
	for ( var i=0;i<values.length;i++) {
        var a=values[i];
        controls.append("<option value='"+a+"'>"+a+"</option>");
    }
}
function setSelectOptions(controls, values){
	clearSelectOptions(controls);
	addSelectOptions(controls, values);
}

function addSelectOptions2(controls, values){
	for ( var i=0;i<values.length;i++) {
        var a=values[i];
        controls.append("<option value='"+a["value"]+"'>"+a["name"]+"</option>");
    }
}
function setSelectOptions2(controls, values){
	clearSelectOptions(controls);
	addSelectOptions2(controls, values);
}

function clearSelectOptions(controls){
	for ( var i=0;i < controls.length;i++) {
		var control = controls.get(i);
		control.options.length = 0;
	}
}

function selectSelectByValue(control_select, value){
	control_select.find("option").each(function(){
		if ($(this).val() == value){
			$(this).attr("selected", "selected");
		}
	})
}

//////////////////////////////////////////
function getAddressJsonTopData(json){
	var keys = [];
	for (var key in json){
		var tmp_data = {
			"name":json[key]["name"],
			//"value":json[key]["code"]
			"value":json[key]["name"]
		};
		keys.push(tmp_data);
	}
	return keys;
}

function getAddressJsonByName(json, name){
	for (var key in json){
		if (json[key]["name"] == name){
			return json[key];
		}
	}
	return null;
}
/////////////////////////////////////////////////////
function getRadioValue(radioName){
	return $("input[name='"+radioName+"']:checked").val();
}

function setRadioChecked(radioName, valeChecked){
	var radios = document.getElementsByName(radioName);
    for (var j = 0; j < radios.length; j++) {
        if (radios[j].value == valeChecked) {
            radios[j].checked = true;
            break;
        }
    }
}

function getCheckboxChecked(control_checkbox){
	if (control_checkbox.checked){
		return 1;
	}
	return 0;
}

function setCheckboxChecked(control_checkbox, checked){
	if (checked){
		control_checkbox.checked = true;
	}
	else{
		control_checkbox.checked = false;
	}
}
/////////////////////////////////////////////////////
function hideAllErrorTips(){
	hideAllErrorMsgs();
	hideAllTooltips();
}
function hideAllTooltips(){
	$("input[tooltip]").tooltip("hide");
}
function hideAllErrorMsgs(){
	$(".errormsg").removeClass("error_active");
}
function showErrorMsg(errmsg_wraper, errmsg){
	errmsg_wraper.find(".msg-error").html('<b></b>'+errmsg);
	errmsg_wraper.addClass("error_active");
}
function showErrorTooltip(input_ele){
	var tooltip_msg = input_ele.attr("tooltip_msg");
	if (!tooltip_msg || tooltip_msg == ""){
		return;
	}
	input_ele.tooltip({
		"trigger":"manual",
		"placement":"right",
		"title":tooltip_msg
	});
	input_ele.tooltip('show');
	input_ele.one( "focus", function() {
		input_ele.tooltip('hide');
	});
}
////////////////////////////////////////////////////////////
function initIEPlaceholder(){
	if (!isIE()){
		return;
	}
	$("input").each(function(){
		var place_hoder = $(this).attr("placeholder");
		if (!place_hoder){
			return;
		}
		$(this).placeholder();
	})
}

function isIE(){
	var ua = navigator.userAgent.toLowerCase();
	if (ua.match(/msie/)){
		return true;
	}
	return false;
}
///////////////////////////////////////////////////////////////////
function getTrimInputValue(input_control){
	var value = input_control.val();
	value = value.replace(/^\s+|\s+$/);
	return value;
}
////////////////////////////////////////////////////////////////////
function ajaxRemoteRequest(action, data, callback){
	var http_protocol = window.location.protocol;
	var http_host     = window.location.host;
	var action_url = http_protocol+"//"+http_host;

	action_url = "http://112.74.105.107"
	action_url += "/" + action;
	$.ajax({
		url: action_url,
		cache: false,
		type: "POST",
		data: data,
		dataType: "json",
		success: function (rsp) {
			callback(rsp);
		}
	});
}

////////////////////////////////////////////////////
var g_global_data = {};
function onLogin(username, password, callback){
	function loginRet(rsp){
		if (rsp.ret == 0){
			g_global_data["username"] = rsp["username"];
		}
		callback(rsp);
	}
	//md5(md5($username)."".$password);
	//var md5_pass = $.md5($.md5(username)+""+password);
	ajaxRemoteRequest("hospital/loginin",{"username":username, "password":password},loginRet);
}
function checkLogin(callback){
	function checkLoginRet(rsp){
		if (rsp.ret == 0){
			g_global_data["username"] = rsp["msg"];
		}
		callback(rsp);
	}
	ajaxRemoteRequest("hospital/check-login",{},checkLoginRet);
}

function onLogout(){
	function onLogoutRet(rsp){
		if (rsp.ret == 0){
			window.location.href="/web/login.html";
		}
	}
	ajaxRemoteRequest("hospital/login-out",{},onLogoutRet);
}

function onChangePassword(old_password, new_password, callback){
	var username = g_global_data["username"];
	ajaxRemoteRequest("hospital/modpwd",{username:username,newpassword:new_password,oldpassword:old_password},callback);
}

////////////////////////////////////////////////////////
function onShowChangePwd(){
	$( "#id_login_frame button[tag='ok']" ).off('click').on("click", function() {
		onChangePwdSubmit();
	});
	$('#id_login_frame').modal();
}

function onChangePwdSubmit(){
	function onChangePasswordRet(rsp){
		if (rsp.ret != 0){
			showErrorMsg(errormsg_wrap, "原始密码错误");
			return;
		}
		$('#id_login_frame').modal('hide');
		gotoLoginPage();
	}
	var old_password_control = $("#id_login_frame input[tag='old_password']");
	var new_password_control = $("#id_login_frame input[tag='new_password']");
	var new_password_again_control = $("#id_login_frame input[tag='new_password_again']");
	var errormsg_wrap = $("#id_login_frame .errormsg");
	var old_password_value = old_password_control.val();
	if (old_password_value == ""){
		showErrorMsg(errormsg_wrap, "请输入原始密码");
		return;
	}
	var new_password_value = new_password_control.val();
	if (new_password_value == ""){
		showErrorMsg(errormsg_wrap, "请输入新密码");
		return;
	}
	var new_password_again_value = new_password_again_control.val();
	if (new_password_again_value == ""){
		showErrorMsg(errormsg_wrap, "请再次输入新密码");
		return;
	}
	if (new_password_value != new_password_again_value){
		showErrorMsg(errormsg_wrap, "再次输入的新密码不一致");
		return;
	}
	onChangePassword(old_password_value, new_password_value, onChangePasswordRet);
}

function gotoLoginPage(){
	gotoPage("login");
}

function gotoPage(page){
	window.location.href="/"+page+".php";
}
