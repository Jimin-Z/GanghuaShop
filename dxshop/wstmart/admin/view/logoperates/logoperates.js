var mmg;
$(function(){
	var laydate = layui.laydate;
	laydate.render({
	    elem: '#startDate'
	});
	laydate.render({
	    elem: '#endDate'
	});
	mmg = layui.table;
	mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/logoperates/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:true,
		cols: [[
			{title:'#',type:'numbers'},
			{title:'职员',field:'staffName',width:120},
			{title:'操作功能', field:'operateDesc' ,width:200,templet:function(item){
				return item['menuName']+"-"+item['operateDesc'];
			}},
			{title:'访问路径', field:'operateUrl'},
			{title:'操作IP', field:'operateIP',width:120},
			{title:'操作时间', field:'operateTime' ,width:170},
			{title:'传递参数', field:'' , fixed: 'right', width:200, align:'center', templet: function(item){
				return '<a data-id="'+item['operateId']+'" class="btn btn-blue btngroup btn'+item['operateId']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
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
			btns.push({title: '查看', clickFun:"toView", cls:"btn-blue", icon:"fa-search"});
			WST.initGridButtons({id:'.btngroup',btns:btns});
		}
	});
})
function loadGrid(p){
	p=(p<=1)?1:p;
	var query = WST.getParams('.ipt');
	mmg.reload('dataTable',{where:query,page:{curr:p}});
}
function toView(id){
	 var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
	 $.post(WST.U('admin/logoperates/get'),{id:id},function(data,textStatus){
	       layer.close(loading);
	       var json = WST.toAdminJson(data);
	       if(json.status==1){
               var content="<xmp style='white-space:normal'>"+json.data.content+"</xmp>";
	    	   $('#content').html(content);
	    	   var box = WST.open({ title:"传递参数",type: 1,area: ['500px', '350px'],
		                content:$('#viewBox'),
		                btn:['关闭'],
		                end:function(){$('#viewBox').hide();},
		                yes: function(index, layero){
		                	layer.close(box);
		                }
	    	   });
	       }else{
	           WST.msg(json.msg,{icon:2});
	       }
	 });
}
