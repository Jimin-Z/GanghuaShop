var mmg;
function initGrid(p){
    var h = WST.pageHeight();
    var cols = [
            {title:'规格类型', field:'catName', width: 120},
            {title:'所属商品分类', field:'goodsCatNames'},
            {title:'是否允许上传图片', field:'isAllowImg', width: 150,templet: function(item){
            	return (item.isAllowImg==1)?"<span class='statu-yes'><i class='fa fa-check-circle'></i> 允许</span>":'';
            }},
            {title:'是否显示', field:'attrVal', width: 150,templet: function(item){
            	return '<input '+(item['shopId']==0?'disabled':'')+' type="checkbox" '+((item['isShow']==1)?"checked":"")+' id="isShow1" name="isShow1" value="1" class="ipt" lay-skin="switch" lay-filter="isShow1" data="'+item['catId']+'" lay-text="显示|隐藏">'
            }},
            {title:'来源', field:'attrVal', width: 120,templet: function(item){
            	if(item["shopId"]>0){
            		return "商家规格";
            	}else{
            		return "<span style='color:red'>平台规格</span>";
            	}
            }},
            {title:'操作', field:'op' , width:150,align:'center', templet: function(item){
            	if(item["shopId"]>0){
            		return '<a data-id="'+item['id']+'" class="btn btn-blue btngroup btn'+item['id']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
            	}else{
            		return '';
            	}
				return "";
                
            }}
            ];

	mmg = layui.table;
	mmg.render({
		elem: '.mmg',
		id:'dataTable',
		url:WST.U('shop/speccats/pageQuery'),
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
                loadGrid(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
            var btns = [];
            btns.push({title: '编辑', clickFun:"toEditCat", cls:"btn-blue", icon:"fa-pencil"});
            btns.push({title: '删除',clickFun:"toDelCat", cls:"btn-red", icon:"fa-trash-o"});
            WST.initGridButtons({id:'.btngroup',btns:btns});

			layui.form.render();
			layui.form.on('switch(isShow1)', function(data){
			var id = $(this).attr("data");
			if(this.checked){
				toggleIsShow(id, 1);
			}else{
				toggleIsShow(id, 0);
			}
			});
		}
	});
}
//------------------规格类型---------------//
function toEditCat(catId){
	$("select[id^='bcat_0_']").remove();
	$('#specCatsForm').get(0).reset();
	$.post(WST.U('shop/speccats/get'),{catId:catId},function(data,textStatus){
        var json = WST.toJson(data);
        WST.setValues(json);
        layui.form.render();
        if(json.goodsCatId>0){
        	var goodsCatPath = json.goodsCatPath.split("_");
        	$('#bcat_0').val(goodsCatPath[0]);
        	var opts = {id:'bcat_0',val:goodsCatPath[0],childIds:goodsCatPath,field:'goodsCats'}
        	WST.ITSetGoodsCats(opts);
        }
		var title =(catId==0)?"新增":"编辑";
		var box = WST.open({title:title,type:1,content:$('#specCatsBox'),area: ['750px', '360px'],btn:['确定','取消'],
			end:function(){$('#specCatsBox').hide();},yes:function(){
			$('#specCatsForm').submit();
		}});
		$('#specCatsForm').validator({
			fields: {
			 	'catName': {rule:"required remote;",msg:{required:'请输入规格名称'}},
			},
			valid: function(form){
			    var params = WST.getParams('.ipt');
			    var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
			    params.goodsCatId = WST.ITGetGoodsCatVal('goodsCats');
			 	$.post(WST.U('shop/speccats/'+((params.catId==0)?"add":"edit")),params,function(data,textStatus){
			 		layer.close(loading);
			    	var json = WST.toJson(data);
					if(json.status=='1'){
						WST.msg("操作成功",{icon:1});
						layer.close(box);
						$('#specCatsBox').hide();
						loadGrid(WST_CURR_PAGE);
						layer.close(box);
				  	}else{
				    	WST.msg(json.msg,{icon:2});
					}
			 	});
			}
		});
	});
}

function loadGrid(p){
	p=(p<=1)?1:p;
	var keyName = $("#keyName").val();
	var specSrc = $("#specSrc").val();
	var goodsCatPath = WST.ITGetAllGoodsCatVals('cat_0','pgoodsCats');
	mmg.reload('dataTable',{
		page:{curr:p},
		where:{
			"specSrc":specSrc,
			"keyName":keyName,
			"goodsCatPath":goodsCatPath.join('_')
		}
	});

}

function toDelCat(catId){
	var box = WST.confirm({content:"您确定要删除该类型吗?",yes:function(){
		var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
		$.post(WST.U('shop/speccats/del'),{catId:catId},function(data,textStatus){
			layer.close(loading);
			var json = WST.toJson(data);
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

function toggleIsShow( catId, isShow){
	$.post(WST.U('shop/speccats/setToggle'), {'catId':catId, 'isShow':isShow}, function(data, textStatus){
		var json = WST.toJson(data);
		if(json.status=='1'){
			WST.msg("操作成功",{icon:1});
			loadGrid(WST_CURR_PAGE);
		}else{
			WST.msg(json.msg,{icon:2});
		}
	})
}
