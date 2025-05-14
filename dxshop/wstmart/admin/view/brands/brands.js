var mmg;
var mmg2;
var mmg3;
var mmg4;
function initGrid(p){
    var tbHeight = $('.wst-toolbar').outerHeight(true)+$('.layui-tab-title').outerHeight(true)+25;
    var h = 'full-'+tbHeight;
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/brands/pageQuery'),cellMinWidth: 80,height: h,skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            { title: '品牌图标', field: 'img',width:100, templet:function(item){
                return "<span class='weixin'><img id='img' onmouseout='toolTip()' onmouseover='toolTip()' style='height:50px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['brandImg']
                    +"'><span class='imged' style='left:45px;' ><img  style='height:200px; width:200px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['brandImg']+"'></span></span>";
            }},
            { title: '品牌名称', field: 'brandName',width:150},
            { title: '品牌介绍', field: 'brandDesc',templet:function(item){
                return "<span  ><p class='wst-nowrap'>"+item['brandDesc']+"</p></span>";
            }},
            { title: '排序号', field: 'sortNo',width:70, templet:function(item){
                return '<span style="color:blue;cursor:pointer;" ondblclick="changeSort(this,'+item["brandId"]+');">'+item['sortNo']+'</span>';
            }},
            {title:'操作', field:'' , fixed: 'right', width:150, align:'center', templet: function(item){
                return '<a data-id="'+item['brandId']+'" class="btn btn-blue btngroup btn'+item['brandId']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
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
            if(WST.GRANT.PPGL_02)btns.push({title: '修改', clickFun:"toEdit", cls:"btn-blue", icon:"fa-pencil"});
            if(WST.GRANT.PPGL_03)btns.push({title:'删除',clickFun:"toDel", cls:"btn-red", icon:"fa-trash-o"});
            if(WST.GRANT.PPGL_00)btns.push({title:'加盟商',clickFun:"toView", cls:"btn-blue", icon:"fa-search"});
            WST.initGridButtons({id:'.btngroup',btns:btns});
        }
    });
}

function loadGrid(p){
    p=(p<=1)?1:p;
    mmg.reload('dataTable',{where:{key:$('#key').val(),id:$('#catId').val()},page:{curr:p}});
}

function initGrid2(p){
    var tbHeight = $('.wst-toolbar2').outerHeight(true)+$('.layui-tab-title').outerHeight(true)+25;
    var h = 'full-'+tbHeight;
    mmg2 = layui.table;
    mmg2.render({elem: '#mmg2',id:'dataTable2',url:WST.U('admin/brandapplys/pageQuery',{isNew:1}),cellMinWidth: 80,height: h,skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            { title: '品牌图标', field: 'img',width:100, templet:function(item){
                return "<span class='weixin'><img id='img' onmouseout='toolTip()' onmouseover='toolTip()' style='height:50px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['brandImg']
                    +"'><span class='imged' style='left:45px;' ><img  style='height:200px; width:200px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['brandImg']+"'></span></span>";
            }},
            { title: '品牌名称', field: 'brandName',width:150},
            {title:'申请品牌商家', field:'shopName',width:170},
            { title: '品牌介绍', field: 'brandDesc',templet:function(item){
                return "<span  ><p class='wst-nowrap'>"+item['brandDesc']+"</p></span>";
            }},
            {title:'审核状态', field:'brandDesc',width:120, templet:function(item){
                if(item['applyStatus']==0){
                    return "<span class='statu-wait'><i class='fa fa-clock-o'></i> "+item['applyStatusName']+"</span>";
                }else if(item['applyStatus']==1){
                    return "<span class='statu-yes'><i class='fa fa-check-circle'></i> "+item['applyStatusName']+"</span>";
                }else{
                    return "<span class='statu-no'><i class='fa fa-ban'></i> "+item['applyStatusName']+"</span>";
                }
            }},
            {title:'操作', field:'' , fixed: 'right', width:200, align:'center', templet: function(item){
                return '<a data-id="'+item['applyId']+'" class="btn btn-blue btngroup btn'+item['applyId']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
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
            var btns = [];
            for(var i=0;i<res.data.length;i++){
                btns = [];
                if(res.data[i]['applyStatus'] == 0){
                    if(WST.GRANT.PPGL_02)btns.push({title: '处理', clickFun:"toEditApply", cls:"btn-blue", icon:"fa-pencil"});
                }else{
                    if(WST.GRANT.PPGL_02)btns.push({title:'查看',clickFun:"toEditApply", cls:"btn-blue", icon:"fa-search"});
                }
                if(WST.GRANT.PPGL_03)btns.push({title:'删除',clickFun:"toDelApply", cls:"btn-red", icon:"fa-trash-o"});
                layui.dropdown.render({
                    elem: '.btn'+res.data[i].applyId,
                    dataId:res.data[i].applyId,
                    trigger: 'hover',
                    data: btns,
                    click: function(obj,othis){
                        var _fn = window[obj.clickFun];
                        if($(this.elem).data('fun-'+obj.clickFun)){
                            _fn && eval(obj.clickFun+'('+$(this.elem).data('fun-'+obj.clickFun)+')');
                        }else{
                            _fn && _fn($(this.elem).data('id'));
                        }
                    }
                });
            }
            WST.initGridButtons({id:'.btngroup',btns:btns});
        }
    });
}

function loadGrid2(p){
    p=(p<=1)?1:p;
    mmg2.reload('dataTable2',{where:{key:$('#key2').val(),isNew:1},page:{curr:p}});
}
function initGrid3(p){
    var tbHeight = $('.wst-toolbar3').outerHeight(true)+$('.layui-tab-title').outerHeight(true)+25;
    var h = 'full-'+tbHeight;
    mmg3 = layui.table;
    mmg3.render({elem: '#mmg3',id:'dataTable3',url:WST.U('admin/brandapplys/pageQuery',{isNew:0}),cellMinWidth: 80,height: h,skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            { title: '品牌图标', field: 'img',width:100, templet:function(item){
                return "<span class='weixin'><img id='img' onmouseout='toolTip()' onmouseover='toolTip()' style='height:50px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['brandImg']
                    +"'><span class='imged' style='left:45px;' ><img  style='height:200px; width:200px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['brandImg']+"'></span></span>";
            }},
            { title: '品牌名称', field: 'brandName',width:150},
            { title:'申请品牌商家', field:'shopName',width:170},
            { title: '品牌介绍', field: 'brandDesc',templet:function(item){
                return "<span  ><p class='wst-nowrap'>"+item['brandDesc']+"</p></span>";
            }},
            {title:'审核状态', field:'brandDesc',width:120, templet:function(item){
                if(item['applyStatus']==0){
                    return "<span class='statu-wait'><i class='fa fa-clock-o'></i> "+item['applyStatusName']+"</span>";
                }else if(item['applyStatus']==1){
                    return "<span class='statu-yes'><i class='fa fa-check-circle'></i> "+item['applyStatusName']+"</span>";
                }else{
                    return "<span class='statu-no'><i class='fa fa-ban'></i> "+item['applyStatusName']+"</span>";
                }
            }},
            {title:'操作', field:'' , fixed: 'right', width:200, align:'center', templet: function(item){
                return '<a data-id="'+item['applyId']+'" class="btn btn-blue btngroup btn'+item['applyId']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
            }}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadGrid3(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
            var btns = [];
            for(var i=0;i<res.data.length;i++){
                btns = [];
                if(res.data[i]['applyStatus'] == 0){
                    if(WST.GRANT.PPGL_02)btns.push({title: '处理', clickFun:"toEditApply", cls:"btn-blue", icon:"fa-pencil"});
                }else{
                    if(WST.GRANT.PPGL_02)btns.push({title:'查看',clickFun:"toEditApply", cls:"btn-blue", icon:"fa-search"});
                }
                if(WST.GRANT.PPGL_03)btns.push({title:'删除',clickFun:"toDelApply", cls:"btn-red", icon:"fa-trash-o"});
                layui.dropdown.render({
                    elem: '.btn'+res.data[i].applyId,
                    dataId:res.data[i].applyId,
                    trigger: 'hover',
                    data: btns,
                    click: function(obj,othis){
                        var _fn = window[obj.clickFun];
                        if($(this.elem).data('fun-'+obj.clickFun)){
                            _fn && eval(obj.clickFun+'('+$(this.elem).data('fun-'+obj.clickFun)+')');
                        }else{
                            _fn && _fn($(this.elem).data('id'));
                        }
                    }
                });
            }
            WST.initGridButtons({id:'.btngroup',btns:btns});
        }
    });
}

function loadGrid3(p){
    p=(p<=1)?1:p;
    mmg3.reload('dataTable3',{where:{key:$('#key3').val(),isNew:0},page:{curr:p}});
}

function initGrid4(p){
    mmg4 = layui.table;
    mmg4.render({elem: '#mmg4',id:'dataTable4',url:WST.U('admin/brands/shopPageQuery',{brandId:$("#brandId").val()}),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'店铺名称', field:'shopName'},
            {title:'申请时间', field:'createTime'},
            {title:'操作', field:'' , fixed: 'right', width:200, align:'center', templet: function(item){
                var h = "";
                if(WST.GRANT.PPGL_03)h += "<a class='btn btn-red' href='javascript:toDelShop("+item["applyId"]+")'><i class='fa fa-trash-o'></i>删除</a> ";
                return h;
            }}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadGrid4(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
        }
    });
}

function loadGrid4(p){
    p=(p<=1)?1:p;
    var brandId = $("#brandId").val();
    mmg4.reload('dataTable4',{where:{brandId:brandId,key:$('#key4').val()},page:{curr:p}});
}

function toEditApply(id){
    location.href=WST.U('admin/brandapplys/toEdit','id='+id+'&isNew='+$('#isNew').val()+'&p='+WST_CURR_PAGE);
}

function toDelApply(id){
    var isNew = $('#isNew').val();
    var box = WST.confirm({content:"您确定要删除该品牌申请吗?",yes:function(){
            var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
            $.post(WST.U('admin/brandapplys/del'),{id:id},function(data,textStatus){
                layer.close(loading);
                var json = WST.toAdminJson(data);
                if(json.status=='1'){
                    WST.msg(json.msg,{icon:1});
                    layer.close(box);
                    if(isNew==1){
                        loadGrid2(WST_CURR_PAGE);
                    }else{
                        loadGrid3(WST_CURR_PAGE);
                    }
                }else{
                    WST.msg(json.msg,{icon:2});
                }
            });
        }});
}

function toEdit(id){
	location.href=WST.U('admin/brands/toEdit','id='+id+'&p='+WST_CURR_PAGE);
}

function toView(id){
    location.href=WST.U('admin/brands/toView','id='+id+'&p='+WST_CURR_PAGE);
}

function toEdits(id,p){
    var params = WST.getParams('.ipt');
    params.id = id;
    var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	$.post(WST.U('admin/brands/'+((id>0)?"edit":"add")),params,function(data,textStatus){
		  layer.close(loading);
		  var json = WST.toAdminJson(data);
		  if(json.status=='1'){
              WST.msg(json.msg,{icon:1},function(){
                  WST.backPrePage();
              });
		  }else{
		        WST.msg(json.msg,{icon:2});
		  }
	});
}

function toDel(id){
	var box = WST.confirm({content:"您确定要删除该品牌吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/brands/del'),{id:id},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg(json.msg,{icon:1});
	           			    	layer.close(box);
	           		            loadGrid(WST_CURR_PAGE);
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
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


var oldSort;
function changeSort(t,id){
    $(t).attr('ondblclick'," ");
    var html = "<input type='text' id='sort-"+id+"' style='width:30px;padding:2px;' onblur='doneChange(this,"+id+")' value='"+$(t).html()+"' />";
    $(t).html(html);
    $('#sort-'+id).focus();
    $('#sort-'+id).select();
    oldSort = $(t).html();
}
function doneChange(t,id){
    var sort = ($(t).val()=='')?0:$(t).val();
    if(sort==oldSort){
        $(t).parent().attr('ondblclick','changeSort(this,'+id+')');
        $(t).parent().html(parseInt(sort));
        return;
    }
    $.post(WST.U('admin/brands/changeSort'),{id:id,sortNo:sort},function(data){
        var json = WST.toAdminJson(data);
        if(json.status==1){
            $(t).parent().attr('ondblclick','changeSort(this,'+id+')');
            $(t).parent().html(parseInt(sort));
        }
    });
}

function toDelShop(id){
    var box = WST.confirm({content:"删除后店铺无法继续使用该品牌，您确定要删除该记录吗?",yes:function(){
            var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
            $.post(WST.U('admin/brandapplys/delShop'),{id:id},function(data,textStatus){
                layer.close(loading);
                var json = WST.toAdminJson(data);
                if(json.status=='1'){
                    WST.msg(json.msg,{icon:1});
                    layer.close(box);
                    loadGrid3(WST_CURR_PAGE);
                }else{
                    WST.msg(json.msg,{icon:2});
                }
            });
        }});
}
