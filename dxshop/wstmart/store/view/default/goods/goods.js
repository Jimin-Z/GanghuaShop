
var mmg;
function toDetail(goodsId,key){
    window.open(WST.U('home/goods/detail','goodsId='+goodsId+"&key="+key));
}

function saleByPage(p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('store/goods/saleByPage'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'商品图片',width:80, field:'goodsName',  templet: function(item){
                return "<span class='weixin'><a style='color:blue' href='javascript:toDetail("+ item['goodsId']+",\""+item['verfiycode']+"\")'><img class='img' style='height:50px;width:50px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['goodsImg']+"'><img class='imged' style='height:200px;width:200px;border:0px; background:#fff' src='"+WST.conf.RESOURCE_PATH+"/"+item['goodsImg']+"'></a></span>";
            }},
            {title:'商品名称', field:'goodsName', templet: function(item){
                return "<a style='color:#666' href='javascript:toDetail("+ item['goodsId']+",\""+item['verfiycode']+"\")'>"+item['goodsName']+"</a> ";
            }},
            {title:'商品编号', field:'goodsSn',width:150},
            {title:'价格(￥)',width:80, field:'shopPrice'},
            {title:'推荐', field:'isRecom',width:60, templet: function(item){
                if(item['isRecom']==1){
                    return "<span class='statu-yes'><i class='fa fa-check-circle'></i> 是</span>";
                }else{
                    return "<span class='statu-wait'><i class='fa fa-clock-o'></i> 否</span>";
                }
            }},
            {title:'精品', field:'isBest',width:60, templet: function(item){
                if(item['isBest']==1){
                    return "<span class='statu-yes'><i class='fa fa-check-circle'></i> 是</span>";
                }else{
                    return "<span class='statu-wait'><i class='fa fa-clock-o'></i> 否</span>";
                }
            }},
            {title:'新品', field:'isNew',width:60, templet: function(item){
                if(item['isNew']==1){
                    return "<span class='statu-yes'><i class='fa fa-check-circle'></i> 是</span>";
                }else{
                    return "<span class='statu-wait'><i class='fa fa-clock-o'></i> 否</span>";
                }
            }},
            {title:'热销', field:'isHot',width:60, templet: function(item){
                if(item['isHot']==1){
                    return "<span class='statu-yes'><i class='fa fa-check-circle'></i> 是</span>";
                }else{
                    return "<span class='statu-wait'><i class='fa fa-clock-o'></i> 否</span>";
                }
            }},
            {title:'销量', field:'saleNum',width:60},
            {title:'库存', field:'goodsStock',width:60}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadGrid(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
        }
    });
}

function loadGrid(p){
    p = (p<=1)?1:p;
    mmg.reload('dataTable',{where:{cat1:$('#cat1').val(),cat2:$('#cat2').val(),goodsType:$('#goodsType').val(),goodsName:$('#goodsName').val()},page:{curr:p}});
}

function getCat(val){
  if(val==''){
  	$('#cat2').html("<option value='' >-请选择-</option>");
  	return;
  }
  $.post(WST.U('store/shopcats/listQuery'),{parentId:val},function(data,textStatus){
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
