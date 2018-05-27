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
	return page;
}

function initAsideMenu(){
	$("#main-sidebar .tree-btn[page]").each(function(){
		var m_this = this;
		var page = $(this).attr("page");
		var isActive = $(this).hasClass("active");
		this.onclick = function(){
			if (isActive && page != "index"){
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
function getManagerInfo(init_end_callback){
	function getManagerInfoRet(rsp){
		if (rsp.ret != 0){
			return;
		}
		if (!rsp["msg"].hospital){
			return;
		}
		var hospital_name = rsp["msg"].hospital["name"];
		g_global_data.hospital = rsp["msg"].hospital;
		$("#user-menu-right-top").html(hospital_name+'<span class="caret"></span>');
		if (typeof init_end_callback != "undefined"){
			init_end_callback();
		}
	}
	var username = g_global_data["username"];
	ajaxRemoteRequest("hospital/get-manager",{username:username},getManagerInfoRet);
}
///////////////////////////////////////////////
function initPage(init_end_callback){
	function initPageOther(init_end_callback){
		getManagerInfo(init_end_callback);
	}
	checkLogin(onCheckLoginRet);
	function onCheckLoginRet(rsp){
		if (rsp.ret != 0){
			gotoLoginPage();
		}
		initPageOther(init_end_callback);
	}
	initAsideMenu();
	initDatePicker("input[tag='datepicker']");
	initDateTimePicker("input[tag='datetimepicker']");
	initMinzu($("select[tag='minzu']"));
	initAddress($("div[tag='address']"));
	initUserMenu();
	initIEPlaceholder();
	initSelectModal();
}
/////////////////////////////////////////
function initAddress(controls){
	var shengfens = getAddressJsonTopData(g_address_data);
	controls.each(function(){
		var m_this = this;
		$("input[tag='address-nodetail-checkbox'").change(function(){
			if (this.checked){
				$(getParentUntil(this, "TR")).find("input[tag='address-nodetail-yuanyi']").removeAttr("disabled");
			}
			else{
				$(getParentUntil(this, "TR")).find("input[tag='address-nodetail-yuanyi']").attr("disabled","disabled");
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
	var selectedIndex = 0;
	control_select.find("option").each(function(){
		if ($(this).val() == value){
			control_select.get(0).selectedIndex = selectedIndex;
		}
		selectedIndex++;
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
function getRadioValue(selector, radioName){
	var value = selector.find("input[name='"+radioName+"']:checked").val();
	if (value.match(/^[1-9][0-9]*$/) || value == ""){
		value = parseInt(value);
	}
	return value;
}

function setRadioCheckedByName(radioName, valeChecked){
	var radios = document.getElementsByName(radioName);
    for (var j = 0; j < radios.length; j++) {
        if (radios[j].value == valeChecked) {
            radios[j].checked = true;
            break;
        }
    }
}

function setRadioChecked(control){
	control.checked = true;
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
	return getTrimValue(value);
}
function getTrimValue(value){
	value = value.replace(/^\s+|\s+$/,'');
	return value;
}
////////////////////////////////////////////////////////////////////
function ajaxRemoteRequest(action, data, callback){
	function callback_inner(rsp){
		if (rsp.ret == 1 && rsp.msg.match(/not login/)){
			gotoLoginPage();
			return;
		}
		callback(rsp);
	}
	var http_protocol = window.location.protocol;
	var http_host     = window.location.host;
	var action_url = http_protocol+"//"+http_host;

	action_url = window.location.origin;
	action_url += "/" + action;
	$.ajax({
		url: action_url,
		cache: false,
		type: "POST",
		data: data,
		dataType: "json",
		success: function (rsp) {
			callback_inner(rsp);
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
	password = $.md5(password);
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
			gotoLoginPage("index");
		}
	}
	ajaxRemoteRequest("hospital/login-out",{},onLogoutRet);
}

function onChangePassword(old_password, new_password, callback){
	var username = g_global_data["username"];
	new_password = $.md5(new_password);
	old_password = $.md5(old_password);
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
/////////////////////////////////////////////////////////////////
function getJsonValue(json, name, default_value){
	if (typeof json[name] != "undefined"){
		return json[name];
	}
	if (typeof default_value != "undefined"){
		return default_value;
	}
	return null;
}
/////////////////////////////////////////////////////////////////////
function strDateToTimestap(sDate){
	var t = parseInt(Date.parse(sDate)/1000);
	if (isNaN(t)){
		t = 0;
	}
	return t;
}
function timestampToString(timestamp){
	if (timestamp <= 0 || timestamp == ""){
		return "";
	}
	var dt = new Date(timestamp * 1000);

	var year  = dt.getFullYear();
	var month = dt.getMonth()+1;
	var day   = dt.getDate();
    var hours = dt.getHours();
    var minutes = dt.getMinutes();
    var seconds = dt.getSeconds();

	if (month < 10) 
		month = '0' + month;
	if (day < 10) 
	 	day = '0' + day;
    if (hours < 10) 
     	hours = '0' + hours;
    if (minutes < 10) 
     	minutes = '0' + minutes;
    if (seconds < 10) 
     	seconds = '0' + seconds;

    return year +"-"+month+"-"+day+" "+hours + ":" + minutes + ":" + seconds;
}

function timestampToDateString(timestamp){
	if (timestamp <= 0 || timestamp == ""){
		return "";
	}
	var dt = new Date(timestamp * 1000);

	var year  = dt.getFullYear();
	var month = dt.getMonth()+1;
	var day   = dt.getDate();

	if (month < 10) 
		month = '0' + month;
	if (day < 10) 
	 	day = '0' + day;
	
    return year +"-"+month+"-"+day;
}

function getParentUntil(node, parentTagname){
	var parentIter = node.parentNode;
	while (parentIter && parentIter.tagName != parentTagname){
		parentIter = parentIter.parentNode;
	}
	return parentIter;
}

//////////////////////////////////////////////////////////////
function getHospitals(){
	return g_all_hospitals;
}
function getHospitalName(hospital_id) {
	var hospitals = getHospitals();
	for (var i = 0; i < hospitals.length; i++) {
		if (hospitals[i]["id"] == hospital_id) {
			return hospitals[i]["name"];
		}
	}
	return "" + hospital_id;
}

function initHospital(controls){
	var hospitals = getHospitals();
	var options_hospitals = [];
	options_hospitals.push({"name":"所有医院","value":0});
    for ( var i=0;i<hospitals.length;i++) {
		options_hospitals.push({"name":hospitals[i].name, "value":hospitals[i].id});
	}
	setSelectOptions2(controls, options_hospitals);
}

////////////////////////////////////////////////////////////////////////////
function evalJsonStr(json_str){
	if (json_str == ""){
		json_str = {};
	}
	else {
		try {
			json_str = eval('(' + json_str + ')');
		}
		catch (err) {
			json_str = {};
		}
	}
	return json_str;
}
//////////////////////////////////////////////////////////////
function showNavTab(section_id, show_nav_id, show_tab_id){
$("#"+section_id+">.nav-tabs>li>a").each(function(){
	if (this.id == show_nav_id){
		$(this.parentNode).addClass("active");
	}
	else{
		$(this.parentNode).removeClass("active");
	}
})
$("#"+section_id+">.tab-content>.tab-pane").each(function(){
	if (this.id == show_tab_id){
		$(this).addClass("active");
		$(this).addClass("in");
	}
	else{
		$(this).removeClass("active");
		$(this).removeClass("in");
	}
})
}

////////////////////////////////////////////////////////////
function isSelectModal(control){
	var json_name = control.attr("json-name");
	if (json_name == "术前诊断" || json_name == "手术诊断" ||
		json_name == "非心脏畸形" ||
		json_name == "术前一般危险因素" ||
		json_name == "主要手术名称" ||
		json_name == "术后并发症"
	){
		return true;
	}
	return false;
}

function get2Keyvalue(arr2Keys){
	var arrValues = [];
	for (var i = 0; i < arr2Keys.length; i++){
		arrValues.push(arr2Keys[i].key1 +"\t" + arr2Keys[i].key2);
	}
	return arrValues.join("\n");
}
function setSelectModalValue(control, value){
	var json_name = control.attr("json-name");
	var data_indexs = "";
	if (json_name == "术前诊断" || json_name == "手术诊断"){
		if (typeof value != "undefined" && value ){
			var data_indexs = g_xianxinbingbingzhong_select_modal.data2Indexs(value);
		}
	}
	else if (json_name == "非心脏畸形"){
		if (typeof value != "undefined" && value ){
			var data_indexs = g_feixinzangjixing_select_modal.data2Indexs(value);
		}
	}
	else if (json_name == "术前一般危险因素"){
		if (typeof value != "undefined" && value ){
			var data_indexs = g_shuqianyibanweixianyinsu_select_modal.data2Indexs(value);
		}
	}
	else if (json_name == "主要手术名称"){
		if (typeof value != "undefined" && value ){
			var data_indexs = g_zhuyaoshoushumingcheng_select_modal.data2Indexs(value);
		}
	}
	else if (json_name == "术后并发症"){
		if (typeof value != "undefined" && value ){
			var data_indexs = g_shuhoubingfazheng_select_modal.data2Indexs(value);
		}
	}
	
	
	var show_values = get2Keyvalue(value);
	control.val(show_values);
	control.attr("data_indexs", data_indexs);
}
function getSelectModalValue(control){
	var json_name = control.attr("json-name");
	var data_indexs = control.attr("data_indexs");
	if (!data_indexs || data_indexs == ""){
		return [];
	}
	if (json_name == "术前诊断" || json_name == "手术诊断"){
		var datas = g_xianxinbingbingzhong_select_modal.indexs2Data(data_indexs);
		return datas;
	}
	else if (json_name == "非心脏畸形"){
		var datas = g_feixinzangjixing_select_modal.indexs2Data(data_indexs);
		return datas;
	}
	else if (json_name == "术前一般危险因素"){
		var datas = g_shuqianyibanweixianyinsu_select_modal.indexs2Data(data_indexs);
		return datas;
	}
	else if (json_name == "主要手术名称"){
		var datas = g_zhuyaoshoushumingcheng_select_modal.indexs2Data(data_indexs);
		return datas;
	}
	else if (json_name == "术后并发症"){
		var datas = g_shuhoubingfazheng_select_modal.indexs2Data(data_indexs);
		return datas;
	}
	return [];
}
function initSelectModal(){
	function onSelectModalSelectOk(control, selected_datas){
		setSelectModalValue(control, selected_datas);
	}
	$("[json-name='术前诊断'],[json-name='手术诊断']").on("focus",(function(){
		var selected_data_index = $(this).attr("data_indexs");
		g_xianxinbingbingzhong_select_modal.show_modal($(this), selected_data_index, onSelectModalSelectOk);
	}));
	$("[json-name='非心脏畸形']").on("focus",(function(){
		var selected_data_index = $(this).attr("data_indexs");
		g_feixinzangjixing_select_modal.show_modal($(this), selected_data_index, onSelectModalSelectOk);
	}));
	$("[json-name='术前一般危险因素']").on("focus",(function(){
		var selected_data_index = $(this).attr("data_indexs");
		g_shuqianyibanweixianyinsu_select_modal.show_modal($(this), selected_data_index, onSelectModalSelectOk);
	}));
	$("[json-name='主要手术名称']").on("focus",(function(){
		var selected_data_index = $(this).attr("data_indexs");
		g_zhuyaoshoushumingcheng_select_modal.show_modal($(this), selected_data_index, onSelectModalSelectOk);
	}));
	$("[json-name='术后并发症']").on("focus",(function(){
		var selected_data_index = $(this).attr("data_indexs");
		g_shuhoubingfazheng_select_modal.show_modal($(this), selected_data_index, onSelectModalSelectOk);
	}));
}

///////////////////////////////////////////////////////////////////////////////////////
function isValidPhone(phone){
	if (typeof phone == "undefined" || phone == "" || phone == null){
		return false;
	}
	if(!/^(\(\d{3,4}\)|\d{3,4}-|\s)?\d{7,14}$/.test(phone) && !/^((1[3-8][0-9])+\d{8})$/.test(phone)){
		return false;
	}
	return true;
}
function isValidRiqi(data){
	if (typeof data == "undefined" || data == "" || data == null){
		return false;
	}
	if (!data.match(/^[1-2][0-9]{3}\-[0-9]{2}-[0-9]{2}$/)){
		return false;
	}
	return true;
}
function isValidRiqiShijian(data){
	if (typeof data == "undefined" || data == "" || data == null){
		return false;
	}
	if (!data.match(/^[1-2][0-9]{3}\-[0-9]{2}\-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/)){
		return false;
	}
	return true;
}
//arr_errmsgs, data_json, "联系人姓名", "不能为空", "请填写 联系人姓名"
function checkValueValid(arr_errmsgs, data_json, key, check_type, errmsg, param1, param2, param3){
	if (check_type == "不能为空"){
		if (typeof data_json[key] == "undefined" || data_json[key] == "" || data_json[key] == null){
			arr_errmsgs.push(errmsg);
		}
		return;
	}
	if (check_type == "长度范围"){
		var min_len = param1;
		var max_len = param2;
		if (data_json[key].length < min_len || data_json[key].length > max_len){
			arr_errmsgs.push(errmsg);
		}
		return;
	}
	if (check_type == "电话号码"){
		if (!isValidPhone(data_json[key])){
			arr_errmsgs.push(errmsg);
		}
		return;
	}
	if (check_type == "日期"){
		if (!isValidRiqi(data_json[key])){
			arr_errmsgs.push(errmsg);
		}
		return;
	}
}

//////////////////////////////////////////////////////////////
function setAllControlDisabled(container, bDisabled){
	container.find("[json-name],button").each(function(){
		this.disabled = bDisabled;
	});
}
/////////////////////////////////////////////////////////////////
function showModalConfirm(title, msg, callback){
	$("#confirm_modal [tag='title']").html(title);
	$("#confirm_modal [tag='msg']").html(msg);
	$("#confirm_modal [tag='button_ok']").get(0).onclick = function(){
		callback('ok');
		$("#confirm_modal").modal("hide");
	}
	$("#confirm_modal").modal();
}

function init_leave_page(msg){
	window.onbeforeunload=function(){
		return msg;
	}
}