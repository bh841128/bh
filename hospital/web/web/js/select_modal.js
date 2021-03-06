function select_modal(){
    var m_this = this;
    var m_options = {};
    var m_records = [];
    var m_index_datas = [];
    var m_filter_param = "";
    m_callback = null;
    m_control  = null;
    this.init = function(options){
        m_options = options;
        m_records = m_options.data_source;
        createDataIndex();
    }
    this.show_modal = function(control, selected_data_index, callback){
        m_filter_param = "";
        m_options.modal_container.find("input[tag='input_search']").val("")
        m_callback = callback;
        m_control = control;
        processData(selected_data_index);
        fillTable();
        m_options.modal_container.find("button[tag='button_ok']").each(function(){
            this.onclick = function(){
                if (typeof m_callback!= undefined){
                    var selected_datas = m_this.getSelectedDatas(m_index_datas);
                    m_callback(m_control, selected_datas);
                }
                m_options.modal_container.modal("hide");
            }
        })
        m_options.modal_container.find("button[tag='button_search']").each(function(){
            this.onclick = function(){
                m_filter_param = m_options.modal_container.find("input[tag='input_search']").val();
                m_filter_param = getTrimValue(m_filter_param);
                fillTable();
            }
        });
        
        m_options.modal_container.find(".modal-title").html(m_options.title);
        m_options.modal_container.modal({backdrop:false});
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
        var datas = [];
        for (var i = 0; i < arr_indexs.length; i++){
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
    }
    function processData(selected_data_index){
        for (var i = 0; i < m_index_datas.length; i++){
            m_index_datas[i]["is_data_selected"] = false;
        }

        var arr_selected_data_index = selected_data_index.split(",");
        var index_selected_data_index = {};
        for (var i = 0; i < arr_selected_data_index.length; i++){
            if (arr_selected_data_index[i] == "" || arr_selected_data_index[i] >= m_index_datas.length){
                continue;
            }
            m_index_datas[arr_selected_data_index[i]].is_data_selected = true;
        }
    }
    function fillTable(){
        var table_html = getTableHtml(m_index_datas);
        var table_container = m_options.modal_container.find("[tag='search-table-wrapper']");
        table_container.html(table_html);
        table_container.find("input[data_index]").change(function(){
            var data_index = $(this).attr("data_index");
            onSelectAData(data_index, this.checked);
        })
    }

    function isDataFilterdOut(data){
        if (m_filter_param == ""){
            return false;
        }
        if (data.key1.indexOf(m_filter_param) >= 0){
            return false;
        }
        if (data.key2.indexOf(m_filter_param) >= 0){
            return false;
        }
        return true;
    }
    function getTableHtml(table_datas) {
        var table_html = '<table class="table table-bordered table-hover table-center table-query" style="text-align:left">';
        table_html += '<tbody>';
        for (var d = 0; d < table_datas.length; d++) {
            var data = table_datas[d];
            if (isDataFilterdOut(data)){
                continue;
            }
            var record_html = '<tr>';
            record_html += '<td style="word-break: keep-all;white-space:nowrap;">' + data.key1 + '</td>';
            record_html += '<td>' + data.key2 + '</td>';

            record_html += '<td><input type="checkbox"'+(data.is_data_selected?' checked':'')+' data_index="'+d+'"></td>';
            record_html += '</tr>';
            table_html += record_html;
        }
        table_html += '</tbody>';
        table_html += '</table>'
        return table_html;
    }

    function onSelectAData(data_index, is_data_selected){
        m_index_datas[data_index].is_data_selected = is_data_selected;
    }
}