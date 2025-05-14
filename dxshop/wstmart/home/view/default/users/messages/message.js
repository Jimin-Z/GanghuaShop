var WST_CURR_PAGE = 1;
function queryByList(p){
     var params = {};
     params.page = p;
     params.limit = (typeof(limit)=='undefined')?WST_PAGE_LIMIT:limit;
     var load = WST.load({msg:'正在加载信息，请稍后...'})
     $.post(WST.U('home/Messages/pageQuery'),params,function(data,textStatus){
    	   layer.close(load);
         var json = WST.toJson(data);
	       if(json.data){
		        json = json.data;
            if(params.page>json.last_page && json.last_page >0){
               queryByList(json.last_page);
               return;
            }
	          var gettpl = document.getElementById('msg').innerHTML;
	          //复选框为未选中状态
	          $('#all').attr('checked',false);
	          layui.laytpl(gettpl).render(json.data, function(html){
	             $('#msg_box').html(html);
                  layui.form.render();
	          });
            if(json.total>0){
            layui.laypage.render({
              elem: 'wst-page',
              count:json.total,
              limit:json.per_page,
              curr: json.current_page,
              layout: ['prev', 'page', 'next', 'skip','count', 'limit'],
                 groups: 3,
                 jump: function(e, first){
                      WST_PAGE_LIMIT = e.limit;
                      if(!first){
                        queryByList(e.curr,e.limit);
                      }
                 }
             });
          }else{
              $('#pager').empty();
          }
	    }
  });
}

function showMsg(id){
  location.href=WST.U('home/messages/showMsg','msgId='+id+'&p='+WST_CURR_PAGE);
}

function delMsg(obj,id){
WST.confirm({content:"您确定要删除该消息吗？", yes:function(tips){
  var ll = WST.load({msg:'数据处理中，请稍候...'});
  $.post(WST.U('home/messages/del'),{id:id},function(data,textStatus){
    layer.close(ll);
      layer.close(tips);
    var json = WST.toJson(data);
    if(json.status=='1'){
      WST.msg('操作成功!', {icon: 1}, function(){
         queryByList(WST_CURR_PAGE);
      });
    }else{
         WST.msg('操作失败!', {icon: 2});
    }
  });
}});
}
function batchDel(){
    var ids = WST.getChks('.chk');
    if(ids==''){
      WST.msg('请选择要删除的消息!', {icon: 2});
      return;
    }
    WST.confirm({content:"您确定要删除该消息吗？", yes:function(tips){
        var params = {};
        params.ids = ids;
        var load = WST.load({msg:'请稍后...'});
        $.post(WST.U('home/messages/batchDel'),params,function(data,textStatus){
          layer.close(load);
          var json = WST.toJson(data);
          if(json.status=='1'){
            WST.msg('操作成功',{icon:1},function(){
                 queryByList(WST_CURR_PAGE);
            });
          }else{
            WST.msg('操作失败',{icon:2});
          }
        });
    }});
}
function batchRead(){
    var ids = WST.getChks('.chk');
    if(ids==''){
      WST.msg('请选择处理的消息!', {icon: 2});
      return;
    }
    WST.confirm({content:"您确定要将这些消息标记为已读吗？", yes:function(tips){
        var params = {};
        params.ids = ids;
        var load = WST.load({msg:'请稍后...'});
        $.post(WST.U('home/messages/batchRead'),params,function(data,textStatus){
          layer.close(load);
          var json = WST.toJson(data);
          if(json.status=='1'){
            WST.msg('操作成功',{icon:1},function(){
                 queryByList(WST_CURR_PAGE);
            });
          }else{
            WST.msg('操作失败',{icon:2});
          }
        });
    }});
}
