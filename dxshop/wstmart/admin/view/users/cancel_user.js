var mmg;
function initGrid(p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/users/cancelPageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'账号', field:'loginName'},
            {title:'昵称', field:'userName' ,templet: function(item){
                var html = '';
                if(item['wxOpenId'] && item['wxOpenId']!='')html = html+'<img class="order-source2" src="'+WST.conf.ROOT+'/wstmart/admin/view/img/order_source_1.png" title="有绑定微信"> ';
                if(item['weOpenId'] && item['weOpenId']!='')html = html+'<img class="order-source2" src="'+WST.conf.ROOT+'/wstmart/admin/view/img/order_source_5.png" title="有绑定小程序"> ';
                html = html +WST.blank(item['userName']);
                return html;
            }},
            {title:'手机号码', field:'userPhone'},
            {title:'电子邮箱', field:'userEmail' },
            {title:'积分', field:'userScore' },
            {title:'用户钱包', field:'userMoney' ,width:200,templet: function(item){
                return '<div style="line-height:20px">可用金额：￥'+item['userMoney']+'<br/>冻结金额：￥'+item['lockMoney']+'<br/>充值送：￥'+item['rechargeMoney']+'</div>';
            }},
            {title:'申请注销时间', field:'applyCancelTime' ,width:200},
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
                if(WST.GRANT.HYZXSQ_02)btns.push({title: '通过',clickFun:"cancelAllow",cls:"btn-blue", icon:"fa-check",act:102});
                if(WST.GRANT.HYZXSQ_02)btns.push({title: '不通过',clickFun:"cancelIllegal",cls:"btn-red", icon:"fa-ban",act:103});
                btns.push({title: '积分',clickFun:"toUserScores",cls:"btn-blue", icon:"fa-search",act:104});
                btns.push({title: '用户资金',clickFun:"toLogmoneys",cls:"btn-blue", icon:"fa-search",act:105});
                btns.push({title: '消费信息',clickFun:"toOrders",cls:"btn-blue", icon:"fa-search",act:106});
                WST.initGridButtons({id:'.btngroup',btns:btns});
            }
        }
    });
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

function cancelAllow(id){
    var msg = "您确定通过该注销申请吗?";
    var box = WST.confirm({content:msg,yes:function(){
            var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
            $.post(WST.U('admin/Users/cancelAllow'),{id:id},function(data,textStatus){
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

function cancelIllegal(id){
    var w = WST.open({type: 1,title:"注销申请不通过原因",shade: [0.6, '#000'],border: [0],
        content: '<textarea id="illegalRemarks" rows="7" style="width:100%" maxLength="200"></textarea>',
        area: ['500px', '260px'],btn: ['确定', '关闭窗口'],
        yes: function(index, layero){
            var illegalRemarks = $.trim($('#illegalRemarks').val());
            if(illegalRemarks==''){
                WST.msg('请输入原因 !', {icon: 2});
                return;
            }
            var ll = WST.msg('数据处理中，请稍候...',{time:6000000});
            $.post(WST.U('admin/Users/cancelIllegal'),{id:id,illegalRemarks:illegalRemarks},function(data){
                layer.close(w);
                layer.close(ll);
                var json = WST.toAdminJson(data);
                if(json.status>0){
                    WST.msg(json.msg, {icon: 1});
                    userQuery(WST_CURR_PAGE);
                }else{
                    WST.msg(json.msg, {icon: 2});
                }
            });
        }
    });
}

function userQuery(p){
    p=(p<=1)?1:p;
    var query = WST.getParams('.query');
    mmg.reload('dataTable',{where:query,page:{curr:p}});
}


