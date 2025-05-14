var mmg;
$(function(){
    var laydate = layui.laydate;
    laydate.render({
        elem: '#startDate'
    });
    laydate.render({
        elem: '#endDate'
    });
})
function initGrid(p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',url:WST.U('admin/orderComplains/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
    cols: [[
      {title:'#',type:'numbers'},
      {title:'投诉人', field:'userName', width: 100,templet: function(item){
              return WST.blank(item['userName'],item['loginName']);
      }},
      {title:'投诉订单号', field:'orderNo',width: 120,templet: function(item){
              var h = "";
              switch(item['orderSrc']){
                 case 0:h += '<i class="fa fa-desktop"></i>';break;
                 case 1:h += '<i class="fa fa-wechat"></i>';break;
                 case 2:h += '<i class="fa fa-mobile fa-lg"></i>';break;
                 case 3:h += '<i class="fa fa-android"></i>';break;
                 case 4:h += '<i class="fa fa-apple"></i>';break;
                 case 5:h += '<i class="fa fa-gg-circle"></i>';break;
              }
              h += " <a style='cursor:pointer' onclick='javascript:showDetail("+ item['complainId'] +");'>"+item['orderNo']+"</a>";
              return h;
      }},
      {title:'订投诉内容',field:'complainContent'},
      {title:'订单来源',width: 100,field:'orderCodeTitle'},
      {title:'被投诉人',width: 120,field:'shopName'},
      {title:'投诉类型',width: 120,field:'complainName'},
      {title:'投诉时间',width: 170,field:'complainTime'},
      {title:'状态', field:'complainStatus', width: 100,templet: function(item){
            if(item['complainStatus']==0)
              return '新投诉';
            else if(item['complainStatus']==1)
              return '转给应诉人';
            else if(item['complainStatus']==2)
              return '应诉人回应';
            else if(item['complainStatus']==3)
              return '等待仲裁';
            else if(item['complainStatus']==4)
              return '已仲裁';
      }},
        {title:'操作', field:'' , fixed: 'right', width:200, align:'center', templet: function(item){
         var h = "";
         h += "<a class='btn btn-blue' href='javascript:toView(" + item['complainId'] + ")'><i class='fa fa-search'></i>查看</a> ";
         if(item['complainStatus']!=4)
         h += "<a class='btn btn-blue' href='javascript:toHandle(" + item['complainId'] + ")'><i class='fa fa-pencil'></i>处理</a> ";
         return h;
      }}
    ]],
    done:function(res, curr, count){
      var e = this;
      var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
      if(count>0 && curr>total_page){
            loadGrid(total_page);
            return;
      }
      WST_CURR_PAGE = curr;
    }
  });
}
function toView(id){
	location.href=WST.U('admin/orderComplains/view','cid='+id+'&p='+WST_CURR_PAGE);
}
function toHandle(id){
	location.href=WST.U('admin/orderComplains/toHandle','cid='+id+'&p='+WST_CURR_PAGE);
}
function loadGrid(page){
	var p = WST.getParams('.j-ipt');
	page=(page<=1)?1:page;
	mmg.reload('mmg',{page:{curr:page},where:p});
}


function deliverNext(id){
     WST.confirm({content:'您确定要转交给应诉人应诉吗?',yes:function(){
       $.post(WST.U('Admin/Ordercomplains/deliverRespond'),{id:id},function(data,textStatus){
          var json = WST.toAdminJson(data);
          if(json.status=='1'){
        	  WST.msg('投诉已移交应诉人',{icon:1},function(){
        		  location.reload();
        	  });
          }else{
            WST.msg(json.msg,{icon:2});
          }
        });
     }});
}

function finalHandle(id){
   var params = {};
   params.cid = id;
   params.finalResult = $.trim($('#finalResult').val());
   if(params.finalResult==''){
     WST.msg('请输入仲裁结果!',{icon:2});
     return;
   }

   var c = WST.confirm({title:'信息提示',content:'您确定仲裁该订单投诉吗?',yes:function(){
     layer.close(c);
     $.post(WST.U('Admin/OrderComplains/finalHandle'),params,function(data,textStatus){
        var json = WST.toAdminJson(data);
        if(json.status=='1'){
          WST.msg(json.msg,{icon:1},function(){
            location.reload();
          });

        }else{
          WST.msg(json.msg,{icon:2});
        }
      });
   }});
}

function showDetail(id){
    parent.showBox({title:'订单详情',type:2,content:WST.U('admin/orderComplains/view',{cid:id,from:1}),area: ['1020px', '500px'],btn:['关闭']});
}

