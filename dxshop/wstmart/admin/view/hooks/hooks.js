var mmg;
function initGrid(p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/hooks/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'名称', field:'name'},
            {title:'描述', field:'hookRemarks'},
            {title:'对应插件', field:'addons' },
            {title:'操作', field:'' , fixed: 'right', width:200, align:'center', templet: function(item){
                if(item['addons']!=''){
                    return '<a class="btn btn-blue btn-mright" href="javascript:hookBox('+item['hookId']+',\''+item['addons']+'\')"><i class="fa fa-search"></i>调整顺序</a>';
                }
                return '';
            }}
        ]],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                hooksQuery(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
        }
    });
}

function hookBox(id,addons){
    addons = addons.replace(',,',',');
    var str = addons.split(',');
    var h = (str.length<=2)?220:(str.length-2)*15+220;
    h = (h>500)?500:h;
    var html = ['<table class="hook">'];
    for(var i=0;i<str.length;i++){
        html.push('<tr><td width="60%" class="hookval" val="'+str[i]+'">'+str[i]+'</td><td><button type="button" class="btn btn-primary btn-mright" onclick="javascript:moveUp(this)">上移</button><button type="button" class="btn btn-primary btn-mright" onclick="javascript:moveDown(this)">下移</button></td></tr>')
    }
    html.push('</table>');
    var w=WST.open({
        type: 1,
        title:"插件监听顺序调整",
        content:html.join(''),shade: [0.6, '#000'],
        area: ['400px', h+'px'],
        btn: ['确定'],
        yes: function(index, layero){
            var hook = [];
            $('.hookval').each(function(){
                hook.push($(this).attr('val'));
            });
            if(hook.length<=1){
                WST.msg('无需调整插件监听顺序', {icon: 2});
                return;
            }
            var ll = WST.msg('数据处理中，请稍候...');
            $.post(WST.U('admin/hooks/changgeHookOrder'),{id:id,hook:hook.join(',')},function(data){
                layer.close(w);
                layer.close(ll);
                var json = WST.toAdminJson(data);
                if(json.status>0){
                    WST.msg(json.msg, {icon: 1});
                    hooksQuery();
                }else{
                    WST.msg(json.msg, {icon: 2});
                }
            });
        }
    });
}
function moveUp(obj){
    var tr = $(obj).parents("tr");
    if (tr.index() != 0)tr.prev().before(tr);
}
function moveDown(obj){
    var down = $(obj).parents("tr").parent();
    var len = down.children().size();
    var tr = $(obj).parents("tr");
    if (tr.index() != len - 1)tr.next().after(tr);
}
//查询
function hooksQuery(p){
    p=(p<=1)?1:p;
    var query = WST.getParams('.query');
    mmg.reload('dataTable',{where:query,page:{curr:p}});
}

