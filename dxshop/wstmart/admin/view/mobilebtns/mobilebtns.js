var mmg,isInitUpload = false;
function initGrid(p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/mobilebtns/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            { title: '图标', field: 'btnImg',width:100, templet:function(item){
                    return '<img src="'+WST.conf.RESOURCE_PATH+'/'+item['btnImg']+'" height="60px" />';
                }},
            { title: '按钮名称', field: 'btnName',width:170},
            { title: '按钮Url', field: 'btnUrl'},
            { title: '按钮类别', field: 'btnSrc', width: 150 ,templet:function(item){
                    var rs = '手机版';
                    switch(item['btnSrc']){
                        case 1:
                            rs='微信版';
                            break;
                        case 2:
                            rs='小程序';
                            break;
                        case 3:
                            rs='App';
                            break;
                    }
                    return rs;
                }},
            {title: '所属插件', field: 'addonsName',width:150},
            {title: '排序号', field: 'btnSort',width:120},
            {title:'操作', field:'' , fixed: 'right', width:200, align:'center', templet: function(item){
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
            if(WST.GRANT.ANGL_02)btns.push({title: '修改', clickFun:"getForEdit", cls:"btn-blue", icon:"fa-pencil"});
            if(WST.GRANT.ANGL_03)btns.push({title:'删除',clickFun:"toDel", cls:"btn-red", icon:"fa-trash-o"});
            WST.initGridButtons({id:'.btngroup',btns:btns});
            $('#btnSrc').change(function(v){
                if($(this).val()==3){// App端
                    if($('#appBtns').length==0){
                        var options = ['<option value="0">请选择页面说明</option>'];
                        for(var i in appScreens){
                            var _obj = appScreens[i];
                            options.push('<option value="'+_obj.explain+'">'+_obj.screenName+'</option>');
                        }
                        var select = '<select id="appBtns" >'+options.join('')+'</select>'
                        var html= '<tr><th>app端按钮说明：</th><td>'+select+'</td></tr><tr id="screenExplain"><th></th><td></td></tr>';
                        $('#mbBtnType').after(html);
                        $('#appBtns').change(function(v){
                            var _explain = $(this).val()==0?'':'<span style="color:red">示例Url：</span>'+$(this).val();
                            $('#screenExplain td').html(_explain);
                        })
                    }
                }else{
                    $('#appBtns').parent().parent().remove();
                    $('#screenExplain').remove();
                }
            })
        }
    });
}
// app按钮
var appScreens = []
$(function(){
  $.post(WST.U('admin/appscreens/pagequery'),{},function(responData){
    appScreens = (responData instanceof Object)?responData:[];
  });
});

function loadGrid(p){
    p=(p<=1)?1:p;
    var query = WST.getParams('.query');
    mmg.reload('dataTable',{where:query,page:{curr:p}});
}
function getForEdit(id){
	 var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
     $.post(WST.U('admin/mobileBtns/get'),{id:id},function(data,textStatus){
           layer.close(loading);
           var json = WST.toAdminJson(data);
           if(json.id){
           		WST.setValues(json);
           		//显示原来的图片
           		$('#preview').html('<img src="'+WST.conf.RESOURCE_PATH+'/'+json.btnImg+'" height="30px;"/>');
           		$('#isImg').val('ok');
           		toEdit(json.id);
           }else{
           		WST.msg(json.msg,{icon:2});
           }
    });
}

function toEdit(id){
  if(!isInitUpload){
    initUpload();
    isInitUpload = true;
  }
	var title =(id==0)?"新增":"编辑";
	var box = WST.open({title:title,type:1,content:$('#mbtnBox'),area: ['680px', '480px'],btn: ['确定','取消'],yes:function(){
			$('#mbtnForm').submit();
	},cancel:function(){
		//重置表单
		$('#mbtnForm')[0].reset();
		//清空预览图
		$('#preview').html('');
		$('#btnImg').val('');

	},end:function(){
		//重置表单
		$('#mbtnForm')[0].reset();
		//清空预览图
		$('#preview').html('');
		$('#btnImg').val('');
    $('#mbtnBox').hide();
    // 隐藏app端说明
    $('#appBtns').parent().parent().remove();
     $('#screenExplain').remove();

	}});
	$('#mbtnForm').validator({
        fields: {
            btnName: {
            	rule:"required;",
            	msg:{required:"请输入按钮名称"},
            	tip:"请输入按钮名称",
            	ok:"",
            },
            btnUrl: {
            	rule:"required;",
            	msg:{required:"请输入按Url"},
            	tip:"请输入按Url",
            	ok:"",
            },
            btnImg:  {
            	rule:"required;",
            	msg:{required:"请上传图标"},
            	tip:"请上传图标",
            	ok:"",
            },

        },
       valid: function(form){
		        var params = WST.getParams('.ipt');
		        	params.id = id;
		        var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
		   		$.post(WST.U('admin/mobileBtns/'+((id==0)?"add":"edit")),params,function(data,textStatus){
		   			  layer.close(loading);
		   			  var json = WST.toAdminJson(data);
		   			  if(json.status=='1'){
		   			    	WST.msg("操作成功",{icon:1});
		   			    	$('#mbtnForm')[0].reset();
		   			    	//清空预览图
		   			    	$('#preview').html('');
		   			    	//清空图片隐藏域
		   			    	$('#btnImg').val('');
		   			    	layer.close(box);
		   		            loadGrid(WST_CURR_PAGE);
		   			  }else{
		   			        WST.msg(json.msg,{icon:2});
		   			  }
		   		});

    	}

  });
}
function initUpload(){
  WST.upload({
    pick:'#adFilePicker',
    formData: {dir:'sysconfigs'},
    accept: {extensions: 'gif,jpg,jpeg,png',mimeTypes: 'image/jpg,image/jpeg,image/png,image/gif'},
    callback:function(f){
      var json = WST.toAdminJson(f);
      if(json.status==1){
        $('#uploadMsg').empty().hide();
        //将上传的图片路径赋给全局变量
      $('#btnImg').val(json.savePath+json.thumb);
      $('#preview').html('<img src="'+WST.conf.RESOURCE_PATH+'/'+json.savePath+json.thumb+'" height="30" />');
      }else{
        WST.msg(json.msg,{icon:2});
      }
  },
  progress:function(rate){
      $('#uploadMsg').show().html('已上传'+rate+"%");
  }
});
}
function toDel(id){
	var box = WST.confirm({content:"您确定要删除该记录吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/mobileBtns/del'),{id:id},function(data,textStatus){
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





