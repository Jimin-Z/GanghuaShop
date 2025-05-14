var mmg;
function initGrid(p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/informs/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'&nbsp;', field:'goodsImg',width:80, templet: function(item){
                var thumb = item['goodsImg'];
                thumb = thumb.replace('.','_thumb.');
                return "<span class='weixin'><img id='img' onmouseout='toolTip()' onmouseover='toolTip()' style='height:50px;width:50px;' src='"+WST.conf.RESOURCE_PATH+"/"+thumb
                    +"'><span class='imged' ><img  style='height:180px;width:180px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['goodsImg']+"'></span></span>";
            }},
            {title:'举报商品', field:'goodsName',templet: function(item){
                return "<a style='color:blue;' target='_blank' href='"+WST.U("home/goods/detail","goodsId="+item['goodsId'])+"'><span>"+item['goodsName']+"</span></a>";
            }},
            {title:'举报店铺',width:170,field:'shopName'},
            {title:'举报人',width:120, field:'userName',templet: function(item){
                return WST.blank(item['userName'],item['loginName']);
            }},
            {title:'举报类型',width:180,field:'informType'},
            {title:'举报时间',width:200, field:'informTime'},
            {title:'状态',width:150,field:'informStatus', templet: function(item){
                if(item['informStatus']==0)
                    return "<span class='statu-wait'><i class='fa fa-clock-o'></i> 等待处理</span>";
                else if(item['informStatus']==1)
                    return "<span class='statu-no'><i class='fa fa-ban'></i> 无效举报</span>";
                else if(item['informStatus']==2)
                    return "<span class='statu-yes'><i class='fa fa-check-circle'></i> 有效举报</span>";
                else if(item['informStatus']==3)
                    return "<span class='statu-no'><i class='fa fa-exclamation-triangle'></i> 恶意举报</span>";
            }},
            {title:'操作', field:'' , fixed: 'right', width:200, align:'center', templet: function(item){
                var h = "";
                h += "<a class='btn btn-blue' href='javascript:toView(" + item['informId'] + ")'><i class='fa fa-search'></i>查看</a> ";
                if(item['informStatus']==0)
                    h += "<a class='btn btn-blue' href='javascript:toHandle(" + item['informId'] + ")'><i class='fa fa-pencil'></i>处理</a> ";
                return h;
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
function toView(id){
	location.href=WST.U('admin/informs/view','cid='+id+'&p='+WST_CURR_PAGE);
}
function toHandle(id){
	location.href=WST.U('admin/informs/toHandle','cid='+id+'&p='+WST_CURR_PAGE);
}
function loadGrid(p){
    p=(p<=1)?1:p;
    var query = WST.getParams('.j-ipt');
    mmg.reload('dataTable',{where:query,page:{curr:p}});
}



function finalHandle(id,p){
   var params = {};
   params.cid = id;
   params.finalResult = $.trim($('#finalResult').val());
   params.informStatus = $('input:radio:checked').val();
   if(params.finalResult==''){
     WST.msg('请输入处理信息!',{icon:2});
     return;
   }
   if(typeof(params.informStatus)=='undefined'){
		WST.msg('请选择处理结果',{icon:2});
		return;
	}
   var c = WST.confirm({title:'信息提示',content:'您确定处理该举报商品吗?',yes:function(){
     layer.close(c);
     $.post(WST.U('admin/informs/finalHandle'),params,function(data,textStatus){
        var json = WST.toAdminJson(data);
        if(json.status=='1'){
          WST.msg(json.msg,{icon:1});
          location.reload();
        }else if(json.status == '2'){
          location.href=WST.U('admin/informs/index',"p="+p);
        }else{
          WST.msg(json.msg,{icon:2});
        }
      });
   }});
}

function toolTip(){
    WST.toolTip();
}

