var mmg1,mmg2,mmg3,mmg,h;
function flowGridInit(p){
    var h = WST.pageHeight();
    var laydate = layui.laydate;
    laydate.render({
        elem: '#startDate'
    });
    laydate.render({
        elem: '#endDate'
    });
    mmg3 = layui.table;
    mmg3.render({elem: '#mmg3',id:'dataTable',url:WST.U('admin/logmoneys/pageQueryByCharge'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'来源', field:'dataSrc'},
            {title:'个人账号/店铺名', field:'loginName'},
            {title:'金额', field:'money' ,templet:function(item){
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
                loadFlowGrid(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
        }
    });
}
function loadFlowGrid(p){
    p=(p<=1)?1:p;
    mmg3.reload('dataTable',{where:{dataSrc:4,key:$('#key3').val(),type:$('#type').val(),startDate:$('#startDate').val(),endDate:$('#endDate').val()},page:{curr:p}});
}
