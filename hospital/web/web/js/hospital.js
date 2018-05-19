function hospital(){
	var m_this = this;
	this.m_page_struct = {
		elements : {
			"side_bar":$("#main-sidebar"),
			"breadcrumb":$("#breadcrumb")
		},
		site_pages : [
			{"name":"新增资料", "container-id":"content-wrapper-add-jibenziliao",
				pages:[
					{"name":"基本资料"},
					{"name":"住院记录",
						pages:[
							{"name":"新增住院记录", "container-id":"content-wrapper-add-zhuyuanjilu",
								pages:[
									{"name":"日期"},
									{"name":"术前信息"},
									{"name":"手术信息"},
									{"name":"术后信息"},
									{"name":"出院资料"}
								]
							}
						]
					}
				]
			},
			{"name":"上传资料", "container-id":"content-wrapper-upload-upload"},
			{"name":"数据查询", "container-id":"content-wrapper-query-query"},
			{"name":"数据导出", "container-id":"content-wrapper-export-export"},
			{"name":"数据报表", "container-id":"content-wrapper-report-report"}
		]
	}
	this.m_global_data = {
		
	};
	///////////////////////////////////////////////初始化
	this.init = function(){
		this.gotoPage(["新增资料","基本资料"]);
	}
	//////////////////////////////////////////////页面跳转管理
	this.gotoPage = function(dstSites){
		function findSitePageInfo(site_configs, site_name){
			for (var i = 0; i < site_configs.length; i++){
				if (site_configs[i].name == site_name){
					return site_configs[i];
				}
			}
			return null;
		}
		function setSitebarHightlight(site_name){
			var site_bar = m_this.m_page_struct.elements["side_bar"];
			site_bar.find(".tree-btn[tag]").each(function(){
				var tag = $(this).attr("tag");
				if (tag == site_name){
					$(this).addClass("active");
				}
				else{
					$(this).removeClass("active");
				}
			})
		}
		function setBreadcrumb(breadcrumb_sites){
			var breadcrumb = m_this.m_page_struct.elements["breadcrumb"];
			breadcrumb.find("li[bread-level]").each(function(){
				var bread_level = $(this).attr("bread-level");
				if (bread_level > breadcrumb_sites.length){
					$(this).hide();
					return;
				}
				if (bread_level == 1){
					$(this).html(breadcrumb_sites[0]);
				}
				else if (bread_level == breadcrumb_sites.length){
					$(this).html(breadcrumb_sites[bread_level - 1]);
					$(this).addClass("active");
				}
				else{
					$(this).html('<a href="#">'+breadcrumb_sites[bread_level - 1]+'</a>');
					$(this).removeClass("active");
				}
				$(this).show();
			})
		}
		function showDstPage(){
			var container_id = "";
			var container_ids = [];
			var site_pages = m_this.m_page_struct.site_pages;
			for (var i = 0; i < dstSites.length; i++){
				var page_info = findSitePageInfo(site_pages, dstSites[i]);
				if (!page_info){
					return false;
				}
				if (typeof page_info["container-id"] != "undefined"){
					container_id = page_info["container-id"];
					container_ids.push(container_id);
				}
				if (typeof page_info["pages"] == "undefined"){
					break;
				}
				site_pages = page_info["pages"];
			}
			if (container_id == ""){
				return false;
			}
			for ($i = 0; i < container_ids.length; i++){
				if (container_ids[i] == container_id){
					continue;
				}
				$("#"+container_ids[i]).hide();
			}
			$("#"+container_id).show();
		}
		
		///设置左侧sidebar高亮
		setSitebarHightlight(dstSites[0]);
		///设置顶部面包屑
		setBreadcrumb(dstSites);
		///设置当前站点
		m_this.setGlobalData("currentSite", dstSites);
		///显示隐藏相关页面
		showDstPage(dstSites);
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

}

