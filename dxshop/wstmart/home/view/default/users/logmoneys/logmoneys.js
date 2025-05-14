$(function () {
	$('#tab').TabPanel({tab:0,callback:function(tab){
		switch(tab){
		   case 0:pageQuery(0,-1);break;
		   case 1:pageQuery(0,1);break;
		   case 2:pageQuery(0,0);break;
		}	
	}})
});
function pageQuery(p,type,limit){
	var tips = WST.load({msg:'正在获取数据，请稍后...'});
	var params = {};
	params.page = p;
	params.type = type;
    params.pagesize = (typeof(limit)=='undefined')?WST_PAGE_LIMIT:limit;
	$.post(WST.U('home/logmoneys/pageUserQuery'),params,function(data,textStatus){
		layer.close(tips);
	    var json = WST.toJson(data);
	    if(json.status==1){
	    	json = json.data;
		    var gettpl = document.getElementById('tblist').innerHTML;
		    layui.laytpl(gettpl).render(json.data, function(html){
		       	$('#page-list').html(html);
		    });
		    if(json.total>0){
                layui.laypage.render({
                    elem: 'pager',
                    count:json.total,
                    limit:json.per_page,
                    curr: json.current_page,
                    layout: ['prev', 'page', 'next', 'skip','count', 'limit'],
			        groups: 3,
			        jump: function(e, first){
                        WST_PAGE_LIMIT = e.limit;
			        	if(!first){
			        		pageQuery(e.curr,type,e.limit);
			        	}
			        } 
			    });
		     }else{
		       	 $('#pager').empty();
		     }
	    }
	});
}