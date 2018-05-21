function select_modal(){
    m_options = {};
    m_selected_datas = [];
    m_records = [];
    m_callback = null;
    this.init = function(options){
        m_options = options;
        m_options.container.find("button[tag='ok']").click(function(){
            if (typeof m_callback!= undefined){
                var selected_datas = getSelectedDatas(m_records);
                m_callback(selected_datas);
            }
        })
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

    function processData(){
        for (var i = 0; i < m_records.length; i++){
            m_records[i]["is_data_selected"] = isRecordSelected(m_records[i], m_selected_datas);
            m_records[i]["data_index"] = i;
        }
    }
    function fillTable(){
        var table_html = getTableHtml(m_records, m_selected_datas);
        var table_container = m_options.container.find("[tag='search-table-wrapper']");
        table_container.html(table_html);
    }

    function getTableHtml(table_datas, selected_datas) {
        var show_fields = m_options.show_fields;
        var table_html = '<table class="table table-bordered table-hover table-center table-query" style="text-align:center">';
        table_html += '<thead><tr>';
        for (var i = 0; i < show_fields.length; i++) {
            table_html += '<th>' + show_fields[i] + '</th>';
        }
        if (options.operations != "") {
            table_html += '<th>选择</th>';
        }
        table_html += '</tr></thead>';
        table_html += '<tbody>';
        for (var d = 0; d < table_datas.length; d++) {
            var data = table_datas[d];
            var record_html = '<tr>';
            for (var i = 0; i < show_fields.length; i++) {
                var show_field = show_fields[i];
                record_html += '<td>' + data[show_field] + '</td>';
            }
            if (options.operations != "") {
                record_html += '<td><input type="checkbox"'+(data.is_data_selected?' checked':'')+' data_index='+data.data_index+'></td>';
            }
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
        for (var i = 0; i < m_records.length; i++){
            if (m_records[i].data_index == data_index){
                m_records[i].is_data_selected = is_data_selected;
            }
        }
    }

    function clearParamControls(){
        m_options.container.find("[tag='param-container'] [json-name]").each(function(){
            clearInputValue($(this));
        })
    }
}