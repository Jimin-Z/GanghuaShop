var mmg;
function edit(p) {
    $('#invoiceForm').isValid(function(v){
        if(v){
            var params = WST.getParams('.ipt');
            var loading = WST.msg('正在提交数据，请稍后...', { icon: 16, time: 60000 });
            $.post(WST.U('shop/invoices/' + ((params.id == 0) ? "add" : "edit")), params, function (data, textStatus) {
                layer.close(loading);
                var json = WST.toJson(data);
                if (json.status == '1') {
                    WST.msg(json.msg,{icon:1},function(){
                        WST.backPrePage();
                    });
                } else {
                    WST.msg(json.msg, { icon: 2 });
                }
            });
        }
    });
}
function initGrid(p) {
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('shop/invoices/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'发票类型', field:'invoiceType', width:100,templet: function(item){
                return item['invoiceType']==0?'普票':'专票';
            }},
            {title:'发票抬头', field:'invoiceHead'},
            {title:'公司税号', field:'invoiceCode'},
            {title:'创建时间', field:'createTime',width:150},
            {title:'操作', field:'' , fixed: 'right', width:200, align:'center', templet: function(item){
                return '<a data-id="'+item['id']+'" class="btn btn-blue btngroup btn'+item['id']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
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
            var btns = [];
            btns.push({title: '编辑', clickFun:"editInvoice", cls:"btn-blue", icon:"fa-pencil"});
            btns.push({title:'删除',clickFun:"delInvoice", cls:"btn-red", icon:"fa-trash-o"});
            WST.initGridButtons({id:'.btngroup',btns:btns});
        }
    });
}

function loadGrid(p){
    p=(p<=1)?1:p;
    mmg.reload('dataTable',{page:{curr:p}});
}

function editInvoice(id) {
    location.href = WST.U('shop/invoices/toEdit', 'id='+id+'&p='+WST_CURR_PAGE);
}
function toAdd(){
    var num = $('#mmg tbody').children().size();
    if(num<20){
        location.href = WST.U('shop/invoices/toEdit');
    }else{
        WST.msg('发票信息不能超过20条', { icon: 2 });
    }
}
function delInvoice(id, t) {
    WST.confirm({
        content: "您确定要删除该发票信息吗？", yes: function (tips) {
            var ll = layer.load('数据处理中，请稍候...');
            $.post(WST.U('shop/invoices/del'), { id: id }, function (data, textStatus) {
                layer.close(ll);
                layer.close(tips);
                var json = WST.toJson(data);
                if (json.status == '1') {
                    WST.msg('操作成功!', { icon: 1 }, function () {
                        initGrid(WST_CURR_PAGE);
                    });
                } else {
                    WST.msg('操作失败!', { icon: 2 });
                }
            });
        }
    });
}
