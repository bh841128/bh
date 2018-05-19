function hospital(){
	var m_this = this;
	this.m_page_struct = {
		elements : {
			"side_bar":$("#main-sidebar"),
			"breadcrumb":$("#breadcrumb-title")
		},
		page_configs : [
			{"name":"新增资料", "container-id":"content-wrapper-add-jibenziliao", "nav-tabs":[]},
			{"name":"新增住院记录", "container-id":"content-wrapper-add-zhuyuanjilu", "nav-tabs":[]},
			{"name":"上传资料", "container-id":"content-wrapper-upload-upload"},
			{"name":"数据查询", "container-id":"content-wrapper-query-query"},
			{"name":"数据导出", "container-id":"content-wrapper-export-export"},
			{"name":"数据报表", "container-id":"content-wrapper-report-report"}
		]
	}
	this.m_global_data = {
		"current_page":""
	};
	///////////////////////////////////////////////初始化
	this.init = function(){
		//这是左侧sidebar点击事件
		var side_bar = m_this.m_page_struct.elements["side_bar"];
		side_bar.find(".tree-btn[tag]").each(function(){
			if ($(this).hasClass("active")){
				return;
			}
			var tag = $(this).attr("tag");
			this.gotoPage(tag);
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
	}
	//////////////////////////////////////////////全局数据管理
	this.setGlobalData = function(key, data){
		m_this.m_global_data[key] = data;
	}
	this.getGlobalData = function(key, data){
		
	}
	this.setGlobalDataDirty = function(key, data){

	}
	this.isGlobalDataDirty = function(key){

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
			if (page_configs[i]["container-id"] == container_id){
				return page_configs[i];
			}
		}
		return null;
	}
}

