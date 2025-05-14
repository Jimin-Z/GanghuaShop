var laytpl = layui.laytpl;
var mmg;
function initGrid(p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'msgTable',url:WST.U('shop/Messages/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {type: 'checkbox', field:'id'},
            {title:'消息', field:'msgContent',templet: function(item){
                    if(item['msgStatus'] == 0){
                        return "<i class='fa fa-envelope fa-lg'></i-o'></i> "+item['msgContent'];
                    }else{
                        return "<i class='fa fa-envelope-open-o fa-lg'></i> "+item['msgContent'];
                    }
                }},
            {title:'时间', field:'createTime' ,width:200},
            {title:'操作', field:'' , fixed: 'right', width:150, align:'center', templet: function(item){
                return '<a data-id="'+item['id']+'" class="btn btn-blue btngroup btn'+item['id']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
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
            btns.push({title: '查看', clickFun:"showMsg", cls:"btn-blue", icon:"fa-search"});
            btns.push({title: '删除',clickFun:"delMsg", cls:"btn-red", icon:"fa-trash-o"});
            WST.initGridButtons({id:'.btngroup',btns:btns});
        }
    });
}

function loadGrid(p){
    p = (p<=1)?1:p;
    mmg.reload('msgTable',{page:{curr:p}});
}

function showMsg(id){
  location.href=WST.U('shop/messages/showShopMsg','msgId='+id+'&p='+WST_CURR_PAGE);
}

function delMsg(id){
WST.confirm({content:"您确定要删除该消息吗？", yes:function(tips){
  var ll = WST.load({msg:'数据处理中，请稍候...'});
  $.post(WST.U('shop/messages/del'),{id:id},function(data,textStatus){
    layer.close(ll);
      layer.close(tips);
    var json = WST.toJson(data);
    if(json.status=='1'){
      WST.msg('操作成功!', {icon: 1}, function(){
         loadGrid(WST_CURR_PAGE);
      });
    }else{
      WST.msg('操作失败!', {icon: 2});
    }
  });
}});
}
function batchDel(){
    var rows = mmg.checkStatus("msgTable").data;
    if(rows.length==0){
        WST.msg('请选择要删除的消息!',{icon:2});
        return;
    }
    var ids = [];
    for(var i=0;i<rows.length;i++){
        ids.push(rows[i]['id']);
    }
    WST.confirm({content:"您确定要删除该消息吗？", yes:function(tips){
        var params = {};
        params.ids = ids;
        var load = WST.load({msg:'请稍后...'});
        $.post(WST.U('shop/messages/batchDel'),params,function(data,textStatus){
          layer.close(load);
          var json = WST.toJson(data);
          if(json.status=='1'){
            WST.msg('操作成功',{icon:1},function(){
                loadGrid(WST_CURR_PAGE);
            });
          }else{
            WST.msg('操作失败',{icon:2});
          }
        });
    }});
}
function batchRead(){
    var rows = mmg.checkStatus("msgTable").data;
    if(rows.length==0){
        WST.msg('请选择处理的消息!',{icon:2});
        return;
    }
    var ids = [];
    for(var i=0;i<rows.length;i++){
        ids.push(rows[i]['id']);
    }
    WST.confirm({content:"您确定要将这些消息标记为已读吗？", yes:function(tips){
        var params = {};
        params.ids = ids;
        var load = WST.load({msg:'请稍后...'});
        $.post(WST.U('shop/messages/batchRead'),params,function(data,textStatus){
          layer.close(load);
          var json = WST.toJson(data);
          if(json.status=='1'){
            WST.msg('操作成功',{icon:1},function(){
                loadGrid(1);
            });
          }else{
            WST.msg('操作失败',{icon:2});
          }
        });
    }});
}
