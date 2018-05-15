function control_json(){
    /////扫码节点下所有的json
    this.parseControlJson = function(selector){
        var input_values = [];
        selector.find("[json-name]").each(function(){
            var json_name = $(this).attr("json-name");
            var json_value = getInputValue($(this));
            var input_value = {"json_name":json_name,"json_value":json_value};
            input_values.push(input_value);
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
        }
        return "";
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
}