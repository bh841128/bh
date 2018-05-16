function control_json(){
    /////扫码节点下所有的json
    this.parseControlJson = function(selector){
        var input_values = [];
        selector.find("[json-name]").each(function(){
            var json_name = $(this).attr("json-name");
            var json_value = getInputValue($(this));
            if (json_value == null){
                return;
            }
            input_values.push({"json_name":json_name,"json_value":json_value});
        })
        
        return input_values;
    }

    /////将json值赋给节点
    this.setJson2Control = function(selector, json){
        
    }

    /////////////////////////////////////////////////////////////////
    function getInputValue(control){
        var tagName = control.prop('tagName');
        if (tagName == "SELECT"){
            return control.val();
        }
        if (tagName == "INPUT"){
            var inputType = control.attr("type");
            if (inputType == "text"){
                return control.val();
            }
            if (inputType == "radio" || inputType == "checkbox"){
                if(!control.get(0).checked){
                    return null;
                }
                return control.get(0).value;
            }
        }
        return null;
    }
    function setInputValue(control,value){
        var tagName = control.prop('tagName');
        if (tagName == "SELECT"){
            selectSelectByValue(control,value);
            return;
        }
        if (tagName == "INPUT"){
            var inputType = control.attr("type");
            if (inputType == "text"){
                control.val(value);
                return;
            }
        }
    }
    /////////////////////////////////////////////////////////////////////////
}

function getValueByJsonName(jsonArrs, jsonName, defaultValue){
	for (var i = 0; i < jsonArrs.length; i++){
		if (jsonArrs[i]["json_name"] == jsonName){
			return jsonArrs[i]["json_value"];
		}
	}
	if (typeof defaultValue != "undefined"){
		return defaultValue;
	}
	return null;
}

function getValuesByMap(raw_json, json_map){
    var data_json = {};
    for (var i = 0; i < json_map.length; i++){
        if (typeof json_map[i]["default_value"] != "undefined"){
            data_json[json_map[i]["field"]] = getValueByJsonName(raw_json,json_map[i]["name"],json_map[i]["default_value"]);
        }
        else{
            data_json[json_map[i]["field"]] = getValueByJsonName(raw_json,json_map[i]["name"]);
        }
    }
    return data_json;
}