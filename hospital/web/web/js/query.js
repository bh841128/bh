function hospital_query(){
    this.query_patient = function(query_param){
        function queryPatientRet(rsp){
            console.dir(rsp);
        }
        if (typeof query_param["page"] == "undefined"){
            query_param["page"] = 0;
        }
        if (typeof query_param["size"] == "undefined"){
            query_param["size"] = 2;
        }
        
        ajaxRemoteRequest("hospital/get-patient-list",query_param,queryPatientRet);
    }
}

