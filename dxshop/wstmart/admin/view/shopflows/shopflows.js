var mmg;
function initGrid(p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/shopflows/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'步骤名称', field:'flowName'},
            {title:'排序', field:'sort' ,width:80,templet: function(item){
                return '<span style="color:blue;cursor:pointer;" ondblclick="changeSort(this,'+item["flowId"]+');">'+item['sort']+'</span>';
            }},
            {title:'是否显示', field:'isShow' ,width:150,templet: function(item){
                var disabled="";
                if(item['isDelete'] == 0)disabled='disabled=disabled';
                return '<form autocomplete="off" class="layui-form" lay-filter="gridForm"><input type="checkbox" id="isShow" name="isShow" '+((item['isShow']==1)?"checked":"")+' lay-skin="switch" value="1" lay-filter="isShow" lay-text="显示|隐藏" '+disabled+' data="'+item['flowId']+'"></form>';
            }},
            {title:'操作', field:'' , fixed: 'right', width:150, align:'center', templet: function(item){
                return '<a data-id="'+item['flowId']+'" class="btn btn-blue btngroup btn'+item['flowId']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
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
            for(var i=0;i<res.data.length;i++){
                btns = [];
                if(WST.GRANT.RZLC_02)btns.push({title: '查看',clickFun:"toEditFlow", cls:"btn-blue", icon:"fa-search"});
                if(WST.GRANT.RZLC_02)btns.push({title: '修改',clickFun:"getForEdit", cls:"btn-blue", icon:"fa-pencil"});
                if(WST.GRANT.RZLC_03 && res.data[i]['isDelete']==1)btns.push({title: '删除',clickFun:"toDel", cls:"btn-red", icon:"fa fa-trash-o"});
                layui.dropdown.render({
                    elem: '.btn'+res.data[i].flowId,
                    dataId:res.data[i].flowId,
                    trigger: 'hover',
                    data: btns,
                    click: function(obj,othis){
                        var _fn = window[obj.clickFun];
                        if($(this.elem).data('fun-'+obj.clickFun)){
                            _fn && eval(obj.clickFun+'('+$(this.elem).data('fun-'+obj.clickFun)+')');
                        }else{
                            _fn && _fn($(this.elem).data('id'));
                        }
                    }
                });
            }
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
    mmg.reload('dataTable',{page:{curr:p}});
}

function getForEdit(id){
	 var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
     $.post(WST.U('admin/shopflows/get'),{id:id},function(data,textStatus){
           layer.close(loading);
           var json = WST.toAdminJson(data);
           if(json.flowId){
           		WST.setValues(json);
           		toEdit(json.flowId);
           }else{
           		WST.msg(json.msg,{icon:2});
           }
    });
}

function toEdit(id){
	var title =(id==0)?"新增":"编辑";
	var box = WST.open({title:title,type:1,content:$('#flowBox'),area: ['550px', '280px'],btn: ['确定','取消'],yes:function(){
			$('#flowForm').submit();
	},cancel:function(){
		//重置表单
		$('#flowForm')[0].reset();

	},end:function(){
		$('#flowBox').hide();
		//重置表单
		$('#flowForm')[0].reset();

	}});
	$('#flowForm').validator({
        fields: {
            flowName: {
            	rule:"required;",
            	msg:{required:"请输入步骤名称"},
            	tip:"请输入步骤名称",
            	ok:"",
            }
        },
       valid: function(form){
		        var params = WST.getParams('.ipt');
		        	params.flowId = id;
		        var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
		   		$.post(WST.U('admin/shopflows/'+((id==0)?"add":"edit")),params,function(data,textStatus){
		   			  layer.close(loading);
		   			  var json = WST.toAdminJson(data);
		   			  if(json.status=='1'){
		   			    	WST.msg("操作成功",{icon:1});
		   			    	$('#flowForm')[0].reset();
		   			    	layer.close(box);
                          loadGrid(WST_CURR_PAGE)
		   			  }else{
		   			        WST.msg(json.msg,{icon:2});
		   			  }
		   		});

    	}

  });
}

function toDel(id){
	var box = WST.confirm({content:"您确定要删除该步骤吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/shopflows/del'),{id:id},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	layer.close(box);
                              loadGrid(WST_CURR_PAGE)
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
    $.post(WST.U('admin/shopflows/changeSort'),{id:id,sort:sort},function(data){
        var json = WST.toAdminJson(data);
        if(json.status==1){
            $(t).parent().attr('ondblclick','changeSort(this,'+id+')');
            $(t).parent().html(parseInt(sort));
        }
    });
}

function toggleIsShow(t,v){
    if(!WST.GRANT.RZLC_02)return;
    var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
    $.post(WST.U('admin/shopflows/editiIsShow'),{id:v,isShow:t},function(data,textStatus){
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

function toEditFlow(id){
    location.href=WST.U('admin/shopflows/toEditFlow','id='+id);
}





