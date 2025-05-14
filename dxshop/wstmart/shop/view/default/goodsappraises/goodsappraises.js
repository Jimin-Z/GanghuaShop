/**获取本店分类**/
function getShopsCats(objId,pVal,objVal){
	$('#'+objId).empty();
	$.post(WST.U('shop/shopcats/listQuery'),{parentId:pVal},function(data,textStatus){
	     var json = WST.toJson(data);
	     var html = [],cat;
	     html.push("<option value='' >-请选择-</option>");
	     if(json.status==1 && json.list){
	    	 json = json.list;
			 for(var i=0;i<json.length;i++){
			     cat = json[i];
			     html.push("<option value='"+cat.catId+"' "+((objVal==cat.catId)?"selected":"")+">"+cat.catName+"</option>");
			 }
	     }
	     $('#'+objId).html(html.join(''));
	});
}
function getCat(val){
  if(val==0){
     $('#cat2').html("<option value='' >-请选择-</option>");
     return;
  }
  $.post(WST.U('shop/shopcats/listQuery'),{parentId:val},function(data,textStatus){
       var json = WST.toJson(data);
       var html = [],cat;
       html.push("<option value='' >-请选择-</option>");
       if(json.status==1 && json.list){
         json = json.list;
       for(var i=0;i<json.length;i++){
           cat = json[i];
           html.push("<option value='"+cat.catId+"'>"+cat.catName+"</option>");
        }
       }
       $('#cat2').html(html.join(''));
  });
}
function queryByPage(p,limit){
    $(".layui-none").hide();
    $('#loading').show();
  if(typeof(limit)=='undefined')limit = WST_PAGE_LIMIT;
  $.post(WST.U('shop/goodsappraises/queryByPage'),{cat1:$('#cat1').val(),cat2:$('#cat2').val(),goodsName:$('#goodsName').val(),page:p,limit:limit},function(data,textStatus){
    $('#loading').hide();
      var json = WST.toJson(data);
      $('.j-order-row').remove();
      if(json.status==1){
        json = json.data;
        if(json.total>0){
          if(p>json.last_page && json.last_page >0){
              queryByPage(json.last_page);
              return;
          }
          var gettpl = document.getElementById('tblist').innerHTML;
          layui.laytpl(gettpl).render(json.data, function(html){
              $(html).insertAfter('#loadingBdy');
              for(var g=0;g<=json.data.length;g++){
                 WST.showPhotos('#img-file-'+g,true);
              }
          });
          if(json.last_page>1){
            layui.laypage.render({
            elem: 'pager',
            count:json.total,
            limit:json.per_page,
            curr: json.current_page,
            prev:'<i class="layui-icon"></i>',
            next:'<i class="layui-icon"></i>',
            layout: ['prev', 'page', 'next', 'skip','count', 'limit'],
                skin: '#1890ff',
                groups: 3,
                jump: function(e, first){
                  WST_PAGE_LIMIT = e.limit;
                  if(!first){
                    queryByPage(e.curr,e.limit);
                  }
                }
            });
          }

        }else{
            $('#pager').empty();
            $(".layui-none").show();
        }
      }
  });
}
function loadGrid(){
    queryByPage(0);
}
function reply(id){
  var w = WST.open({
          type: 1,
          title:"回复评论",
          shade: [0.6, '#000'],
          border: [0],
          content: '<textarea style="width:calc(100% - 13px);height:150px;margin-bottom:2px;"" id="reply" ></textarea>',
          area: ['500px', '270px'],
          btn: ['回复', '关闭窗口'],
            yes: function(index, layero){
               var params = {};
               if($('#reply').val()==''){
                  WST.msg('回复内容不能为空',{icon:2});
                  return false;
               }
               params.reply = $('#reply').val();
               params.id=id;
               $.post(WST.U('shop/goodsappraises/shopReply'),params,function(data){
                  layer.close(index);
                  $('#r'+id).remove();
                  var json = WST.toJson(data);
                  if(json.status==1){
                    var today = new Date();
                        today = today.toLocaleDateString();
                    var html = '<hr/><p class="reply-content">商家回复：'+params.reply+'【'+today+'】</p>'
                    $('#reply'+id).html(html);
                  }
               });
            }
      });
}

function report(id){
    var w = WST.open({
        type: 1,
        title:"举报评论",
        shade: [0.6, '#000'],
        border: [0],
        content: '<textarea style="width:calc(100% - 13px);height:130px;margin-bottom:2px;"" id="reportContent" ></textarea>',
        area: ['500px', '250px'],
        btn: ['举报', '关闭窗口'],
        yes: function(index, layero){
            var params = {};
            if($('#reportContent').val()==''){
                WST.msg('举报内容不能为空',{icon:2});
                return false;
            }
            params.reportContent = $('#reportContent').val();
            params.id=id;
            $.post(WST.U('shop/goodsappraises/shopReport'),params,function(data){
                layer.close(index);
                $('#r'+id).remove();
                var json = WST.toJson(data);
                if(json.status==1){
                    WST.msg(json.msg, { icon: 1 }, function () {
                        loadGrid();
                    });
                } else {
                    WST.msg(json.msg, { icon: 2 });
                }
            });
        }
    });
}
