function submitOrder(){
	var params = WST.getParams('.j-ipt');
	params.isUseScore = $('#isUseScore').prop('checked')?1:0
	var load = WST.load({msg:'正在提交，请稍后...'});
	$.post(WST.U('home/orders/quickSubmit'),params,function(data,textStatus){
		layer.close(load);
		var json = WST.toJson(data);
	    if(json.status==1){
	    	 WST.msg(json.msg,{icon:1},function(){
	    		 location.href=WST.U('home/orders/succeed','pkey='+json.pkey);
	    	 });
	    }else{
	    	WST.msg(json.msg,{icon:2});
	    }
	});
}

function inEffect(obj,n){
	$(obj).addClass('j-selected').siblings('.wst-frame'+n).removeClass('j-selected');
}
function changeSelected(n,index,obj){
	$('#'+index).val(n);
	inEffect(obj,2);
}
function getCartMoney(){
	var params = {};
	params.isUseScore = $('#isUseScore').prop('checked')?1:0;
	params.useScore = $('#useScore').val();
	params.rnd = Math.random();
	params.deliverType = 1;
	var couponIds = [];
	$('.j-shop').each(function(){
		couponIds.push($(this).attr('dataval')+":"+$('#couponId_'+$(this).attr('dataval')).val());
	});
	params.couponIds = couponIds.join(',');
	var load = WST.load({msg:'正在计算订单价格，请稍后...'});
	$.post(WST.U('home/carts/getQuickCartMoney'),params,function(data,textStatus){
		layer.close(load);
		var json = WST.toJson(data);
		if(json.status==1){
		    json = json.data;
		    for(var key in json.shops){
		    	$('#shopC_'+key).html(json.shops[key]['goodsMoney']);
		    }
		    $('#maxScoreSpan').html(json.maxScore);
		    $('#maxScoreMoneySpan').html(json.maxScoreMoney);
		    $('#isUseScore').attr('dataval',json.maxScore);
		    $('#useScore').val(json.useScore);
		    $('#orderScore').html(json.orderScore);
		    $('#scoreMoney2').html(json.scoreMoney);
		 	$('#totalMoney').html(json.realTotalMoney);
		}
	});
}
function checkScoreBox(v){
    if(v){
    	var val = $('#isUseScore').attr('dataval');
    	$('#useScore').val(val);
        $('#scoreMoney').show();
    }else{
    	$('#scoreMoney').hide();
    }
    getCartMoney();
}


var invoicebox;
function changeInvoice(t,str,obj){
	var param = {};
	param.isInvoice = $('#isInvoice').val();
	param.invoiceId = $('#invoiceId').val();
	var loading = WST.load({msg:'正在请求数据，请稍后...'});
	$.post(WST.U('home/invoices/index'),param,function(data){
		layer.close(loading);
		// layer弹出层
		invoicebox =	layer.open({
			title:'发票信息',
			type: 1,
			area: ['628px', ''], //宽高
			content: data,
			success :function(){
				var invType = parseInt($('#invoiceType').val());
				var invoiceType = (invType == -1)?0:invType;
				$('.inv_type_ul .inv_li1').each(function(idx,item){
					if(parseInt($(item).attr('invType'))==invoiceType){
						$(item).addClass('inv_li_curr');
					}else{
						$(item).removeClass('inv_li_curr');
					}
				});
				$('.inv_li2:nth-child(2)').addClass('inv_li_curr').siblings().removeClass('inv_li_curr');
				$('#isInvoice').val(1);
				var invoiceNum = 0;
				$('.inv_ul li').each(function(idx,item){
					if(parseInt($(item).attr('type'))==invoiceType){
						$(item).show();
						invoiceNum++;
					}else{
						$(item).hide();
					}
				});
				if(invoiceType==0 && invoiceNum==1){
					$('#noNormalInvoice').show();
				}
				if(invoiceType==1 && invoiceNum==0){
					$('#noSpecialInvoice').show();
				}
				if(param.invoiceId>0){
					$('.inv_codebox').show();
					$('#invoice_num').val($('#invoiceCode_'+param.invoiceId).val());
					if(invoiceType==1){
						$('#invoice_addr').val($('#invoiceAddr_'+param.invoiceId).val());
						$('#invoice_phone_number').val($('#invoicePhoneNumber_'+param.invoiceId).val());
						$('#invoice_bank_name').val($('#invoiceBankName_'+param.invoiceId).val());
						$('#invoice_bank_no').val($('#invoiceBankNo_'+param.invoiceId).val());
						$('.inv_codebox2').css({display:'block'});
					}else{
						$('.inv_codebox2').css({display:'none'});
					}
				}
			}
		});
	});
}
function layerclose(){
  layer.close(invoicebox);
}


function changeInvoiceType(t,obj){
	$(obj).addClass('inv_li_curr').siblings().removeClass('inv_li_curr');
	var invoiceNum = 0;
	$('.inv_ul li').each(function(idx,item){
		if(parseInt($(item).attr('type'))==t){
			$(item).show();
			invoiceNum++;
		}else{
			$(item).hide();
		}
	});
	if(t==0 && invoiceNum==1){
		$('#noNormalInvoice').show();
	}
	if(t==1 && invoiceNum==0){
		$('#noSpecialInvoice').show();
	}
	if(t==1){
		$('.inv_ul li').each(function(idx,item){
			if(parseInt($(item).attr('isPerson'))==1){
				$(item).removeClass('inv_li_curr');
			}
		});
	}
	$('.inv_codebox').css({display:'none'});
	$('.inv_codebox2').css({display:'none'});
}

function changeInvoiceItem(t,obj){
	$(obj).addClass('inv_li_curr').siblings().removeClass('inv_li_curr');
	$('#invoiceType').val($(obj).attr('type'));
	$('.inv_editing').remove();// 删除正在编辑中的发票信息
	$('.inv_add').show();
	$('#invoiceId').val(t);
	var invoiceType = $('#invoiceType').val();
	if(t==0){
		// 为个人时，隐藏识别号
		$('.inv_codebox').css({display:'none'});
		$('.inv_codebox2').css({display:'none'});
		$('#invoice_num').val(' ');
		$('#invoice_addr').val(' ');
		$('#invoice_phone_number').val(' ');
		$('#invoice_bank_name').val(' ');
		$('#invoice_bank_no').val(' ');
	}else{
		$('#invoice_num').val($('#invoiceCode_'+t).val());
		$('.inv_codebox').css({display:'block'});
		if(invoiceType==1){
			$('#invoice_addr').val($('#invoiceAddr_'+t).val());
			$('#invoice_phone_number').val($('#invoicePhoneNumber_'+t).val());
			$('#invoice_bank_name').val($('#invoiceBankName_'+t).val());
			$('#invoice_bank_no').val($('#invoiceBankNo_'+t).val());
			$('.inv_codebox2').css({display:'block'});
		}else{
			$('.inv_codebox2').css({display:'none'});
		}
	}
	$("#invoice_obj").val(t);
}
// 是否需要开发票
function changeInvoiceItem1(t,obj){
	$(obj).addClass('inv_li_curr').siblings().removeClass('inv_li_curr');
	$('#isInvoice').val(t);
}


// 设置页面显示值
function setInvoiceText(invoiceHead){
	var isInvoice  = $('#isInvoice').val();
	var invoiceObj = $('#invoice_obj').val();// 发票对象
	var invType = parseInt($('#invoiceType').val());
	var text = '不开发票';
	var invoiceClient = '';
	if(isInvoice==1){
		text = (invoiceObj==0)?'普通发票  个人   明细':((invType==0)?'普通发票 ':'专用发票 ')+invoiceHead+' 明细';
		invoiceClient = (invoiceObj==0)?'个人':invoiceHead;
	}
	$('#invoice_info').html(text);
	$('#invoiceClient').val(invoiceClient);
	layerclose();
}


// 保存纳税人识别号
function saveInvoice(){
	var isInv = $('#isInvoice').val();
	var id = $('#invoiceId').val();
	var invoiceHead = $('#invoiceHead_'+id).html();// 发票抬头
	var isPerson = 0;
	$('.inv_ul li').each(function(idx,item){
		if(parseInt($(item).attr('isPerson'))==1 && $(item).hasClass('inv_li_curr')){
			isPerson = 1;
		}
	});
	if(isInv==1 && isPerson==0 && invoiceHead==undefined){
		WST.msg('请选择发票',{icon:2});
		return;
	}
	setInvoiceText(invoiceHead);
}

