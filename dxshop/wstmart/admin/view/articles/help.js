var mmg,combo;
function initGrid(p){
	mmg = layui.table;
	mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/articles/pageQueryByHelp'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
		cols: [[
			{title:'#',type:'numbers'},
			{type: 'checkbox', field:'articleId'},
			{title:'ID',  field:'articleId',width:60},
			{title:'标题', field:'articleTitle'},
			{title:'分类', field:'catName',width:150},
			{title:'是否显示', field:'isShow' ,width:120,templet: function(item){
				return '<form autocomplete="off" class="layui-form" lay-filter="gridForm"><input type="checkbox" id="isShow" name="isShow" '+((item['isShow']==1)?"checked":"")+' lay-skin="switch" value="1" lay-filter="isShow" lay-text="显示|隐藏" data="'+item['articleId']+'"></form>';
			}},
			{title:'最后编辑者', field:'staffName',width:120},
			{title:'创建时间', field:'createTime' ,width:170},
			{title:'排序号', name:'catSort' ,width:80, templet: function(item){
				return '<span style="color:blue;cursor:pointer;" ondblclick="changeSort(this,'+item["articleId"]+');">'+item['catSort']+'</span>';
			}},
			{title:'操作', field:'' , fixed: 'right', width:150, align:'center', templet: function(item){
				return '<a data-id="'+item['articleId']+'" class="btn btn-blue btngroup btn'+item['articleId']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
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
			if(WST.GRANT.DPBZ_02)btns.push({title: '修改', clickFun:"toEdit", cls:"btn-blue", icon:"fa-pencil"});
			if(WST.GRANT.DPBZ_03)btns.push({title:'删除',clickFun:"toDel", cls:"btn-red", icon:"fa-trash-o"});
			WST.initGridButtons({id:'.btngroup',btns:btns});
			layui.form.render();
			layui.form.on('switch(isShow)', function(data){
				var id = $(this).attr("data");
				if(this.checked){
					toggleIsShow(1,id);
				}else{
					toggleIsShow(0,id);
				}
			});
		}
	});
}

function loadGrid(p){
	p=(p<=1)?1:p;
	mmg.reload('dataTable',{where:{key:$('#key').val(),catId:$('#catId').val()},page:{curr:p}});
}

function toggleIsShow(t,v){
	if(!WST.GRANT.DPBZ_02)return;
    var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
    	$.post(WST.U('admin/articles/editiIsShow'),{id:v,isShow:t},function(data,textStatus){
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

function toEdit(id){
	location.href=WST.U('admin/articles/toEditHelp','id='+id+'&p='+WST_CURR_PAGE);
}

function toEdits(id,p){
    var params = WST.getParams('.ipt');
    params.id = id;
    if(params.TypeStatus == 4){
    	params.coverImg = '';
    }
    var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	$.post(WST.U('admin/articles/'+((id>0)?"editHelp":"addHelp")),params,function(data,textStatus){
		  layer.close(loading);
		  var json = WST.toAdminJson(data);
		  if(json.status=='1'){
			  WST.msg(json.msg,{icon:1},function(){
				  WST.backPrePage();
			  });
		  }else{
		        WST.msg(json.msg,{icon:2});
		  }
	});
}

function toDel(id){
	var box = WST.confirm({content:"您确定要删除该文章吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/articles/delHelp'),{id:id},function(data,textStatus){
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

function toBatchDel(){
	var rows = mmg.checkStatus("dataTable").data;
	if(rows.length==0){
		WST.msg('请选择要删除的文章',{icon:2});
		return;
	}
	var ids = [];
	for(var i=0;i<rows.length;i++){
       ids.push(rows[i]['articleId']);
	}
	var box = WST.confirm({content:"您确定要删除这些文章吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/articles/delByBatchHelp'),{ids:ids.join(',')},function(data,textStatus){
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
var oldSort;
function changeSort(t,id){
   $(t).attr('ondblclick'," ");
var html = "<input type='text' id='sort-"+id+"' style='width:30px;padding:2px;' onblur='doneChange(this,"+id+")' value='"+$(t).html()+"' />";
 $(t).html(html);
 $('#sort-'+id).focus();
 $('#sort-'+id).select();
 oldSort = $(t).html();
}
function doneChange(t,id){
  var sort = ($(t).val()=='')?0:$(t).val();
  if(sort==oldSort){
    $(t).parent().attr('ondblclick','changeSort(this,'+id+')');
    $(t).parent().html(parseInt(sort));
    return;
  }
  $.post(WST.U('admin/articles/changeSort'),{id:id,catSort:sort},function(data){
    var json = WST.toAdminJson(data);
    if(json.status==1){
        $(t).parent().attr('ondblclick','changeSort(this,'+id+')');
        $(t).parent().html(parseInt(sort));
    }
  });
}
