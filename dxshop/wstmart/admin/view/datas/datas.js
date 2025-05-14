var zTree,mmg,rMenu,diff = 0;
function layout(){
	var h = WST.pageHeight();
	var w = WST.pageWidth();
	$('.j-layout').width(w-10);
	$('.j-layout-left').width(200).height(h-110);
	$('.j-layout-center').width(w-220).height(h-110);
	$('#headTip').WSTTips({width:90,height:35,callback:function(v){
		 diff = v?110:53;
		 $('.j-layout-left').height(h-diff);
		 $('#menuTree').height(h-diff-40);
		 $('.j-layout-center').height(h-diff);
		 if(mmg)mmg.resize({height:h-diff-125});
    }});
}
function initGrid(id){
	mmg = layui.table;
	mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/datas/childQuery','id='+id),cellMinWidth: 80,height:'full-190',skin: 'line',even: true, limit:20,page:true,
		cols: [[
			{title:'#',type:'numbers'},
			{title:'数据名称', field:'dataName'},
			{title:'数据值', field:'dataVal'},
			{title:'排序号', field:'dataSort' },
			{title:'操作', field:'' , fixed: 'right', width:200, align:'center', templet: function(item){
					return '<a data-id="'+item['id']+'" class="btn btn-blue btngroup btn'+item['id']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
				}}
		]],
		done: function(res, curr, count){
			var e = this;
			var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
			if(count>0 && curr>total_page){
				loadGrid(id,total_page);
				return;
			}
			WST_CURR_PAGE = curr;
			var btns = [];
			for(var i=0;i<res.data.length;i++){
				btns = [];
				if(WST.GRANT.SJGL_02)btns.push({title: '编辑',cls:"btn-blue", icon:"fa-pencil",act:102});
				if(WST.GRANT.SJGL_03)btns.push({title: '删除',cls:"btn-blue", icon:"fa-trash-o",act:103});
				layui.dropdown.render({
					elem: '.btn'+res.data[i].id,
					dataId:res.data[i].id,
					catId:res.data[i].catId,
					trigger: 'hover',
					data: btns,
					click: function(obj,othis){
						switch(obj.act){
							case 102:getForEdit(this.dataId);break;
							case 103:toDel(this.dataId,this.catId);break;
						}
					}
				});
			}
		}
	});
	isInit = true;
}


var isInit = false;
$(window).resize(function(){layout();});
$(function(){
	layout();
	$('#menuTree').height(WST.pageHeight()-140);
	var setting = {
	      view: {
	           selectedMulti: false,
	           dblClickExpand:false
	      },
	      async: {
	           enable: true,
	           url:WST.U('admin/datacats/listQuery'),
	           autoParam:["id", "name=n", "level=lv"]
	      },
	      callback:{
	           onRightClick: onRightClick,
	           onClick: onClick,
	           onAsyncSuccess: onAsyncSuccess
	      }
	};
	$.fn.zTree.init($("#menuTree"), setting);
	zTree = $.fn.zTree.getZTreeObj("menuTree");
	rMenu = $("#rMenu");



	$('#m_add').click(function(){
		treeNode = zTree.getSelectedNodes()[0];
	    editMenu({menuId:0,menuName:'',parentId:treeNode.id,pnode:treeNode,menuSort:0});
	});
	$('#m_edit').click(function(){
		treeNode = zTree.getSelectedNodes()[0];
	    getForEditMenu(treeNode.id);
	    return false;
	});
	$('#m_del').click(function(){
		treeNode = zTree.getSelectedNodes()[0];
	              	layer.confirm('您确定要删除该数据分类['+treeNode.name+']吗？', {btn: ['确定','取消']}, function(){
	              	    var loading = WST.msg('正在提交请求，请稍后...', {icon: 16,time:60000});
	              	    $.post(WST.U('admin/datacats/del'),{id:treeNode.id},function(data,textStatus){
	              		     layer.close(loading);
	              		     var json = WST.toAdminJson(data);
	              		     if(json.status=='1'){
	              		          WST.msg("操作成功",{icon:1});
	              		          zTree.reAsyncChildNodes(treeNode.getParentNode(), "refresh",true);
	              		     }else{
	              		          WST.msg(json.msg,{icon:2});
	              		     }
	              		 });
	                  });
	    return false;
	});
});
function loadGrid(id,p){
	p=(p<=1)?1:p;
	mmg.reload('dataTable',{where:{id:id},page:{curr:p}});
}
function onAsyncSuccess(event, treeId, treeNode, msg){
	var json = WST.toAdminJson(msg);
	if(json && json.id==0){
		var treeNode = zTree.getNodeByTId('menuTree_1');
		zTree.reAsyncChildNodes(treeNode, "refresh",true);
		zTree.expandAll(treeNode,true);
	}
}
function onClick(e,treeId, treeNode){
	if(treeNode.id>0){
	      $('.wst-toolbar').show();
	      $('#maingrid').show();
	}else{
	    $('.wst-toolbar').hide();
	    $('#maingrid').hide();
	}
	if(!isInit){
		initGrid(treeNode.id);
	}else{
        loadGrid(treeNode.id);
	}
}
function onRightClick(event, treeId, treeNode) {
	if(!treeNode)return;
	if(!WST.GRANT.CDGL_01 && !WST.GRANT.CDGL_02 && !WST.GRANT.CDGL_03)return;
	if(!treeNode && event.target.tagName.toLowerCase() != "button" && $(event.target).parents("a").length == 0) {
		zTree.cancelSelectedNode();
		showRMenu("root", event.clientX, event.clientY);
	}else if(treeNode && !treeNode.noR) {
		zTree.selectNode(treeNode);
		var level = treeNode.level;
		if(level==0){
			$("#m_edit").hide();
			$("#m_del").hide();
		}else{
			$("#m_edit").show();
			$("#m_del").show();
		}
		showRMenu("node", event.clientX, event.clientY);
	}
}
function showRMenu(type, x, y) {
	$("#rMenu ul").show();
    y += document.body.scrollTop;
    x += document.body.scrollLeft;
    rMenu.css({"top":y+"px", "left":x+"px", "visibility":"visible"});
	$("body").bind("mousedown", onBodyMouseDown);
}
function hideRMenu() {
	if (rMenu) rMenu.css({"visibility": "hidden"});
	$("body").unbind("mousedown", onBodyMouseDown);
}
function onBodyMouseDown(event){
	if (!(event.target.id == "rMenu" || $(event.target).parents("#rMenu").length>0)) {
		rMenu.css({"visibility" : "hidden"});
	}
}
function getForEditMenu(id){
	 var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
    $.post(WST.U('admin/datacats/get'),{id:id},function(data,textStatus){
          layer.close(loading);
          var json = WST.toAdminJson(data);
          if(json.catId){
          	  editMenu(json);
          }else{
          	  WST.msg(json.msg,{icon:2});
          }
   });
}
function editMenu(obj){
	WST.setValues(obj);
	var box = WST.open({ title:(obj.catId==0)?'新增数据分类':"编辑数据分类",type: 1,area: ['700px', '300px'],
	                content:$('#menuBox'),
	                btn:['确定','取消'],
	                end:function(){$('#menuBox').hide();$("#catName").val('');$("#catCode").val('');},
	                yes: function(index, layero){
	                	if(!$('#catName').isValid())return;
	                	if(!$('#catCode').isValid())return;
		                var params = WST.getParams('.ipt2');
		                params.catId = obj.catId;
		                var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
		                $.post(WST.U('admin/datacats/'+((params.catId)?"edit":"add")),params,function(data,textStatus){
		                	layer.close(loading);
		                	var json = WST.toAdminJson(data);
		                	if(json.status=='1'){
		                	    WST.msg("操作成功",{icon:1});
		                		layer.close(box);
		                	    $('#menuForm')[0].reset();
		                		treeNode = zTree.getNodeByTId('menuTree_1');
		                		zTree.reAsyncChildNodes(treeNode, "refresh",true);
		                	}else{
		                		WST.msg(json.msg,{icon:2});
		                	}
		                });
	            }});
}

function getForEdit(id){
	 var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
     $.post(WST.U('admin/datas/get'),{id:id},function(data,textStatus){
           layer.close(loading);
           var json = WST.toAdminJson(data);
           if(json.id){
           		WST.setValues(json);
           		toEdit(json.id);
           }else{
           		WST.msg(json.msg,{icon:2});
           }
    });
}

function toEdit(id){
	var title = "新增数据";
	if(id>0){
		title = "编辑数据";
	}else{
		$('#dataForm')[0].reset();
	}
	var box = WST.open({title:title,type:1,content:$('#dataBox'),area: ['640px', '300px'],btn:['确定','取消'],
               end:function(){$('#dataBox').hide();},
		       yes:function(){
		            if(!$('#dataName').isValid())return;
		            if(!$('#dataVal').isValid())return;
	                var params = WST.getParams('.ipt');
	                params.catId = zTree.getSelectedNodes()[0].id;
	                params.id = id;
	                var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           		$.post(WST.U('admin/datas/'+((id==0)?"add":"edit")),params,function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	$('#dataForm')[0].reset();
	           			    	layer.close(box);
	           		            loadGrid(params.catId);
	           			  }else{
	           			        WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	          }});
}

function toDel(id,pid){
	var box = WST.confirm({content:"您确定要删除该数据吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/datas/del'),{id:id},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	layer.close(box);
	           		            loadGrid(pid);
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}
