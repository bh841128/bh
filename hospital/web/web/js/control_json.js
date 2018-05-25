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
        selector.find("[json-name]").each(function(){
            var json_name = $(this).attr("json-name");
            var value = "";
            if (typeof json == "undefined" || !json || typeof json[json_name] == "undefined" || !json[json_name]){
                value = "";
            }
            else{
                value = json[json_name];
            }
            setInputValue($(this),value);
        })
    }

    /////////////////////////////////////////////////////////////////
    function getInputValue(control){
        function getInputValueInner(){
            if (isSelectModal(control)){
                return getSelectModalValue(control);
            }
            var tagName = control.prop('tagName');
            if (tagName == "SELECT"){
                return control.val();
            }
            if (tagName == "INPUT"){
                var inputType = control.attr("type");
                if (inputType == "text"){
                    return control.val();
                }
                if (inputType == "radio"){
                    if(!control.get(0).checked){
                        return null;
                    }
                    var value = control.get(0).value;
                    if (value.match(/^[1-9][0-9]*$/) || value=="0"){
                        return parseInt(value);
                    }
                    return value;
                }
                if (inputType == "checkbox"){
                    if(!control.get(0).checked){
                        return 0;
                    }
                    return 1;
                }
            }
            return null;
        }
        var value = getInputValueInner();
        if (value == null || value == ""){
            return value;
        }
        var json_type = control.attr("json_type");
        if (json_type && json_type != "number_int"){
            value = parseInt(value);
        }
        
        return value;
    }
    function setInputValue(control,value){
        if (isSelectModal(control)){
            setSelectModalValue(control, value);
            return;
        }
        var tagName = control.prop('tagName');
        if (tagName == "SELECT"){
            selectSelectByValue(control,value);
            var tag = control.attr("tag");
            if (!tag){
                return;
            }
            if (tag == "address-shengfen" || tag == "address-chengshi"){
                control.trigger( "change" );
            }
            return;
        }
        if (tagName == "INPUT"){
            var inputType = control.attr("type");
            if (inputType == "text"){
                control.val(value);
                return;
            }
            if (inputType == "checkbox"){
                setCheckboxChecked(control.get(0),value);
                control.trigger( "change" );
                return;
            }
            if (inputType == "radio"){
                if (control.val() == value){
                    setRadioChecked(control.get(0));
                    control.trigger( "change" );
                }
                
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

function getValueByJsonKey(json, key, defaultValue){
    if (typeof json[key] == "undefined"){
        if (typeof defaultValue != "undefined"){
            return defaultValue;
        }
        return null;
    }
	return json[key];
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

function getValuesByMapReverse(raw_json, json_map){
    var data_json = {};
    for (var i = 0; i < json_map.length; i++){
        if (typeof json_map[i]["default_value"] != "undefined"){
            data_json[json_map[i]["name"]] = getValueByJsonKey(raw_json,json_map[i]["field"],json_map[i]["default_value"]);
        }
        else{
            data_json[json_map[i]["name"]] = getValueByJsonKey(raw_json,json_map[i]["field"]);
        }
    }
    return data_json;
}

function arrayToJson(raw_json){
    var data_json = {};
    for (var i = 0; i < raw_json.length; i++){
        data_json[raw_json[i]["json_name"]] = raw_json[i]["json_value"];
    }
    return data_json;
}