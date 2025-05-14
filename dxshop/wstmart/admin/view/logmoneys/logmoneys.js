var mmg1,mmg2,mmg3,mmg4,mmg,h;
function initTab(p){
	var element = layui.element;
	var isInit = isInit2 = isInit3 =  false;
	element.on('tab(msgTab)', function(data){
        var len = $(".layui-tab-title li").length;
	     if(data.index==1){
	        if(!isInit){
	           isInit = true;
	           shopGridInit(p);
	        }else{
	           loadShopGrid(p);
	        }
	     }
	     if(data.index==2){
            if(len==3){
                if(!isInit2){
                    isInit2 = true;
                    flowGridInit(p);
                }else{
                    loadFlowGrid(p);
                }
            }else if(len==4){
                if(!isInit3){
                    isInit3 = true;
                    supplierGridInit(p);
                }else{
                    loadSupplierGrid(p);
                }
            }
	     }
         if(data.index==3){
            if(!isInit2){
                isInit2 = true;
                flowGridInit(p);
            }else{
                loadFlowGrid(p);
            }
         }
	});
	userGridInit(p);
}
function userGridInit(p){
    var tbHeight = $('.wst-toolbar').outerHeight(true)+$('.layui-tab-title').outerHeight(true)+25;
    var h = 'full-'+tbHeight;
    mmg1 = layui.table;
    mmg1.render({elem: '#mmg1',id:'dataTable',url:WST.U('admin/logmoneys/pageQueryByUser'),cellMinWidth: 80,height: h,skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'账号', field:'loginName'},
            {title:'名称', field:'userName'},
            {title:'可用金额', field:'userMoney' ,templet: function(item){
                return "<span style='color:red;'>"+'￥'+item['userMoney']+"</span>";
            }},
            {title:'冻结金额', field:'lockMoney',templet: function(item){
                return "<span style='color:#31c15a;'>"+'￥'+item['lockMoney']+"</span>";
            }},
            {title:'充值送', field:'rechargeMoney' ,templet: function(item){
                return "<span style='color:#1890ff;'>"+'￥'+item['rechargeMoney']+"</span>";
            }},
            {title:'操作', field:'' , fixed: 'right', width:150, align:'center', templet: function(item){
                return '<a class="btn btn-blue" href="javascript:tologmoneys(0,'+item['userId']+')"><i class="fa fa-search"></i>查看</a>';
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
function shopGridInit(p){
    var tbHeight = $('.wst-toolbar2').outerHeight(true)+$('.layui-tab-title').outerHeight(true)+25;
    var h = 'full-'+tbHeight;
    mmg2 = layui.table;
    mmg2.render({elem: '#mmg2',id:'dataTable2',url:WST.U('admin/logmoneys/pageQueryByShop'),cellMinWidth: 80,height: h,skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'账号', field:'loginName'},
            {title:'商家', field:'shopName'},
            {title:'可用金额', field:'shopMoney' ,templet: function(item){
                return "<span style='color:red;'>"+'￥'+item['shopMoney']+"</span>";
            }},
            {title:'冻结金额', field:'lockMoney' ,templet: function(item){
                return "<span style='color:#31c15a;'>"+'￥'+item['lockMoney']+"</span>";
            }},
            {title:'充值送', field:'rechargeMoney' ,templet: function(item){
                return "<span style='color:#1890ff;'>"+'￥'+item['rechargeMoney']+"</span>";
            }},
            {title:'操作', field:'' , fixed: 'right', width:200, align:'center', templet: function(item){
                return '<a class="btn btn-blue" href="javascript:tologmoneys(1,'+item['shopId']+')"><i class="fa fa-search"></i>查看</a>';
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
function flowGridInit(p){
    var laydate = layui.laydate;
    laydate.render({
        elem: '#startDate'
    });
    laydate.render({
        elem: '#endDate'
    });
    var tbHeight = $('.wst-toolbar3').outerHeight(true)+$('.layui-tab-title').outerHeight(true)+25;
    var h = 'full-'+tbHeight;
    mmg3 = layui.table;
    mmg3.render({elem: '#mmg3',id:'dataTable3',url:WST.U('admin/logmoneys/pageQuery'),cellMinWidth: 80,height: h,skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'来源', field:'dataSrc',width:120},
            {title:'个人账号/店铺名', field:'loginName',width:190},
            {title:'金额', field:'money' ,width:150,templet: function(item){
                if(item['moneyType']==1){
                    return '<font color="red">+￥'+item['money']+'</font>';
                }else{
                    return '<font color="green">-￥'+item['money']+'</font>';
                }
            }},
            {title:'备注', field:'remark'},
            {title:'外部流水', field:'tradeNo'},
            {title:'日期', field:'createTime' ,width:170}
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
function loadUserGrid(p){
    p=(p<=1)?1:p;
    mmg1.reload('dataTable',{where:{key:$('#key1').val()},page:{curr:p}});
}
function loadShopGrid(p){
    p=(p<=1)?1:p;
    mmg2.reload('dataTable2',{where:{key:$('#key2').val()},page:{curr:p}});
}
function loadFlowGrid(p){
    p=(p<=1)?1:p;
    mmg3.reload('dataTable3',{where:{key:$('#key3').val(),type:$('#type').val(),startDate:$('#startDate').val(),endDate:$('#endDate').val()},page:{curr:p}});
}
function tologmoneys(t,id){
	location.href= WST.U('admin/logmoneys/tologmoneys','id='+id+"&src=logmoneys&type="+t+"&startDate="+$('#startDate').val()+"&endDate="+'&endDate='+$('#endDate').val()+'&p='+WST_CURR_PAGE);
}

function moneyGridInit(type,id){
    var laydate = layui.laydate;
    laydate.render({
        elem: '#startDate'
    });
    laydate.render({
        elem: '#endDate'
    });
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/logmoneys/pageQuery','type='+type+'&id='+id),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:true,
        cols: [[
            {title:'#',type:'numbers'},
            {title:'来源', field:'dataSrc',width:120},
            {title:'金额', field:'money',width:150 ,templet: function(item){
                if(item['moneyType']==1){
                    return '<font color="red">+￥'+item['money']+'</font>';
                }else{
                    return '<font color="green">-￥'+item['money']+'</font>';
                }
            }},
            {title:'备注', field:'remark'},
            {title:'外部流水', field:'tradeNo'},
            {title:'日期', field:'createTime' ,width:170}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadMoneyGrid(type,id,total_page);
                return;
            }
            WST_CURR_PAGE = curr;
        }
    });
}

function loadMoneyGrid(t,id,p){
    p=(p<=1)?1:p;
    mmg.reload('dataTable',{where:{id:id,type:t,startDate:$('#startDate').val(),endDate:$('#endDate').val()},page:{curr:p}});
}

var w;
function toAdd(id,type){
    var ll = WST.msg('正在加载信息，请稍候...');
    $.post(WST.U('admin/logmoneys/toAdd',{id:id,type:type}),{},function(data){
        layer.close(ll);
        w =WST.open({type: 1,title:"调节会员资金",shade: [0.6, '#000'],offset:'50px',border: [0],content:data,area: ['550px', '380px'],success:function(){
            layui.form.render();
        }});
    });
}
function editMoney(id,type){
    var params = WST.getParams('.ipt');
    params.targetId = id;
    params.targetType = type;
    var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
    $.post(WST.U('admin/logmoneys/add'),params,function(data,textStatus){
        layer.close(loading);
        var json = WST.toAdminJson(data);
        if(json.status=='1'){
            WST.msg("操作成功",{icon:1});
            closeFrom();
            loadMoneyGrid();
        }else{
            WST.msg(json.msg,{icon:2});
        }
    });
}
function closeFrom(){
    layer.close(w);
}

function supplierGridInit(p){
    var tbHeight = $('.wst-toolbar4').outerHeight(true)+$('.layui-tab-title').outerHeight(true)+25;
    var h = 'full-'+tbHeight;
    mmg4 = layui.table;
    mmg4.render({elem: '#mmg4',id:'dataTable4',url:WST.U('admin/logmoneys/pageQueryBySupplier'),cellMinWidth: 80,height: h,skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'账号', field:'loginName'},
            {title:'供货商', field:'supplierName'},
            {title:'可用金额', field:'supplierMoney' ,templet: function(item){
                return "<span style='color:red;'>"+'￥'+item['supplierMoney']+"</span>";
            }},
            {title:'冻结金额', field:'lockMoney' ,templet: function(item){
                return "<span style='color:#31c15a;'>"+'￥'+item['lockMoney']+"</span>";
            }},
            {title:'充值送', field:'rechargeMoney' ,templet: function(item){
                return "<span style='color:#1890ff;'>"+'￥'+item['rechargeMoney']+"</span>";
            }},
            {title:'操作', field:'' , fixed: 'right', width:200, align:'center', templet: function(item){
                return '<a class="btn btn-blue" href="javascript:tologmoneys(3,'+item['supplierId']+')"><i class="fa fa-search"></i>查看</a>';
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
    mmg4.reload('dataTable4',{where:{key:$('#key4').val()},page:{curr:p}});
}
