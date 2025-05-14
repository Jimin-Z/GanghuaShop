var mmg;
function initGrid(p){
	var parentId=$('#h_areaId').val();
	mmg = layui.table;
	mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/areas/pageQuery',{parentId:parentId}),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
		cols: [[
			{title:'#',type:'numbers'},
			{title:'地区名称', field:'areaName'},
			{title:'是否显示', field:'isShow',width:150,templet: function(item){
				return '<input type="checkbox" '+((item['isShow']==1)?"checked":"")+' name="isShow2" lay-skin="switch" lay-filter="isShow2" data="'+item['areaId']+'" lay-text="显示|隐藏">';
			}},
			{title:'排序字母',field:'areaKey',width:120},
			{title:'排序号',field:'areaSort',width:80},
			{title:'操作', field:'' , fixed: 'right', width:150, align:'center', templet: function(item){
				return '<a data-id="'+item['areaId']+'" class="btn btn-blue btngroup btn'+item['areaId']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
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
			btns.push({title: '查看', clickFun:"toView", cls:"btn-blue", icon:"fa-search"});
			if(WST.GRANT.DQGL_02)btns.push({title: '修改', clickFun:"toEdit", cls:"btn-blue", icon:"fa-pencil"});
			if(WST.GRANT.DQGL_03)btns.push({title:'删除',clickFun:"toDel", cls:"btn-red", icon:"fa-trash-o"});
			WST.initGridButtons({id:'.btngroup',btns:btns});
			layui.form.render();
			layui.form.on('switch(isShow2)', function(data){
				var id = $(this).attr("data");
				if(this.checked){
					toggleIsShow(0,id);
				}else{
					toggleIsShow(1,id);
				}
			});
		}
	});
}
function loadGrid(p){
	p=(p<=1)?1:p;
	mmg.reload('dataTable',{page:{curr:p}});
}

function toggleIsShow(t,v){
	if(!WST.GRANT.DQGL_02)return;
    var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
    	$.post(WST.U('admin/areas/editiIsShow'),{id:v,isShow:t},function(data,textStatus){
			  layer.close(loading);
			  var json = WST.toAdminJson(data);
			  if(json.status=='1'){
			    	WST.msg(json.msg,{icon:1});
                  loadGrid(WST_CURR_PAGE);
			  }else{
			    	WST.msg(json.msg,{icon:2});
			  }
		});
}

function toReturn(){
	location.href=WST.U('admin/areas/index','parentId='+$('#h_parentId').val()+'&p='+WST_CURR_PAGE);
}

function letterOnblur(obj){
	if($.trim(obj.value)=='')return;
	var loading = WST.msg('正在生成排序字母，请稍后...', {icon: 16,time:60000});
	$.post(WST.U('admin/areas/letterObtain'),{code:obj.value},function(data,textStatus){
		layer.close(loading);
		var json = WST.toAdminJson(data);
		if(json.status == 1){
			$('#areaKey').val(json.msg);
		}
	});
}

function toEdit(id,pid){
	$('#areaForm')[0].reset();
	if(id>0){
		var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
		$.post(WST.U('admin/areas/get'),{id:id},function(data,textStatus){
			layer.close(loading);
			var json = WST.toAdminJson(data);
			if(json){
				WST.setValues(json);
				layui.form.render();
				editsBox(id);
			}
		});
	}else{
		WST.setValues({parentId:pid,areaId:0});
		layui.form.render();
		editsBox(id);
	}
}
function toView(id){
	location.href = WST.U('admin/areas/index','parentId='+id);
}
function editsBox(id){
	var box = WST.open({title:(id>0)?'修改地区':"新增地区",type:1,content:$('#areasBox'),area: ['460px', '360px'],btn:['确定','取消'],
		end:function(){$('#areasBox').hide();},yes:function(){
		$('#areaForm').submit();
	          }});
	$('#areaForm').validator({
	    fields: {
	    	areaName: {
	    		tip: "请输入地区名称",
	    		rule: '地区名称:required;length[~10];'
	    	},
		    areaKey: {
	    		tip: "请输入排序字母",
	    		rule: '排序字母:required;length[~1];'
	    	},
	    	areaSort: {
            	tip: "请输入排序号",
            	rule: '排序号:required;length[~8];'
            }
	    },
	    valid: function(form){
	        var params = WST.getParams('.ipt');
	        var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	    		$.post(WST.U('admin/areas/'+((id>0)?"edit":"add")),params,function(data,textStatus){
	    			  layer.close(loading);
	    			  var json = WST.toAdminJson(data);
	    			  if(json.status=='1'){
	    			    	WST.msg(json.msg,{icon:1});
	    			    	$('#areasBox').hide();
	    			    	layer.close(box);
                          loadGrid(WST_CURR_PAGE);
	    			  }else{
	    			        WST.msg(json.msg,{icon:2});
	    			  }
	    		});
	    }
	});
}

function toDel(id){
	var box = WST.confirm({content:"您确定要删除该地区吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/areas/del'),{id:id},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg(json.msg,{icon:1});
	           			    	layer.close(box);
                              loadGrid(WST_CURR_PAGE);
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}
function hotCity(){
	location.href = WST.U("admin/areas/hotcity");
}

function hotCityInit(){
	$(".city-item").click(function(){
		var _input = $(this).find(".ipt");
		var _obj = $(_input);
		var _val = _obj.val();
		var _text = _obj.attr("title");
		var _checked = _obj.prop("checked");
		_obj.prop("checked", !_checked)
		if(!_checked){
			// 选中
			$(".hc-list").append('<div class="hc-item" id="hot_city_'+_val+'">'+_text+' <span id='+_val+' onclick="disCheck(this)">x</span></div>')
		}else{
			// 取消选中
			$("#hot_city_"+_val).remove();
		}
	});
	$(".ipt").click(function(e){
		var _obj = $(this);
		var _val = _obj.val();
		var _text = _obj.attr("title");
		if(_obj.prop("checked")){
			// 选中
			$(".hc-list").append('<div class="hc-item" id="hot_city_'+_val+'">'+_text+' <span id='+_val+' onclick="disCheck(this)">x</span></div>')
		}else{
			// 取消选中
			$("#hot_city_"+_val).remove();
		}
		e.stopPropagation()
	});
}


// 删除热门城市
function disCheck(obj){
	var id = $(obj).attr("id");
	$('#chk_'+id).prop("checked", false);
	$(obj).parent().remove();
}
function getIds(){
	var checkedIpts = $(".ipt").filter(function(k,v){
		return $(v).prop("checked");
	});
	var _ids = [];
	checkedIpts.map(function(k,v){
		_ids.push($(v).val());
	});
	return _ids;
}
function commit(){
	var ids = getIds();
	var params = {};
	params.ids = ids.join(",");
	var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	$.post(WST.U('admin/areas/setHotCity'),params,function(data,textStatus){
		layer.close(loading);
		var json = WST.toAdminJson(data);
		if(json.status=='1'){
			WST.msg(json.msg,{icon:1});
		}else{
			WST.msg(json.msg,{icon:2});
		}
	});
}
