var mmg;
function initGrid(p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/banks/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            { title: '银行名称', field: 'bankName',templet:function(item){
                if(item['bankImg'] && item['bankImg']!=''){
                    return '<img src="'+WST.conf.RESOURCE_PATH+'/'+item['bankImg']+'" height="28px" />&nbsp;'+item['bankName'];
                }
                return '<span style="margin-left:32px">'+item['bankName']+'</span>';
            }},
            {title:'银行代码', field:'bankCode',width:120},
            {title:'是否启用', field:'isShow',width:150, templet:function(item){
                return '<input type="checkbox" '+((item['isShow']==1)?"checked":"")+' name="isShow2" lay-skin="switch" lay-filter="isShow2" data="'+item['bankId']+'" lay-text="显示|隐藏">';
            }},
            {title:'操作', field:'' , fixed: 'right', width:150, align:'center', templet: function(item){
                return '<a data-id="'+item['bankId']+'" class="btn btn-blue btngroup btn'+item['bankId']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
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
            if(WST.GRANT.YHGL_02)btns.push({title: '修改', clickFun:"getForEdit", cls:"btn-blue", icon:"fa-pencil"});
            if(WST.GRANT.YHGL_03)btns.push({title:'删除',clickFun:"toDel", cls:"btn-red", icon:"fa-trash-o"});
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
function toggleIsShow(t,v){
  if(!WST.GRANT.YHGL_02)return;
    var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
      $.post(WST.U('admin/banks/editiIsShow'),{id:v,isShow:t},function(data,textStatus){
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
function loadGrid(p){
    p=(p<=1)?1:p;
    mmg.reload('dataTable',{page:{curr:p}});
}
function toDel(id){
	var box = WST.confirm({content:"您确定要删除该记录吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/banks/del'),{id:id},function(data,textStatus){
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
     $.post(WST.U('admin/banks/get'),{id:id},function(data,textStatus){
           layer.close(loading);
           var json = WST.toAdminJson(data);
           if(json.bankId){
           		WST.setValues(json);
              $('#isShow')[0].checked = (json.isShow==1);
              layui.form.render();
              $('#preview').empty();
              if(json.bankImg && json.bankImg!='')$('#preview').html('<img src="'+WST.conf.RESOURCE_PATH+'/'+json.bankImg+'" height="30"  />');
           		toEdit(json.bankId);
           }else{
           		WST.msg(json.msg,{icon:2});
           }
    });
}
function initUpload(){
  //文件上传
  WST.upload({
      pick:'#bankImgPicker',
      formData: {dir:'banks'},
      accept: {extensions: 'gif,jpg,jpeg,png',mimeTypes: 'image/jpg,image/jpeg,image/png,image/gif'},
      callback:function(f){
        var json = WST.toAdminJson(f);
        if(json.status==1){
          $('#uploadMsg').empty().hide();
          $('#bankImg').val(json.savePath+json.thumb);
          $('#preview').html('<img src="'+WST.conf.RESOURCE_PATH+'/'+json.savePath+json.thumb+'" height="30" />');
        }else{
            WST.msg(json.msg,{icon:2});
        }
    },
    progress:function(rate){
        $('#uploadMsg').show().html('已上传'+rate+"%");
    }
  });
}
var isInitUpload = false;
function resetBank(){
    $("#bankName").val("");
    $("#bankImg").val("");
    $("#preview").empty();
}
function toEdit(id){
	if(id==0){
      title = "新增";
      resetBank();
  }else{
      title = "编辑";
  }
  if(!isInitUpload){
     isInitUpload = true;
     initUpload();
  }
	var box = WST.open({title:title,type:1,content:$('#bankBox'),area: ['650px', '380px'],
		btn:['确定','取消'],end:function(){$('#bankBox').hide();},yes:function(){
		$('#bankForm').submit();
	},cancel:function () {
            resetBank();
        },btn2: function() {
            resetBank();
        },});
	$('#bankForm').validator({
        fields: {
            bankName: {
            	rule:"required;",
            	msg:{required:"银行名称不能为空"},
            	tip:"请输入银行名称",
            	ok:""
            }
        },
       valid: function(form){
		        var params = WST.getParams('.ipt');
	                params.bankId = id;
	                var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           		$.post(WST.U('admin/banks/'+((id==0)?"add":"edit")),params,function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	$('#bankBox').hide();
	           			    	$('#bankForm')[0].reset();
	           			    	layer.close(box);
                              loadGrid(WST_CURR_PAGE);
	           			  }else{
	           			        WST.msg(json.msg,{icon:2});
	           			  }
	           		});

    	}

  });

}
