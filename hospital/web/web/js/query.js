function patient_query(){
    var m_this = this;
    //"序号","病案号","姓名","性别", "出生日期", "联系人", "联系电话", "医院", "上传时间", "状态", "--操作,删除"
    this.map_showname_name = {
        "序号":"id",
        "病案号":"medical_id",
        "姓名":"name",
        "性别":"sexy",
        "出生日期":"birthday",
        "联系人":"relate_text.姓名",
        "联系电话":"relate_text.联系人电话",
        "医院":"hospital_id",
        "上传时间":"uploadtime",
        "状态":"status"
    }
    
    this.query_patient = function(query_param, callback){
        function queryPatientRet(rsp){
            console.dir(rsp);
            callback(rsp);
        }
        if (typeof query_param["page"] == "undefined"){
            query_param["page"] = 0;
        }
        if (typeof query_param["size"] == "undefined"){
            query_param["size"] = 2;
        }
        
        ajaxRemoteRequest("hospital/get-patient-list",query_param,queryPatientRet);
    }

    function fillPageNav(total_num, page_size, cur_page, page_nav_wrapper){

    }
    function getJsonValueByShowname(json, show_name){
        if (typeof m_this.map_showname_name[show_name] == "undefined"){
            return "";
        }
        var field_name = m_this.map_showname_name[show_name];
        var field_names = field_name.split(".");
        var value = json;
        for (var i = 0; i < field_names.length; i++){
            if (typeof value[field_names[i]] == "undefined"){
                return "";
            }
            value = value[field_names[i]];
        }
        if (typeof value == "undefined"){
            return "";
        }
        return value;
    }
    function getTableShowData(data, show_fields){
        var table_datas = [];
        for (var i = 0; i < data.length; i++){
            try{
                data[i]["relate_text"] = eval('('+data[i]["relate_text"]+')');
            }
            catch (err) {
                data[i]["relate_text"] = {};
            }
            
            var table_data = {};
            for (var f = 0; f < show_fields.length; f++){
                var show_name = show_fields[f];
                table_data[show_name] = getJsonValueByShowname(data[i], show_name);
            }
            if (typeof data[i]["id"] != "undefined"){
                table_data["id"] = data[i]["id"];
            }
            
            table_datas.push(table_data);
        }
        return table_datas;
    }
    function getOpertionHtml(data, operations){
        return '<button type="button" class="btn btn-link">删除</button>';
    }
    function getTableHtml(table_datas, options){
        var table_html = '<table class="table table-bordered table-hover table-center table-query" style="text-align:center">';
        table_html += '<thead><tr>';
        for (var i = 0; i < options.show_fields.length; i++){
            table_html += '<th>'+options.show_fields[i]+'</th>';
        }
        if (typeof options.operations != ""){
            table_html += '<th>操作</th>';
        }
        table_html += '</tr></thead>';
        table_html += '<tbody>';
        for (var d = 0; d < table_datas.length; d++){
            var data = table_datas[d];
            var record_html = '<tr>';
            for (var i = 0; i < options.show_fields.length; i++){
                var show_field = options.show_fields[i];
                record_html += '<td>'+data[show_field]+'</td>';
            }
            if (typeof options.operations != ""){
                record_html += '<td>'+getOpertionHtml(data,options.operations) +'</td>';
            }
            record_html += '</tr>';
            table_html += record_html;
        }
        table_html += '</tbody>';
        table_html += '</table>'
        return table_html;
    }
    function getHospitalName(hospital_id){
        var hospitals = [
            {"name":"中国医学科学院阜外医院","id":"1"},
            {"name":"上海交通大学医学院附属上海儿童医学中心","id":"2"},
            {"name":"复旦大学附属儿科医院","id":"3"},
            {"name":"中南大学湘雅二医院","id":"4"},
            {"name":"南京市儿童医院","id":"5"},
            {"name":"青岛市妇女儿童医院","id":"6"},
            {"name":"河南省人民医院","id":"7"},
            {"name":"广州市妇女儿童医疗中心","id":"8"},
            {"name":"中国人民解放军第四军医大学第一附属医院","id":"9"},
            {"name":"中国人民解放军第三军医大学","id":"10"}
        ];
        for (var i = 0; i < hospitals.length; i++){
            if (hospitals[i]["id"] == hospital_id){
                return hospitals[i]["name"];
            }
        }
        return ""+hospital_id;
    }
    function getStatusName(status){
        var status_map = [
            {"name":"正常","id":"1"},
            {"name":"上传","id":"2"},
            {"name":"删除","id":"3"}
        ];
        for (var i = 0; i < status_map.length; i++){
            if (status_map[i]["id"] == status){
                return status_map[i]["name"];
            }
        }
        return ""+status;
    }
    this.fillTable = function(datas, options, table_wrapper, page_nav_wrapper){
        var table_datas = getTableShowData(datas, options.show_fields);
        for (var i = 0; i < table_datas.length; i++){
            table_datas[i]["医院"] = getHospitalName(table_datas[i]["医院"]);
            table_datas[i]["状态"] = getStatusName(table_datas[i]["状态"]);
        }
        console.dir(table_datas);
        var table_html = getTableHtml(table_datas, options);
        table_wrapper.html(table_html);
        if (page_nav_wrapper){
            fillPageNav(options.total_num, options.page_size, options.cur_page, page_nav_wrapper);
        }
    }
}
