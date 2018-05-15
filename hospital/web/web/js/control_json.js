function control_json(){
    /////扫码节点下所有的json
    this.parseControlJson = function(selector){
        var input_values = [];
        selector.find("input[json-name]").each(function(){
            var json_name = $(this).attr("json-name");
            var json_value = getInputValue($(this));
            var input_value = {"json-name":json_name,"json_value":json_value};
            input_values.push(input_value);
        })
        console.dir(input_values);
        return input_values;
    }

    /////将json值赋给节点
    this.setJson2Control = function(selector, json){

    }

    /////////////////////////////////////////////////////////////////
    function getInputValue(control){
        return "";
    }
}