var mmg;
function initGrid(p){
    var h = WST.pageHeight();
    var cols = [
        {title:'分组名称', field:'groupName'},
        {title:'排序号', field:'groupOrder' ,width:80},
        {title:'最低消费', field:'minMoney' ,width:120},
        {title:'最高消费', field:'maxMoney' ,width:120},
        {title:'操作', field:'' , align:'center', width:150,templet: function(item){
            var h = "";
            h = '<a class="btn btn-blue btngroup btn'+item['id']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
            return h
        }}
    ];
    mmg = layui.table;
    mmg.render({
        elem: '.mmg',
        id:'dataTable',
        url:WST.U('shop/shopmembergroups/pageQuery'),
        cellMinWidth: 80,height: WST.initGridHeight(),
        skin: 'line',
        even: true,
        limit:20,
        page:{curr:p},
        cols:[cols],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadGrid(total_page);
                return;
            }
            var btns = [];var item;
            for(var i=0;i<res.data.length;i++){
                 item = res.data[i];
                 btns = [];
                 btns.push({title: '编辑',clickFun:"getForEdit", cls:"btn-blue", icon:"fa-pencil",act:102});
                 btns.push({title: '删除',clickFun:"del", cls:"btn-red", icon:"fa-trash-o",act:103});
                 layui.dropdown.render({
                    elem: '.btn'+item.id,
                    dataId:item.id,
                    trigger: 'hover',
                    data: btns,
                    click: function(obj,othis){
                        switch(obj.act){
                           case 102:toEdit(this.dataId);break;
                           case 103:toDel(this.dataId);break;
                        }
                    }
                  });
            }
        }
    })
}

function loadGrid(p){
	p=(p<=1)?1:p;
    mmg.reload('dataTable',{
        page:{curr:p},
        where:{
            groupName:$('#groupName2').val()
        }
    });
}

function getForEdit(id){
	 var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
     $.post(WST.U('shop/shopmembergroups/get'),{id:id},function(data,textStatus){
           layer.close(loading);
           var json = WST.toJson(data);
           if(json.id){
           	  WST.setValues(json);
              toEdit(json.id);
           }else{
           		WST.msg(json.msg,{icon:2});
           }
    });
}
function toEdit(id){
	if(id==0){
      title = "新增";

  }else{
      title = "编辑";
  }
var box = WST.open({title:title,type:1,content:$('#editBox'),area: ['500px', '280px'],
		btn:['确定','取消'],end:function(){$('#editBox').hide();},yes:function(){
		$('#editForm').submit();
	},cancel:function () {
            $('#editForm')[0].reset();
        },btn2: function() {
            $('#editForm')[0].reset();
        },});
	$('#editForm').validator({
        fields: {
            groupName: {
            	rule:"required;",
            	msg:{required:"分组名称不能为空"},
            	tip:"请输入分组名称",
            	ok:""
            },
            minMoney: {
                rule:"required;",
                msg:{required:"最低消费不能为空"},
                tip:"请输入最低消费",
                ok:""
            },
            maxMoney: {
                rule:"required;",
                msg:{required:"最高消费不能为空"},
                tip:"请输入最高消费",
                ok:""
            }
        },
       valid: function(form){
		        var params = WST.getParams('.ipt');
	                params.id = id;
	                var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           		$.post(WST.U('shop/shopmembergroups/'+((id==0)?"add":"edit")),params,function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	$('#editBox').hide();
	           			    	$('#editForm')[0].reset();
	           			    	layer.close(box);
                              loadGrid(WST_CURR_PAGE);
	           			  }else{
	           			        WST.msg(json.msg,{icon:2});
	           			  }
	           		});

    	}

  });

}
//删除
function del(id){
	var c = WST.confirm({content:'您确定要删除该分组吗?',yes:function(){
		layer.close(c);
		var load = WST.load({msg:'正在删除，请稍后...'});
		$.post(WST.U('shop/shopmembergroups/del'),{id:id},function(data,textStatus){
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

//设置分组
function setGroup(){

}
