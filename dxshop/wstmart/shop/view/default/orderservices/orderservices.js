// 列表

function queryByPage(p){
    var params = {};
	params = WST.getParams('.s-ipt');
	params.key = $.trim($('#key').val());
	params.page = p;


    // 订单编号,售后商品,售后类型,状态,操作

	mmg = layui.table;
	mmg.render({elem: '#mmg', id:'dataTable',url:WST.U('shop/orderservices/pageQuery', params), cellMinWidth: 80, height: WST.initGridHeight(), skin: 'line', even: true, limit:20, page:{curr:p},
		cols: [[
			{title:'#',type:'numbers'},
			{title:'订单编号', field:'orderNo' ,width:120,templet: function(item){
					return item['orderNo'];
			}},
			{title:'售后商品', field:'gImgs' ,templet: function(item){
                var imgCode = item.gImgs.map(function(imgSrc){
                    return "<img style='height:50px;width:50px;' src="+WST.conf.RESOURCE_PATH+"/"+imgSrc+" class=''>"
                });
                imgCode = imgCode.join('')

				return imgCode;
			}},
            {title:'申请人', field:'loginName' ,width:170},
            {title:'申请时间', field:'createTime' ,width:160},
			{title:'售后类型', width:100, field:'complainContent' ,templet: function(item){
				var type = "";
                switch(item.goodsServiceType){
                    case 0:
                        type = "退货退款";
                    break;
                    case 1:
                        type = "仅退款";
                    break;
                    case 2:
                        type = "仅换货";
                    break;
                }
                return type;
			}},
            {title:'申请原因', field:'serviceTypeText' ,width:200},
			{title:'状态', field:'statusText' ,width:120},
			{title:'操作',field:'',fixed: 'right',width:150,templet: function(item){
				var h = "";
				h += "<a  class='btn btn-blue' onclick='javascript:toView("+item['id']+")'><i class='fa fa-search'></i>查看</a> ";
				return h;
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
function toView(id){
    location.href=WST.U('shop/orderservices/deal','id='+id+'&p='+WST_CURR_PAGE);
}

function loadGrid(p){
    p = (p<=1)?1:p;

    var params = {};
	params = WST.getParams('.s-ipt');
	params.key = $.trim($('#key').val());
	mmg.reload('dataTable',{
        page:{curr:p},
        where:params
    });
}

// 处理退换货
function isArgee(val){
    $('#isShopAgree').val(val);
    if(val==1){
        $('#j-agree-box').show();
        $('#j-disagree-box').hide();
    }else{
        $('#j-agree-box').hide();
        $('#j-disagree-box').show();
    }
}
function beforeCommit(){
    var isShopAgree = parseInt($('#isShopAgree').val());
    if(isShopAgree!==0 && isShopAgree!==1){
        return WST.msg('请选择是否受理');
    }
    var _type = $('#goodsServiceType').val();
    if(_type==0 || _type==2){
        // 商家同意
        commit();
    }else{
        // 退款
        refund();
    }
}
// 退款
function refund(){
    var postData = {
        id:$('#id').val(),
        isShopAgree:$('#isShopAgree').val()
    }
    console.log('postData', postData);
    if(postData.isShopAgree!=0 && postData.isShopAgree!=1){
        return WST.msg('请选择是否受理');
    }
    if(postData.isShopAgree==0){
        // 不受理
        var disagreeRemark =  $('#disagreeRemark').val();
        if(disagreeRemark.length==0){
            return WST.msg('请输入不受理原因');
        }
        postData.disagreeRemark = disagreeRemark;
    }
    $.post(WST.U("shop/orderservices/dealRefund"),postData,function(res){
        var json = WST.toJson(res);
        WST.msg(json.msg);
        if(json.status==1){
            return goBack();
        }
    });
}


// 提交换货
function commit(){
    var postData = {
        id:$('#id').val(),
        isShopAgree:$('#isShopAgree').val()
    }
    if(postData.isShopAgree!=0 && postData.isShopAgree!=1){
        return WST.msg('请选择是否受理');
    }
    if(postData.isShopAgree==1){
        // 受理
        var shopAddress =  $('#shopAddress').val();
        var shopName =  $('#shopName').val();
        var shopPhone =  $('#shopPhone').val();
        if(shopAddress.length==0){
            return WST.msg('商家收货地址不能为空');
        }
        if(shopName.length==0){
            return WST.msg('商家收货人不能为空');
        }
        if(shopPhone.length==0){
            return WST.msg('商家联系人不能为空');
        }
        postData.shopAddress = shopAddress;
        postData.shopName = shopName;
        postData.shopPhone = shopPhone;
    }
    if(postData.isShopAgree==0){
        // 不受理
        var disagreeRemark =  $('#disagreeRemark').val();
        if(disagreeRemark.length==0){
            return WST.msg('请输入不受理原因');
        }
        postData.disagreeRemark = disagreeRemark;
    }

    $.post(WST.U("shop/orderservices/dealApply"),postData,function(res){
        var json = WST.toJson(res);
        WST.msg(json.msg);
        if(json.status==1){
            return goBack();
        }
    });
}
// 确认收货
function receive(p){
    var postData = {
        id:$('#id').val(),
        isShopAccept:$('#isShopAccept').val(),
        shopRejectType:$('#shopRejectType').val(),
        shopRejectOther:$('#shopRejectOther').val()
    }
    if(postData.shopRejectType=='10000' && postData.shopRejectOther.length==0){
        return WST.msg('请输入拒收原因');
    }
    $.post(WST.U('shop/orderservices/shopReceive'),postData,function(res){
        var json = WST.toJson(res);
        WST.msg(json.msg);
        if(json.status==1){
            return goBack();
        }
    })
}
// 是否确认收货
function isShopAccept(val){
    $('#isShopAccept').val(val);
    if(val==-1){
        $('#j-receive-box').show();
    }else{
        $('#j-receive-box').hide();
    }
}
// 选择拒收类型
function changeRejectType(val){
    if(val==10000){
        // 显示"原因输入框"
        $('#j-receive-input-box').show();
    }else{
        $('#j-receive-input-box').hide();
    }
}



// 商家发货相关

// 选择物流方式
function shopExpressType(val){
    $('#shopExpressType').val(val);
    if(val==1){
        $('.j-express-box').show();
    }else{
        $('.j-express-box').hide();
    }
}

// 发货
function send(p){
    var postData = WST.getParams('.ex-ipt');
    postData.id = $('#id').val();
    if(postData.shopExpressType==1){
        if(postData.shopExpressId==0)return WST.msg('请选择物流公司');
        if(postData.shopExpressNo.length==0)return WST.msg('请输入物流单号');
    }
    $.post(WST.U('shop/orderservices/shopSend'),postData,function(res){
        var json = WST.toJson(res);
        WST.msg(json.msg);
        if(json.status==1){
            return goBack(p);
        }
    });
}


function goBack(){
    history.go(-1);
    // location.href =
}
