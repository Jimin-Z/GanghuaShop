var mmg;
function initGrid(p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/switchs/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            { title: 'PC端网址', field: 'homeURL'},
            { title: '手机端网址', field: 'mobileURL'},
            { title: '微信端网址', field: 'wechatURL'},
            {title:'操作', field:'' , fixed: 'right', width:200, align:'center', templet: function(item){
                    return '<a data-id="'+item['id']+'" class="btn btn-blue btngroup btn'+item['id']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
                }}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadQuery(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
            var btns = [];
            if(WST.GRANT.YMQH_02)btns.push({title: '修改', clickFun:"getForEdit", cls:"btn-blue", icon:"fa-pencil"});
            if(WST.GRANT.YMQH_03)btns.push({title:'删除',clickFun:"toDel", cls:"btn-red", icon:"fa-trash-o"});
            WST.initGridButtons({id:'.btngroup',btns:btns});
        }
    });
}
function loadGrid(p){
    p=(p<=1)?1:p;
    mmg.reload('dataTable',{page:{curr:p}});
}
function toDel(id){
	var box = WST.confirm({content:"您确定要删除该记录吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/switchs/del'),{id:id},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	layer.close(box);
                              loadGrid(WST_CURR_PAGE);
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}
function getForEdit(id){
    var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
    $.post(WST.U('admin/switchs/get'),{id:id},function(data,textStatus){
        layer.close(loading);
        var json = WST.toAdminJson(data);
        if(json['id']>0){
            WST.setValues(json);
            toEdit(json['id']);
        }else{
            WST.msg(json.msg,{icon:2});
        }
    });
}
function toEdit(id){
    if(id==0){
        $('#switchForm')[0].reset();
    }
	var box = WST.open({title:"新增",type:1,content:$('#switchBox'),area: ['450px', '300px'],
		  btn:['确定','取消'],yes:function(){
          save(0,box);
      },
      btn2:function(){$('#switchBox').hide();},
      cancel:function(){$('#switchBox').hide();}
    });
}

function save(type,box){
   var params = WST.getParams('.ipt');
   var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
   $.post(WST.U('admin/switchs/'+((params.id==0)?'add':'edit')),params,function(data,textStatus){
        layer.close(loading);
        var json = WST.toAdminJson(data);
        if(json.status=='1'){
            WST.msg("操作成功",{icon:1});
            if(type==0){
                $('#switchForm')[0].reset();
                $('#switchBox').hide();
                layer.close(box);
            }else{
              $('#switchForm')[0].reset();
            }
            loadGrid(WST_CURR_PAGE);
            return;
        }else{
            WST.msg(json.msg,{icon:2});
            return;
        }
   });
}
