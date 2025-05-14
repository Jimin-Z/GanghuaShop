var mmg;
function initGrid(p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/reports/shopExpireByPage',WST.getParams('.ipt')),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'店铺编号', field:'shopSn'},
            {title:'店铺账号', field:'loginName'},
            {title:'店铺名称', field:'shopName'},
            {title:'所属行业', field:'tradeName'},
            {title:'店铺地址', field:'shopAddress'},
            {title:'到期日期', field:'expireDate'}
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
    var params = WST.getParams('.j-ipt');
    params.areaIdPath = WST.ITGetAllAreaVals('areaId1','j-areas').join('_');
    p=(p<=1)?1:p;
    mmg.reload('dataTable',{where:params,page:{curr:p}});
}
function toolTip(){
    WST.toolTip();
}
function toExport(){
    var params = WST.getParams('.j-ipt');
    params.areaIdPath = WST.ITGetAllAreaVals('areaId1','j-areas').join('_');
    var box = WST.confirm({content:"您确定要导出该统计数据吗?",yes:function(){
        layer.close(box);
        location.href=WST.U('admin/reports/toExportShopExpire',params);
    }});
}
