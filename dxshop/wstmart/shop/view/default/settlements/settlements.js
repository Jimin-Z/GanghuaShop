var mmg1,mmg2,mmg3;

function loadGrid(p){
    p=(p<=1)?1:p;
    mmg1.reload('dataTable1',{where:{settlementNo:$('#settlementNo_0').val(),isFinish:$('#isFinish_0').val()},page:{curr:p}});
}
function loadUnSettleGrid(p){
    p=(p<=1)?1:p;
    mmg2.reload('dataTable2',{where:{orderNo:$('#orderNo_1').val(),
        startDate:$('#startDate').val(),endDate:$('#endDate').val()},page:{curr:p}});
}
function loadSettleGrid(p){
    p=(p<=1)?1:p;
    mmg3.reload('dataTable3',{where:{settlementNo:$('#settlementNo_2').val(),orderNo:$('#orderNo_2').val(),isFinish:$('#isFinish_2').val()},page:{curr:p}});
}
function view(val){
    location.href=WST.U('shop/settlements/view','id='+val);
}
function getQueryPage(p){
    var tbHeight = $('.wst-toolbar1').outerHeight(true)+56+20;
    var h = 'full-'+tbHeight;
    mmg1 = layui.table;
    mmg1.render({elem: '#mmg1', id:'dataTable1',url:WST.U('shop/settlements/pageQuery'), cellMinWidth: 80, height: h, skin: 'line', even: true, limit:20, page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'结算单号', field:'settlementNo', width: 150},
            {title:'类型', field:'', width: 50,templet:function(item){
                if(item['settlementType']==1){
                    return "定时";
                }else{
                    return "手动";
                }
            }},
            {title:'结算金额', field:'settlementMoney', width: 120,templet:function(item){return '￥'+item['settlementMoney'];}},
            {title:'结算佣金', field:'commissionFee', width: 120,templet:function(item){return '￥'+item['commissionFee'];}},
            {title:'返还金额', field:'backMoney', width: 120,templet:function(item){return '￥'+item['backMoney'];}},
            {title:'创建时间', field:'createTime', width: 150},
            {title:'结算状态', field:'', width: 60,templet:function(item){
                if(item['settlementStatus']==1){
                    return "已结算";
                }else{
                    return "未结算";
                }
            }},
            {title:'结算时间', field:'', width: 170,templet:function(item){
                return WST.blank(item['settlementTime'],'-');
            }},
            {title:'备注', field:'', fixed: 'right', align:'center',templet:function(item){
                return WST.blank(item['remarks'],'-');
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

function getUnSettledOrderPage(p){
    var tbHeight = $('.wst-toolbar2').outerHeight(true)+56+20;
    var h = 'full-'+tbHeight;
    mmg2 = layui.table;
    mmg2.render({elem: '#mmg2', id:'dataTable2',url:WST.U('shop/settlements/pageUnSettledQuery'), cellMinWidth: 80, height: h, skin: 'line', even: true, limit:20, page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'订单号', field:'orderNo', width: 150},
            {title:'下单时间', field:'createTime', width: 170},
            {title:'支付方式', field:'payTypeNames', width: 120},
            {title:'商品总金额', field:'goodsMoney', width: 120,templet:function(item){return '￥'+item['goodsMoney'];}},
            {title:'运费', field:'deliverMoney', width: 120,templet:function(item){return '￥'+item['deliverMoney'];}},
            {title:'订单总金额', field:'totalMoney', width: 120,templet:function(item){return '￥'+item['totalMoney'];}},
            {title:'实付金额', field:'realTotalMoney', width: 120,templet:function(item){return '￥'+item['realTotalMoney'];}},
            {title:'已退还金额', field:'refundedPayMoney' ,width:120, templet:function(item){
                return '￥'+(parseFloat(item['refundedPayMoney'])+parseFloat(item['refundedScoreMoney']));
            }},
            {title:'失效积分换算金额', field:'refundedGetScoreMoney' ,width:150, templet:function(item){
                return '￥'+parseFloat(item['refundedGetScoreMoney']);
            }},
            {title:'应付佣金', field:'commissionFee', width: 150,templet:function(item){return '￥'+item['commissionFee'];}},
            {title:'预计结算日期', field:'afterSaleEndTime', fixed: 'right', align:'center'}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadUnSettleGrid(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
        }
    });
}
function getSettleOrderPage(p){
    var tbHeight = $('.wst-toolbar3').outerHeight(true)+56+20;
    var h = 'full-'+tbHeight;
    mmg3 = layui.table;
    mmg3.render({elem: '#mmg3', id:'dataTable3',url:WST.U('shop/settlements/pageSettledQuery'), cellMinWidth: 80, height: h, skin: 'line', even: true, limit:20, page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'订单号', field:'orderNo', width: 150},
            {title:'支付方式', field:'payTypeNames', width: 80},
            {title:'商品总金额', field:'goodsMoney', width: 100,templet:function(item){return '￥'+item['goodsMoney'];}},
            {title:'运费', field:'deliverMoney', width: 80,templet:function(item){return '￥'+item['deliverMoney'];}},
            {title:'订单总金额', field:'totalMoney', width: 100,templet:function(item){return '￥'+item['totalMoney'];}},
            {title:'实付金额', field:'realTotalMoney', width: 100,templet:function(item){return '￥'+item['realTotalMoney'];}},
            {title:'已退还金额', field:'refundedPayMoney' ,width:120, templet:function(item){
                return '￥'+(parseFloat(item['refundedPayMoney'])+parseFloat(item['refundedScoreMoney']));
            }},
            {title:'失效积分换算金额', field:'refundedGetScoreMoney' ,width:150, templet:function(item){
                return '￥'+parseFloat(item['refundedGetScoreMoney']);
            }},
            {title:'应付佣金', field:'commissionFee', width: 100,templet:function(item){return '￥'+item['commissionFee'];}},
            {title:'结算单号', field:'settlementNo', width: 150},
            {title:'结算时间', field:'' , fixed: 'right', align:'center', templet: function(item){
                return WST.blank(item['settlementTime'],'-');
            }}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadSettleGrid(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
        }
    });
}
