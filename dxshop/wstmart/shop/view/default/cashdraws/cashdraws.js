var mmg;
$(function () {
	$('#tab').TabPanel({tab:0,callback:function(tab){
		switch(tab){
		   case 0:pageQuery();break;
		   case 1:pageConfigQuery(0);break;
		}
	}})
});
var isSetPayPwd = 1;
function getShopMoney(){
	$.post(WST.U('shop/shops/getShopMoney'),{},function(data,textStatus){
		var json = WST.toJson(data);
		if(json.status==1){
			var shopMoney = json.data.shopMoney;
			var rechargeMoney = json.data.rechargeMoney;
			$('#shopMoney').html('¥'+shopMoney);
			$('#lockMoney').html('¥'+json.data.lockMoney);
			rechargeMoney = parseFloat(shopMoney - rechargeMoney)
			$('#userCashMoney').html('¥'+rechargeMoney.toFixed(2));
			if(json.data.isDraw==1){
               $('#drawBtn').show();
			}else{
               $('#drawBtn').hide();
			}
			isSetPayPwd = json.data.isSetPayPwd;
		}
	});
}
function pageQuery(){
	mmg = layui.table;
	var tbHeight = 120+45+20;
	var h = 'full-'+tbHeight;
	mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('shop/cashdraws/pageQueryByShop'),cellMinWidth: 80,height: h,skin: 'line',even: true,limit:20,page:true,
		cols: [[
			{title:'#',type:'numbers'},
			{title:'提现单号', field:'cashNo', width: 150},
			{title:'提现账号信息', field:'accTargetName', templet:function(item){
				if(item['accType']==1){
					return item['accNo'];
				}else{
					return item['accTargetName']+'|'+item['accNo'];
				}
			}},
			{title:'持卡人/真实姓名', field:'accUser', width: 150},
			{title:'提现金额', field:'money', width: 150,templet:function(item){return '￥'+item['money'];}},
			{title:'申请时间', field:'createTime', width: 150},
			{title:'提现状态', field:'', width: 250,align:'center', fixed: 'right',templet:function(item){
				if(item['cashSatus']==1){
					return "<span class='statu-yes'><i class='fa fa-check-circle'></i> 提现成功</span>";
				}else if(item['cashSatus']==-1){
					return "<span class='statu-no'>提现失败<br/>【原因】"+item['cashRemarks']+"</span>";
				}else{
					return "<span class='statu-wait'><i class='fa fa-clock-o'></i> 待处理</span>";
				}
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
		}
	});
}
function loadGrid(p){
	p = (p<=1)?1:p;
	mmg.reload('dataTable',{page:{curr:p}});
}
var w;
function toDrawMoney(){
	if(isSetPayPwd==0){
		WST.msg('请先设置店铺支付密码',{icon:2,time:1000},function(){
			location.href = WST.U('shop/users/security');
		});
		return;
	}
    var tips = WST.load({msg:'正在获取数据，请稍后...'});
	$.post(WST.U('shop/cashdraws/toEditByShop'),{},function(data,textStatus){
		layer.close(tips);
		w = WST.open({
		    type: 1,
		    title:"申请提现",
		    shade: [0.6, '#000'],
		    border: [0],
		    content: data,
		    area: ['550px', '450px'],
		    offset: '100px'
		});
	});
}
function drawMoney(){
	$('#drawForm').isValid(function(v){
		if(v){
			var params = WST.getParams('.j-ipt');
			if(params.accType==1 && $.trim(params.accUser)==''){
                WST.msg('请输入真实姓名',{icon:2,time:3000});
                return;
			}
		    if(window.conf.IS_CRYPT=='1'){
		        var public_key=$('#token').val();
		        var exponent="10001";
		   	    var rsa = new RSAKey();
		        rsa.setPublic(public_key, exponent);
		        params.payPwd = rsa.encrypt(params.payPwd);
		    }
			var tips = WST.load({msg:'正在提交数据，请稍后...'});
			$.post(WST.U('shop/cashdraws/drawMoneyByShop'),params,function(data,textStatus){
				layer.close(tips);
			    var json = WST.toJson(data);
			    if(json.status==1){
		            WST.msg(json.msg,{icon:1},function(){
                        loadGrid(WST_CURR_PAGE);
		            	getShopMoney();
		            	layer.close(w);
		            });
			    }else{
			    	WST.msg(json.msg,{icon:2,time:3000});
			    }
			});
		}
	});
}
function layerclose(){
  layer.close(w);
}

function changeDrawMoney(obj){
	WST.isChinese(this,1);
	var commission = $('#commission').val();
	var totalMoney = $(obj).val()?$(obj).val():0;
	totalMoney = parseFloat(totalMoney);
	if(!totalMoney){
		$("#chargeService").html("0");
		$("#actualMoney").html("0");
		return;
	}
	var money = 0;
	if(commission!=undefined){
		money = (parseFloat(totalMoney)*parseFloat(commission)*0.01).toFixed(2);
	}
	$("#chargeService").html(money);
	$("#actualMoney").html((parseFloat(totalMoney-money)).toFixed(2));
}

function changeAccType(v){
	$('.accType').hide();
    $('.accType'+v).show()
}
