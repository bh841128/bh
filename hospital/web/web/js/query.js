function patient_query() {
    var m_this = this;
    this.m_options = {};
    this.m_data = {};
    this.m_query_param = {};

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////业务相关
    //"序号","病案号","姓名","性别", "出生日期", "联系人", "联系电话", "医院", "上传时间", "状态", "--操作,删除"
    this.map_showname_name = {
        "序号": "id",
        "病案号": "medical_id",
        "姓名": "name",
        "性别": "sexy",
        "出生日期": "birthday",
        "联系人": "relate_text.姓名",
        "联系电话": "relate_text.联系人电话",
        "医院": "hospital_id",
        "上传时间": "uploadtime",
        "状态": "status"
    }
    this.map_query_param = [
        {"name":"姓名","field":"name"},
        {"name":"病案号","field":"medical_id"},
        {"name":"性别","field":"sexy"},
        {"name":"联系人","field":"relate_name"},
        {"name":"联系电话","field":"relate_iphone"},
        {"name":"上传时间-开始","field":"start_time"},
        {"name":"上传时间-结束","field":"end_time"},
        {"name":"状态","field":"status"}
    ]
    this.m_query_data_api = "hospital/get-patient-list";
    this.preProcessData = function(rawDatas) {
        for (var i = 0; i < rawDatas.length; i++) {
            try {
                rawDatas[i]["relate_text"] = eval('(' + rawDatas[i]["relate_text"] + ')');
            }
            catch (err) {
                rawDatas[i]["relate_text"] = {};
            }
        }
    }
    this.transData = function(table_datas) {
        for (var i = 0; i < table_datas.length; i++) {
            table_datas[i]["医院"] = getHospitalName(table_datas[i]["医院"]);
            table_datas[i]["状态"] = getStatusName(table_datas[i]["状态"]);
            table_datas[i]["上传时间"] = timestampToString(table_datas[i]["上传时间"]);
            table_datas[i]["性别"] = getXingbieName(table_datas[i]["性别"]);
        }
    }
    this.onOperationClick = function(operationType, dataId){
        function onOperationRet(rsp){
            if (rsp.ret != 0){
                alert("操作失败，请稍后再试");
                return;
            }
            queryPageData(m_this.m_query_param.size, m_this.m_query_param.page);
        }
        function onEditPatientInfoRet(ret_info){
            if (ret_info.ret != 0){
                alert("读取数据错误，请稍候再试");
                return;
            }
        }
        if (operationType == "删除"){
            ajaxRemoteRequest("hospital/set-patients-status", {"ids":dataId+"","status":3}, onOperationRet);
            return;
        }
        if (operationType == "编辑"){
            g_hospital.onEditPatientInfo(dataId,onEditPatientInfoRet);
            return;
        }
    }
    ///////////////////
    function getStatusName(status) {
        var status_map = [
            { "name": "未上传", "id": "1" },
            { "name": "上传", "id": "2" },
            { "name": "删除", "id": "3" }
        ];
        for (var i = 0; i < status_map.length; i++) {
            if (status_map[i]["id"] == status) {
                return status_map[i]["name"];
            }
        }
        return "" + status;
    }
    function getXingbieName(xingbie) {
        var xingbie_map = [
            { "name": "男", "id": "1" },
            { "name": "女", "id": "2" }
        ];
        for (var i = 0; i < xingbie_map.length; i++) {
            if (xingbie_map[i]["id"] == xingbie) {
                return xingbie_map[i]["name"];
            }
        }
        return "" + xingbie;
    }
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //接口
    this.init = function (options) {
        m_this.m_options = options;
        if (typeof m_this.m_options["nav_page_num"] == "undefined") {
            m_this.m_options["nav_page_num"] = 7;
        }
        initPageNav(m_this.m_options.page_nav_wrapper, m_this.m_options);
    }
    this.queryData = function (query_param) {
        function queryDataRet(rsp) {
            
            console.dir(rsp);
            if (rsp.ret != 0 && rsp.ret != 2) {
                alert("拉取数据错误，请稍候重试");
                return;
            }
            if (rsp.ret == 2) {
                m_this.m_data.records = [];
                m_this.m_data.page_size = query_param.size;
                m_this.m_data.cur_page = 1;
                m_this.m_data.total_num = 0;
                //alert("没有数据");
            }
            else{
                m_this.m_data.page_size = query_param.size;
                m_this.m_data.cur_page = parseInt(rsp.page);
                m_this.m_data.total_num = parseInt(rsp.total);
                m_this.m_data.records = rsp.msg;
            }

            fillTable(m_this.m_data, m_this.m_options);
        }

        if (typeof query_param["page"] == "undefined") {
            query_param["page"] = 1;
        }
        if (typeof query_param["size"] == "undefined") {
            query_param["size"] = 10;
        }
        m_this.m_query_param = query_param;

        ajaxRemoteRequest(m_this.m_query_data_api, m_this.m_query_param, queryDataRet);
    }
    function queryPageData(page_size, pageGo){
        m_this.m_query_param.page = pageGo;
        m_this.m_query_param.size = page_size;
        m_this.queryData(m_this.m_query_param);
    }
    this.parseQueryParam = function(params_input_wrapper){
        var raw_json = {};
		var g_control_json = new control_json();
        raw_json = g_control_json.parseControlJson(params_input_wrapper);
        var json_map = m_this.map_query_param;
        var query_json_tmp = getValuesByMap(raw_json, json_map);
        var query_json = {};
        for (var x in query_json_tmp){
            if (query_json_tmp[x] == null || query_json_tmp[x] == ""){
                continue;
            }
            query_json[x] = query_json_tmp[x];
        }
        if (typeof query_json["start_time"] != "undefined"){
            query_json["start_time"] = strDateToTimestap(query_json["start_time"]);
        }
        if (typeof query_json["end_time"] != "undefined"){
            query_json["end_time"] = strDateToTimestap(query_json["end_time"]);
        }
        console.dir(query_json);
        return query_json;
    }
    ////////////////////////////////////////////////////////////////////////////////////////////
    function initPageNav(page_nav_wrapper, options) {
        var navHtml = '<ul class="pagination">' +
            '<li class="page-item nav-page-total" tag="total_num"><a class="page-link" href="#">共条</a></li>' +
            '<li class="page-item" tag="goto_page_input"><div style="position:relative;float:left;margin-left:5px;"><div class="input-group"><input type="text" class="form-control" style="width:50px"></div></li>' +
            '<li class="page-item" tag="goto_page_button"><a class="page-link" href="#">跳转</a></li>' +
            '<li class="page-item" tag="goto_page_first"><a class="page-link" href="#" style="margin-left:5px">首页</a></li>' +
            '<li class="page-item" tag="goto_page_prev"><a class="page-link" href="#" style="margin-left:5px">&lt;</a></li>';
        for (var i = 0; i < options.nav_page_num; i++) {
            navHtml += '<li class="page-item" tag="page_page" page-index="'+i+'"><a class="page-link" href="#" style="margin-left:5px">' + (i + 1) + '</a></li>';
        }
        navHtml += '<li class="page-item" tag="goto_page_next"><a class="page-link" href="#" style="margin-left:5px">&gt;</a></li>' +
            '<li class="page-item" tag="goto_page_last"><a class="page-link" href="#" style="margin-left:5px">尾页</a></li>' +
            '<li class="page-item nav-page-total" tag="total_page"><a class="page-link" href="#" style="margin-left:5px">共页</a></li>' +
            '</ul>';
        page_nav_wrapper.html(navHtml);
    }
    function updatePageNav(total_num, page_size, cur_page, page_nav_wrapper) {
        var total_page = 0;
        if (total_num > 0) {
            total_page = Math.ceil(total_num / page_size);
        }
        if (total_page <= 1){
            total_page = 1;
        }
        page_nav_wrapper.find("[tag='total_num'] a").html('共' + total_num + '条');
        page_nav_wrapper.find("[tag='total_page'] a").html('共' + total_page + '页');

        var max_show_page = page_nav_wrapper.find("[tag='page_page']").length;
        var show_pages = [];
        if (total_page <= max_show_page){
            for (var i = 1; i <= total_page; i++){
                show_pages.push(i);
            }
        }
        else{
            var seed_page = cur_page;
            if (seed_page <= 1){
                seed_page = 1;
            }
            if (seed_page > total_page){
                seed_page = total_page;
            }
            
            var cur_show_page_num = 1;
            var seed_page_left  = seed_page;
            var seed_page_right = seed_page;
            while (seed_page_right - seed_page_left + 1 < max_show_page){
                if (seed_page_left > 1){
                    seed_page_left--;
                    cur_show_page_num++;
                }
                if (seed_page_right < total_page){
                    seed_page_right++;
                    cur_show_page_num++;
                }
            }
    
            var show_pages_2 = [];
            if (seed_page_left > 1){
                show_pages.push(1);
                seed_page_left++;
                show_pages.push("...");
                seed_page_left++;
            }
            if (seed_page_right < total_page){
                show_pages_2.push("...");
                seed_page_right--;
                show_pages_2.push(total_page);
                seed_page_right--;
            }
            for (var i = seed_page_left; i <= seed_page_right; i++){
                show_pages.push(i);
            }
            for (var i = 0; i < show_pages_2.length; i++){
                show_pages.push(show_pages_2[i]);
            }
        }
        
        for (var i = 0; i < show_pages.length; i++){
            var page = show_pages[i];
            var page_item = page_nav_wrapper.find("[page-index='"+i+"']")
            page_item.removeClass("page-nav-dot");
            page_item.removeClass("page-nav-cur");
            if (page == "..."){
                page_item.addClass("page-nav-dot");
            }
            else if (page == cur_page){
                page_item.addClass("page-nav-cur");
            }
            else{
                page_item.attr("show-page-no", page);
            }
            
            page_item.find("a").html(page);
            page_item.show();
        }

        for (var i = show_pages.length; i < max_show_page; i++){
            page_nav_wrapper.find("[page-index='"+i+"']").hide();
        }

        page_nav_wrapper.find("li[tag]").each(function(){
            var tag = $(this).attr("tag");
            var pageGo = $(this).attr("show-page-no");
            $(this).find("a").off('click').on("click", function(){
                if (tag == "page_page"){
                    if (!pageGo || pageGo == cur_page){
                        return false;
                    }
                    queryPageData(page_size, pageGo);
                }
                if (tag == "goto_page_prev"){
                    if (cur_page <= 1){
                        return false;
                    }
                    queryPageData(page_size, cur_page - 1);
                    return false;
                }
                if (tag == "goto_page_next"){
                    if (cur_page >= total_page){
                        return false;
                    }
                    queryPageData(page_size, cur_page + 1);
                    return false;
                }
                if (tag == "goto_page_first"){
                    if (cur_page == 1){
                        return false;
                    }
                    queryPageData(page_size, 1);
                    return false;
                }
                if (tag == "goto_page_last"){
                    if (cur_page == total_page){
                        return false;
                    }
                    queryPageData(page_size, total_page);
                    return false;
                }
                if (tag == "goto_page_button"){
                    var gotoPage = parseInt(page_nav_wrapper.find("[tag='goto_page_input'] input").val());
                    if (isNaN(gotoPage) || gotoPage == cur_page || gotoPage <= 0 || gotoPage > total_page){
                        return false;
                    }
                    queryPageData(page_size, gotoPage);
                    return false;
                }
                return false;
            })
        })
    }
    function fillTable(data, options) {
        m_this.preProcessData(data.records);
        var table_datas = getTableShowData(data.records, options.show_fields);
        m_this.transData(table_datas);
        console.dir(table_datas);
        var table_html = getTableHtml(table_datas, options);
        options.table_wrapper.html(table_html);
        if (options.page_nav_wrapper) {
            updatePageNav(data.total_num, data.page_size, data.cur_page, options.page_nav_wrapper);
        }
        options.table_wrapper.find("[operation-type]").each(function(){
            var operationType = $(this).attr("operation-type");
            var dataId   = $(this).attr("data-id");
            $(this).click(function(){
                m_this.onOperationClick(operationType, dataId);
                return false;
            })
            
        })
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////
    function getJsonValueByShowname(json, show_name) {
        if (typeof m_this.map_showname_name[show_name] == "undefined") {
            return "";
        }
        var field_name = m_this.map_showname_name[show_name];
        var field_names = field_name.split(".");
        var value = json;
        for (var i = 0; i < field_names.length; i++) {
            if (typeof value[field_names[i]] == "undefined") {
                return "";
            }
            value = value[field_names[i]];
        }
        if (typeof value == "undefined") {
            return "";
        }
        return value;
    }
    function getTableShowData(data, show_fields) {
        var table_datas = [];
        for (var i = 0; i < data.length; i++) {
            var table_data = {};
            for (var f = 0; f < show_fields.length; f++) {
                var show_name = show_fields[f];
                table_data[show_name] = getJsonValueByShowname(data[i], show_name);
            }
            if (typeof data[i]["id"] != "undefined") {
                table_data["id"] = data[i]["id"];
            }

            table_datas.push(table_data);
        }
        return table_datas;
    }
    function getOpertionHtml(data, operations) {
        var arrHtmls = [];
        var arrOperations = operations.split(",");
        var status = data["状态"];
        for (var i = 0; i < arrOperations.length; i++) {
            var operation = arrOperations[i];
            if (status == "已上传" && (operation == "删除" || operation == "上传"|| operation == "编辑")){
                continue;
            }
            var html = '<button type="button" class="btn btn-link" data-id="' + data["id"] + '" operation-type="' + operation + '">' + operation + '</button>';
            arrHtmls.push(html);
        }
        return arrHtmls.join("&nbsp;&nbsp;");
    }
    function getTableHtml(table_datas, options) {
        var table_html = '<table class="table table-bordered table-hover table-center table-query" style="text-align:center">';
        table_html += '<thead><tr>';
        for (var i = 0; i < options.show_fields.length; i++) {
            table_html += '<th>' + options.show_fields[i] + '</th>';
        }
        if (options.operations != "") {
            table_html += '<th>操作</th>';
        }
        table_html += '</tr></thead>';
        table_html += '<tbody>';
        for (var d = 0; d < table_datas.length; d++) {
            var data = table_datas[d];
            var record_html = '<tr>';
            for (var i = 0; i < options.show_fields.length; i++) {
                var show_field = options.show_fields[i];
                record_html += '<td>' + data[show_field] + '</td>';
            }
            if (options.operations != "") {
                record_html += '<td>' + getOpertionHtml(data, options.operations) + '</td>';
            }
            record_html += '</tr>';
            table_html += record_html;
        }
        table_html += '</tbody>';
        table_html += '</table>'
        return table_html;
    }
}

function zhuyuanjilu_query(){
    var m_this = this;
    var m_options = {};
    var m_patient_query = new patient_query();
    var map_showname_name = {
        "序号": "id",
        "入院日期": "hospitalization_in_time",
        "出院日期": "hospitalization_out_time",
        "手术日期": "operation_time",
        "上传时间": "uploadtime",
        "状态": "status"
    }
    var map_query_param = [
    ]
    this.m_query_data_api = "hospital/get-record-list";
    this.preProcessData = function(rawDatas) {
    }
    this.transData = function(table_datas) {
        for (var i = 0; i < table_datas.length; i++) {
            table_datas[i]["入院日期"]  = timestampToDateString(table_datas[i]["入院日期"]);
            table_datas[i]["出院日期"]  = timestampToDateString(table_datas[i]["出院日期"]);
            table_datas[i]["上传时间"]  = timestampToDateString(table_datas[i]["上传时间"]);
            table_datas[i]["手术日期"]  = timestampToDateString(table_datas[i]["手术日期"]);
            table_datas[i]["状态"]      = getStatusName(table_datas[i]["状态"]);
        }
    }
    this.onOperationClick = function(operationType, dataId){
        alert(operationType);
    }
    this.init = function(options){
        m_options = options;
        if (typeof m_options["page_size"] == "undefined"){
            m_options["page_size"] = 10;
        }
        m_patient_query.init(m_options);
        m_patient_query.m_query_data_api = m_this.m_query_data_api;
        m_patient_query.map_showname_name = map_showname_name;
        m_patient_query.map_query_param = map_query_param;
        m_patient_query.preProcessData = m_this.preProcessData;
        m_patient_query.transData = m_this.transData;
        m_patient_query.onOperationClick = m_this.onOperationClick;
    }
    this.queryData = function (query_param){
        query_param.patient_id = m_options.patient_id;
        query_param.size = m_options.page_size;
        return m_patient_query.queryData(query_param);
    }
    /////////////////////////////////////////////////////
    function getStatusName(status) {
        var status_map = [
            { "name": "未上传", "id": "1" },
            { "name": "已上传", "id": "2" },
            { "name": "删除", "id": "3" }
        ];
        for (var i = 0; i < status_map.length; i++) {
            if (status_map[i]["id"] == status) {
                return status_map[i]["name"];
            }
        }
        return "" + status;
    }
}
