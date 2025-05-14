
var mmg;
function initGrid(p){
	mmg = layui.table;
	mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('shop/stores/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
		cols: [[
			{title:'#',type:'numbers'},
			{title:'账号名', field:'loginName' ,width:150},
			{title:'门店名称', field:'storeName' ,width:150},
			{title:'所在地区', field:'storeAddress' , templet: function(item){
				return "<div>"+item['areaNames']+item['storeAddress']+"</div><div>"+item['storeTel']+"</div>";
			}},
			{title:'实景图片', field:'storeImg' ,width:120, templet: function(item){
				var thumb = item['storeImg'];
				thumb = thumb.replace('.','_thumb.');
				return "<span class='weixin'><img id='img' onmouseout='toolTip()' onmouseover='toolTip()' style='height:50px;' src='"+WST.conf.RESOURCE_PATH+"/"+thumb
					+"'><span class='imged' ><img  style='height:180px;max-width:480px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['storeImg']+"'></span></span>";
			}},
			{title:'启用状态', field:'storeStatus' ,width:150,sortable:true,templet: function(item){
				return '<input type="checkbox" '+((item['storeStatus']==1)?"checked":"")+' id="storeStatus" name="storeStatus" value="1" class="ipt" lay-skin="switch" lay-filter="storeStatus" data="'+item['storeId']+'" lay-text="启用|关闭">'
			}},
			{title:'创建时间', field:'createTime' ,width:200,sortable:true},
			{title:'操作', field:'' ,width:150, align:'center', fixed: 'right',templet: function(item){
				return '<a data-id="'+item['storeId']+'" class="btn btn-blue btngroup btn'+item['storeId']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
			}}
		]],
		done: function(res, curr, count){
			var e = this;
			var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
			if(count>0 && curr>total_page){
				loadGrid(total_page);
				return;
			}
			WST_CURR_PAGE = curr;
			var btns = [];
			btns.push({title: '编辑', clickFun:"toEdit", cls:"btn-blue", icon:"fa-pencil"});
			btns.push({title:'删除',clickFun:"del", cls:"btn-red", icon:"fa-trash-o"});
			WST.initGridButtons({id:'.btngroup',btns:btns});
			layui.form.render();
			layui.form.on('switch(storeStatus)', function(data){
				var id = $(this).attr("data");
				if(this.checked){
					toggleStoreStatus(id, 1);
				}else{
					toggleStoreStatus(id, 0);
				}
			});
		}
	});
}

function toggleStoreStatus( storeId, status){
	$.post(WST.U('shop/stores/setStoreStatus'), {'storeId':storeId, 'storeStatus':status}, function(data, textStatus){
		var json = WST.toJson(data);
		if(json.status=='1'){
			WST.msg("操作成功",{icon:1});
			loadGrid(WST_CURR_PAGE);
		}else{
			WST.msg(json.msg,{icon:2});
		}
	})
}


function loadGrid(p){
	p=(p<=1)?1:p;
    var params = WST.getParams('.s-query');
	params.areaIdPath = WST.ITGetAllAreaVals('areaId','j-areas').join('_');
	mmg.reload('dataTable',{where:params,page:{curr:p}});
}

function toEdit(storeId){
	location.href = WST.U('shop/stores/edit','storeId='+storeId+'&p='+WST_CURR_PAGE);
}
function toAdd(){
    location.href = WST.U('shop/stores/add','p='+WST_CURR_PAGE);
}
function toolTip(){
    WST.toolTip();
}


//删除角色
function del(id){
	var c = WST.confirm({content:'删除门店，并将删除门店下所有店员帐号与门店的关系，您确定要删除吗?',yes:function(){
		layer.close(c);
		var load = WST.load({msg:'正在删除，请稍后...'});
		$.post(WST.U('shop/stores/del'),{storeId:id},function(data,textStatus){
			layer.close(load);
		    var json = WST.toJson(data);
		    if(json.status==1){
		    	WST.msg(json.msg,{icon:1});
                loadGrid(WST_CURR_PAGE);
		    }else{
		    	WST.msg(json.msg,{icon:2});
		    }
		});
	}});
}


