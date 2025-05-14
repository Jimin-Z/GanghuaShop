var mmg,WST_CURR_PAGE = 0;
function initGrid(p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',url:WST.U('admin/navs/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#', type:'numbers'},
            {title:'导航类型', field:'navType',width:100,templet:function(item,rowIndex){
                return (item['navType']==0)?'顶部':'底部';
             }},
            {title:'导航名称', field:'navTitle',width:150},
            {title:'导航链接', field:'navUrl'},
            {title:'是否显示', field:'isShow', width:120, templet:function(item,rowIndex){
                return '<span class="layui-form"><input type="checkbox" '+ ((item.isShow==1)?"checked":"" )+' class="ipt" id="isShow" name="isShow" lay-skin="switch" lay-filter="isShow" data="'+item['id']+'" lay-text="显示|隐藏"></span>';
            }},
            {title:'打开方式', field:'isOpen',width:120, templet:function(item,rowIndex){
                return (item['isOpen']==1)?'<span style="cursor:pointer" onclick="isShowtoggle(\'isOpen\','+item['id']+', 0)">新窗口打开</span>':'<span style="cursor:pointer" onclick="isShowtoggle(\'isOpen\','+item['id']+', 1)">页面跳转</span>';
            }},
            {title:'排序号', field:'navSort',width:120,},
            {title:'操作', field:'' ,width:150, fixed:'right', templet: function(item,rowIndex){
                var h = "";
                if(WST.GRANT.DHGL_02 || WST.GRANT.DHGL_03)h = '<a class="btn btn-blue btngroup btn'+item['id']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
                return h
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
            for(var i=0;i<res.data.length;i++){
                 btns = [];
                 if(WST.GRANT.DHGL_02)btns.push({title: '修改',act: 100});
                 if(WST.GRANT.DHGL_03)btns.push({title: '删除',act: 101});
                 layui.dropdown.render({
                    elem: '.btn'+res.data[i].id,
                    dataId:res.data[i].id,
                    trigger: 'hover',
                    data: btns,
                    click: function(obj,othis){
                        switch(obj.act){
                           case 100:toEdit(this.dataId);break;
                           case 101:toDel(this.dataId);break;
                        }
                    }
                  });
            }


            layui.form.render();
            layui.form.on('switch(isShow)', function(data){
                var id = $(this).attr("data");
                if(this.checked){
                    isShowtoggle('isShow',id, 1);
                }else{
                    isShowtoggle('isShow',id, 0);
                }
            });
        }
    });
}

function loadGrid(p){
    p=(p<=1)?1:p;
    mmg.reload("mmg", { page:{curr:p}} );
}
function toEdit(id){
  location.href = WST.U('admin/navs/toEdit','id='+id+'&p='+WST_CURR_PAGE);
}
function toDel(id){
	var box = WST.confirm({content:"您确定要删除该记录吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/Navs/del'),{id:id},function(data,textStatus){
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
function edit(id,p){
  //获取所有参数
  var params = WST.getParams('.ipt');
    params.id = id;
    var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
    $.post(WST.U('admin/Navs/'+((id==0)?"add":"edit")),params,function(data,textStatus){
      layer.close(loading);
      var json = WST.toAdminJson(data);
      if(json.status=='1'){
          WST.msg("操作成功",{icon:1},function(){
             WST.backPrePage();
          });
          
      }else{
            WST.msg(json.msg,{icon:2});
      }
    });
}
function isShowtoggle(field, id, val){
	if(!WST.GRANT.DHGL_02)return;
	$.post(WST.U('admin/Navs/editiIsShow'), {'field':field, 'id':id, 'val':val}, function(data, textStatus){
		var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
                              loadGrid(WST_CURR_PAGE);
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	})
}


function changeFlink(obj){
     var flink = $(obj).val();
     if(flink==1)
       $("#articles").hide();
     else
       $("#articles").show();
     
}
function changeArticles(obj){
     var url = $(obj).val();
    
     $("#navUrl").val(url);
}
