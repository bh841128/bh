function hospital(){
	var m_this = this;
	this.m_page_struct = {
		elements : {
			"side_bar":$("#main-sidebar")
		},
		site_pages : [
			{"name":"新增资料","icon":"glyphicon-plus", pages:[
				{"name":"基本资料"},
				{"name":"住院记录"},
				{"name":"新增住院记录",pages:[
					{"name":"日期"},
					{"name":"术前信息"},
					{"name":"手术信息"},
					{"name":"术后信息"},
					{"name":"出院资料"}
				]}
			]},
			{"name":"上传资料","icon":"glyphicon-upload"},
			{"name":"数据查询","icon":"glyphicon-search"},
			{"name":"数据导出","icon":"glyphicon-export"},
			{"name":"数据报表","icon":"glyphicon-list-alt"}
		]
	}
	this.m_global_data = {
		currentSite:[]
	};
	///////////////////////////////////////////////初始化
	this.init = function(){
	}
	//////////////////////////////////////////////页面跳转管理
	this.gotoPage = function(dstSite){
		function findSitePageInfo(top_site){
			var site_pages = m_this.m_page_struct.site_pages;
			for (var i = 0; i < site_pages.length; i++){
				if (site_pages[i].name == "top_site"){
					return site_pages[i];
				}
			}
			return null;
		}
		
		var top_site = dstSite[0];
		var top_site_info = findSitePageInfo(top_site);
		if (!top_site_info){
			return false;
		}
		function setSitebarHightlight(top_site){
			var site_bar = m_this.m_page_struct.elements["side_bar"];
			site_bar.find(".tree-btn[tag]").each(function(){
				var tag = $(this).attr("tag");
				if (tag == top_site){
					$(this).addClass("active");
				}
				else{
					$(this).removeClass("active");
				}
			})
		}
		///设置左侧sidebar高亮
		

		///设置顶部面包屑
	}
	//////////////////////////////////////////////全局数据管理
	this.addGlobalData = function(key, data){

	}
	this.getGlobalData = function(key, data){
		
	}
	this.setGlobalDataDirty = function(key, data){

	}
	this.isGlobalDataDirty = function(key){

	}
	////////////////////////////////////////////数据接口管理
}

