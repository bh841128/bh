function hospital(){
	var m_this = this;
	this.m_page_struct = {
		elements : {
			"side_bar":$("#main-sidebar"),
			"breadcrumb":$("#breadcrumb-title")
		},
		page_configs : [
			{"name":"新增资料", "container_id":"content-wrapper-add-jibenziliao"},
			{"name":"新增住院记录", "container_id":"content-wrapper-add-zhuyuanjilu"},
			{"name":"上传资料", "container_id":"content-wrapper-upload-upload"},
			{"name":"数据查询", "container_id":"content-wrapper-query-query"},
			{"name":"数据导出", "container_id":"content-wrapper-export-export"},
			{"name":"数据报表", "container_id":"content-wrapper-report-report"}
		]
	}
	this.m_global_data = {
		"current_page":""
	};
	///////////////////////////////////////////////初始化
	this.init = function(){
		initControls();
		initAddPatientZyjl();
		//这是左侧sidebar点击事件
		var side_bar = m_this.m_page_struct.elements["side_bar"];
		side_bar.find(".tree-btn[tag]").click(function(){
			if ($(this).hasClass("active")){
				return;
			}
			var tag = $(this).attr("tag");
			m_this.gotoPage(tag);
		});

		//默认页面
		this.gotoPage(["新增资料"]);
	}
	//////////////////////////////////////////////页面跳转管理
	this.gotoPage = function(page_name){
		function setBreadcrumb(page_name){
			var breadcrumb = m_this.m_page_struct.elements["breadcrumb"];
			breadcrumb.html(page_name);
		}
		function setSitebarHightlight(page_name){
			if (page_name == "新增住院记录"){
				page_name = "新增资料";
			}
			var side_bar = m_this.m_page_struct.elements["side_bar"];
			side_bar.find(".tree-btn[tag]").each(function(){
				var tag = $(this).attr("tag");
				if (tag == page_name){
					$(this).addClass("active");
				}
				else{
					$(this).removeClass("active");
				}
			})
		}
		function showDstPage(page_name){
			var page_configs = m_this.m_page_struct.page_configs;
			var page_info = findPageInfo(page_configs, page_name);
			if (!page_info){
				return false;
			}
			if (page_name == "新增资料"){
				showNavTab("jibenziliao-section", "nav-tab-jibenziliao", "tab-jibenziliao");
			}
			else if (page_name == "新增住院记录"){
				showNavTab("zhuyuanjilu-section", "nav-tab-zyjl-riqi", "tab-zyjl-riqi");
			}
			var container_id = page_info.container_id;
			for (var i = 0; i < page_configs.length; i++){
				if (page_configs[i].container_id != container_id){
					$("#"+page_configs[i].container_id).hide();
				}
			}
			$("#"+container_id).show();
		}
		
		var current_page = m_this.getGlobalData("current_page");
		if (current_page == "新增资料" || current_page == "新增住院记录"){
			//确认是否离开页面
		}
		///设置左侧sidebar高亮
		setSitebarHightlight(page_name);
		///设置顶部面包屑
		setBreadcrumb(page_name);
		///设置当前站点
		m_this.setGlobalData("currentSite", page_name);
		///显示隐藏相关页面
		showDstPage(page_name);
		//////////////////
		m_this.setGlobalData("current_page", current_page);
	}
	//////////////////////////////////////////////全局数据管理
	this.setGlobalData = function(key, data){
		m_this.m_global_data[key] = data;
	}
	this.getGlobalData = function(key, data){
		if (typeof m_this.m_global_data[key] == "undefined"){
			return "";
		}
		return m_this.m_global_data[key];
	}
	////////////////////////////////////////////数据接口管理
	function findPageInfo(page_configs, page_name){
		var page_configs = m_this.m_page_struct.page_configs;
		for (var i = 0; i < page_configs.length; i++){
			if (page_configs[i].name == page_name){
				return page_configs[i];
			}
		}
		return null;
	}
	function findPageInfoByContainerId(page_configs, container_id){
		var page_configs = m_this.m_page_struct.page_configs;
		for (var i = 0; i < page_configs.length; i++){
			if (page_configs[i]["container_id"] == container_id){
				return page_configs[i];
			}
		}
		return null;
	}
	/////////////////////////////////////////////
	function initControls(){
		initDatePicker("input[tag='datepicker']");
		initDateTimePicker("input[tag='datetimepicker']");
		initMinzu($("select[tag='minzu']"));
		initAddress($("div[tag='address']"));
		initUserMenu();
		initIEPlaceholder();
	}
	function initUserMenu(){
		$("#user_login_menu a[tag='change_password']").click(function(){
			onShowChangePwd();
		})
		$("#user_login_menu a[tag='signout']").click(function(){
			onLogout();
		})
	
		$("input[tag]").one( "focus", function() {
			hideAllErrorMsgs();
		});
	}
	/////////////////////////////////////////初始化添加资料 住院记录
	function initAddPatientZyjl(){
		g_addPatient = new addPatient();
		g_addPatient.init();
		//查询住院记录
		g_queryZhuyuanjilu = new queryZhuyuanjilu();
		g_queryZhuyuanjilu.init();
		//添加住院记录
		g_addZhuyuanjilu = new addZhuyuanjilu();
		g_addZhuyuanjilu.init();
	}
	/////////////////////////////////////////初始化上传
	function initUpload(){

	}
	/////////////////////////////////////////初始化查询
	function query_queryDefaultPage(){
		var query_params = g_patient_query.parseQueryParam($("#query_param_form"));
		query_params.page = 1;
		query_params.size = 10;
		g_patient_query.queryData(query_params);
	}
	function initQuery(){
		var options = {
            "show_fields":["序号","病案号","姓名","性别", "出生日期", "联系人", "联系电话", "医院", "上传时间", "状态"],
            "operations":"编辑,删除",
            "table_wrapper":$("#query-table-wrapper"),
            "page_nav_wrapper":$("#query-page-nav")
        }
        g_patient_query = new patient_query();
		g_patient_query.init(options);
		$("#content-query input[tag='datetimepicker']").val("");
        $("#content-query button[tag='query']").click(function(){
            query_queryDefaultPage();
        })
	}
	/////////////////////////////////////////初始化导出
	function initExport(){

	}
	/////////////////////////////////////////初始化报表
	function initReport(){
		g_report = new report();
		g_report.init();
	}
}

