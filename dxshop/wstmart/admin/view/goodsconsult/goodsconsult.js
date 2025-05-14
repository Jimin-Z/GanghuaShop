var mmg;
function initGrid(p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/goodsconsult/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'商品主图',width:80, field:'goodsImg', templet: function(item){
                var thumb = item['goodsImg'];
                thumb = thumb.replace('.','_thumb.');
                return "<span class='weixin'><img id='img' onmouseout='toolTip()' onmouseover='toolTip()' style='height:50px;width:50px;' src='"+WST.conf.RESOURCE_PATH+"/"+thumb
                    +"'><span class='imged' style='left:45px;'><img  style='height:150px;width:150px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['goodsImg']+"'></span></span>";
            }},
            {title:'商品', field:'goodsName',templet: function(item){
                return "<span  >"+item['goodsName']+"</span>";
            }},
            {title:'咨询内容', field:'consultContent', templet: function(item){
                return "<span  >"+item['consultContent']+"</span>";
            }},
            {title:'回复内容', field:'reply', templet: function(item){
                return "<span  >"+item['reply']+"</span>";
            }},
            {title:'状态',width:120, field:'isShow', templet: function(item){
                return (item['isShow']==0)?"<span class='statu-no'><i class='fa fa-ban'></i> 隐藏</span>":"<span class='statu-yes'><i class='fa fa-check-circle'></i> 显示</span></h3>";
            }},
            {title:'操作', field:'' , fixed: 'right', width:150, align:'center', templet: function(item){
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
            if(WST.GRANT.SPZX_02)btns.push({title: '修改', clickFun:"toEdit", cls:"btn-blue", icon:"fa-pencil"});
            if(WST.GRANT.SPZX_03)btns.push({title:'删除',clickFun:"toDel", cls:"btn-red", icon:"fa-trash-o"});
            WST.initGridButtons({id:'.btngroup',btns:btns});
        }
    });
}

function toEdit(id){
    location.href = WST.U('admin/goodsconsult/toEdit','id='+id+'&p='+WST_CURR_PAGE);
}

function toDel(id){
	var box = WST.confirm({content:"您确定要删除该记录吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/goodsconsult/del'),{id:id},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	layer.close(box);
	           		            loadGrid(WST_CURR_PAGE);
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}
function loadGrid(p){
    p=(p<=1)?1:p;
    var query = WST.getParams('.query');
    mmg.reload('dataTable',{where:query,page:{curr:p}});
}

function editInit(p){
/* 表单验证 */
    $('#goodsconsultForm').validator({
            fields: {
                consultContent: {
                  rule:"required;length(3~200)",
                  msg:{length:"评价内容为3-200个字",required:"评价内容为3-200个字"},
                  tip:"评价内容为3-200个字",
                  ok:"",
                },
                reply:  {
                  rule:"required;length(3~200)",
                  msg:{length:"回复内容为3-200个字",required:"回复内容为3-200个字"},
                  tip:"回复内容为3-200个字",
                  ok:""
                },

            },
          valid: function(form){
            var params = WST.getParams('.ipt');
            var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
            $.post(WST.U('admin/goodsconsult/edit'),params,function(data,textStatus){
              layer.close(loading);
              var json = WST.toAdminJson(data);
              if(json.status=='1'){
                  WST.msg("操作成功",{icon:1},function(){
                      WST.backPrePage();
                  });
              }else{
                    WST.msg(json.msg,{icon:2});
              }
            });

      }

    });
}
function toolTip(){
    $('body').mousemove(function(e){
    	var windowH = $(window).height();
        if(e.pageY >= windowH*0.8){
        	var top = windowH*0.233;
        	$('.imged').css('margin-top',-top);
        }else{
        	var top = windowH*0.06;
        	$('.imged').css('margin-top',-top);
        }
    });
}
