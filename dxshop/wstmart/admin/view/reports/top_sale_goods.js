var mmg;
function initSaleGrid(p){
    var laydate = layui.laydate;
    laydate.render({
        elem: '#startDate'
    });
    laydate.render({
        elem: '#endDate'
    });
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/reports/topSaleGoodsByPage',WST.getParams('.ipt')),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'&nbsp;', field:'goodsName', templet: function(item){
                var thumb = item['goodsImg'];
                thumb = thumb.replace('.','_thumb.');
                return "<span class='weixin'><a target='_blank' href='"+WST.U("home/goods/detail","goodsId="+item['goodsId'])+"'><img id='img' onmouseout='toolTip()' onmouseover='toolTip()' style='height:50px;width:50px;' src='"+WST.conf.RESOURCE_PATH+"/"+thumb
                    +"'><span class='imged' ><img  style='height:180px;width:180px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['goodsImg']+"'></span></span>";
            }},
            {title:'商品名称', field:'goodsName', templet: function(item){
                return "<a style='color:#666' target='_blank' href='"+WST.U("home/goods/detail","goodsId="+item['goodsId'])+"'>"+item['goodsName']+"</a>";
            }},
            {title:'商品编号', field:'goodsSn'},
            {title:'所属店铺', field:'shopName'},
            {title:'销量', field:'goodsNum'}
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
function loadGrid(){
    var params = WST.getParams('.ipt');
    p=(p<=1)?1:p;
    mmg.reload('dataTable',{where:params,page:{curr:p}});
}
function toolTip(){
    WST.toolTip();
}
function toExport(){
    var params = WST.getParams('.ipt');
    var box = WST.confirm({content:"您确定要导出该统计数据吗?",yes:function(){
        layer.close(box);
        location.href=WST.U('admin/reports/toExportSaleGoods',params);
    }});
}
