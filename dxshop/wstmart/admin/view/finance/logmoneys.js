var mmg1,mmg2,mmg3,mmg4,mmg5,mmg6,mmg7,mmg8,mmg9,mmg10,mmg,h;
function initTab(p){
	var element = layui.element;
	var isInit1 = isInit2 = isInit3 = isInit4 = isInit5 = isInit6 = isInit7 = isInit8 = isInit9 = isInit10 =  false;
	element.on('tab(msgTab)', function(data){
        var tabId = $(this).attr("id");
        console.log(tabId);
        if(tabId=="users"){//用户资金
            if(!isInit1){
               isInit1 = true;
               userGridInit(p);
            }else{
               loadUserGrid(p);
            }
        }else if(tabId=="shops"){//商家资金
            if(!isInit2){
               isInit2 = true;
               shopGridInit(p);
            }else{
               loadShopGrid(p);
            }
        }else if(tabId=="suppliers"){//供货商资金
            if(!isInit3){
                isInit3 = true;
                supplierGridInit(p);
            }else{
                loadSupplierGrid(p);
            }
        }else if(tabId=="rechangeMoney"){//充值记录
            if(!isInit4){
                isInit4 = true;
                rechangeGridInit(p);
            }else{
                loadRechangeGrid(p);
            }
        }else if(tabId=="renewMoney"){//年费记录
            if(!isInit5){
                isInit5 = true;
                renewGridInit(p);
            }else{
                loadRenewGrid(p);
            }
        }else if(tabId=="refundMoney"){//退款记录
            if(!isInit6){
                isInit6 = true;
                refundGridInit(p);
            }else{
                loadRefundGrid(p);
            }
        }else if(tabId=="cashDraw"){//提现记录
            if(!isInit7){
                isInit7 = true;
                cashDrawGridInit(p);
            }else{
                loadCashDrawGrid(p);
            }
        }else if(tabId=="moneyList"){//资金流水
            if(!isInit8){
                isInit8 = true;
                moneyGridInit(p);
            }else{
                loadMoneyGrid(p);
            }
        }else if(tabId=="scoreList"){//积分流水
            if(!isInit9){
                isInit9 = true;
                scoreGridInit(p);
            }else{
                loadScoreGrid(p);
            }
        }else if(tabId=="commissionList"){//订单佣金
            if(!isInit10){
                isInit10 = true;
                commissionGridInit(p);
            }else{
                loadCommissionGrid(p);
            }
        }

	});
}
function phaseSummary(type,flag){
    if(flag==1)var loading = WST.msg('正在处理数据，请稍后...', {icon: 16,time:60000});
    $.post(WST.U('admin/logmoneys/phaseSummary'),{type:type},function(data,textStatus){
        if(flag==1)layer.close(loading);
        var json = WST.toAdminJson(data);
        if(json.status=='1'){
            $("#s_rechangeMoney").html(json.data.rechangeMoney);
            $("#s_giveMoney").html(json.data.giveMoney);
            $("#s_renewMoney").html(json.data.renewMoney);
            $("#s_cashDraw").html(json.data.cashDraw);
            $("#s_refundMoney").html(json.data.refundMoney);
            $("#s_giveScore").html(json.data.giveScore);
            $("#s_exchangeScore").html(json.data.exchangeScore);
            $("#s_commission").html(json.data.commission);
        }else{
            WST.msg(json.msg,{icon:2});
        }
    });
}
//用户资金
function userGridInit(p){
    var tbHeight = $('.header1').outerHeight(true)+$('.header2').outerHeight(true)+$('.wst-toolbar1').outerHeight(true)+45+20;
    var h = 'full-'+tbHeight;
    mmg1 = layui.table;
    mmg1.render({elem: '#mmg1',id:'dataTable',url:WST.U('admin/logmoneys/pageQueryByUser'),cellMinWidth: 80,height: h,skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'账号', field:'loginName'},
            {title:'名称', field:'userName'},
            {title:'可用金额', field:'userMoney',templet: function(item){
                return "<span style='color:red;'>￥"+item['userMoney']+"</span>";
            }},
            {title:'冻结金额', field:'lockMoney' ,templet: function(item){
                return "<span style='color:#31c15a;'>￥"+item['lockMoney']+"</span>";
            }},
            {title:'充值送', field:'rechargeMoney' ,templet: function(item){
                return "<span style='color:#1890ff;'>￥"+item['rechargeMoney']+"</span>";
            }}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadUserGrid(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
        }
    });
}
function loadUserGrid(p){
    p=(p<=1)?1:p;
    mmg1.reload('dataTable',{where:{key:$('#key1').val()},page:{curr:p}});
}
//商家资金
function shopGridInit(p){
    var tbHeight = $('.header1').outerHeight(true)+$('.header2').outerHeight(true)+$('.wst-toolbar2').outerHeight(true)+45+20;
    var h = 'full-'+tbHeight;
    mmg2 = layui.table;
    mmg2.render({elem: '#mmg2',id:'dataTable2',url:WST.U('admin/logmoneys/pageQueryByShop'),cellMinWidth: 80,height: h,skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'账号', field:'loginName'},
            {title:'商家', field:'shopName'},
            {title:'可用金额', field:'shopMoney',templet: function(item){
                return "<span style='color:red;'>￥"+item['shopMoney']+"</span>";
            }},
            {title:'冻结金额', field:'lockMoney' ,templet: function(item){
                return "<span style='color:#31c15a;'>￥"+item['lockMoney']+"</span>";
            }},
            {title:'充值送', field:'rechargeMoney' ,templet: function(item){
                return "<span style='color:#1890ff;'>￥"+item['rechargeMoney']+"</span>";
            }}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadShopGrid(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
        }
    });
}
function loadShopGrid(p){
    p=(p<=1)?1:p;
    mmg2.reload('dataTable2',{where:{key:$('#key2').val()},page:{curr:p}});
}

//供货商资金
function supplierGridInit(p){
    var tbHeight = $('.header1').outerHeight(true)+$('.header2').outerHeight(true)+$('.wst-toolbar3').outerHeight(true)+45+20;
    var h = 'full-'+tbHeight;
    mmg3 = layui.table;
    mmg3.render({elem: '#mmg3',id:'dataTable3',url:WST.U('admin/logmoneys/pageQueryBySupplier'),cellMinWidth: 80,height: h,skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'账号', field:'loginName'},
            {title:'供货商', field:'supplierName'},
            {title:'可用金额', field:'supplierMoney',templet: function(item){
                return "<span style='color:red;'>￥"+item['supplierMoney']+"</span>";
            }},
            {title:'冻结金额', field:'lockMoney' ,templet: function(item){
                return "<span style='color:#31c15a;'>￥"+item['lockMoney']+"</span>";
            }},
            {title:'充值送', field:'rechargeMoney' ,templet: function(item){
                return "<span style='color:#1890ff;'>￥"+item['rechargeMoney']+"</span>";
            }}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadSupplierGrid(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
        }
    });
}
function loadSupplierGrid(p){
    p=(p<=1)?1:p;
    mmg3.reload('dataTable3',{where:{key:$('#key3').val()},page:{curr:p}});
}

//充值记录
function rechangeGridInit(p){
    var laydate = layui.laydate;
    laydate.render({
        elem: '#startDate4'
    });
    laydate.render({
        elem: '#endDate4'
    });
    var tbHeight = $('.header1').outerHeight(true)+$('.header2').outerHeight(true)+$('.wst-toolbar4').outerHeight(true)+45+20;
    var h = 'full-'+tbHeight;
    mmg4 = layui.table;
    mmg4.render({elem: '#mmg4',id:'dataTable4',url:WST.U('admin/logmoneys/rechangePageQuery'),cellMinWidth: 80,height: h,skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'来源', field:'dataSrc'},
            {title:'个人账号/店铺名', field:'loginName'},
            {title:'金额', field:'money' ,templet: function(item){
                $("#totalRechangeMoney").html(item['totalRechangeMoney']);
                if(item['moneyType']==1){
                    return '<font color="red">+￥'+item['money']+'</font>';
                }else{
                    return '<font color="green">-￥'+item['money']+'</font>';
                }
            }},
            {title:'备注', field:'remark'},
            {title:'外部流水', field:'tradeNo'},
            {title:'日期', field:'createTime' ,width:200}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadRechangeGrid(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
        }
    });
}

function loadRechangeGrid(p){
    p=(p<=1)?1:p;
    mmg4.reload('dataTable4',{where:{key:$('#key4').val(),type:$('#type4').val(),startDate:$('#startDate4').val(),endDate:$('#endDate4').val()},page:{curr:p}});
}


//年费记录
function renewGridInit(p){
    var laydate = layui.laydate;
    laydate.render({
        elem: '#startDate5'
    });
    laydate.render({
        elem: '#endDate5'
    });
    var tbHeight = $('.header1').outerHeight(true)+$('.header2').outerHeight(true)+$('.wst-toolbar5').outerHeight(true)+45+20;
    var h = 'full-'+tbHeight;
    mmg5 = layui.table;
    mmg5.render({elem: '#mmg5',id:'dataTable5',url:WST.U('admin/shops/statRenewMoneyByPage'),cellMinWidth: 80,height: h,skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'店铺名称', field:'shopName' ,templet: function(item){
                $("#totalRenewMoney").html(item['totalRenewMoney']);
                return item['shopName'];
            }},
            {title:'缴费对象', field:'type', templet: function(item){
                return (item['type']==3)?"供货商":"商家";
            }},
            {title:'缴纳年费描述', field:'remark' ,templet: function(item){
                return (item['isRefund']==1)?item['remark']+'(已退款)':item['remark'];
            }},
            {title:'年费金额', field:'money' ,templet: function(item){
                    return '￥'+item['money'];
                }},
            {title:'外部流水号', field:'',templet: function(item){
                    return WST.blank(item['tradeNo'],'-');
                }},
            {title:'缴纳时间', field:'createTime',width:200},
            {title:'开始日期', field:'startDate'},
            {title:'结束日期', field:'endDate'}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadRenewGrid(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
        }
    });
}

function loadRenewGrid(p){
    p=(p<=1)?1:p;
    mmg5.reload('dataTable5',{where:{type:$('#type5').val(),key:$('#key5').val(),startDate:$('#startDate5').val(),endDate:$('#endDate5').val()},page:{curr:p}});
}


//提现记录
function cashDrawGridInit(p){
    var laydate = layui.laydate;
    laydate.render({
        elem: '#startDate7'
    });
    laydate.render({
        elem: '#endDate7'
    });
    var tbHeight = $('.header1').outerHeight(true)+$('.header2').outerHeight(true)+$('.wst-toolbar7').outerHeight(true)+45+20;
    var h = 'full-'+tbHeight;
    mmg7 = layui.table;
    mmg7.render({elem: '#mmg7',id:'dataTable7',url:WST.U('admin/cashdraws/statCashDrawal'),cellMinWidth: 80,height: h,skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'提现单号', field:'cashNo'},
            {title:'会员名称', field:'loginName' ,templet: function(item){
                $("#totalCashDrawMoney").html(item['totalCashDrawMoney']);
                $('#totalCashDrawCommission').html(item['totalCashDrawCommission']);
                if(item['targetType']==1){
                    return WST.blank(item['userName'])+"("+item['loginName']+")";
                }else{
                    return WST.blank(item['userName'])+"("+item['loginName']+")";
                }
            }},
            {title:'会员类型', field:'targetTypeName'},
            {title:'提现银行', field:'accTargetName'},
            {title:'银行卡号', field:'accNo'},
            {title:'持卡人', field:'accUser'},
            {title:'提现金额', field:'money' , templet: function(item){
                return "<span style='color:red;'>￥"+item['money']+"</span>";
            }},
            {title:'手续费', field:'commission' , templet: function(item){
                return '￥'+item['commission'];
            }},
            {title:'费率', field:'commissionRate' , templet: function(item){
                return item['commissionRate']+'%';
            }},
            {title:'提现时间', field:'createTime',width:200}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadCashDrawGrid(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
        }
    });
}

function loadCashDrawGrid(p){
    p=(p<=1)?1:p;
    mmg7.reload('dataTable7',{where:{key:$('#key7').val(),type:$('#type7').val(),startDate:$('#startDate7').val(),endDate:$('#endDate7').val()},page:{curr:p}});
}


//资金流水
function moneyGridInit(p){
    var laydate = layui.laydate;
    laydate.render({
        elem: '#startDate8'
    });
    laydate.render({
        elem: '#endDate8'
    });
    var tbHeight = $('.header1').outerHeight(true)+$('.header2').outerHeight(true)+$('.wst-toolbar8').outerHeight(true)+45+20;
    var h = 'full-'+tbHeight;
    mmg8 = layui.table;
    mmg8.render({elem: '#mmg8',id:'dataTable8',url:WST.U('admin/logmoneys/pageQuery'),cellMinWidth: 80,height: h,skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'来源', field:'dataSrc'},
            {title:'个人账号/店铺名', field:'loginName'},
            {title:'金额', field:'money' ,templet: function(item){
                if(item['moneyType']==1){
                    return '<font color="red">+￥'+item['money']+'</font>';
                }else{
                    return '<font color="green">-￥'+item['money']+'</font>';
                }
            }},
            {title:'备注', field:'remark'},
            {title:'外部流水', field:'tradeNo'},
            {title:'日期', field:'createTime' ,width:200}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadMoneyGrid(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
        }
    });
}

function loadMoneyGrid(p){
    p=(p<=1)?1:p;
    mmg8.reload('dataTable8',{where:{key:$('#key8').val(),type:$('#type8').val(),startDate:$('#startDate8').val(),endDate:$('#endDate8').val()},page:{curr:p}});
}

//积分流水
function scoreGridInit(p){
    var laydate = layui.laydate;
    laydate.render({
        elem: '#startDate9'
    });
    laydate.render({
        elem: '#endDate9'
    });
    var tbHeight = $('.header1').outerHeight(true)+$('.header2').outerHeight(true)+$('.wst-toolbar9').outerHeight(true)+45+20;
    var h = 'full-'+tbHeight;
    mmg9 = layui.table;
    mmg9.render({elem: '#mmg9',id:'dataTable9',url:WST.U('admin/userscores/statPageQuery'),cellMinWidth: 80,height: h,skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'来源', field:'dataSrc'},
            {title:'积分变化', field:'dataSrc',templet: function(item){
                $("#totalInScore").html(item['totalInScore']);
                $("#totalOutScore").html(item['totalOutScore']);
                if(item['scoreType']==1){
                    return '<font color="red">+'+item['score']+'</font>';
                }else{
                    return '<font color="green">-'+item['score']+'</font>';
                }
            }},
            {title:'备注', field:'dataRemarks'},
            {title:'日期', field:'createTime',width: 200}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadScoreGrid(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
        }
    });
}

function loadScoreGrid(p){
    p=(p<=1)?1:p;
    mmg9.reload('dataTable9',{where:{key:$('#key9').val(),startDate:$('#startDate9').val(),endDate:$('#endDate9').val()},page:{curr:p}});
}


//订单佣金
function commissionGridInit(p){
    var laydate = layui.laydate;
    laydate.render({
        elem: '#startDate10'
    });
    laydate.render({
        elem: '#endDate10'
    });
    var tbHeight = $('.header1').outerHeight(true)+$('.header2').outerHeight(true)+$('.wst-toolbar10').outerHeight(true)+45+20;
    var h = 'full-'+tbHeight;
    mmg10 = layui.table;
    mmg10.render({elem: '#mmg10',id:'dataTable10',url:WST.U('admin/settlements/statPageQuery'),cellMinWidth: 80,height: h,skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'结算单号', field:'settlementNo'},
            {title:'结算对象', field:'type',templet: function(item){
                return (item['type']==3)?"供货商":"商家";
            }},
            {title:'申请店铺', field:'shopName'},
            {title:'结算金额',field:'settlementMoney' ,templet: function(item){
                $("#totalCommission").html(item['totalCommission']);
                return '￥'+item['totalCommission'];
            }},
            {title:'返还金额', field:'backMoney' ,templet: function(item){
                return '￥'+item['backMoney'];
            }},
            {title:'结算佣金', field:'commissionFee' ,templet: function(item){
                return "<span style='color:red;'>￥"+item['commissionFee']+"</span>";
            }},
            {title:'结算时间', field:'createTime',width:200}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadCommissionGrid(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
        }
    });
}

function loadCommissionGrid(p){
    p=(p<=1)?1:p;
    mmg10.reload('dataTable10',{where:{key:$('#key10').val(),type:$('#type10').val(),startDate:$('#startDate10').val(),endDate:$('#endDate10').val()},page:{curr:p}});
}
