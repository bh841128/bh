function addRecord(){
	this.init = function(){
		$("#add-zhuyuanjilu").click(function(){
			$("#content-add").hide();
			$("#content-zyjl").show();
		})
		$("#tab-jibenziliao button[tag='jibenziliao-baocun']").click(function(){
			onJibenziliaoSave();
		})
	}
	function onJibenziliaoSave(){
		var raw_json = {};
		var g_control_json = new control_json();
		raw_json["患者基本资料"] = g_control_json.parseControlJson($("#huanzhe-jibenziliao"));
		raw_json["联系人基本资料"] = g_control_json.parseControlJson($("#lianxiren-jibenziliao"));
		console.dir(raw_json);
		/////////////////////////////////////////////////
		var data_json = {};
		var json_map = {
			"medical_id":"病案号",
			"sexy":"性别",
			"name":"姓名",
			"nation":"民族",
			"isSupply":"详细地址-不能提供",
			"reason":"详细地址-不能提供-原因",
			"province":"省份",
			"city":"城市",
			"district":"区县",
			"address":"详细地址",
		};
		for (var data_name in json_map){
			data_json[data_name] = getValueByJsonName(raw_json["患者基本资料"],json_map[data_name]);
		}
		var data_json_lianxiren = {"a":100};
		data_json["relate_text"] = $.toJSON(data_json_lianxiren);
		console.dir(data_json);
		////////////////////////////////////////////////
		////检查参数合法性
		////////////////////////////////////////////////
		//发送插入请求
	}
}