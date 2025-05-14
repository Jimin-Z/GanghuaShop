var mmg;
var mmg2;
var mmg3;
function initGrid(p){
    var h = WST.pageHeight();
    var cols = [
            {title:'品牌图标', field:'img', width: 80, templet: function(item){
                return "<span class='weixin'><img id='img' onmouseout='toolTip()' onmouseover='toolTip()' style='height:40px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['brandImg']
            	+"'><span class='imged' style='left:45px;' ><img  style='height:200px; width:200px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['brandImg']+"'></span></span>";
            }},
            {title:'品牌名称', field:'brandName'},
            {title:'品牌介绍', field:'brandDesc', templet: function(item){
                return "<span  ><p class='wst-nowrap'>"+item['brandDesc']+"</p></span>";
            }},
			{title:'审核状态', field:'brandDesc', width: 120,templet: function(item){
				if(item['applyStatus']==0){
					return "<span class='statu-wait'><i class='fa fa-clock-o'></i> "+item['applyStatusName']+"</span>";
				}else if(item['applyStatus']==1){
					return "<span class='statu-yes'><i class='fa fa-check-circle'></i> "+item['applyStatusName']+"</span>";
				}else{
					return "<span class='statu-no'><i class='fa fa-ban'></i> "+item['applyStatusName']+"</span>";
				}
			}},
            {title:'操作', field:'' , width: 150,align:'center', templet: function(item){
                var h = "";
                h = '<a class="btn btn-blue btngroup btn'+item['applyId']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
                return h
            }}
            ];

	mmg = layui.table;
	mmg.render({
		elem: '.mmg',
		id:'dataTable',
		url:WST.U('shop/brandapplys/pageQuery',{isNew:1}),
		cellMinWidth: 80,
		height: WST.initGridHeight(),
		skin: 'line',
		even: true,
		limit:20,
		page:{curr:p},
		cols: [cols],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadGrid(total_page);
                return;
            }
            var btns = [];var item;
            for(var i=0;i<res.data.length;i++){
            	 item = res.data[i];
                 btns = [];
                 if(item['applyStatus'] == 0){
                 	btns.push({title: '编辑',clickFun:"toEdit", cls:"btn-blue", icon:"fa-pencil",act:102});
                 }else{
                    btns.push({title: '查看',clickFun:"toEdit", cls:"btn-blue", icon:"fa-search",act:100});
                 }

                 btns.push({title: '删除',clickFun:"toDel", cls:"btn-red", icon:"fa-trash-o",act:103});
                 btns.push({type: '-'});
                 btns.push({title: '查看商家',clickFun:"toView", cls:"btn-blue", icon:"fa-search",act:104});
                 layui.dropdown.render({
                    elem: '.btn'+item.applyId,
                    dataId:item.applyId,
                    trigger: 'hover',
                    data: btns,
                    click: function(obj,othis){
                        switch(obj.act){
                           case 100:toEdit(this.dataId);break;
                           case 102:toEdit(this.dataId);break;
                           case 103:toDel(this.dataId);break;
                           case 104:toView(this.dataId);break;
                        }
                    }
                  });
            }
        }
	});
}

function loadGrid(p){
    p=(p<=1)?1:p;
	mmg.reload('dataTable',{
		page:{curr:p},
		where:{
			isNew:1,
			key:$('#key').val()
		}
	});
}

function initGrid2(p){
	var h = WST.pageHeight();
	var cols = [
		{title:'品牌图标', field:'img', width: 80, templet: function(item){
				return "<span class='weixin'><img id='img' onmouseout='toolTip()' onmouseover='toolTip()' style='height:40px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['brandImg']
					+"'><span class='imged' style='left:45px;' ><img  style='height:200px; width:200px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['brandImg']+"'></span></span>";
			}},
		{title:'品牌名称', field:'brandName'},
		{title:'品牌介绍', field:'brandDesc',templet: function(item){
				return "<span  ><p class='wst-nowrap'>"+item['brandDesc']+"</p></span>";
			}},
		{title:'审核状态', field:'brandDesc', width: 100,templet: function(item){
				if(item['applyStatus']==0){
					return "<span class='statu-wait'><i class='fa fa-clock-o'></i> "+item['applyStatusName']+"</span>";
				}else if(item['applyStatus']==1){
					return "<span class='statu-yes'><i class='fa fa-check-circle'></i> "+item['applyStatusName']+"</span>";
				}else{
					return "<span class='statu-no'><i class='fa fa-ban'></i> "+item['applyStatusName']+"</span>";
				}
			}},
		{title:'操作', field:'' , align:'center', width: 150, templet: function(item){
                var h = "";
                h = '<a class="btn btn-blue btngroup btn'+item['applyId']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
                return h;
			}}
	];
	mmg2 = layui.table;
	mmg2.render({
		elem: '.mmg2',
		id:'dataTable2',
		url:WST.U('shop/brandapplys/pageQuery',{isNew:0}),
		cellMinWidth: 80,
		height: WST.initGridHeight(),
		skin: 'line',
		even: true,
		limit:20,
		page:{curr:p},
		cols: [cols],
		done:function(res, curr, count){
			var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadGrid2(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
            var btns = [];
            for(var i=0;i<res.data.length;i++){
            	 item = res.data[i];
                 btns = [];
                 if(item['applyStatus'] == 0){
                 	btns.push({title: '编辑',clickFun:"toEdit", cls:"btn-blue", icon:"fa-pencil",act:102});
                 }else{
                    btns.push({title: '查看',clickFun:"toEdit", cls:"btn-blue", icon:"fa-search",act:100});
                 }

                 btns.push({title: '删除',clickFun:"toDel", cls:"btn-red", icon:"fa-trash-o",act:103});
                 layui.dropdown.render({
                    elem: '.btn'+item.applyId,
                    dataId:item.applyId,
                    trigger: 'hover',
                    data: btns,
                    click: function(obj,othis){
                        switch(obj.act){
                           case 100:toEdit(this.dataId);break;
                           case 102:toEdit(this.dataId);break;
                           case 103:toDel(this.dataId);break;
                        }
                    }
                  });
            }
		}
	});
}

function loadGrid2(p){
	p=(p<=1)?1:p;
	mmg2.reload('dataTable2',{
		page:{curr:p},
		where:{
			isNew:0,
			key:$('#key2').val()
		}
	});
}

function initGrid3(p){
	var h = WST.pageHeight();
	var cols = [
		{title:'店铺名称', field:'shopName'},
		{title:'申请时间', field:'createTime'}
	];
	mmg3 = layui.table;
	mmg3.render({
		elem: '.mmg3',
		id:'dataTable3',
		url:WST.U('shop/brandapplys/shopPageQuery'),
		cellMinWidth: 80,
		height: WST.initGridHeight(),
		skin: 'line',
		even: true,
		limit:20,
		page:{curr:p},
		cols: [cols],
	});

	loadGrid3(p);
}

function loadGrid3(p){
	p=(p<=1)?1:p;
	var brandId = $("#brandId").val();
	// mmg3.load({page:p,brandId:brandId,key:$('#key3').val()});

	mmg3.reload('dataTable3',{
		page:{curr:p},
		where:{
			brandId:brandId,
			key:$('#key3').val()
		}
	});
}

function toEdit(id){
	location.href=WST.U('shop/brandapplys/toEdit','id='+id+'&isNew='+$('#isNew').val()+'&p='+WST_CURR_PAGE);
}

function toView(id){
	location.href=WST.U('shop/brandapplys/toView','id='+id+'&p='+WST_CURR_PAGE);
}

function toEdits(id,p){
    var params = WST.getParams('.ipt');
    params.id = id;
    var type = $('#type').val();
    params.isNew = 0;
    if(type=='new'){
        params.isNew = 1;
    }
    var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	$.post(WST.U('shop/brandapplys/'+((id>0)?"edit":"add")),params,function(data,textStatus){
		  layer.close(loading);
		  var json = WST.toJson(data);
		  if(json.status=='1'){
		    	WST.msg(json.msg,{icon:1});
			    location.href=WST.U('shop/brandapplys/index',"p="+p+'&type='+type);
		  }else{
		        WST.msg(json.msg,{icon:2});
		  }
	});
}

function toDel(id){
    var isNew = $('#isNew').val();
	var box = WST.confirm({content:"您确定要删除该品牌吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('shop/brandapplys/del'),{id:id},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg(json.msg,{icon:1});
	           			    	layer.close(box);
                                  if(isNew==1){
                                      loadGrid(WST_CURR_PAGE);
                                  }else{
                                      loadGrid2(WST_CURR_PAGE);
                                  }
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}

function getBrandByKey(){
	if($.trim($('#keyName').val())==''){
        WST.msg('请输入品牌名称',{icon:2});
        return;
    }
	$('#brandNameBox').html('');
    cleanBrandInfo();
	var loading = WST.msg('正在查询品牌信息...', {icon: 16,time:60000});
	$.post(WST.U('shop/brandapplys/getBrandByKey'),{key:$('#keyName').val()},function(data,textStatus){
		layer.close(loading);
		var json = WST.toJson(data);
		if(json.status=='1'){
			var brands = json.data.data;
			for(var i=0;i<brands.length;i++){
				var brand = brands[i];
				var brandHtml = "";
				brandHtml += "<div class='wst-flex-row wst-ac brand-item'>";
				brandHtml += "<input type='radio' name='select-brand' class='select-brand' onclick='selectBrand(this)' value='"+brand.brandId+"'>";
				brandHtml += "<img src='"+WST.conf.RESOURCE_PATH+'/'+brand.brandImg+"' class='ipt select-brand-img' height='30'>";
				brandHtml += "<p>"+brand.brandName+"</p>";
				brandHtml += "</div>";
				$('#brandNameBox').append(brandHtml);
			}
		}else{
			WST.msg(json.msg,{icon:2});
		}
	});
}

function selectBrand(obj){
	var loading = WST.msg('正在加载品牌信息...', {icon: 16,time:60000});
	var brandId = $(obj).val();
	$.post(WST.U('shop/brandapplys/getBrandInfo'),{brandId:brandId},function(data,textStatus){
		layer.close(loading);
		var json = WST.toJson(data);
		if(json.status=='1'){
			var brand = json.data.data;
			$('#isNew').val(0);
			$('#brandId').val(brand.brandId);
			$('#brandName').val(brand.brandName).attr('readonly','readonly');
			$('#brandImg').val(brand.brandImg);
			$('#preview').html('');
			$('#preview').append("<img src='"+WST.conf.RESOURCE_PATH+'/'+brand.brandImg+"' class='ipt' height='30'>");
			$("#filePicker").hide();
			$("#brandDesc").val(brand.brandDesc);
			editor1.html(brand.brandDesc);
			editor1.readonly(true);
			for(var i=0;i<brand.catIds;i++){
				$(".goods-cat").each(function(idx, item) {
					$(item).attr("disabled","disabled");
					if($(item).val()==brand.catIds[i]){
						$(item).prop("checked",true);
					}
				});
			}
		}else{
			WST.msg(json.msg,{icon:2});
			cleanBrandInfo();
		}
	});
}

function cleanBrandInfo(){
	$('#isNew').val(1);
	$('#brandName').val('').attr('readonly',true);
    $('#brandId').val('');
	$('#brandImg').val('');
    $("#brandDesc").val('');
	editor1.html('');
	editor1.readonly(true);
	$(".goods-cat").each(function(idx, item) {
		$(item).attr("disabled",true);
		$(item).prop("checked",false);
	});
	$("#filePicker").show();
}

function initBrandInfo(){
    $('#brandName').attr('readonly',true);
    editor1.readonly(true);
    $(".goods-cat").each(function(idx, item) {
        $(item).attr("disabled",true);
    });
    $("#filePicker").hide();
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

function delVO(obj){
	$(obj).parent().remove();
	var imgPath = [];
	$('.step_pic').each(function(){
		imgPath.push($(this).attr('v'));
	});
	$('#accreditImg').val(imgPath.join(','));
}
