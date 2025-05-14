var mmg;
function initGrid(p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/userranks/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'会员等级图标', field:'userrankImg',width:120, templet: function(item){
                return '<img src="'+WST.conf.RESOURCE_PATH+'/'+item['userrankImg']+'" height="28px" />';
            }},
            {title:'会员等级名称', field:'rankName'},
            {title:'积分下限', field:'startScore',width:120},
            {title:'积分上限', field:'endScore',width:120},
            {title:'操作', field:'' , fixed: 'right', width:150, align:'center', templet: function(item){
                return '<a data-id="'+item['rankId']+'" class="btn btn-blue btngroup btn'+item['rankId']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
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
            if(WST.GRANT.HYDJ_02)btns.push({title: '修改', clickFun:"toEdit", cls:"btn-blue", icon:"fa-pencil"});
            if(WST.GRANT.HYDJ_03)btns.push({title:'删除',clickFun:"toDel", cls:"btn-red", icon:"fa-trash-o"});
            WST.initGridButtons({id:'.btngroup',btns:btns});
        }
    });
}
function loadGrid(p){
    p=(p<=1)?1:p;
    mmg.reload('dataTable',{page:{curr:p}});
}
function toEdit(id){
    location.href = WST.U('admin/userranks/toEdit','id='+id+'&p='+WST_CURR_PAGE);
}
function toDel(id){
	var box = WST.confirm({content:"您确定要删除该记录吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/userranks/del'),{id:id},function(data,textStatus){
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

function editInit(p){
 /* 表单验证 */
    $('#userRankForm').validator({
            fields: {
                rankName: {
                  rule:"required",
                  msg:{required:"请输入会员等级名称"},
                  tip:"请输入会员等级名称",
                  ok:"",
                },
                userrankImg: {
                  rule:"required",
                  msg:{required:"请输上传会员图标"},
                  tip:"请输上传会员图标",
                  ok:"",
                }

            },

          valid: function(form){
            var params = WST.getParams('.ipt');
            var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
            $.post(WST.U('admin/userranks/'+((params.rankId==0)?"add":"edit")),params,function(data,textStatus){
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

    });

//文件上传
WST.upload({
    pick:'#userranksPicker',
    formData: {dir:'userranks'},
    accept: {extensions: 'gif,jpg,jpeg,png',mimeTypes: 'image/jpg,image/jpeg,image/png,image/gif'},
    callback:function(f){
      var json = WST.toAdminJson(f);
      if(json.status==1){
      $('#uploadMsg').empty().hide();
      //保存上传的图片路径
      $('#userrankImg').val(json.savePath+json.thumb);
      $('#preview').html('<img src="'+WST.conf.RESOURCE_PATH+'/'+json.savePath+json.thumb+'" height="30" />');
      }else{
        WST.msg(json.msg,{icon:2});
      }
  },
  progress:function(rate){
      $('#uploadMsg').show().html('已上传'+rate+"%");
  }
});


};





