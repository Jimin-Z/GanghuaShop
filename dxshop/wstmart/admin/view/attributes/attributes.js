var mmg;
function initGrid(p){
	mmg = layui.table;
	mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/attributes/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
		cols: [[
			{title:'#',type:'numbers'},
			{title:'属性名称', field:'attrName',width:170},
			{title:'所属商品分类', field:'goodsCatNames',width:200},
			{title:'属性类型', field:'attrType',width:150, templet: function(item){
				return (item['attrType']==1)?'多选项':(item['attrType']==2?'下拉框':'输入框');
			}},
			{title:'属性选项', field:'attrVal'},
			{title:'是否显示', field:'attrVal',width:120,templet: function(item){
				return '<input type="checkbox" '+((item['isShow']==1)?"checked":"")+' id="isShow1" name="isShow1" value="1" class="ipt" lay-skin="switch" lay-filter="isShow1" data="'+item['attrId']+'" lay-text="显示|隐藏">'
			}},
			{title:'排序号', field:'attrSort',width:60},
			{title:'操作', field:'' , fixed: 'right', width:150, align:'center', templet: function(item){
				return '<a data-id="'+item['attrId']+'" class="btn btn-blue btngroup btn'+item['attrId']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
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
			if(WST.GRANT.SPSX_02)btns.push({title: '修改', clickFun:"toEdit", cls:"btn-blue", icon:"fa-pencil"});
			if(WST.GRANT.SPSX_03)btns.push({title:'删除',clickFun:"toDel", cls:"btn-red", icon:"fa-trash-o"});
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

//------------------属性类型---------------//
function toEdit(attrId){
	$("select[id^='bcat_0_']").remove();
	$('#attrForm').get(0).reset();
	$.post(WST.U('admin/attributes/get'),{attrId:attrId},function(data,textStatus){
        var json = WST.toAdminJson(data);
        WST.setValues(json);
        changeArrType(json.attrType);
        layui.form.render();
        if(json.goodsCatId>0){
        	var goodsCatPath = json.goodsCatPath.split("_");
        	$('#bcat_0').val(goodsCatPath[0]);
        	var opts = {id:'bcat_0',val:goodsCatPath[0],childIds:goodsCatPath,className:'goodsCats'}
        	WST.ITSetGoodsCats(opts);
        }
		var title =(attrId==0)?"新增":"编辑";
		var box = WST.open({title:title,type:1,content:$('#attrBox'),area: ['750px', '480px'],btn:['确定','取消'],
			end:function(){$('#attrBox').hide();},yes:function(){
			$('#attrForm').submit();
		}});
		$('#attrForm').validator({
			rules: {
				attrType: function() {
		            return ($('#attrType').val()!='0');
		        }
		    },
			fields: {
			 	'attrName': {rule:"required",msg:{required:'请输入属性名称'}},
			 	'attrVal': 'required(attrType)'
			},
			valid: function(form){
			    var params = WST.getParams('.ipt');
			    var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
			    params.goodsCatId = WST.ITGetGoodsCatVal('goodsCats');
			 	$.post(WST.U('admin/attributes/'+((params.attrId==0)?"add":"edit")),params,function(data,textStatus){
			 		layer.close(loading);
			    	var json = WST.toAdminJson(data);
					if(json.status=='1'){
						WST.msg("操作成功",{icon:1});
						layer.close(box);
						$('#attrBox').hide();
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
	var goodsCatPath = WST.ITGetAllGoodsCatVals('cat_0','pgoodsCats');
	mmg.reload('dataTable',{where:{"keyName":keyName,"goodsCatPath":goodsCatPath.join('_')},page:{curr:p}});
}

function toDel(attrId){
	var box = WST.confirm({content:"您确定要删除该属性吗?",yes:function(){
		var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
		$.post(WST.U('admin/attributes/del'),{attrId:attrId},function(data,textStatus){
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

function toggleIsShow( attrId, isShow){
	$.post(WST.U('admin/attributes/setToggle'), {'attrId':attrId, 'isShow':isShow}, function(data, textStatus){
		var json = WST.toAdminJson(data);
		if(json.status=='1'){
			WST.msg("操作成功",{icon:1});
			loadGrid(WST_CURR_PAGE);
		}else{
			WST.msg(json.msg,{icon:2});
		}
	})
}

function changeArrType(v){
	if(v>0){
		$('#attrValTr').show();
	}else{
		$('#attrValTr').hide();
	}
}
