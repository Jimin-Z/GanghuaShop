var mmg;
function initGrid(p){
  var positionType = $("#positionType").val();
  var adPositionId = $("#adPositionId").val();
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/ads/pageQuery','positionType='+positionType+'&adPositionId='+adPositionId),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'图标', field:'' ,width:150, templet: function(item){
                var adFile = item['adFile'].split(',');
                return'<img src="'+WST.conf.RESOURCE_PATH+'/'+adFile[0]+'" style="max-width:100px; max-height:80px;"/>';
            }},
            {title:'标题', field:'adName'},
            {title:'广告位置', field:'positionName',width:120},
            {title:'广告网址', field:'adURL' },
            {title:'广告开始日期', field:'adStartDate',width:150},
            {title:'广告结束日期', field:'adEndDate',width:150},
            {title:'点击数', field:'adClickNum',width:80},
            {title:'排序号', field:'adSort' ,width:80,templet: function(item){
                return '<span style="color:blue;cursor:pointer;" ondblclick="changeSort(this,'+item["adId"]+');">'+item['adSort']+'</span>';
            }},
            {title:'操作', field:'' ,width:150, fixed: 'right',align:'center', templet: function(item){
                return '<a data-id="'+item['adId']+'" class="btn btn-blue btngroup btn'+item['adId']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
            }}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadQuery(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
            var btns = [];
            for(var i=0;i<res.data.length;i++){
                btns = [];
                if(adPositionId>0){
                    if(WST.GRANT.GGGL_02)btns.push({title: '修改',clickFun:"toEdit2", cls:"btn-blue", icon:"fa fa-pencil"});
                }else{
                    if(WST.GRANT.GGGL_02)btns.push({title: '修改',clickFun:"toEdit", cls:"btn-blue", icon:"fa fa-pencil"});
                }
                if(WST.GRANT.GGGL_03)btns.push({title: '删除',clickFun:"toDel", cls:"btn-red", icon:"fa fa-trash-o"});
                layui.dropdown.render({
                    elem: '.btn'+res.data[i].adId,
                    dataId:res.data[i].adId,
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
        }
    });
}
function toEdit(id){
    location.href = WST.U('admin/ads/toedit','id='+id+'&p='+WST_CURR_PAGE);
}
function toEdit2(id){
	var adPositionId = $("#adPositionId").val();
    location.href = WST.U('admin/ads/toedit2','id='+id+'&adPositionId='+adPositionId+'&p='+WST_CURR_PAGE);
}
function toDel(id){
	var box = WST.confirm({content:"您确定要删除该记录吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/ads/del'),{id:id},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	layer.close(box);
	           		        loadQuery(WST_CURR_PAGE);
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}
function loadQuery(p){
    p=(p<=1)?1:p;
    var query = WST.getParams('.query');
    mmg.reload('dataTable',{where:query,page:{curr:p}});
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
  $.post(WST.U('admin/ads/changeSort'),{id:id,adSort:sort},function(data){
    var json = WST.toAdminJson(data);
    if(json.status==1){
        $(t).parent().attr('ondblclick','changeSort(this,'+id+')');
        $(t).parent().html(parseInt(sort));
    }
  });
}



//查询
function adsQuery(){
		var query = WST.getParams('.query');
	    grid.set('url',WST.U('admin/ads/pageQuery',query));
}

var isContinueAdd = false;
function save(){
   isContinueAdd = false;
   $('#adsForm').submit();
}
function continueAdd(){
   isContinueAdd = true;
   $('#adsForm').submit();
}
function editInit(p){
  var laydate = layui.laydate;
    form = layui.form;
    laydate.render({elem: '#adStartDate'});
    laydate.render({elem: '#adEndDate'});
  //文件上传
	WST.upload({
  	  pick:'#adFilePicker',
  	  formData: {dir:'adspic'},
      compress:false,//默认不对图片进行压缩
  	  accept: {extensions: 'gif,jpg,jpeg,png',mimeTypes: 'image/jpg,image/jpeg,image/png,image/gif'},
  	  callback:function(f){
  		  var json = WST.toAdminJson(f);
  		  if(json.status==1){
  			$('#uploadMsg').empty().hide();
        var html = '<img src="'+WST.conf.RESOURCE_PATH+'/'+json.savePath+json.thumb+'" />';
        $('#preview').html(html);
        // 图片路径
        $('#adFile').val(json.savePath+json.thumb);
  		  }
	  },
	  progress:function(rate){
	      $('#uploadMsg').show().html('已上传'+rate+"%");
	  }
    });

 /* 表单验证 */
    $('#adsForm').validator({
    		timely:2,
            fields: {
                adPositionId: {
                  rule:"required",
                  msg:{required:"请选择广告位置"},
                  tip:"请选择广告位置",
                  ok:"验证通过",
                },
                adName: {
                  rule:"required;",
                  msg:{required:"广告标题不能为空"},
                  tip:"请输入广告标题",
                  ok:"验证通过",
                },
                adFile: {
                  rule:"required;",
                  msg:{required:"请上传广告图片"},
                  tip:"请上传广告图片",
                  ok:"",
                },
                adStartDate: {
                  rule:"required;match(lt, adEndDate, date)",
                  msg:{required:"请选择广告开始时间",match:"必须小于广告结束时间"},
                  ok:"验证通过",
                },
                adEndDate: {
                  rule:"required;match(gt, adStartDate, date)",
                  msg:{required:"请选择广告结束时间",match:"必须大于广告开始时间"},
                  ok:"验证通过",
                }
            },
          valid: function(form){
            var params = WST.getParams('.ipt');
            var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
            $.post(WST.U('admin/ads/'+((params.adId==0)?"add":"edit")),params,function(data,textStatus){
              layer.close(loading);
              var json = WST.toAdminJson(data);
              if(json.status=='1'){
                  WST.msg("操作成功",{icon:1});
                  if(isContinueAdd){
                     $('#adsForm').get(0).reset();
                     $('#preview').empty();
                     $('#adFile').val('');
                  }else{
                	  var positionId = $("#positionId").val();
                	  if(positionId>0){
                		  location.href = WST.U('admin/ads/index2','id='+positionId+'&p='+p);
                	  }else{
                		  location.href = WST.U('admin/ads/index',"p="+p);
                	  }
                  }
              }else{
                    WST.msg(json.msg,{icon:2});
              }
            });
      }
    });

    // app页面说明
    $.post(WST.U('admin/appscreens/pagequery'),{},function(responData){
      appScreens = responData;
    });
}

// app按钮
var appScreens = [];

var positionInfo;
/*获取地址*/
function addPosition(pType, val, getSize)
{
    $.post(WST.U('admin/adpositions/getPositon'),{'positionType':pType},function(data,textStatus){
        positionInfo = data;
        var html='<option value="">请选择</option>';
        $(data).each(function(k,v){
			var selected;
            if(v.positionId==val){
              selected = 'selected="selected"';
              getPhotoSize(v.positionId);
            }
            html +='<option '+selected+' value="'+v.positionId+'">'+v.positionName+'</option>';
        });
        $('#adPositionId').html(html);
        layui.form.render('select');

        // app内页面跳转说明
        if(pType==4){// App端
           if($('#appBtns').length==0){
               var options = ['<option value="0">请选择页面说明</option>'];
               for(var i in appScreens){
                  var _obj = appScreens[i];
                  options.push('<option value="'+_obj.explain+'">'+_obj.screenName+'</option>');
               }
               var select = '<select id="appBtns" >'+options.join('')+'</select>'
               var html= '<tr><th>app端广告网址说明：</th><td>'+select+'</td></tr><tr id="screenExplain"><th></th><td></td></tr>';
               $('#adsBtnType').after(html);
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




/*获取图片尺寸 以及设置图片显示方式*/
function getPhotoSize(pType)
{
  $(positionInfo).each(function(k,v){
      if(v.positionId==pType){
        $('#img_size').html(v.positionWidth+'x'+v.positionHeight);
        if(v.positionWidth>v.positionHeight){
             $('.ads-h-list').removeClass('ads-h-list').addClass('ads-w-list');
         }
      }
  });

}
