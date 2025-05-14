var mmg;
$(function () {
    pageQuery(-1);
	$('#tab').TabPanel({tab:0,callback:function(tab){
		switch(tab){
		   case 0:loadGrid(-1);break;
		   case 1:loadGrid(1);break;
		   case 2:loadGrid(0);break;
		}
	}})
});
function pageQuery(type){
    var tbHeight = 120+45+20;
    var h = 'full-'+tbHeight;
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('shop/logmoneys/pageShopQuery'),cellMinWidth: 80,height: h,skin: 'line',even: true,limit:20,page:true,
        cols: [[
            {title:'#',type:'numbers'},
            {title:'来源/用途', field:'dataSrc', width: 160},
            {title:'金额', field:'', width: 150,templet:function(item){
                if(item['moneyType']==1){
                    return "+￥"+item['money'];
                }else{
                    return "-￥"+item['money'];
                }
            }},
            {title:'日期', field:'createTime', width: 150},
            {title:'外部流水号', field:'', width: 150,templet:function(item){
                return WST.blank(item['tradeNo'],'-');
            }},
            {title:'备注', field:'remark', templet:function(item){
                return '<div title="'+item['remark']+'">'+item['remark']+'</div>';
            }}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadGrid(type,total_page);
                return;
            }
            WST_CURR_PAGE = curr;
        }
    });
}
function loadGrid(type,p){
    p = (p<=1)?1:p;
    mmg.reload('dataTable',{page:{curr:p},where:{type:type}});
}
