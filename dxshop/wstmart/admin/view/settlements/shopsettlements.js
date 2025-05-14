var mmg;
function initGrid(p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/settlements/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'结算单号', field:'settlementNo', width:120},
            {title:'申请店铺', field:'shopName'},
            {title:'结算金额', field:'settlementMoney' , width:120,templet: function(item){
                return '￥'+item['settlementMoney'];
            }},
            {title:'结算佣金', field:'commissionFee' , width:120,templet: function(item){
                return '￥'+item['commissionFee'];
            }},
            {title:'返还金额', field:'backMoney' , width:120, templet: function(item){
                return '￥'+item['backMoney'];
            }},
            {title:'申请时间', field:'createTime',width:170},
            {title:'状态', field:'settlementStatus' , width:120, templet: function(item){
                return (item['settlementStatus']==1)?"<span class='statu-yes'><i class='fa fa-check-circle'></i> 已结算&nbsp;</span>":"<span class='statu-yes'><i class='fa fa-check-circle'></i> 未结算&nbsp;</span>";
            }},
            {title:'操作', field:'' , fixed: 'right', width:150, align:'center', templet: function(item){
                var h = "";
                h += "<a class='btn btn-blue' href='javascript:toView(" + item['settlementId'] + ")'><i class='fa fa-search'></i>查看</a>&nbsp;&nbsp;";
                return h;
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
        }
    });
}

function toView(id){
	location.href=WST.U('admin/settlements/toView','id='+id+'&p='+WST_CURR_PAGE);
}
function loadGrid(p){
    p=(p<=1)?1:p;
    mmg.reload('dataTable',{where:{settlementNo:$('#settlementNo').val(),settlementStatus:$('#settlementStatus').val(),shopName:$('#shopName').val(),startDate:$('#startDate').val(),endDate:$('#endDate').val()},page:{curr:p}});
}

var flag = false;
function intView(id){
    var h = WST.pageHeight();
    var element = layui.element;
    var isInit = false;
    element.on('tab(msgTab)', function(data){
        if(data.index==1){
            if(!isInit){
               isInit = true;
               initGoodsGrid(id);
            }
        }
    });
}
function initGoodsGrid(id){
    var tbHeight = $('.layui-tab-title').outerHeight(true)+30;
    var h = 'full-'+tbHeight;
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/settlements/pageGoodsQuery','id='+id),cellMinWidth: 80,height: h,skin: 'line',even: true,limit:20,page:true,
        cols: [[
            {title:'#',type:'numbers'},
            {title:'订单号', field:'orderNo', width:120},
            {title:'商品名称', field:'goodsName' },
            {title:'商品规格', field:'goodsSpecNames',templet: function(item){
                var val = item['goodsSpecNames'];
                if(WST.blank(val)!=''){
                    val = val.split('@@_@@');
                    val = val.join('，');
                }
                return val;
            }},
            {title:'商品价格', field:'goodsPrice' , width:100, templet: function(item){
                return '￥'+item['goodsPrice'];
            }},
            {title:'购买数量', field:'goodsNum', width:100},
            {title:'佣金比率', field:'commissionRate', width:100}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadGoodGrid(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
        }
    });
}
function loadGoodGrid(p){
    p=(p<=1)?1:p;
    mmg.reload('dataTable',{page:{curr:p}});
}
function toExport(){
    var params = {};
    params = WST.getParams('.j-ipt');
    var box = WST.confirm({content:"您确定要导出结算记录吗?",yes:function(){
        layer.close(box);
        location.href=WST.U('admin/settlements/toExport',params);
    }});
}
