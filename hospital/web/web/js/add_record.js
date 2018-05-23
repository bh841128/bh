function addPatient(){
	var m_patient_id = 0;
	var m_this = this;
	var m_json_map = [
		{"name":"病案号","field":"medical_id"},
		{"name":"性别","field":"sexy"},
		{"name":"姓名","field":"name"},
		{"name":"民族","field":"nation"},
		{"name":"出生日期","field":"birthday"},
		{"name":"详细地址-不能提供","field":"isNotSupply", "default_value":0},
		{"name":"详细地址-不能提供-原因","field":"reason"},
		{"name":"省份","field":"province"},
		{"name":"城市","field":"city"},
		{"name":"区县","field":"district"},
		{"name":"详细地址","field":"address"}
	];

	this.init = function(){
		$("#add-zhuyuanjilu").click(function(){
			onAddZhuyuanjilu();
		})
		$("#tab-jibenziliao button[tag='jibenziliao-baocun']").click(function(){
			onJibenziliaoSave();
		})
		//查询住院记录
		g_queryZhuyuanjilu = new queryZhuyuanjilu();
		g_queryZhuyuanjilu.init();

		$("#jibenziliao-section [json-name],#zhuyuanjilu-section [json-name]").on( "focus", function() {
			hideAllErrorMsgs();
		});
	}
	this.initData = function(patient_data){
		if (typeof patient_data != "undefined"){
			m_patient_id = patient_data["id"];
			initInputsByData(patient_data);
			$("#nav-tab-zhuyuanjilu").get(0).disabled = false;
		}
		else{
			m_patient_id = 0;
			initInputsByData({});
			$("#nav-tab-zhuyuanjilu").get(0).disabled = true;
		}
		if (typeof patient_data != "undefined" && patient_data["status"] == 2){
			setJibenZiliaoState(true);
		}
		else{
			setJibenZiliaoState(false);
		}
		g_hospital.setGlobalData("patient_id", m_patient_id);
		hideAllErrorMsgs();
	}
	this.showPage = function(patient_data){
		m_this.initData(patient_data);
	}
	this.showPageZyjlList = function(patient_data){
		m_this.showPage(patient_data);
		g_queryZhuyuanjilu.showPage(m_patient_id);
	}
	function onAddZhuyuanjilu(){
		g_addZhuyuanjilu.onAddZhuyuanjilu();
	}
	function onJibenziliaoSave(){
		var raw_json = {};
		var g_control_json = new control_json();
		raw_json["患者基本资料"] = g_control_json.parseControlJson($("#huanzhe-jibenziliao"));
		raw_json["联系人基本资料"] = g_control_json.parseControlJson($("#lianxiren-jibenziliao"));
		//console.dir(raw_json);
		/////////////////////////////////////////////////
		
		var data_json = getValuesByMap(raw_json["患者基本资料"], m_json_map);
		data_json["isSupply"] = data_json["isNotSupply"]?0:1;
		delete data_json["isNotSupply"];
		var data_json_lianxiren = arrayToJson(raw_json["联系人基本资料"]);
		data_json["relate_text"] = $.toJSON(data_json_lianxiren);
		//console.dir(data_json);
		////////////////////////////////////////////////
		////检查参数合法性
		if (!checkHuanzheInputValid(raw_json["患者基本资料"])){
			return false;
		}
		if (!checkLianxirenInputValid(raw_json["联系人基本资料"])){
			return false;
		}
		////////////////////////////////////////////////
		//发送插入请求
		if (m_patient_id > 0){
			data_json["id"] = m_patient_id;
			ajaxRemoteRequest("hospital/update-patient",data_json,onUpdatePatientRet);
		}
		else{
			ajaxRemoteRequest("hospital/insert-patient",data_json,onAddPatientRet);
		}
		
	}
	function onAddPatientRet(rsp){
		//console.dir(rsp);
		if (rsp.ret != 0){
			alert("添加数据失败，请稍后再试");
			return;
		}
		alert("添加成功");
		g_operation_type = 1;
		m_patient_id = rsp.id;
		g_hospital.setGlobalData("patient_id", m_patient_id);
		$("#nav-tab-zhuyuanjilu").get(0).disabled = false;
	}
	function onUpdatePatientRet(rsp){
		//console.dir(rsp);
		if (rsp.ret != 0){
			alert("更新数据失败，请稍后再试");
			return;
		}
		alert("更新成功");
	}
	function setJibenZiliaoState(bSisabled){
		setAllControlDisabled($("#tab-jibenziliao"),bSisabled);
	}
	/////////////////////////////////////////////////////////////////////
	function initInputsByData(db_data){
		//console.dir(db_data);
		var data_json = getValuesByMapReverse(db_data, m_json_map);
		data_json["详细地址-不能提供"] = db_data["isSupply"]==0?1:0;
		//console.dir(data_json);
		var g_control_json = new control_json();
		g_control_json.setJson2Control($("#huanzhe-jibenziliao"), data_json);
		g_control_json.setJson2Control($("#lianxiren-jibenziliao"), db_data.relate_text);
	}
	////////////////////////////////////////////////////////////////////////
	function checkHuanzheInputValid(raw_json){
		var data_json   = arrayToJson(raw_json);
		var arr_errmsgs = [];
		checkValueValid(arr_errmsgs, data_json, "病案号",		"不能为空",		"请填写 病案号");
		checkValueValid(arr_errmsgs, data_json, "性别",			"不能为空", 	"请选择 性别");
		checkValueValid(arr_errmsgs, data_json, "姓名",			"不能为空", 	"请填写 患者姓名");
		checkValueValid(arr_errmsgs, data_json, "姓名",			"长度范围", 	"患者姓名 格式不正确，请重新填写", 2, 10);
		checkValueValid(arr_errmsgs, data_json, "民族",			"不能为空", 	"请选择 民族");
		checkValueValid(arr_errmsgs, data_json, "出生日期",		"不能为空", 	"请选择 出生日期");
		if(!data_json["详细地址-不能提供"]){
		checkValueValid(arr_errmsgs, data_json, "省份",		"不能为空", 	"请选择 省份");
		checkValueValid(arr_errmsgs, data_json, "城市",		"不能为空", 	"请选择 城市");
		checkValueValid(arr_errmsgs, data_json, "区县",		"不能为空", 	"请选择 区县");
		checkValueValid(arr_errmsgs, data_json, "详细地址",	"不能为空",		"请填写 详细地址");
		checkValueValid(arr_errmsgs, data_json, "详细地址",	"长度范围", 	"详细地址 格式不正确，请重新填写", 2, 100);
		}
		else{
		checkValueValid(arr_errmsgs, data_json, "详细地址-不能提供-原因",	"不能为空",		"请填写 详细地址不能提供的原因");
		checkValueValid(arr_errmsgs, data_json, "详细地址-不能提供-原因",	"长度范围",		"详细地址不能提供的原因 格式不正确，请重新填写", 2, 100);
		}
		if (arr_errmsgs.length > 0){
			showInputValueInvalid(arr_errmsgs[0]);
			return false;
		}
		return true;
	}
	function checkLianxirenInputValid(raw_json){
		var data_json   = arrayToJson(raw_json);
		var arr_errmsgs = [];

		checkValueValid(arr_errmsgs, data_json, "联系人姓名", "不能为空", "请填写 联系人姓名");
		checkValueValid(arr_errmsgs, data_json, "联系人姓名", "长度范围", "联系人姓名 格式不正确，请重新填写", 2, 10);
		if (!data_json["联系人电话-不能提供"]){
		checkValueValid(arr_errmsgs, data_json, "联系人电话", "不能为空", "请填写 联系人电话");
		checkValueValid(arr_errmsgs, data_json, "联系人电话", "电话号码", "联系人电话 格式不正确，请重新填写");
		}
		else{
		checkValueValid(arr_errmsgs, data_json, "联系人电话-不能提供-原因",	"不能为空", "请填写 联系人电话不能提供的原因");
		checkValueValid(arr_errmsgs, data_json, "联系人电话-不能提供-原因",	"长度范围", "联系人电话不能提供的原因 格式不正确，请重新填写", 2, 100);
		}
		if (!data_json["联系人电话(号码二)-不能提供"]){
		checkValueValid(arr_errmsgs, data_json, "联系人电话(号码二)", "不能为空", "请填写 联系人电话(号码二)");
		checkValueValid(arr_errmsgs, data_json, "联系人电话(号码二)",	"电话号码",	"联系人电话(号码二) 格式不正确，请重新填写");
		}
		if (!data_json["联系人电话(号码三)-不能提供"]){
		checkValueValid(arr_errmsgs, data_json, "联系人电话(号码三)", "不能为空", "请填写 联系人电话(号码三)");
		checkValueValid(arr_errmsgs, data_json, "联系人电话(号码三)",	"电话号码",	"联系人电话(号码三) 格式不正确，请重新填写");
		}
	
		if (arr_errmsgs.length > 0){
			showInputValueInvalid(arr_errmsgs[0]);
			return false;
		}
		return true;
	}

	function showInputValueInvalid(errormsg){
		showErrorMsg($("#tab-jibenziliao .errormsg"), errormsg);
	}
}

function queryZhuyuanjilu(){
	var m_zhuyuanjilu_query = null;
	this.init = function(){
		$('#nav-tab-zhuyuanjilu').on('shown.bs.tab', function (e) {
			m_patient_id = g_hospital.getGlobalData("patient_id");
			onQueryZhuyuanjilu();
		});
		var options = {
			"show_fields":["序号","入院日期","出院日期","手术日期","上传时间", "状态"],
			"operations":"详情,编辑,上传,删除",
			"table_wrapper":$("#zyjl-query-zyjl-table-wrapper"),
			"page_nav_wrapper":$("#zyjl-query-zyjl-nav")
		}
		m_zhuyuanjilu_query = new zhuyuanjilu_query();
		m_zhuyuanjilu_query.init(options);
	}
	this.showPage = function(){
		var patient_id = g_hospital.getGlobalData("patient_id");
		onQueryZhuyuanjilu(patient_id);
	}
	function onQueryZhuyuanjilu(patient_id){
		if (patient_id <= 0){
			return;
		}
		m_zhuyuanjilu_query.queryData({"patient_id":patient_id});
	}
}

function addZhuyuanjilu(){
	var m_zyjl_id = 0;
	var m_come_from = "";
	var m_json_map = [
		{"name":"入院日期","field":"hospitalization_in_time"},
		{"name":"出院日期","field":"hospitalization_out_time"},
		{"name":"手术日期","field":"operation_time"}
	];
	this.init = function(){
		$("#content-wrapper-add-zhuyuanjilu button[tag='zyjl-save']").click(function(){
			onZhuyuanjiluSave();
		})
		$("#content-wrapper-add-zhuyuanjilu button[tag='zyjl-upload']").click(function(){
			onUploadZhuyuanjilu();
		})
		$("#content-wrapper-add-zhuyuanjilu button[tag='zyjl-return']").click(function(){
			onZhuyuanjiluReturn();
		})
		initControlJwxzbch();
		$("#jibenziliao-section [json-name],#zhuyuanjilu-section [json-name]").on( "focus", function() {
			hideAllErrorMsgs();
		});
	}
	this.showPage = function(zyjl_data, come_from){
		if (typeof zyjl_data != "undefined" && zyjl_data){
			m_zyjl_id = zyjl_data["id"];
			initInputsByData(zyjl_data);
		}
		else{
			m_zyjl_id = 0;
			initInputsByDefault();
		}
		if (typeof come_from == "undefined"){
			m_come_from = "";
		}
		else{
			m_come_from = come_from;
		}
		g_hospital.setGlobalData("zyjl_id",m_zyjl_id);
		if (typeof zyjl_data != "undefined" && zyjl_data && zyjl_data["status"] == 2){
			setJibenZiliaoState(true);
		}
		else{
			setJibenZiliaoState(false);
		}
	}

	function onUploadZhuyuanjilu(){
		function onUploadZhuyuanjiluRet(rsp){
			if (rsp.ret != 0){
				alert("上传失败，请稍候再试");
				return false;
			}
			alert("上传成功");
			gotoZyjlList();
		}
		/////校验参数合法性
		if(!checkValidZhuyuanjilu()){
			return false;
		}
		ajaxRemoteRequest("hospital/set-records-status",{"ids":""+m_zyjl_id,"status":2},onUploadZhuyuanjiluRet);
	}

	this.onAddZhuyuanjilu = function(){
		setAllControlDisabled($("#content-wrapper-add-zhuyuanjilu"), false);
		showNavTab("zhuyuanjilu-section", "nav-tab-zyjl-riqi", "tab-zyjl-riqi");
		initInputsByDefault();
		$("#content-wrapper-add-jibenziliao").hide();
		$("#content-wrapper-add-zhuyuanjilu").show();
		m_come_from = "";
	}
	function initInputsByDefault(){
		initInputsByJson({
			operation_before_info:{
				"既往心脏病手术次数":"0"
			}
		});
	}
	
		
	function onZhuyuanjiluReturn(){
		if (m_come_from == ""){
			gotoZyjlList();
			return;
		}
		g_hospital.gotoPage(m_come_from);
	}
	function gotoZyjlList(){
		g_queryZhuyuanjilu.showPage(g_hospital.getGlobalData("patient_id"));
		showNavTab("jibenziliao-section", "nav-tab-zhuyuanjilu", "tab-zhuyuanjilu");
		$("#content-wrapper-add-jibenziliao").show();
		$("#content-wrapper-add-zhuyuanjilu").hide();
	}

	function getAllInputDatas(){
		var raw_json = {};
		var g_control_json = new control_json();
		raw_json = g_control_json.parseControlJson($("#tab-zyjl-riqi"));
		//console.dir(raw_json);
		/////////////////////////////////////////////////
		var data_json = getValuesByMap(raw_json, m_json_map);
		data_json["patient_id"] = g_hospital.getGlobalData("patient_id");
		data_json["hospitalization_in_time"] = strDateToTimestap(data_json["hospitalization_in_time"]);
		data_json["hospitalization_out_time"] = strDateToTimestap(data_json["hospitalization_out_time"]);
		data_json["operation_time"] = strDateToTimestap(data_json["operation_time"]);
		
		//console.dir(data_json);
		var raw_json_operation_before_info = g_control_json.parseControlJson($("#tab-zyjl-shuqianxinxi"));
		//console.dir(raw_json_operation_before_info);
		var data_json_operation_before_info = arrayToJson(raw_json_operation_before_info);
		data_json.operation_before_info = $.toJSON(data_json_operation_before_info);
		//console.dir(data_json_operation_before_info);

		var raw_json_operation_info = g_control_json.parseControlJson($("#tab-zyjl-shoushuxinxi"));
		//console.dir(raw_json_operation_info);
		var data_json_operation_info = arrayToJson(raw_json_operation_info);
		data_json.operation_info = $.toJSON(data_json_operation_info);
		//console.dir(data_json_operation_info);

		var raw_json_operation_after_info = g_control_json.parseControlJson($("#tab-zyjl-shuhouxinxi"));
		//console.dir(raw_json_operation_after_info);
		var data_json_operation_after_info = arrayToJson(raw_json_operation_after_info);
		data_json.operation_after_info = $.toJSON(data_json_operation_after_info);
		//console.dir(data_json_operation_after_info);

		var raw_json_hospitalization_out_info = g_control_json.parseControlJson($("#tab-zyjl-chuyuanziliao"));
		//console.dir(raw_json_hospitalization_out_info);
		var data_json_hospitalization_out_info = arrayToJson(raw_json_hospitalization_out_info);
		data_json.hospitalization_out_info = $.toJSON(data_json_hospitalization_out_info);
		//console.dir(data_json_hospitalization_out_info);
		return data_json;
	}
	function onZhuyuanjiluSave(){
		var data_json = getAllInputDatas();
		////////////////////////////////////////////////
		////检查参数合法性
		////////////////////////////////////////////////
		//发送插入请求
		if (m_zyjl_id > 0){
			data_json["id"] = m_zyjl_id;
			ajaxRemoteRequest("hospital/set-record-text",data_json,onUpdateZhuyuanjiluRet);
		}
		else{
			ajaxRemoteRequest("hospital/insert-record",data_json,onAddZhuyuanjiluRet);
		}	
	}
	function onUpdateZhuyuanjiluRet(rsp){
		console.dir(rsp);
		if (rsp.ret != 0){
			alert("更新数据失败，请稍后再试");
			return;
		}
		alert("更新成功");
	}

	function onAddZhuyuanjiluRet(rsp){
		//console.dir(rsp);
		if (rsp.ret != 0){
			alert("添加数据失败，请稍后再试");
			return;
		}
		alert("添加成功");
		g_operation_type = 3;
		m_zyjl_id = rsp.id;
		g_hospital.setGlobalData("zyjl_id",m_zyjl_id);
	}

	function initInputsByJson(data_json){
		data_json["入院日期"] = timestampToDateString(getJsonValue(data_json,"入院日期",''));
		data_json["出院日期"] = timestampToDateString(getJsonValue(data_json,"出院日期",''));
		data_json["手术日期"] = timestampToDateString(getJsonValue(data_json,"手术日期",''));
		data_json.operation_before_info = getJsonValue(data_json,"operation_before_info",{});
		data_json.operation_info = getJsonValue(data_json,"operation_info",{});
		data_json.operation_after_info = getJsonValue(data_json,"operation_after_info",{});
		data_json.hospitalization_out_info = getJsonValue(data_json,"hospitalization_out_info",{});
		//console.dir(data_json);
		var g_control_json = new control_json();
		g_control_json.setJson2Control($("#tab-zyjl-riqi"), data_json);
		g_control_json.setJson2Control($("#tab-zyjl-shuqianxinxi"), 	data_json.operation_before_info);
		g_control_json.setJson2Control($("#tab-zyjl-shoushuxinxi"), 	data_json.operation_info);
		g_control_json.setJson2Control($("#tab-zyjl-shuhouxinxi"), 		data_json.operation_after_info);
		g_control_json.setJson2Control($("#tab-zyjl-chuyuanziliao"), 	data_json.hospitalization_out_info);
	}
	function initInputsByData(db_data){
		//console.dir(db_data);
		var data_json = getValuesByMapReverse(db_data, m_json_map);
		data_json.operation_before_info = db_data.operation_before_info;
		data_json.operation_info = db_data.operation_info;
		data_json.operation_after_info = db_data.operation_after_info;
		data_json.hospitalization_out_info = db_data.hospitalization_out_info;
		initInputsByJson(data_json);
	}
	///////////////////////////////////////////////////////
	//既往心脏病手术次数
	function initControlJwxzbch(){
		$("#jyxzbcs-radio-wraper input[name='zyjl-jiwangxinzangbingcishu']").off('change').on("change", function(){
			var value = getRadioValue($("#jyxzbcs-radio-wraper"), 'zyjl-jiwangxinzangbingcishu');
			var i = 0;
			$("#jyxzbcs-wraper [tag='jyxzbcs']").each(function(){
				if (i >= value){
					$(this).hide();
				}
				else{
					$(this).show();
				}
				i++;
			})
		})
	}
	/////////////////////////////////
	function setJibenZiliaoState(bSisabled){
		setAllControlDisabled($("#content-wrapper-add-zhuyuanjilu"),bSisabled);
		var return_buttons = $("#content-wrapper-add-zhuyuanjilu button[tag='zyjl-return']");
		for (var i = 0; i < return_buttons.length; i++){
			return_buttons.get(i).disabled = false;
		}
	}
	//////////////////////////////////////////////////////////////////////////
	function showInputValueInvalid(err_msg){
		showErrorMsg($("#zhuyuanjilu-section .errormsg"), err_msg);
	}

	function checkValidRiqi(data_json){return [];
		var arr_errmsgs = [];
		if (data_json.hospitalization_in_time < 1000000){
			arr_errmsgs.push("请输入入院日期");
		}
		if (data_json.hospitalization_out_time < 1000000){
			arr_errmsgs.push("请输入出院日期");
		}
		if (data_json.operation_time < 1000000){
			arr_errmsgs.push("请输入手术日期");
		}
		if (data_json.hospitalization_in_time > data_json.hospitalization_out_time){
			arr_errmsgs.push("入院日期不能大于出院日期");
		}
		if (data_json.operation_time > data_json.hospitalization_out_time){
			arr_errmsgs.push("手术日期不能大于出院日期");
		}
		if (data_json.operation_time < data_json.hospitalization_in_time){
			arr_errmsgs.push("入院日期不能大于手术日期");
		}
		return arr_errmsgs;
	}
	function checkValidShuqianxinxi(data_json){
		var arr_errmsgs = [];
		var operation_before_info = operation_before_info.operation_before_info;
		for (var i = 1; i <= operation_before_info["既往心脏病手术次数"]; i++){
			if (operation_before_info["既往心脏病手术时间-不能提供-"+i] <= 0){
				checkValueValid(arr_errmsgs, data_json, "既往心脏病手术时间-"+i,		"不能为空",		"请填写 既往心脏病手术时间"+i);
			}
			if (operation_before_info["既往心脏病手术医院-不能提供-"+i] <= 0){
				checkValueValid(arr_errmsgs, data_json, "既往心脏病手术医院-"+i,		"不能为空",		"请填写 既往心脏病手术医院"+i);
			}
			if (operation_before_info["既往心脏病手术名称-不能提供-"+i] <= 0){
				checkValueValid(arr_errmsgs, data_json, "既往心脏病手术名称-"+i,		"不能为空",		"请填写 既往心脏病手术名称"+i);
			}
			
		}
		return arr_errmsgs;
	}
	
	function checkValidZhuyuanjilu(){
		var data_json = getAllInputDatas();
		var arr_errmsgs = checkValidRiqi(data_json);
		if (arr_errmsgs.length > 0){
			showInputValueInvalid(arr_errmsgs[0]);
			showNavTab("zhuyuanjilu-section", "nav-tab-zyjl-riqi", "tab-zyjl-riqi");
			return false;
		}
		var arr_errmsgs = checkValidShuqianxinxi(data_json);
		if (arr_errmsgs.length > 0){
			showInputValueInvalid(arr_errmsgs[0]);
			showNavTab("zhuyuanjilu-section", "nav-tab-zyjl-riqi", "tab-zyjl-shuqianxinxi");
			return false;
		}
		return false;
	}
}