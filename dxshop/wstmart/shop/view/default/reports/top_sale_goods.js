var mmg;
function loadStat(){
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('shop/reports/getTopSaleGoods'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:true,
        cols: [[
            {title:'#',type:'numbers'},
            {title:'商品', field:'goodsName'},
            {title:'商品编号', field:'goodsSn'},
            {title:'销量', field:'goodsNum', width: 150}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadGrid(total_page);
                return;
            }
        }
    });
}
function loadGrid(p){
    p=(p<=1)?1:p;
    mmg.reload('dataTable',{page:{curr:p},where:{startDate:$('#startDate').val(),endDate:$('#endDate').val()}});
}

function toExport(){
    var params = WST.getParams('.j-ipt');
    var box = WST.confirm({content:"您确定要导出该统计数据吗?",yes:function(){
        layer.close(box);
        location.href=WST.U('shop/reports/toExportTopSaleGoods',params);
    }});
}
