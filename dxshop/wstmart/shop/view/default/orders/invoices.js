var mmg,mmg2;
$(function(){
    var laydate = layui.laydate;
    laydate.render({
        elem: '#startDate'
    });
    laydate.render({
        elem: '#endDate'
    });
    laydate.render({
        elem: '#startDate2'
    });
    laydate.render({
        elem: '#endDate2'
    });
})

function initGrid(p){
    var tbHeight = $('.wst-tab-nav').outerHeight(true)+$('.wst-toolbar').outerHeight(true)+30;
    var h = 'full-'+tbHeight;
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('shop/orderinvoices/queryShopInvoicesByPage',{isMakeInvoice:0}),cellMinWidth: 80,height: h,skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {type: 'checkbox', field:'orderId'},
            {title:'订单编号', field:'orderNo' ,width:140},
            {title:'开票金额', field:'realTotalMoney' ,width:100 },
            {title:'发票抬头', field:'invoiceHead' ,width:200},
            {title:'发票税号', field:'invoiceCode' ,width:200},
            {title:'注册地址', field:'invoiceAddr' ,width:200},
            {title:'注册电话', field:'invoicePhoneNumber' ,width:200},
            {title:'开户银行', field:'invoiceBankName' ,width:200},
            {title:'银行账号', field:'invoiceBankNo' ,width:200},
            {title:'下单时间', field:'createTime', fixed: 'right', width:200, align:'center'}
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
function initGrid2(p){
    var tbHeight = $('.wst-tab-nav').outerHeight(true)+$('.wst-toolbar2').outerHeight(true)+30;
    var h = 'full-'+tbHeight;
    mmg2 = layui.table;
    mmg2.render({elem: '#mmg2',id:'dataTable2',url:WST.U('shop/orderinvoices/queryShopInvoicesByPage',{isMakeInvoice:1}),cellMinWidth: 80,height: h,skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {type: 'checkbox', field:'orderId'},
            {title:'订单编号', field:'orderNo' ,width:140},
            {title:'开票金额', field:'realTotalMoney' ,width:100 },
            {title:'发票抬头', field:'invoiceHead' ,width:200},
            {title:'发票税号', field:'invoiceCode' ,width:200},
            {title:'注册地址', field:'invoiceAddr' ,width:200},
            {title:'注册电话', field:'invoicePhoneNumber' ,width:200},
            {title:'开户银行', field:'invoiceBankName' ,width:200},
            {title:'银行账号', field:'invoiceBankNo' ,width:200},
            {title:'下单时间', field:'createTime', fixed: 'right', width:200, align:'center'}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadGrid2(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
        }
    });
}
function loadGrid(p){
    p=(p<=1)?1:p;
    var params = {};
    params.startDate = $('#startDate').val();
    params.endDate = $('#endDate').val();
    params.orderNo = $("#orderNo").val();
    mmg.reload('dataTable',{page:{curr:p},where:params});

}

function loadGrid2(p){
    p=(p<=1)?1:p;
    var params = {};
    params.startDate = $('#startDate2').val();
    params.endDate = $('#endDate2').val();
    params.orderNo = $("#orderNo2").val();
    mmg2.reload('dataTable2',{page:{curr:p},where:params});
}

//导出发票
function toExport(isMakeInvoice){
    var rows = mmg.selectedRows();
    var ids = [];
    for(var i=0;i<rows.length;i++){
        ids.push(rows[i]['orderId']);
     }
     var params = {};
     params = WST.getParams('.j-ipt');
     params.ids = ids.join(',');
     params.isMakeInvoice = isMakeInvoice;
     params.limit = 20;
     var box = WST.confirm({content:"您确定要导出这些发票信息吗?",yes:function(){
            layer.close(box);
            location.href=WST.U('shop/orderinvoices/toExport',params);
     }});
}

//批量设置
function toBatchSet(isMakeInvoice){
    var rows = mmg.checkStatus("dataTable").data;
    if(rows.length==0){
        WST.msg('请选择要设置的订单',{icon:2});
        return;
    }
    var ids = [];
    for(var i=0;i<rows.length;i++){
        ids.push(rows[i]['orderId']);
    }
    var msg = (isMakeInvoice==1)?"确定设置这些为已开发票吗?":"确定设置这些为未开发票吗?";
    var box = WST.confirm({content:msg,yes:function(){
            var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
            $.post(WST.U('shop/orderinvoices/setByBatch'),{ids:ids.join(','),isMakeInvoice:isMakeInvoice},function(data,textStatus){
                layer.close(loading);
                var json = WST.toJson(data);
                if(json.status=='1'){
                    WST.msg(json.msg,{icon:1});
                    layer.close(box);
                    loadGrid(WST_CURR_PAGE);
                }else{
                    WST.msg(json.msg,{icon:2});
                }
            });
        }});
}
