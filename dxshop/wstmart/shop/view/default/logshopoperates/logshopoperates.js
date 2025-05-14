var mmg;
$(function(){
	var laydate = layui.laydate;
	laydate.render({
	    elem: '#startDate'
	});
	laydate.render({
	    elem: '#endDate'
	});
	var h = WST.pageHeight();
    var cols = [
            {title:'帐号', field:'loginName', width:120},
            {title:'操作功能', field:'operateDesc' ,width:120},
            {title:'访问路径', field:'operateUrl'},
            {title:'操作IP', field:'operateIP' ,width:120},
            {title:'操作时间', field:'operateTime' ,width:170},
            {title:'传递参数', field:'op',width:150,templet: function (item,rowIndex){
	        	return "<a  class='btn btn-blue' onclick='javascript:toView("+item['operateId']+")'><i class='fa fa-search'></i>查看</a>";
	        }}
            ];
	mmg = layui.table;  
	mmg.render({
        elem: '.mmg',
        id:'dataTable',
        url:WST.U('shop/logshopoperates/pageQuery'),
        cellMinWidth: 80,height: WST.initGridHeight(),
        skin: 'line',
        even: true,
        limit:20,
        page:{curr:1},
        cols:[cols]
    })
    
})
function loadGrid(){
	
	mmg.reload('dataTable',{
        page:{curr:1},
        where:{
            startDate:$('#startDate').val(),
			endDate:$('#endDate').val(),
			loginName:$('#loginName').val(),
			operateUrl:$('#operateUrl').val()
        }
    });
}
function toView(id){
	 var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
	 $.post(WST.U('shop/logshopoperates/get'),{id:id},function(data,textStatus){
	       layer.close(loading);
	       var json = WST.toJson(data);
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