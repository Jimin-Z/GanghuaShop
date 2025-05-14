var mmg,h;
function initGridMsg(p){
    var tbHeight = $('.wst-toolbar').outerHeight(true)+35+20;
    var h = 'full-'+tbHeight;
    mmg = layui.table;
    mmg.render({elem: '#mmg1',id:'dataTable1',url:WST.U('admin/templatemsgs/pageMsgQuery'),cellMinWidth: 80,height: h,skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'发送时机', field:'tplCode',width:160},
            {title:'发送内容', field:'tplContent'},
            {title:'是否开启', field:'status',width:120 ,align:'center',templet: function(item){
                return '<input type="checkbox" '+((item['status']==1)?"checked":"")+' name="isShow2" lay-skin="switch" lay-filter="isShow2" data="'+item['id']+'" lay-text="开启|关闭">';
            }},
            {title:'操作', field:'' , fixed: 'right', width:150, align:'center', templet: function(item){
                var h = "";
                if(WST.GRANT.XXMB_02)h += "<a  class='btn btn-blue' onclick='javascript:toEditMsg("+item['id']+")'><i class='fa fa-pencil'></i>修改</a> ";
                return h;
            }}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadGridMsg(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
            layui.form.render();
            layui.form.on('switch(isShow2)', function(data){
                var id = $(this).attr("data");
                if(this.checked){
                    toggleIsShow(0,id,1);
                }else{
                    toggleIsShow(1,id,1);
                }
            });
        }
    });
}
function initGridEmail(p){
    var tbHeight = $('.wst-toolbar').outerHeight(true)+35+20;
    var h = 'full-'+tbHeight;
    mmg = layui.table;
    mmg.render({elem: '#mmg2',id:'dataTable2',url:WST.U('admin/templatemsgs/pageEmailQuery'),cellMinWidth: 80,height: h,skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'发送时机', field:'tplCode',width:160},
            {title:'发送内容', field:'tplContent'},
            {title:'是否开启', field:'status',width:120 ,align:'center',templet: function(item){
                return '<input type="checkbox" '+((item['status']==1)?"checked":"")+' name="isShow2" lay-skin="switch" lay-filter="isShow2" data="'+item['id']+'" lay-text="开启|关闭">';
            }},
            {title:'操作', field:'' , fixed: 'right', width:150, align:'center', templet: function(item){
                var h = "";
                if(WST.GRANT.XXMB_02)h += "<a  class='btn btn-blue' onclick='javascript:toEditEmail("+item['id']+")'><i class='fa fa-pencil'></i>修改</a> ";
                return h;
            }}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadGridEmail(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
            layui.form.render();
            layui.form.on('switch(isShow2)', function(data){
                var id = $(this).attr("data");
                if(this.checked){
                    toggleIsShow(0,id,2);
                }else{
                    toggleIsShow(1,id,2);
                }
            });
        }
    });
}
function initGridSMS(p){
    var tbHeight = $('.wst-toolbar').outerHeight(true)+$('#alertTips').outerHeight(true)+35+20;
    var h = 'full-'+tbHeight;
    mmg = layui.table;
    mmg.render({elem: '#mmg3',id:'dataTable3',url:WST.U('admin/templatemsgs/pageSMSQuery'),cellMinWidth: 80,height: h,skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'发送时机', field:'tplCode',width:160},
            {title:'发送内容', field:'tplContent'},
            {title:'是否开启', field:'status',width:120 ,align:'center',templet: function(item){
                return '<input type="checkbox" '+((item['status']==1)?"checked":"")+' name="isShow2" lay-skin="switch" lay-filter="isShow2" data="'+item['id']+'" lay-text="开启|关闭">';
            }},
            {title:'操作', field:'' , fixed: 'right', width:150, align:'center', templet: function(item){
                var h = "";
                if(WST.GRANT.XXMB_02)h += "<a  class='btn btn-blue' onclick='javascript:toEditSMS("+item['id']+")'><i class='fa fa-pencil'></i>修改</a> ";
                return h;
            }}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadGridSMS(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
            layui.form.render();
            layui.form.on('switch(isShow2)', function(data){
                var id = $(this).attr("data");
                if(this.checked){
                    toggleIsShow(0,id,3);
                }else{
                    toggleIsShow(1,id,3);
                }
            });
        }
    });
}
function loadGridMsg(p){
    p=(p<=1)?1:p;
    mmg.reload('dataTable1',{page:{curr:p}});
}

function loadGridEmail(p){
    p=(p<=1)?1:p;
    mmg.reload('dataTable2',{page:{curr:p}});
}

function loadGridSMS(p){
    p=(p<=1)?1:p;
    mmg.reload('dataTable3',{page:{curr:p}});
}
function toggleIsShow(t,v,table){
	if(!WST.GRANT.XXMB_02)return;
    var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
    	$.post(WST.U('admin/TemplateMsgs/editiIsShow'),{id:v,status:t},function(data,textStatus){
			  layer.close(loading);
			  var json = WST.toAdminJson(data);
			  if(json.status=='1'){
			    	WST.msg(json.msg,{icon:1});
                    mmg.reload('dataTable'+table,{page:{curr:WST_CURR_PAGE}});
			  }else{
			    	WST.msg(json.msg,{icon:2});
			  }
		});
}
var editor1;
function initEditor(){
  KindEditor.ready(function(K) {
    editor1 = K.create('textarea[name="tplContent"]', {
      uploadJson : WST.conf.ROOT+'/admin/messages/editorUpload',
      height:'350px',
      allowFileManager : false,
      allowImageUpload : true,
      items:[
              'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
              'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
              'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
              'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
              'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
              'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|','image','table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
              'anchor', 'link', 'unlink', '|', 'about'
      ],
      afterBlur: function(){ this.sync(); }
    });
  });
}

function toEditMsg(id){
    location.href = WST.U('admin/templatemsgs/toEditMsg','id='+id+'&p='+WST_CURR_PAGE+'&tabType=1');
}
function toEditEmail(id){
    location.href = WST.U('admin/templatemsgs/toEditEmail','id='+id+'&p='+WST_CURR_PAGE+'&tabType=2');
}
function toEditSMS(id){
    location.href = WST.U('admin/templatemsgs/toEditSMS','id='+id+'&p='+WST_CURR_PAGE+'&tabType=3');
}
function save(type,p){
	  var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
    var params = WST.getParams('.ipt');
	  $.post(WST.U('admin/templatemsgs/edit'),params,function(data,textStatus){
	      layer.close(loading);
	      var json = WST.toAdminJson(data);
	      if(json.status=='1'){
	          WST.msg("操作成功",{icon:1});
	          location.href = WST.U('admin/templatemsgs/index','tabType='+type+'&p='+p);
	      }else{
	          WST.msg(json.msg,{icon:2});
	      }
	  });
}





