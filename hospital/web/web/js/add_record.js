function addPatient(){
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
		
		if (g_patient_id > 0){
			if (g_operation_type > 0){
				initPatientData(g_patient_id);
			}
		}
	}
	function onAddZhuyuanjilu(){
		$("#content-add").hide();
		$("#content-zyjl").show();
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
		if (g_patient_id > 0){
			data_json["id"] = g_patient_id;
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
		g_patient_id = rsp.id;
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
	function initPatientData(patient_id){
		function onGetPatientDataRet(rsp){
			if (rsp.ret != 0){
				g_patient_id = 0;
				alert("读取数据失败，请稍候再试");
				return;
			}
			var db_data = rsp.msg;
			if (db_data.relate_text == ""){
				db_data.relate_text = {};
			}
			else {
				try {
					db_data.relate_text = eval('(' + db_data.relate_text + ')');
				}
				catch (err) {
					db_data.relate_text = {};
				}
			}
			initInputsByData(db_data);
			if (g_operation_type == 2 || g_operation_type == 3){
				onAddZhuyuanjilu();
			}
		}
		ajaxRemoteRequest("hospital/get-patient",{id:patient_id},onGetPatientDataRet);
	}
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
	this.init = function(){
		initZhuyuanjilu();
	}
	function initZhuyuanjilu(){
		function onQueryZhuyuanjilu(){
			if (g_patient_id <= 0){
				return;
			}
			g_zhuyuanjilu_query.queryData({"patient_id":g_patient_id});
		}

		$('#nav-tab-zhuyuanjilu').on('shown.bs.tab', function (e) {
			onQueryZhuyuanjilu();
		});
		var options = {
            "show_fields":["序号","入院日期","出院日期","手术日期","上传时间", "状态"],
            "operations":"详情,编辑,删除",
            "table_wrapper":$("#query-table-wrapper"),
			"page_nav_wrapper":$("#query-page-nav"),
			"patient_id":g_patient_id
		}
		var g_zhuyuanjilu_query = new zhuyuanjilu_query();
		g_zhuyuanjilu_query.init(options);
		
		onQueryZhuyuanjilu();
	}
}

function addZhuyuanjilu(){
	var m_json_map = [
		{"name":"入院日期","field":"hospitalization_in_time"},
		{"name":"出院日期","field":"hospitalization_out_time"},
		{"name":"手术日期","field":"operation_time"}
	];
	this.init = function(){
		$("#zyjl-wraper button[tag='zyjl-save']").click(function(){
			onZhuyuanjiluSave();
		})
		$("#zyjl-wraper button[tag='zyjl-upload']").click(function(){
			onUploadZhuyuanjilu();
		})
		initControlJwxzbch();
		
		if (g_patient_id > 0 && g_zyjl_id > 0){
			if (g_operation_type == 3){
				initZhuyuanjiluData(g_zyjl_id);
			}
		}
	}

	function onZhuyuanjiluSave(){
		var raw_json = {};
		var g_control_json = new control_json();
		raw_json = g_control_json.parseControlJson($("#tab-zyjl-riqi"));
		console.dir(raw_json);
		/////////////////////////////////////////////////
		var data_json = getValuesByMap(raw_json, m_json_map);
		data_json["patient_id"] = g_patient_id;
		data_json["hospitalization_in_time"] = strDateToTimestap(data_json["hospitalization_in_time"]);
		data_json["hospitalization_out_time"] = strDateToTimestap(data_json["hospitalization_out_time"]);
		data_json["operation_time"] = strDateToTimestap(data_json["operation_time"]);
		
		console.dir(data_json);
		var raw_json_operation_before_info = g_control_json.parseControlJson($("#tab-zyjl-shuqianxinxi"));
		console.dir(raw_json_operation_before_info);
		var data_json_operation_before_info = arrayToJson(raw_json_operation_before_info);
		data_json.raw_json_operation_before_info = $.toJSON(data_json_operation_before_info);
		console.dir(data_json_operation_before_info);
		////////////////////////////////////////////////
		////检查参数合法性
		////////////////////////////////////////////////
		//发送插入请求
		if (g_zyjl_id > 0){
			data_json["id"] = g_zyjl_id;
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
		g_zyjl_id = rsp.id;
	}

	function initZhuyuanjiluData(zyjl_id){
		function onGetZhuyuanjiluDataRet(rsp){
			if (rsp.ret != 0){
				g_patient_id = 0;
				alert("读取数据失败，请稍候再试");
				return;
			}
			var db_data = rsp.msg;
			if (db_data.operation_before_info == ""){
				db_data.operation_before_info = {};
			}
			else {
				try {
					db_data.operation_before_info = eval('(' + db_data.operation_before_info + ')');
				}
				catch (err) {
					db_data.operation_before_info = {};
				}
			}
			initInputsByData(db_data);
		}
		ajaxRemoteRequest("hospital/get-record",{id:zyjl_id},onGetZhuyuanjiluDataRet);
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
		g_control_json.setJson2Control($("#tab-zyjl-shuqianxinxi"), db_data.operation_before_info);
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