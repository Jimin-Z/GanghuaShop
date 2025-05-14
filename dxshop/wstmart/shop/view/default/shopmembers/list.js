var mmg;
var mmg2;
function initGrid(p){
    var h = WST.pageHeight();
    var cols = [
            {type:'checkbox', field:'id', fixed: 'left'},
            {title:'客户信息', field:'loginName'},
            {title:'客户分组', field:'groupName',width:170,templet: function(item){
                var val = item['groupName'];
            	if(WST.blank(item['groupName'])=='')return '-';
              return val;
            }},
            {title:'交易金额(￥)', field:'totalOrderMoney',width:100},
			{title:'交易笔数(笔)', field:'totalOrderNum',width:100},
			{title:'平均交易金额(￥)', field:'avgMoney',width:180,templet: function(item){
				return Math.round(item['totalOrderMoney']/item['totalOrderNum']*100) / 100;
			}},
			{title:'最近交易时间', field:'lastOrderTime',width:170},
            {title:'操作', field:'' , align:'center',width:150, templet: function(item){
				return "<a class='btn btn-blue' href='javascript:toView("+item["userId"]+")'><i class='fa fa-search'></i>交易记录</a> ";
            }}
            ];
    mmg = layui.table;
    mmg.render({
        elem: '.mmg',
        id:'dataTable',
        url:WST.U('shop/shopmembers/pageQuery',{isOrder:1}),
        cellMinWidth: 80,height: WST.initGridHeight(38),
        skin: 'line',
        even: true,
        limit:20,
        page:{curr:p},
        cols:[cols]
    })

    loadGrid(p);
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
        {title:'#',type:'numbers'},
		{title:'客户信息', field:'loginName'},
    {title:'客户分组', field:'groupName',width:170, templet: function(item){
        if(WST.blank(item['groupName'])=='')return '-';
        return item['groupName'];
    }},
    {title:'关注时间', field:'createTime',width:170}
	];
    mmg2 = layui.table;

    mmg2.render({
        elem: '.mmg2',
        id:'dataTable2',
        url:WST.U('shop/shopmembers/pageQuery',{isOrder:0}),
        cellMinWidth: 80,height: WST.initGridHeight($('.wst-toolbar2').outerHeight(true)+38),
        skin: 'line',
        even: true,
        limit:20,
        page:{curr:p},
        cols:[cols]
    })

	loadGrid2(p);
}

function loadGrid2(p){
	p=(p<=1)?1:p;
    mmg2.reload('dataTable2',{
        page:{curr:p},
        where:{
            isNew:1,
            key:$('#key2').val()
        }
    });
}

function toView(userId){
	location.href=WST.U('shop/orders/finished','userId='+userId);
}
function setGroup(type){

  var  _key = (type==1)?"dataTable":"dataTable2";
  var rows = mmg.checkStatus(_key).data;


  if(rows.length==0){
      WST.msg('请选择要设置的会员',{icon:2});
      return;
  }
  var box = WST.open({title:'设置会员分组',type:1,content:$('#editBox'),area: ['400px', '150px'],
    btn:['确定','取消'],end:function(){$('#editBox').hide();},yes:function(){
        $('#editForm').submit();
    },cancel:function () {
        $('#editForm')[0].reset();
    },btn2: function() {
        $('#editForm')[0].reset();
    },});
  $('#editForm').validator({
       valid: function(form){
            if(rows.length==0){
               WST.msg('请选择要设置的会员',{icon:2});
               return;
            }
            var ids = [];
            for(var i=0;i<rows.length;i++){
                 ids.push(rows[i]['userId']); 
            }
            var params = {};
            params.groupId = $('#groupId').val();
            params.ids = ids.join(',');
            var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
            $.post(WST.U('shop/shopmembers/setgroup'),params,function(data,textStatus){
                layer.close(loading);
                var json = WST.toJson(data);
                if(json.status=='1'){
                    WST.msg("操作成功",{icon:1});
                    $('#editBox').hide();
                    $('#editForm')[0].reset();
                    layer.close(box);
                    if(type==1){
                        loadGrid(WST_CURR_PAGE);
                    }else{
                        loadGrid2(WST_CURR_PAGE);
                    }
                }else{
                    WST.msg(json.msg,{icon:2});
                }
            });
      }
  });
}