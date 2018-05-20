function addPatient(){
	var m_patient_id = 0;
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
		{"name":"详细地址","field":"address"},
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
	}
	this.showPage = function(patient_data){
		if (typeof patient_data != "undefined"){
			m_patient_id = patient_data["id"];
			g_hospital.setGlobalData("patient_id", m_patient_id);
			initInputsByData(patient_data);
			$("#nav-tab-zhuyuanjilu").get(0).disabled = false;
		}
		else{
			m_patient_id = 0;
			$("#nav-tab-zhuyuanjilu").get(0).disabled = true;
		}
	}
	this.showPageZyjlList = function(patient_data){
		m_this.showPage(patient_data);
		g_queryZhuyuanjilu.showPage(m_patient_id);
	}
	function onAddZhuyuanjilu(){
		$("#content-wrapper-add-jibenziliao").hide();
		$("#content-wrapper-add-zhuyuanjilu").show();
	}
	function onJibenziliaoSave(){
		var raw_json = {};
		var g_control_json = new control_json();
		raw_json["患者基本资料"] = g_control_json.parseControlJson($("#huanzhe-jibenziliao"));
		raw_json["联系人基本资料"] = g_control_json.parseControlJson($("#lianxiren-jibenziliao"));
		console.dir(raw_json);
		/////////////////////////////////////////////////
		
		var data_json = getValuesByMap(raw_json["患者基本资料"], m_json_map);
		data_json["isSupply"] = data_json["isNotSupply"]?0:1;
		delete data_json["isNotSupply"];
		var data_json_lianxiren = arrayToJson(raw_json["联系人基本资料"]);
		data_json["relate_text"] = $.toJSON(data_json_lianxiren);
		console.dir(data_json);
		////////////////////////////////////////////////
		////检查参数合法性
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
		console.dir(rsp);
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
		console.dir(rsp);
		if (rsp.ret != 0){
			alert("更新数据失败，请稍后再试");
			return;
		}
		alert("更新成功");
	}
	/////////////////////////////////////////////////////////////////////
	function initInputsByData(db_data){
		console.dir(db_data);
		var data_json = getValuesByMapReverse(db_data, m_json_map);
		data_json["详细地址-不能提供"] = db_data["isSupply"]==0?1:0;
		console.dir(data_json);
		var g_control_json = new control_json();
		g_control_json.setJson2Control($("#huanzhe-jibenziliao"), data_json);
		g_control_json.setJson2Control($("#lianxiren-jibenziliao"), db_data.relate_text);
	}
	////////////////////////////////////////////////////////////////////////
}

function queryZhuyuanjilu(){
	var m_patient_id = 0;
	var m_zhuyuanjilu_query = null;
	this.init = function(){
		$('#nav-tab-zhuyuanjilu').on('shown.bs.tab', function (e) {
			m_patient_id = g_hospital.getGlobalData("patient_id");
			onQueryZhuyuanjilu(m_patient_id);
		});
		var options = {
			"show_fields":["序号","入院日期","出院日期","手术日期","上传时间", "状态"],
			"operations":"详情,编辑,删除",
			"table_wrapper":$("#zyjl-query-zyjl-table-wrapper"),
			"page_nav_wrapper":$("#zyjl-query-zyjl-nav")
		}
		m_zhuyuanjilu_query = new zhuyuanjilu_query();
		m_zhuyuanjilu_query.init(options);
	}
	this.showPage = function(patient_id){
		m_patient_id = patient_id;
		onQueryZhuyuanjilu(m_patient_id);
	}
	function onQueryZhuyuanjilu(patient_id){
		if (patient_id <= 0){
			return;
		}
		m_zhuyuanjilu_query.queryData({"patient_id":patient_id});
	}
}

function addZhuyuanjilu(){
	var m_patient_id = 0;
	var m_zyjl_id = 0;
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
		initControlJwxzbch();
	}
	this.showPage = function(zyjl_data){
		if (typeof zyjl_data != "undefined"){
			m_patient_id = zyjl_data["patient_id"];
			m_zyjl_id = zyjl_data["id"];
			initInputsByData(zyjl_data);
		}
		else{
			m_patient_id = 0;
			m_zyjl_id    = 0;
		}
		g_hospital.setGlobalData("patient_id",m_patient_id);
		g_hospital.setGlobalData("zyjl_id",m_zyjl_id);
	}

	function onZhuyuanjiluSave(){
		var raw_json = {};
		var g_control_json = new control_json();
		raw_json = g_control_json.parseControlJson($("#tab-zyjl-riqi"));
		console.dir(raw_json);
		/////////////////////////////////////////////////
		var data_json = getValuesByMap(raw_json, m_json_map);
		data_json["patient_id"] = g_hospital.getGlobalData("patient_id");
		data_json["hospitalization_in_time"] = strDateToTimestap(data_json["hospitalization_in_time"]);
		data_json["hospitalization_out_time"] = strDateToTimestap(data_json["hospitalization_out_time"]);
		data_json["operation_time"] = strDateToTimestap(data_json["operation_time"]);
		
		console.dir(data_json);
		var raw_json_operation_before_info = g_control_json.parseControlJson($("#tab-zyjl-shuqianxinxi"));
		console.dir(raw_json_operation_before_info);
		var data_json_operation_before_info = arrayToJson(raw_json_operation_before_info);
		data_json.operation_before_info = $.toJSON(data_json_operation_before_info);
		console.dir(data_json_operation_before_info);

		var raw_json_operation_info = g_control_json.parseControlJson($("#tab-zyjl-shoushuxinxi"));
		console.dir(raw_json_operation_info);
		var data_json_operation_info = arrayToJson(raw_json_operation_info);
		data_json.operation_info = $.toJSON(data_json_operation_info);
		console.dir(data_json_operation_info);

		var raw_json_operation_after_info = g_control_json.parseControlJson($("#tab-zyjl-shuhouxinxi"));
		console.dir(raw_json_operation_after_info);
		var data_json_operation_after_info = arrayToJson(raw_json_operation_after_info);
		data_json.operation_after_info = $.toJSON(data_json_operation_after_info);
		console.dir(data_json_operation_after_info);

		var raw_json_hospitalization_out_info = g_control_json.parseControlJson($("#tab-zyjl-chuyuanziliao"));
		console.dir(raw_json_hospitalization_out_info);
		var data_json_hospitalization_out_info = arrayToJson(raw_json_hospitalization_out_info);
		data_json.hospitalization_out_info = $.toJSON(data_json_hospitalization_out_info);
		console.dir(data_json_hospitalization_out_info);
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
		console.dir(rsp);
		if (rsp.ret != 0){
			alert("添加数据失败，请稍后再试");
			return;
		}
		alert("添加成功");
		g_operation_type = 3;
		m_zyjl_id = rsp.id;
	}

	function initInputsByData(db_data){
		console.dir(db_data);
		var data_json = getValuesByMapReverse(db_data, m_json_map);
		data_json["入院日期"] = timestampToDateString(data_json["入院日期"]);
		data_json["出院日期"] = timestampToDateString(data_json["出院日期"]);
		data_json["手术日期"] = timestampToDateString(data_json["手术日期"]);
		console.dir(data_json);
		var g_control_json = new control_json();
		g_control_json.setJson2Control($("#tab-zyjl-riqi"), data_json);
		g_control_json.setJson2Control($("#tab-zyjl-shuqianxinxi"), 	db_data.operation_before_info);
		g_control_json.setJson2Control($("#tab-zyjl-shoushuxinxi"), 	db_data.operation_info);
		g_control_json.setJson2Control($("#tab-zyjl-shuhouxinxi"), 		db_data.operation_after_info);
		g_control_json.setJson2Control($("#tab-zyjl-chuyuanziliao"), 	db_data.hospitalization_out_info);
	}
	///////////////////////////////////////////////////////
	//既往心脏病手术次数
	function initControlJwxzbch(){
		$("#jyxzbcs-radio-wraper input[name='zyjl-jiwangxinzangbingcishu']").off('click').on("change", function(){
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
}