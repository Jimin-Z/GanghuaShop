var grid;
var h;
var mmg;
function initGrid(p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/messages/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {type: 'checkbox', field:'id'},
            {title:'消息类型', field:'msgType',width:120,templet: function(item){
                    return (item['msgType']==0)?'手工发送':'系统发送';
                }},
            {title:'发送者', field:'stName',width:170 },
            {title:'接收者', field:'loginName' ,width:170,templet: function(item){
                    return (item['loginName']!=null)?item['loginName']:item['shopName'];
                }},
            {title:'消息内容', field:'msgContent'},
            {title:'阅读状态', field:'msgStatus' ,width:120,templet: function(item){
                    return (item['msgStatus']==0)?"<span class='statu-no'><i class='fa fa-ban'></i> 未读</span>":"<span class='statu-yes'><i class='fa fa-check-circle'></i> 已读</span>";
                }},
            {title:'有效状态', field:'dataFlag' ,width:120,templet: function(item){
                    return (item['dataFlag']==-1)?"<span class='statu-wait'><i class='fa fa-ban'></i> 已删除</span>":"<span class='statu-yes'><i class='fa fa-check-circle'></i> 有效</span>";
                }},
            {title:'发送时间', field:'createTime' ,width:170},
            {title:'操作', field:'' , fixed: 'right', width:200, align:'center', templet: function(item){
                    return '<a data-id="'+item['id']+'" class="btn btn-blue btngroup btn'+item['id']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
                }}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                msgQuery(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
            var btns = [];
            if(WST.GRANT.SCXX_00)btns.push({title: '查看', clickFun:"showFullMsg", cls:"btn-blue", icon:"fa-pencil"});
            if(WST.GRANT.SCXX_03)btns.push({title:'删除',clickFun:"toDel", cls:"btn-red", icon:"fa-trash-o"});
            WST.initGridButtons({id:'.btngroup',btns:btns});
        }
    });
}



function showFullMsg(id){
	  parent.showBox({title:'内容详情',type:2,content:WST.U('admin/messages/showFullMsg','id='+id),area: ['800px', '500px'],btn:['关闭']});

}

function toDel(id){
	var box = WST.confirm({content:"您确定要删除该记录吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/messages/del'),{id:id},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	layer.close(box);
	           		        msgQuery(WST_CURR_PAGE);
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}

//切换卡
$(function (){
//编辑器
KindEditor.ready(function(K) {
editor1 = K.create('textarea[name="msgContent"]', {
  uploadJson : WST.conf.ROOT+'/admin/messages/editorUpload',
  height:'350px',
  allowFileManager : false,
  allowImageUpload : true,
  themeType : "default",
  items:[     'source', 'undo', 'redo',  'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
                'plainpaste', 'wordpaste', 'justifyleft', 'justifycenter', 'justifyright',
                'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
                'superscript', 'clearhtml', 'quickformat', 'selectall',  'fullscreen',
                'formatblock', 'fontname', 'fontsize',  'forecolor', 'hilitecolor', 'bold',
                'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', 'image','multiimage','media','table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
                'anchor', 'link', 'unlink'
  ],
  afterBlur: function(){ this.sync(); }
});
});
});


function sendToTheUser(t){
        if($('#theUser').prop('checked')){
          $('#user_query').show();
          $('#send_to').show();
        }else{
          $('#user_query').hide();
          $('#send_to').hide();
        }

     }
     //账号模糊查找
     function userQuery(){
      var key = $('#loginName').val();
      var html = '';
      $.post(WST.U('admin/messages/userQuery'),{'loginName':key},function(text,dataStatus){
          $(text).each(function(k,v){
            html += '<option value="'+v.userId+'">'+v.loginName+'</option>';
          });
          $('#ltarget').html(html);
      });

     }
     //发送消息
     function sendMsg(){
        var params = WST.getParams('.ipt');
        var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
        $.post(WST.U('admin/messages/add'),params,function(data,textStatus){
          layer.close(loading);
          var json = WST.toAdminJson(data);
          if(json.status=='1'){
              WST.msg("操作成功",{icon:1});
              $('#ltarget').html('');
              $('#rtarget').html('');
              $('#loginName').val('');
              editor1.html('');

          }else{
                WST.msg(json.msg,{icon:2});
          }
        });
     }


function msgQuery(p){
    p=(p<=1)?1:p;
    var query = WST.getParams('.query');
    mmg.reload('dataTable',{where:query,page:{curr:p}});
  }

//批量删除
function toBatchDelete(){
    var rows = mmg.checkStatus("dataTable").data;
	if(rows.length==0){
		 WST.msg('请选择记录',{icon:2});
		 return;
	}
	var ids = [];
	for(var i=0;i<rows.length;i++){
       ids.push(rows[i]['id']);
	}
	var box2 = WST.confirm({content:"您确定要删除选中的记录吗?",yes:function(){
        var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	       	$.post(WST.U('admin/messages/batchDel'),{ids:ids.join(',')},function(data,textStatus){
	 			  layer.close(loading);
	 			  var json = WST.toAdminJson(data);
	 			  if(json.status=='1'){
	 			    	WST.msg(json.msg,{icon:1});
	 			    	layer.close(box2);
	 			    	msgQuery(WST_CURR_PAGE);
	 			  }else{
	 			    	WST.msg(json.msg,{icon:2});
	 			  }
	 		});
         }});
}
