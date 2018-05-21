function select_modal(){
    var m_options = {};
    var m_records = [];
    var m_index_datas = [];
    m_callback = null;
    m_control  = null;
    this.init = function(options){
        m_options = options;
        m_records = m_options.data_source;
        m_options.container.find("button[tag='ok']").click(function(){
            if (typeof m_callback!= undefined){
                var selected_datas = m_this.getSelectedDatas(m_index_datas);
                m_callback(m_control, selected_datas);
            }
        })
        createDataIndex();
    }
    this.show_modal = function(control, selected_data_index, callback){
        m_callback = callback;
        m_control = control;
        clearParamControls();
        processData(selected_data_index);
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
    this.getSelectedIndexs = function(datas){
        var selected_indexs = [];
        for (var i = 0; i < datas.length; i++){
            if (datas[i].is_data_selected){
                selected_indexs.push(i);
            }
        }
        return selected_indexs.join(",");
    }
    this.data2Indexs = function(datas){
        var selected_indexs = [];
        for (var i = 0; i < datas.length; i++){
            var key1 = datas[i].key1;
            var key2 = datas[i].key2;
            for (var j = 0; j < m_index_datas.length; j++){
                if (key1 != m_index_datas[j].key1 || key2 != m_index_datas[j].key2){
                    continue;
                }
                selected_indexs.push(j);
                break;
            }
        }
        return selected_indexs.join(",");
    }
    this.indexs2Data = function(indexs){
        var arr_indexs = indexs.split(",");
        var datas = {};
        for (var i = 0; i < arr_selected_data_index; i++){
            if (arr_indexs[i] == "" || arr_indexs[i] >= m_index_datas.length){
                continue;
            }
            datas.push({key1:m_index_datas[arr_indexs[i]].key1, key2:m_index_datas[arr_indexs[i]].key2});
        }
        return datas;
    }

    function createDataIndex(){
        m_index_datas = [];
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
        m_index_datas[i].is_data_selected = false;
    }
    function processData(selected_data_index){
        for (var i = 0; i < m_index_datas.length; i++){
            m_index_datas[i]["is_data_selected"] = false;
        }

        var arr_selected_data_index = selected_data_index.split(",");
        var index_selected_data_index = {};
        for (var i = 0; i < arr_selected_data_index; i++){
            if (arr_selected_data_index[i] == "" || arr_selected_data_index[i] >= m_index_datas.length){
                continue;
            }
            m_index_datas[arr_selected_data_index[i]].is_data_selected = true;
        }
    }
    function fillTable(){
        var table_html = getTableHtml(m_index_datas);
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