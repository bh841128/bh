function report(){
    var m_this = this;
    this.init = function(){
        initHospital($("#hospital-select"));
        initBar([], ["所有医院"]);
    }
    
    function initBar(data,keys){
        if (typeof g_report_bar == "undefined"){
            g_report_bar = new Morris.Bar({
                element: 'report-chart',
                resize: true,
                data: data,
                barColors: ['rgb(86,187,251)', '#f56954'],
                xkey: 'y',
                ykeys: keys,
                labels: keys,
                hideHover: 'auto'
            });
        }
        else{
            g_report_bar.options.ykeys = keys;
            g_report_bar.options.labels = keys;
            g_report_bar.setData(data);
        }
        
        $("#foot_hospital_name").html(g_hospital_name);
        $("#year-select,#hospital-select").change(function(){
            m_this.onQueryReportTable();
        })
    }
    this.onQueryReportTable = function(){
        var year = $("#year-select").val();
        queryReportTable(year);
    }
    function queryReportTable(year){
        function onQueryReportTableRet(rsp){
            if (rsp.ret != 0){
                alert("查询数据错误，请稍后再试");
                return;
            }
            var data = [];
            for (var i = 0; i < rsp.msg.length; i++){
                var record =  rsp.msg[i];
                data.push({
                    hospital_id:record["hospital_id"],
                    month:record["mon"],
                    num:record["count(*)"]
                })
            }
            showReportBar(data);
        }
        ajaxRemoteRequest("hospital/records-table",{year:year},onQueryReportTableRet);
    }
    function showReportBar(data){
        var hospital_id = $("#hospital-select").val();
        var hospital_name = getHospitalName(hospital_id);
        var the_hospital = {"name":hospital_name,"id":hospital_id};
        var report_data_tmp = {};
        for (var i = 1; i <= 12; i++){
            report_data_tmp[i] = {};
            report_data_tmp[i][the_hospital.name] = 0;
            report_data_tmp[i]["其他"] = 0;
            report_data_tmp[i]["所有医院"] = 0;
        }
        var total_num = 0;
        for (var i = 0; i < data.length; i++){
            var record_num = parseInt(data[i].num);
            total_num += record_num;
            var month = parseInt(data[i]["month"],10);
            if (data[i].hospital_id == the_hospital.id){
                report_data_tmp[month][the_hospital.name]+=record_num;
            }
            else{
                report_data_tmp[month]["其他"]+=record_num;
            }
            report_data_tmp[month]["所有医院"] += record_num;
        }

        var report_data = [];
        var keys = [];
        if (hospital_id == 0){
            keys = ["所有医院"];
        }
        else{
            keys = [hospital_name, "其他"];
        }
        for (var i = 1; i <= 12; i++){
            var report_record = {};
            var yuefen = i>=10?i+"":"0"+i;
            report_record["y"] = yuefen+"月份";
            for (var k = 0; k < keys.length; k++){
                report_record[keys[k]] = report_data_tmp[i][keys[k]];
            }
            report_data.push(report_record);
        }
        console.dir(report_data);
        $("#report-sub-title").html("总量："+total_num);
        initBar(report_data, keys);
        if (hospital_id > 0){
            $("#foot_hospital_name").html(hospital_name);
            $("#foot_hospital_name,#foot_hospital_name_square").show();
            $("#foot_hospital_other").html("其他");
        }
        else{
            $("#foot_hospital_name").html('');
            $("#foot_hospital_name,#foot_hospital_name_square").hide();
            $("#foot_hospital_other").html("所有医院");
        }
    }
}