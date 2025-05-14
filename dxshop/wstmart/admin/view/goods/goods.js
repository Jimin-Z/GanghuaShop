var mmg;
function initSaleGrid(p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/goods/saleByPage'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'&nbsp;', field:'goodsImg', width:70,templet: function(item){
                var thumb = item['goodsImg'];
                thumb = thumb.replace('.','_thumb.');
                return "<span class='weixin'><img id='img' onmouseout='toolTip()' onmouseover='toolTip()' style='height:50px;width:50px;' src='"+WST.conf.RESOURCE_PATH+"/"+thumb
                    +"'><span class='imged' ><img  style='height:180px;width:180px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['goodsImg']+"'></span></span>";
            }},
            {title:'商品名称', field:'goodsName', templet: function(item){
                return "<span><p class='wst-nowrap'><a style='color:blue' target='_blank' href='"+WST.U("home/goods/detail","goodsId="+item['goodsId'])+"'>"+item['goodsName']+"</a></p></span>";
            }},
            {title:'商品编号', field:'goodsSn' ,width:150},
            {title:'价格', field:'shopPrice' ,width:120,templet: function(item){
                return '￥'+item['shopPrice'];
            }},
            {title:'所属店铺', field:'shopName',width:170},
            {title:'所属分类', field:'goodsCatName' ,templet: function(item){
                return "<span  ><p class='wst-nowrap'>"+item['goodsCatName']+"</p></span>";
            }},
            {title:'销量', field:'saleNum',width:120},
            {title:'操作', field:'' , fixed: 'right', width:200, align:'center', templet: function(item){
                var h = "";
                if(WST.GRANT.SJSP_04)h += "<a class='btn btn-red' href='javascript:illegal(" + item['goodsId'] + ",1)'><i class='fa fa-ban'></i>违规下架</a> ";
                if(WST.GRANT.SJSP_03)h += "<a class='btn btn-red' href='javascript:del(" + item['goodsId'] + ",1)'><i class='fa fa-trash-o'></i>删除</a> ";
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
function loadGrid(p){
	p=(p<=1)?1:p;
	var params = WST.getParams('.j-ipt');
	params.areaIdPath = WST.ITGetAllAreaVals('areaId1','j-areas').join('_');
	params.goodsCatIdPath = WST.ITGetAllGoodsCatVals('cat_0','pgoodsCats').join('_');
    mmg.reload('dataTable',{where:params,page:{curr:p}});
}

function del(id,type){
	var box = WST.confirm({content:"您确定要删除该商品吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           $.post(WST.U('admin/goods/del'),{id:id},function(data,textStatus){
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
function illegal(id,type){
	var w = WST.open({type: 1,title:((type==1)?"商品违规原因":"商品不通过原因"),shade: [0.6, '#000'],border: [0],
	    content: '<textarea id="illegalRemarks" rows="7" style="width:calc(100% - 13px)" maxLength="200"></textarea>',
	    area: ['500px', '260px'],btn: ['确定', '关闭窗口'],
        yes: function(index, layero){
        	var illegalRemarks = $.trim($('#illegalRemarks').val());
        	if(illegalRemarks==''){
        		WST.msg(((type==1)?'请输入违规原因 !':'请输入不通过原因!'), {icon: 2});
        		return;
        	}
        	var ll = WST.msg('数据处理中，请稍候...');
		    $.post(WST.U('admin/goods/illegal'),{id:id,illegalRemarks:illegalRemarks},function(data){
		    	layer.close(w);
		    	layer.close(ll);
		    	var json = WST.toAdminJson(data);
				if(json.status>0){
					WST.msg(json.msg, {icon: 1});
					loadGrid(WST_CURR_PAGE);
				}else{
					WST.msg(json.msg, {icon: 2});
				}
		   });
        }
	});
}

function initAuditGrid(p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/goods/auditByPage'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {type: 'checkbox', field:'goodsId'},
            {title:'&nbsp;', field:'goodsName',width:70,templet: function(item){
                return "<span class='weixin'><img class='img' style='height:50px;width:50px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['goodsImg']+"'><img class='imged' style='height:200px;width:200px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['goodsImg']+"'></span>";
            }},
            {title:'商品名称', field:'goodsName',templet: function(item){
                return "<span><p class='wst-nowrap'><a style='color:blue' target='_blank' href='"+WST.U("home/goods/detail","goodsId="+item['goodsId']+"&key="+item['verfiycode'])+"'>"+item['goodsName']+"</a></p></span>";
            }},
            {title:'商品编号', field:'goodsSn' ,width:150},
            {title:'价格', field:'shopPrice' ,width:120,templet: function(item){
                return '￥'+item['shopPrice'];
            }},
            {title:'所属店铺', field:'shopName',width:170},
            {title:'所属分类', field:'goodsCatName' ,templet: function(item){
                return "<span  ><p class='wst-nowrap'>"+item['goodsCatName']+"</p></span>";
            }},
            {title:'销量', field:'saleNum',width:80},
            {title:'操作', field:'' , fixed: 'right', width:150, align:'center', templet: function(item){
                return '<a data-id="'+item['goodsId']+'" class="btn btn-blue btngroup btn'+item['goodsId']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
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
            for(var i=0;i<res.data.length;i++){
                btns = [];
                if(WST.GRANT.DSHSP_04){
                    btns.push({title: '通过',cls:"btn-blue", icon:"fa-check",act:104});
                    btns.push({title: '不通过',cls:"btn-blue", icon:"fa-red",act:105});
                }
                if(WST.GRANT.DSHSP_03)btns.push({title: '删除',cls:"btn-red", icon:"fa-trash-o",act:103});
                layui.dropdown.render({
                    elem: '.btn'+res.data[i].goodsId,
                    dataId:res.data[i].goodsId,
                    trigger: 'hover',
                    data: btns,
                    click: function(obj,othis){
                        switch(obj.act){
                            case 104:allow(this.dataId);break;
                            case 105:illegal(this.dataId);break;
                            case 103:del(this.dataId,0);break;
                        }
                    }
                });
            }
        }
    });
}
// 批量审核通过
function toBatchAllow(){
    var rows = mmg.checkStatus("dataTable").data;
	if(rows.length==0){
		 WST.msg('请选择商品',{icon:2});
		 return;
	}
	var ids = [];
	for(var i=0;i<rows.length;i++){
       ids.push(rows[i]['goodsId']);
	}

    var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
   	$.post(WST.U('admin/goods/batchAllow'),{ids:ids.join(',')},function(data,textStatus){
   			  layer.close(loading);
   			  var json = WST.toAdminJson(data);
   			  if(json.status=='1'){
   			    	WST.msg(json.msg,{icon:1});
   		            loadGrid(WST_CURR_PAGE);
   			  }else{
   			    	WST.msg(json.msg,{icon:2});
   			  }
   		});
}
// 批量审核不通过
function toBatchIllegal(){
    var rows = mmg.checkStatus("dataTable").data;
	if(rows.length==0){
		 WST.msg('请选择商品',{icon:2});
		 return;
	}
	var ids = [];
	for(var i=0;i<rows.length;i++){
       ids.push(rows[i]['goodsId']);
	}
	// 先显示弹出框,让用户输入审核不通原因
	var w = WST.open({type: 1,title:"商品不通过原因",shade: [0.6, '#000'],border: [0],
	    content: '<textarea id="illegalRemarks" rows="7" style="width:calc(100% - 13px)" maxLength="200"></textarea>',
	    area: ['500px', '260px'],btn: ['确定', '关闭窗口'],
        yes: function(index, layero){
        	var illegalRemarks = $.trim($('#illegalRemarks').val());
        	if(illegalRemarks==''){
        		WST.msg('请输入不通过原因!', {icon: 2});
        		return;
        	}
        	var ll = WST.msg('数据处理中，请稍候...');
		    $.post(WST.U('admin/goods/batchIllegal'),{ids:ids.join(','),illegalRemarks:illegalRemarks},function(data){
		    	layer.close(w);
		    	layer.close(ll);
		    	var json = WST.toAdminJson(data);
				if(json.status>0){
					WST.msg(json.msg, {icon: 1});
					loadGrid(WST_CURR_PAGE);
				}else{
					WST.msg(json.msg, {icon: 2});
				}
		   });
        }
	});
}

function allow(id,type){
	var box = WST.confirm({content:"您确定审核通过该商品吗?",yes:function(){
        var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
        $.post(WST.U('admin/goods/allow'),{id:id},function(data,textStatus){
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

function initIllegalGrid(p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/goods/illegalByPage'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'&nbsp;', field:'goodsName', width:70,templet: function(item){
                    return "<span class='weixin'><img class='img' style='height:50px;width:50px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['goodsImg']+"'><img class='imged' style='height:200px;width:200px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['goodsImg']+"'></span>";
                }},
            {title:'商品名称', field:'goodsName', templet: function(item){
                return "<span><p class='wst-nowrap'><a style='color:blue' target='_blank' href='"+WST.U("home/goods/detail","goodsId="+item['goodsId']+"&key="+item['verfiycode'])+"'>"+item['goodsName']+"</a></p></span>";
            }},
            {title:'商品编号', field:'goodsSn',width:150},
            {title:'所属店铺', field:'shopName',width:170},
            {title:'所属分类', field:'goodsCatName' ,templet: function(item){
                return "<span  ><p class='wst-nowrap'>"+item['goodsCatName']+"</p></span>";
            }},
            {title:'违规原因', field:'illegalRemarks', templet: function(item){
                return '<div >'+item['illegalRemarks']+'</div>';
            }},
            {title:'操作', field:'' , fixed: 'right', width:200, align:'center', templet: function(item){
                var h = "";
                if(WST.GRANT.WGSP_04)h += "<a class='btn btn-blue' href='javascript:allow(" + item['goodsId'] + ",0)'><i class='fa fa-check'></i>审核通过</a> ";
                if(WST.GRANT.WGSP_03)h += "<a class='btn btn-red' href='javascript:del(" + item['goodsId'] + ",0)'><i class='fa fa-trash-o'></i>删除</a></div> ";
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
function toolTip(){
    WST.toolTip();
}


var goodsTotal,num=0,vtype=0,creatQrcodeCnt=0;
var goodsList = [];
var goodsDir = "";
var grqmap = [],errRqlist = [];
function toExplode(){

    var box = WST.open({title:'导出商品二维码',type:1,content:layui.$('#exportBox'),area: ['400px', '180px'],btn:['确定导出','取消'],yes:function(){
        vtype = $("#vtype").val();
        var params = WST.getParams('.j-ipt');
        grqmap = []
        errRqlist = [];
        params.areaIdPath = WST.ITGetAllAreaVals('areaId1','j-areas').join('_');
        params.goodsCatIdPath = WST.ITGetAllGoodsCatVals('cat_0','pgoodsCats').join('_');
        params.goodsCatIdPath = WST.ITGetAllGoodsCatVals('cat_0','pgoodsCats').join('_');
        var loading = WST.msg('正在处理，请稍后...', {icon: 16,time:60000});
        $.post(WST.U('admin/goods/checkExportGoods'),params,function(data,textStatus){
                  layer.close(loading);
                  var json = WST.toAdminJson(data);
                  if(json.status==1){
                        goodsList = json.data.glist;
                        goodsDir = json.data.gdir;
                        goodsTotal = goodsList.length;
                        for(var i in goodsList){
                            grqmap[goodsList[i]['goodsId']] = goodsList[i];
                        }
                        layer.close(box);
                        if(goodsTotal>0){
                            createGoodsQrcode();
                        }else{
                            WST.msg("没有可导出的商品",{icon:1});
                        }
                  }else{
                        WST.msg(json.msg,{icon:2});
                  }
            });
        }
    });
}

function createGoodsQrcode(){
    var goodsId = goodsList[num].goodsId;
    WST.msg("当前正在生成第"+(num+1)+"个商品,进度"+num+"/"+goodsTotal);
    $.post(WST.U('admin/goods/createGoodsQrcode'),{vtype:vtype,goodsId:goodsId,dir:goodsDir},function(data,textStatus){
        var json = WST.toAdminJson(data);

        if(json.status!=1){
            errRqlist.push("<div style='line-height:30px;padding:0 20px;color:red;'>编号为【"+grqmap[goodsId]["goodsSn"]+"】的商品，"+json.msg+"，已跳过</div>");
        }else{
            creatQrcodeCnt++
        }
        if(num < goodsTotal-1){
            num++
            layer.closeAll();
            createGoodsQrcode();
            return;
        }else{
            num=0;
            if(creatQrcodeCnt>0){
                WST.msg("已完成生成商品二维码,共"+creatQrcodeCnt+"个",{icon:1});
                packageDownQrcode();
            }else{
                if(errRqlist.length>0){
                    WST.open({title:'提醒',
                    type:1,
                    content:errRqlist.join(""),
                    area: ['600px', '400px'],
                    btn:['确定'],
                    yes:function(){layer.closeAll();}})
                }
                WST.msg("没有商品可生成二维码",{icon:1});
            }
        }

    });
}


function packageDownQrcode(){
    var loading = WST.msg('正在打包商品二维码，请稍后...', {icon: 16,time:60000});
    $.post(WST.U('admin/goods/packageDownQrcode'),{dir:goodsDir},function(data,textStatus){
        var json = WST.toAdminJson(data);
        if(json.status=='1'){
            layer.close(loading);
            if(errRqlist.length>0){
                WST.open({title:'提醒',
                type:1,
                content:errRqlist.join(""),
                area: ['600px', '400px'],
                btn:['确定'],
                yes:function(){layer.closeAll();}})
            }

            window.location = window.conf.DOMAIN+"/"+json.data;
        }else{
            WST.msg(json.msg,{icon:2});
        }
    });
}
