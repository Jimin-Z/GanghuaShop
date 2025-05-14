var mmg;
function initGrid(p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/users/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'账号', field:'loginName'},
            {title:'昵称',field:'userName' ,templet: function(item){
                var html = '';
                if(item['wxOpenId'] && item['wxOpenId']!='')html = html+'<img class="order-source2" src="'+WST.conf.ROOT+'/wstmart/admin/view/img/order_source_1.png" title="有绑定微信"> ';
                if(item['weOpenId'] && item['weOpenId']!='')html = html+'<img class="order-source2" src="'+WST.conf.ROOT+'/wstmart/admin/view/img/order_source_5.png" title="有绑定小程序"> ';
                html = html +WST.blank(item['userName']);
                return html;
            }},
            {title:'手机号码', field:'userPhone'},
            {title:'电子邮箱', field:'userEmail'},
            {title:'积分', field:'userScore' },
            {title:'等级', field:'rank'},
            {title:'注册时间', field:'createTime' ,width:170},
            {title:'用户钱包', field:'userMoney' ,width:250,templet: function(item){
                return '<div style="line-height:20px">可用金额：￥'+item['userMoney']+'<br/>冻结金额：￥'+item['lockMoney']+'<br/>充值送：￥'+item['rechargeMoney']+'</div>';
            }},
            {title:'登录状态', field:'userStatus',width:120, templet: function(item){
                return '<input type="checkbox" '+((item['userStatus']==1)?"checked":"")+' lay-skin="switch" lay-filter="userStatus" data="'+item['userId']+'" lay-text="启用|停用">';
            }},
            {title:'操作', field:'' , fixed: 'right', width:200, align:'center', templet: function(item){
                return '<a data-id="'+item['userId']+'" class="btn btn-blue btngroup btn'+item['userId']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
            }}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                userQuery(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
            var btns = [];
            for(var i=0;i<res.data.length;i++){
                btns = [];
                if(WST.GRANT.HYGL_02)btns.push({title: '修改',cls:"btn-blue", icon:"fa-pencil",act:102});
                if(WST.GRANT.HYGL_03)btns.push({title: '删除',cls:"btn-blue", icon:"fa-pencil",act:103});
                btns.push({title: '积分',cls:"btn-blue", icon:"fa-search",act:104});
                btns.push({title: '用户资金',cls:"btn-blue", icon:"fa-search",act:105});
                btns.push({title: '消费信息',cls:"btn-blue", icon:"fa-search",act:106});
                layui.dropdown.render({
                    elem: '.btn'+res.data[i].userId,
                    dataId:res.data[i].userId,
                    userType:res.data[i].userType,
                    trigger: 'hover',
                    data: btns,
                    click: function(obj,othis){
                        switch(obj.act){
                            case 102:toEdit(this.dataId);break;
                            case 103:toDel(this.dataId,this.userType);break;
                            case 104:toUserScores(this.dataId);break;
                            case 105:toLogmoneys(this.dataId);break;
                            case 106:toOrders(this.dataId);break;
                        }
                    }
                });
            }
            layui.form.render();
            layui.form.on('switch(userStatus)', function(data){
                var id = $(this).attr("data");
                if(this.checked){
                    changeUserStatus(id, 1);
                }else{
                    changeUserStatus(id, 0);
                }
            });
        }
    });
}
function toEdit(id){
   location.href=WST.U('admin/users/toEdit','id='+id+'&p='+WST_CURR_PAGE);
}
function toUserScores(id){
    location.href=WST.U('admin/userscores/touserscores','id='+id+'&p='+WST_CURR_PAGE);
}
function toLogmoneys(id){
    location.href=WST.U('admin/logmoneys/tologmoneys','id='+id+'&src=users'+'&p='+WST_CURR_PAGE+"&type=0");
}
function toOrders(id){
    location.href=WST.U('admin/orders/index','userId='+id+'&p='+WST_CURR_PAGE+"&type=0");
}
function toDel(id,userType){
  var msg = (userType==1)?"您要删除的用户是商家用户，您确定要删除吗？":"您确定要删除该用户吗?";
	var box = WST.confirm({content:msg,yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/Users/del'),{id:id},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	layer.close(box);
	           		         userQuery(WST_CURR_PAGE);
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}

function userQuery(p){
    p=(p<=1)?1:p;
    var query = WST.getParams('.query');
    mmg.reload('dataTable',{where:query,page:{curr:p}});
}

function changeUserStatus(id, status){
  $.post(WST.U('admin/Users/changeUserStatus'), {'id':id, 'status':status}, function(data, textStatus){
    var json = WST.toAdminJson(data);
                    if(json.status=='1'){
                        WST.msg("操作成功",{icon:1});
                        userQuery(WST_CURR_PAGE);
                    }else{
                        WST.msg(json.msg,{icon:2});
                    }
  })
}

function editInit(p){
  var laydate = layui.laydate;
  laydate.render({elem: '#brithday'});
	/* 表单验证 */
  $('#userForm').validator({
            dataFilter: function(data) {
                if (data.ok === '该登录账号可用' ) return "";
                else return "已被注册";
            },
            rules: {
                loginName: function(element) {
                    return /\w{5,}/.test(element.value) || '账号应为5-16字母、数字或下划线';
                },
                myRemote: function(element){
                    return $.post(WST.U('admin/users/checkLoginKey'),{'loginName':element.value,'userId':$('#userId').val()},function(data,textStatus){});
                }
            },
            fields: {
                loginName: {
                  rule:"required;loginName;myRemote",
                  msg:{required:"请输入会员账号"},
                  tip:"请输入会员账号",
                  ok:"",
                },
                userPhone: {
                  rule:"mobile;myRemote",
                  ok:"",
                },
                userEmail: {
                  rule:"email;myRemote",
                  ok:"",
                },
                userScore: {
                  rule:"integer[+0]",
                  msg:{integer:"当前积分只能是正整数"},
                  tip:"当前积分只能是正整数",
                  ok:"",
                },
                userTotalScore: {
                  rule:"match[gte, userScore];integer[+0];",
                  msg:{integer:"当前积分只能是正整数",match:'会员历史积分必须不小于会员积分'},
                  tip:"当前积分只能是正整数",
                  ok:"",
                },
                userQQ: {
                  rule:"integer[+]",
                  msg:{integer:"QQ只能是数字"},
                  tip:"QQ只能是数字",
                  ok:"",
                },

            },

          valid: function(form){
            var params = WST.getParams('.ipt');
            var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
            $.post(WST.U('admin/Users/'+((params.userId==0)?"add":"edit")),params,function(data,textStatus){
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



//上传头像
  WST.upload({
      pick:'#adFilePicker',
      formData: {dir:'users'},
      accept: {extensions: 'gif,jpg,jpeg,png',mimeTypes: 'image/jpg,image/jpeg,image/png,image/gif'},
      callback:function(f){
        var json = WST.toAdminJson(f);
        if(json.status==1){
        $('#uploadMsg').empty().hide();
        //将上传的图片路径赋给全局变量
        $('#userPhoto').val(json.savePath+json.thumb);
        $('#preview').html('<img src="'+WST.conf.RESOURCE_PATH+'/'+json.savePath+json.thumb+'"  height="30" />');
        }else{
          WST.msg(json.msg,{icon:2});
        }
    },
    progress:function(rate){
        $('#uploadMsg').show().html('已上传'+rate+"%");
    }
    });
}

function toExport(){
  var params = {};
  params = WST.getParams('.query');
  var box = WST.confirm({content:"您确定要导出这些会员信息吗?",yes:function(){
      layer.close(box);
      location.href=WST.U('admin/users/toExport',params);
  }});
}
