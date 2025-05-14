



function storeSalestatistics(p,limit){
    $(".layui-none").hide();
    $('#loading').show();
    var params = WST.getParams('.s-query');
    params.page = p;
    if(typeof(limit)=='undefined')limit = WST_PAGE_LIMIT;
    params.limit = limit;
  $.post(WST.U('shop/stores/pageQuerySalestatistics'),params,function(data,textStatus){
    $('#loading').hide();
      var json = WST.toJson(data);
      console.log(json);
      $('.j-order-row').remove();
      if(json.status==1){
        json = json.data;
        $('.j-order-row').remove();
        if(params.page>json.last_page && json.last_page >0){
            storeSalestatistics(json.last_page);
            return;
        }
        var gettpl = document.getElementById('tblist').innerHTML;
        layui.laytpl(gettpl).render(json.data, function(html){
            $("#statOderMoney").html(json.totalMoney);
            $(html).insertAfter('#loadingBdy');
            $('.gImg').lazyload({ effect: "fadeIn",failurelimit : 10,skip_invisible : false,threshold: 200,placeholder:window.conf.RESOURCE_PATH+'/'+WST.conf.GOODS_LOGO});
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
                  theme: '#1890ff',
                  groups: 3,
                  jump: function(e, first){
                      if(!first){
                          storeSalestatistics(e.curr,e.limit);
                      }
                  }
              });
          }
     }
  });
}
