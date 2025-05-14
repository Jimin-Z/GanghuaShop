var mmg;
function initGrid(p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/limitwords/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            { title: '禁用关键字', field: 'word'},
            { title: '创建时间', field: 'createTime'},
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
            if(WST.GRANT.XTJYGJZ_02)btns.push({title: '编辑', clickFun:"toEdit", cls:"btn-blue", icon:"fa-pencil"});
            if(WST.GRANT.XTJYGJZ_03)btns.push({title:'删除',clickFun:"toDel", cls:"btn-red", icon:"fa-trash-o"});
            WST.initGridButtons({id:'.btngroup',btns:btns});
        }
    });
}
function loadGrid(p){
    p=(p<=1)?1:p;
    mmg.reload('dataTable',{where:{word:$('#limitword').val()},page:{curr:p}});
}

function toEdit(id){
    $('#limitWordForm')[0].reset();
    if(id>0){
        $.post(WST.U('admin/limitwords/get'),{id:id},function(data,textStatus){
            var json = WST.toAdminJson(data);
            if(json){
                WST.setValues(json);
                layui.form.render();
                editsBox(id);
            }
        });
    }else{
        WST.setValues({word:''});
        layui.form.render();
        editsBox(id);
    }
}

function editsBox(id,v){
    var title =(id>0)?"修改系统禁用关键字":"新增系统禁用关键字";
    var box = WST.open({title:title,type:1,content:$('#limitWordBox'),area: ['500px', '200px'],btn:['确定','取消'],
        end:function(){$('#limitWordBox').hide();},yes:function(){
            $('#limitWordForm').submit();
        }});
    $('#limitWordForm').validator({
        fields: {
            word: {
                tip: "请输入系统禁用关键字",
                rule: '系统禁用关键字:required;length[~50];'
            },
        },
        valid: function(form){
            var params = WST.getParams('.ipt');
            params.id = id;
            var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
            $.post(WST.U('admin/limitwords/'+((id>0)?"edit":"add")),params,function(data,textStatus){
                layer.close(loading);
                var json = WST.toAdminJson(data);
                if(json.status=='1'){
                    WST.msg(json.msg,{icon:1});
                    layer.close(box);
                    setTimeout(function(){
                        loadGrid(WST_CURR_PAGE);
                    },1000);
                }else{
                    WST.msg(json.msg,{icon:2});
                }
            });
        }
    });
}

function toDel(id){
    var box = WST.confirm({content:"您确定要删除该关键字吗?",yes:function(){
            var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
            $.post(WST.U('admin/limitwords/del'),{id:id},function(data,textStatus){
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
