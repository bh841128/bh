function addRecord(){
	var m_patient_id = 0;
	var m_operation_type = 0;
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

	this.init = function(patient_id, operation_type){
		m_patient_id = patient_id;
		m_operation_type = operation_type;
		$("#add-zhuyuanjilu").click(function(){
			$("#content-add").hide();
			$("#content-zyjl").show();
		})
		$("#tab-jibenziliao button[tag='jibenziliao-baocun']").click(function(){
			onJibenziliaoSave();
		})
		if (m_patient_id > 0){
			if (m_operation_type == 1){
				initPatientData(m_patient_id);
			}
		}
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
		ajaxRemoteRequest("hospital/insert-patient",data_json,onAddRecordRet);
	}
	function onAddRecordRet(rsp){
		console.dir(rsp);
		if (rsp.ret != 0){
			alert("添加数据失败，请稍后再试");
			reutrn;
		}
		m_operation_type = 1;
		//m_patient_id = rsp.id;
	}
	/////////////////////////////////////////////////////////////////////
	function initPatientData(patient_id){
		function onGetPatientDataRet(rsp){
			if (rsp.ret != 0){
				m_patient_id = 0;
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
}