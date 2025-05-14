var mmg;
$(function(){
    var laydate = layui.laydate;
    laydate.render({
        elem: '#startDate'
    });
    laydate.render({
        elem: '#endDate'
    });
    layer.photos({
        photos: '.feedback-content-gallery',
        area: ['20%','auto']
    });
})
function initGrid(p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/feedbacks/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'用户', field:'userName',width:120 },
            {title: '反馈类型', field:'feedbackType',width:120},
            {title: '反馈内容', field:'feedbackContent'},
            {title: '联系方式', field:'contactInfo',width:170},
            {title: '创建时间', field:'createTime',width:170},
            {title:'处理状态', field:'feedbackStatus' ,width:150,templet:function(item){
                    if(item['feedbackStatus']==0){
                        return "<span class='statu-wait'><i class='fa fa-clock-o'></i> "+item['feedbackStatusName']+"</span>";
                    }else{
                        return "<span class='statu-yes'><i class='fa fa-check-circle'></i> "+item['feedbackStatusName']+"</span>";
                    }
                }},
            {title:'操作', field:'' ,width:200, fixed: 'right',align:'center', templet: function(item){
                    return '<a data-id="'+item['feedbackId']+'" class="btn btn-blue btngroup btn'+item['feedbackId']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
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
                if(res.data[i]['feedbackStatus'] == 0){
                    if(WST.GRANT.GNFK_02)btns.push({title: '回复',clickFun:"toEdit", cls:"btn-blue", icon:"fa-pencil"});
                }else{
                    btns.push({title: '查看',clickFun:"toEdit", cls:"btn-blue", icon:"fa-pencil"});
                }
                if(WST.GRANT.GNFK_03)btns.push({title: '删除',clickFun:"toDel", cls:"btn-red", icon:"fa fa-trash-o"});
                layui.dropdown.render({
                    elem: '.btn'+res.data[i].feedbackId,
                    dataId:res.data[i].feedbackId,
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
        }
    });
}

function loadGrid(p){
    p=(p<=1)?1:p;
    var query = WST.getParams('.ipt');
    mmg.reload('dataTable',{where:query,page:{curr:p}});
}

function toDel(id){
    var box = WST.confirm({content:"您确定要删除该反馈吗?",yes:function(){
        var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
        $.post(WST.U('admin/feedbacks/del'),{feedbackId:id},function(data,textStatus){
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

function toEdit(id){
    location.href=WST.U('admin/feedbacks/toEdit','feedbackId='+id+'&p='+WST_CURR_PAGE);
}

function toEdits(id,p){
    var params = WST.getParams('.ipt');
    params.feedbackId = id;
    var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
    $.post(WST.U('admin/feedbacks/edit'),params,function(data,textStatus){
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
