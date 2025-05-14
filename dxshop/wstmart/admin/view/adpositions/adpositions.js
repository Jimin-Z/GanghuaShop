var mmg;
function initGrid(p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/adpositions/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'位置名称', field:'positionName'},
            {title:'宽度', field:'positionWidth'},
            {title:'高度', field:'positionHeight'},
            {title:'位置类型', field:'' ,templet: function(item){
                var pName;
                switch(item['positionType']){
                    case 2:
                        pName='微信版';
                        break;
                    case 3:
                        pName='手机版';
                        break;
                    case 4:
                        pName='APP版';
                        break;
                    case 5:
                        pName='小程序版';
                        break;
                    default:
                        pName='PC版';
                        break;
                }
                return pName;
            }},
            {title:'位置代码', field:'positionCode'},
            {title:'操作', field:'' , fixed: 'right', width:200, align:'center', templet: function(item){
                return '<a data-id="'+item['positionId']+'" class="btn btn-blue btngroup btn'+item['positionId']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
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
            if(WST.GRANT.GGGL_00)btns.push({title: '广告管理', clickFun:"toAds", cls:"btn-blue", icon:"fa-pencil"});
            if(WST.GRANT.GGWZ_02)btns.push({title: '修改', clickFun:"toEdit", cls:"btn-blue", icon:"fa-pencil"});
            if(WST.GRANT.GGWZ_03)btns.push({title:'删除',clickFun:"toDel", cls:"btn-red", icon:"fa-trash-o"});
            WST.initGridButtons({id:'.btngroup',btns:btns});
        }
    });
}
function toEdit(id){
	location.href = WST.U('admin/adpositions/toedit','id='+id+'&p='+WST_CURR_PAGE);
}
function toAds(id){
	location.href = WST.U('admin/ads/index2','id='+id+'&p='+WST_CURR_PAGE);
}
function loadQuery(p){
    p=(p<=1)?1:p;
    var query = WST.getParams('.query');
    mmg.reload('dataTable',{where:query,page:{curr:p}});
}
function toDel(id){
	var box = WST.confirm({content:"您确定要删除该记录吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/adpositions/del'),{id:id},function(data,textStatus){
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



function editInit(p){
	 /* 表单验证 */
    $('#adPositionsForm').validator({
            fields: {
                positionType: {
                  rule:"required",
                  msg:{required:"请选择位置类型"},
                  tip:"请选择位置类型",
                  ok:"",
                },
                positionName: {
                  rule:"required;",
                  msg:{required:"请输入位置名称"},
                  tip:"请输入位置名称",
                  ok:"",
                },
                positionCode: {
                    rule:"required;",
                    msg:{required:"请输入位置代码"},
                    tip:"请输入位置代码",
                    ok:"",
                  },
                positionWidth: {
                  rule:"required;",
                  msg:{required:"请输入建议宽度"},
                  ok:"",
                },
                positionHeight: {
                  rule:"required",
                  msg:{required:"请输入建议高度"},
                  ok:"",
                }
            },
          valid: function(form){
            var params = WST.getParams('.ipt');
            var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
            $.post(WST.U('admin/adpositions/'+((params.positionId==0)?"add":"edit")),params,function(data,textStatus){
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
