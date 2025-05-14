var mmg;
var mmg2;
function initGrid(p){
    var tbHeight = $('.wst-toolbar').outerHeight(true)+$('.layui-tab-title').outerHeight(true)+45;
    var h = 'full-'+tbHeight;
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/goodsappraises/pageQuery'),cellMinWidth: 80,height: h,skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'商品主图',width:80, field:'goodsImg', templet: function(item){
                var thumb = item['goodsImg'];
                thumb = thumb.replace('.','_thumb.');
                return "<span class='weixin'><img id='img' onmouseout='toolTip()' onmouseover='toolTip()' style='height:50px;width:50px;' src='"+WST.conf.RESOURCE_PATH+"/"+thumb
                    +"'><span class='imged' style='left:45px;'><img  style='height:150px;width:150px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['goodsImg']+"'></span></span>";
            }},
            {title:'订单号', field:'orderNo',width:120},
            {title:'商品',field:'goodsName',templet: function(item){
                return "<span  >"+item['goodsName']+"</span>";
            }},
            {title:'评分',width:170, field:'goodsScore',templet: function(item){
                var s="<div><div style='line-height:20px;'>商品评分：";
                for(var i=0;i<item['goodsScore'];++i){
                    s +="<img src='"+WST.conf.ROOT+"/wstmart/admin/view/goodsappraises/icon_score_yes.png'>";
                }
                s += "</div>";
                s += "<div style='line-height:20px;'>时效评分：";
                for(var i=0;i<item['timeScore'];++i){
                    s +="<img src='"+WST.conf.ROOT+"/wstmart/admin/view/goodsappraises/icon_score_yes.png'>";
                }
                s += "</div>";
                s+= "<div style='line-height:20px;'>服务评分：";
                for(var i=0;i<item['serviceScore'];++i){
                    s +="<img src='"+WST.conf.ROOT+"/wstmart/admin/view/goodsappraises/icon_score_yes.png'>";
                }
                s += "</div></div>";
                return s;
            }},
            {title:'评价内容', field:'content'},
            {title:'状态', field:'isShow',width:60, templet: function(item){
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
            if(WST.GRANT.PJGL_02)btns.push({title: '修改', clickFun:"toEdit", cls:"btn-blue", icon:"fa-pencil"});
            if(WST.GRANT.PJGL_03)btns.push({title:'删除',clickFun:"toDel", cls:"btn-red", icon:"fa-trash-o"});
            WST.initGridButtons({id:'.btngroup',btns:btns});
        }
    });
}
function initGrid2(p){
    var tbHeight = $('.wst-toolbar2').outerHeight(true)+$('.layui-tab-title').outerHeight(true)+45;
    var h = 'full-'+tbHeight;
    mmg2 = layui.table;
    mmg2.render({elem: '#mmg2',id:'dataTable2',url:WST.U('admin/goodsappraises/pageQuery','isReport=1'),cellMinWidth: 80,height: h,skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'商品主图',width:80, field:'goodsImg', templet: function(item){
                    var thumb = item['goodsImg'];
                    thumb = thumb.replace('.','_thumb.');
                    return "<span class='weixin'><img id='img' onmouseout='toolTip()' onmouseover='toolTip()' style='height:50px;width:50px;' src='"+WST.conf.RESOURCE_PATH+"/"+thumb
                        +"'><span class='imged' style='left:45px;'><img  style='height:150px;width:150px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['goodsImg']+"'></span></span>";
                }},
            {title:'订单号', field:'orderNo',width:120},
            {title:'商品',field:'goodsName',width:250,templet: function(item){
                return "<span  >"+item['goodsName']+"</span>";
            }},
            {title:'评分',width:170, field:'goodsScore',templet: function(item){
                var s="<div><div style='line-height:20px;'>商品评分：";
                for(var i=0;i<item['goodsScore'];++i){
                    s +="<img src='"+WST.conf.ROOT+"/wstmart/admin/view/goodsappraises/icon_score_yes.png'>";
                }
                s += "</div>";
                s += "<div style='line-height:20px;'>时效评分：";
                for(var i=0;i<item['timeScore'];++i){
                    s +="<img src='"+WST.conf.ROOT+"/wstmart/admin/view/goodsappraises/icon_score_yes.png'>";
                }
                s += "</div>";
                s+= "<div style='line-height:20px;'>服务评分：";
                for(var i=0;i<item['serviceScore'];++i){
                    s +="<img src='"+WST.conf.ROOT+"/wstmart/admin/view/goodsappraises/icon_score_yes.png'>";
                }
                s += "</div></div>";
                return s;
            }},
            {title:'举报理由', field:'reportContent'},
            {title:'评价状态', field:'appraisesStatus',width:60, templet: function(item){
                if(item['appraisesStatus']==1){
                    return "<span class='statu-yes'><i class='fa fa-check-circle'></i> 有效</span>";
                }else if(item['appraisesStatus']==0){
                    return "<span class='statu-wait'><i class='fa fa-clock-o'></i> 无效</span>";
                }else{
                    return "<span class='statu-no'><i class='fa fa-ban'></i> 删除</span>";
                }
            }},
            {title:'操作', field:'' , fixed: 'right', width:150, align:'center', templet: function(item){
                var h = "";
                if(WST.GRANT.PJGL_02 && item['appraisesStatus']==1)h += "<a class='btn btn-blue' href='javascript:toHandle("+item['id']+")'><i class='fa fa-pencil'></i>处理</a> ";
                return h;
            }}
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
function toHandle(id){
    location.href = WST.U('admin/goodsappraises/toHandle','id='+id+'&p='+WST_CURR_PAGE+'&tabType=2');
}
function toEdit(id){
    location.href = WST.U('admin/goodsappraises/toEdit','id='+id+'&p='+WST_CURR_PAGE+'&tabType=1');
}
function toDel(id){
	var box = WST.confirm({content:"您确定要删除该记录吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/goodsappraises/del'),{id:id},function(data,textStatus){
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
function loadGrid2(p){
    p=(p<=1)?1:p;
    var query = WST.getParams('.query2');
    query.isReport = 1;
    query.shopName = $('#shopName2').val();
    query.goodsName = $('#goodsName2').val();
    mmg2.reload('dataTable2',{where:query,page:{curr:p}});
}
function editInit(p){


/* 表单验证 */
    $('#goodsAppraisesForm').validator({
            fields: {
                content: {
                  rule:"required;length(3~50)",
                  msg:{length:"评价内容为3-50个字",required:"评价内容为3-50个字"},
                  tip:"评价内容为3-50个字",
                  ok:"",
                },
                score:  {
                  rule:"required",
                  msg:{required:"评分必须大于0"},
                  ok:"",
                  target:"#score_error",
                },

            },

          valid: function(form){
            var params = WST.getParams('.ipt');
                //获取修改的评分
                params.goodsScore = $('.goodsScore').find('[name=score]').val();
                params.timeScore = $('.timeScore').find('[name=score]').val();
                params.serviceScore = $('.serviceScore').find('[name=score]').val();
            var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
            $.post(WST.U('admin/goodsappraises/'+((params.id==0)?"add":"edit")),params,function(data,textStatus){
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

function handle(id,p){
    var params = {};
    params.id = id;
    params.reportStatus = $('input:radio:checked').val();
    params.reportDesc = $.trim($('#reportDesc').val());
    if(params.reportStatus==-1 && params.reportDesc==''){
        WST.msg('请输入举报失败原因!',{icon:2});
        return;
    }
    var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
    $.post(WST.U('admin/goodsappraises/handle'),params,function(data,textStatus){
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
