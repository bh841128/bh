function select_modal(){
    var m_options = {};
    var m_selected_datas = [];
    var m_records = [];
    var m_index_datas = {};
    m_callback = null;
    this.init = function(options){
        m_options = options;
        m_options.container.find("button[tag='ok']").click(function(){
            if (typeof m_callback!= undefined){
                var selected_datas = getSelectedDatas(m_index_datas);
                m_callback(selected_datas);
            }
        })
        createDataIndex();
    }
    this.show_modal = function(records, selected_datas, callback){
        m_callback = callback;
        clearParamControls();

        m_selected_datas = selected_datas;
        m_records = records;
        fillTable();
        container.modal();
    }
    this.getSelectedDatas = function(datas){
        var selected_datas = [];
        for (var i = 0; i < datas.length; i++){
            if (datas[i].is_data_selected){
                selected_datas.push(datas[i]);
            }
        }
        return selected_datas;
    }

    function createDataIndex(){
        m_index_datas = {};
        for (var key1 in m_records){
            var key2s = m_records[key1];
            if (key2s.length == 0){
                m_index_datas.push({key1:key1,key2:""});
            }
            else{
                for (var i = 0; i < key2s.length; i++){
                    m_index_datas.push({key1:key1,key2:key2s[i]});
                }
            }
        }
        for (var i = 0; i < m_index_datas.length; i++){
            if (isRecordSelected(m_index_datas[i], m_selected_datas)){
                m_index_datas[i].is_data_selected = true;
            }
            else{
                m_index_datas[i].is_data_selected = false;
            }
        }
    }
    function processData(){
        for (var i = 0; i < m_records.length; i++){
            m_records[i]["is_data_selected"] = isRecordSelected(m_records[i], m_selected_datas);
            m_records[i]["data_index"] = i;
        }
    }
    function fillTable(){
        var table_html = getTableHtml(m_index_datas, m_selected_datas);
        var table_container = m_options.container.find("[tag='search-table-wrapper']");
        table_container.html(table_html);
        table_container.find("input[data_index]").change(function(){
            var data_index = $(this).attr("data_index");
            onSelectAData(data_index, this.checked);
        })
    }

    function getTableHtml(table_datas, selected_datas) {
        var table_html = '<table class="table table-bordered table-hover table-center table-query" style="text-align:center">';
        table_html += '<tbody>';
        for (var d = 0; d < table_datas.length; d++) {
            var data = table_datas[d];
            var record_html = '<tr>';
            for (var i = 0; i < 2; i++) {
                record_html += '<td>' + data[i] + '</td>';
            }
            record_html += '<td><input type="checkbox"'+(data.is_data_selected?' checked':'')+' data_index="'+d+'"></td>';
            record_html += '</tr>';
            table_html += record_html;
        }
        table_html += '</tbody>';
        table_html += '</table>'
        return table_html;
    }

    function isRecordSelected(record, selected_datas){
        function isRecordEqual(record, selected_data){
            for (var key in record){
                if (typeof selected_data[key] != "undefined" && selected_data[key] != record[key]){
                    return false;
                }
            }
            return true;
        }
        for (var i = 0; i < selected_datas.length; i++){
            if (isRecordEqual(record, selected_datas[i])){
                return true;
            }
        }
        return false;
    }
    function onSelectAData(data_index, is_data_selected){
        m_index_datas[data_index].is_data_selected = is_data_selected;
    }

    function clearParamControls(){
        m_options.container.find("[tag='param-container'] [json-name]").each(function(){
            clearInputValue($(this));
        })
    }
}