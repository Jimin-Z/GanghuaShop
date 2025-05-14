/**删除批量上传的图片**/
var WSTHook_beforeEditGoods = [];
var mmg;
var form;
$(function(){
	form = layui.form;
	form.on('radio(isFreeShipping)', function(data){
	  if($(this).val()==1){
	  	$("#shippingFeeTypeTr").hide();
	  	$("#shopExpressTr").hide();
	  }else{
	  	$("#shippingFeeTypeTr").show();
	  	$("#shopExpressTr").show();
	  }
	});
});
function delBatchUploadImg(obj,fn){
	var c = WST.confirm({content:'您确定要删除商品图片吗?',yes:function(){
		$(obj).parent().remove("li");
		layer.close(c);
		fn();
	}});
}
function lastGoodsCatCallback(opts){
	if(opts.isLast && opts.val){
	    getSpecAttrs(opts.val);
	}else{
		$('#specBtns').hide();
		$('#specsAttrBox').empty();
		$("#selMouldBox").hide();
	}
}
/**初始化**/
function initEdit(){
	$('#tab').TabPanel({tab:0,callback:function(no){
		if(no==1){
			$('.j-specImg').children().each(function(){
				if(!$(this).hasClass('webuploader-pick'))$(this).css({width:'80px',height:'25px'});
			});
		}
		if(!initBatchUpload && no==2){
			initBatchUpload = true;
			var uploader = batchUpload({uploadPicker:'#batchUpload',uploadServer:WST.U('shop/index/uploadPic'),formData:{dir:'goods',isWatermark:1,isThumb:1},uploadSuccess:function(file,response){
				var json = WST.toJson(response);
				if(json.status==1){
					$li = $('#'+file.id);
					$li.append('<input type="hidden" class="j-gallery-img" iv="'+json.savePath + json.thumb+'" v="' +json.savePath + json.name+'"/>');
					//$li.append('<span class="btn-setDefault">默认</span>' );
	                var delBtn = $('<span class="btn-del">删除</span>');
	                $li.append(delBtn);
	                delBtn.on('click',function(){
	                	delBatchUploadImg($(this),function(){
	                		if($('.filelist').find('li').length==0){
	                			$("#batchUpload").find('.placeholder').removeClass( 'element-invisible' );
						        $('.filelist').parent().removeClass('filled');
						        $('.filelist').hide();
						        $("#batchUpload").find('.statusBar').addClass( 'element-invisible' );
	                		}
	                		uploader.removeFile(file);
	        				uploader.refresh();
	                	});
	    			});
	                $('.filelist li').css('border','1px solid rgb(59, 114, 165)');
				}else{
					WST.msg(json.msg,{icon:2});
				}
			}});
		}
		$('.btn-del').click(function(){
			delBatchUploadImg($(this),function(){
				if($('.filelist').find('li').length==0){
        			$("#batchUpload").find('.placeholder').removeClass( 'element-invisible' );
			        $('.filelist').parent().removeClass('filled');
			        $('.filelist').hide();
			        $("#batchUpload").find('.statusBar').addClass( 'element-invisible' );
			        uploader.refresh();
        		}
        		$(this).parent().remove();
        	});
		})
	}});
	WST.upload({
	  	  pick:'#goodsImgPicker',
	  	  formData: {dir:'goods',isWatermark:1,isThumb:1},
	  	  accept: {extensions: 'gif,jpg,jpeg,png',mimeTypes: 'image/jpg,image/jpeg,image/png,image/gif'},
	  	  callback:function(f){
	  		  var json = WST.toJson(f);
	  		  if(json.status==1){
	  			  $('#uploadMsg').empty().hide();
	              $('#preview').attr('src',WST.conf.RESOURCE_PATH+"/"+json.savePath+json.thumb);
	              $('#goodsImg').val(json.savePath+json.name);
	              $('#msg_goodsImg').hide();
	  		  }
		  },
		  progress:function(rate){
		      $('#uploadMsg').show().html('已上传'+rate+"%");
		  }
	});
	WST.upload({
	  	  pick:'#goodsVideoPicker',
	  	  formData: {dir:'goods'},
	  	  server:WST.U('shop/index/uploadVideo'),
	  	  accept: {extensions: '3gp,mp4,rmvb,mov,avi,m4v',mimeTypes: 'video/*,audio/*,application/*'},
	  	  callback:function(f){
	  		  var json = WST.toJson(f);
	  		  if(json.status==1){
	  			  $('#uploadVideoMsg').empty().hide();
	  			  $('#goodsVideoPlayer').attr('src',WST.conf.RESOURCE_PATH+"/"+json.savePath+json.name);
	              $('#goodsVideo').val(json.savePath+json.name);
	              $('.vedio-del').css('display','inline-block');
	              $('#msg_goodsVideo').hide();
	  		  }
		  },
		  progress:function(rate){
		      $('#uploadVideoMsg').show().html('已上传'+rate+"%");
		  }
	});
	KindEditor.ready(function(K) {
		editor1 = K.create('textarea[name="goodsDesc"]', {
		  height:'350px',
		  width:'800px',
		  uploadJson : WST.conf.ROOT+'/shop/goods/editorUpload',
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
	if(OBJ.goodsId>0){
		var goodsCatIds = OBJ.goodsCatIdPath.split('_');
		getBrands('brandId',goodsCatIds[0],OBJ.brandId);
		if(goodsCatIds.length>1){
			var objId = goodsCatIds[0];
			$('#cat_0').val(objId);
			var opts = {id:'cat_0',val:goodsCatIds[0],childIds:goodsCatIds,isRequire:true,className:'j-goodsCats',afterFunc:'lastGoodsCatCallback'}
        	WST.ITSetGoodsCats(opts);
	    }
		getShopsCats('shopCatId2',OBJ.shopCatId1,OBJ.shopCatId2);
	}
}
function clearVedio(obj){
	$(obj).hide();
	$('#goodsVideoPlayer').attr('src','');
	$('#goodsVideo').val('');
}
/**获取本店分类**/
function getShopsCats(objId,pVal,objVal){
	$('#'+objId).empty();
	$.post(WST.U('shop/shopcats/listQuery'),{parentId:pVal},function(data,textStatus){
	     var json = WST.toJson(data);
	     var html = [],cat;
	     html.push("<option value='' >-请选择-</option>");
	     if(json.status==1 && json.list){
	    	 json = json.list;
			 for(var i=0;i<json.length;i++){
			     cat = json[i];
			     html.push("<option value='"+cat.catId+"' "+((objVal==cat.catId)?"selected":"")+">"+cat.catName+"</option>");
			 }
	     }
	     $('#'+objId).html(html.join(''));
	});
}
/**获取品牌**/
function getBrands(objId,catId,objVal){
	$('#'+objId).empty();
	$.post(WST.U('shop/brands/listQuery'),{catId:catId},function(data,textStatus){
	     var json = WST.toJson(data);
	     var html = [],cat;
	     html.push("<option value='' >-请选择-</option>");
	     if(json.status==1 && json.list){
	    	 json = json.list;
			 for(var i=0;i<json.length;i++){
			     cat = json[i];
			     html.push("<option value='"+cat.brandId+"' "+((objVal==cat.brandId)?"selected":"")+">"+cat.brandName+"</option>");
			 }
	     }
	     $('#'+objId).html(html.join(''));
	});
}
function toEdit(id,src){
	location.href = WST.U('shop/goods/edit','id='+id+'&src='+src+'&p='+WST_CURR_PAGE);
}
function toAdd(src){
    location.href = WST.U('shop/goods/add','src='+src);
}
/**保存商品数据**/
function save(p){
	var va = $("input[name='defaultSpec']:checked").val();
	if(va){
		$("#marketPrice").val($("#marketPrice_"+va).val());
		$("#shopPrice").val( $("#specPrice_"+va).val());
		$("#costPrice").val( $("#costPrice_"+va).val());
		$("#goodsWeight").val( $("#specWeight_"+va).val());
		$("#goodsVolume").val( $("#specVolume_"+va).val());
	}
	$('#editform').isValid(function(v){
		if(v){
			var params = WST.getParams('.j-ipt');
			params.goodsCatId = WST.ITGetGoodsCatVal('j-goodsCats');
			params.specNum = specNum;
			var specsName,specImg;
			$('.j-speccat').each(function(){
				specsName = 'specName_'+$(this).attr('cat')+'_'+$(this).attr('num');
				specImg = 'specImg_'+$(this).attr('cat')+'_'+$(this).attr('num');
				if($(this)[0].checked){
					params[specsName] = $.trim($('#'+specsName).val());
					params[specImg] = $.trim($('#'+specImg).attr('v'));
				}
			});
			var gallery = [];
			$('.j-gallery-img').each(function(){
				gallery.push($(this).attr('v'));
			});
			params.gallery = gallery.join(',');
			var specsIds = [];
			var specidsmap = [];
			$('.j-ws').each(function(){
				specsIds.push($(this).attr('v'));
				specidsmap.push(WST.blank($(this).attr('sid'))+":"+$(this).attr('v'));
			});
			var specmap = [];
			for(var key in id2SepcNumConverter){
				specmap.push(key+":"+id2SepcNumConverter[key]);
			}
			params.specsIds = specsIds.join(',');
			params.specidsmap = specidsmap.join(',');
			params.specmap = specmap.join(',');
			if(WSTHook_beforeEditGoods.length>0){
				for(var i=0;i<WSTHook_beforeEditGoods.length;i++){
					delete window['callback_'+WSTHook_beforeEditGoods[i]];
					params = window[WSTHook_beforeEditGoods[i]](params);
					if(window['callback_'+WSTHook_beforeEditGoods[i]]){
						window['callback_'+WSTHook_beforeEditGoods[i]]();
						return;
					}
				}
			}
			var memberGroupId = [];
			var memberReduceMoney = [];
			$('.member-group-id').each(function(idx,item){
				memberGroupId.push($(item).val());
			});
			$('.member-reduce-money').each(function(idx,item){
				memberReduceMoney.push($(item).val());
			});
			params.memberGroupId = memberGroupId.join(',');
			params.memberReduceMoney = memberReduceMoney.join(',');
			var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
		    $.post(WST.U('shop/goods/'+((params.goodsId==0)?"toAdd":"toEdit")),params,function(data,textStatus){
		    	layer.close(loading);
		    	var json = WST.toJson(data);
		    	if(json.status=='1'){
		    		WST.msg(json.msg,{icon:1},function(){
						if($('#WSTReferer').val().indexOf('sale')==-1 && $('#WSTReferer').val().indexOf('audit')==-1 && $('#WSTReferer').val().indexOf('store')==-1){
                                location.reload();
							}else{
								WST.backPrePage();
							}
					});
		    	}else{
		    		WST.msg(json.msg,{icon:2});
		    	}
		    });
		}
	});
}
var id2SepcNumConverter = {};
/**添加普通规格值**/
function addSpec(opts){
	var html = [];
	html.push('<div class="spec-item">',
	          '<input type="checkbox" class="j-speccat j-speccat_'+opts.catId+' j-spec_'+opts.catId+'_'+specNum+'" cat="'+opts.catId+'" num="'+specNum+'" onclick="javascript:addSpecSaleCol()" '+opts.checked+'/>',
	          '<input type="text" class="spec-ipt" id="specName_'+opts.catId+'_'+specNum+'" maxLength="50" value="'+WST.blank(opts.val)+'" onblur="batchChangeTxt(this.value,'+opts.catId+','+specNum+')"/>',
	          '<span class="item-del" onclick="delSpec(this,'+opts.catId+','+specNum+')"></span>',
	          '</div>');
	$(html.join('')).insertBefore('#specAddBtn_'+opts.catId);
	if(opts.itemId){
		id2SepcNumConverter[opts.itemId] = opts.catId+'_'+specNum;
	}

	specNum++;
}
/**删除普通规格值**/
function delSpec(obj,catId,num){
	if($('.j-spec_'+catId+'_'+num)[0].checked){
		$('.j-spec_'+catId+'_'+num)[0].checked = false;
		addSpecSaleCol();
	}
	$(obj).parent().remove();
}
/**添加带图片的规格值**/
function addSpecImg(opts){
	var html = [];
	html.push('<tr>',
			    '<td>',
	            '<input type="checkbox" class="j-speccat j-speccat_'+opts.catId+' j-spec_'+opts.catId+'_'+specNum+'" cat="'+opts.catId+'" num="'+specNum+'" onclick="javascript:addSpecSaleCol()" '+opts.checked+'/>',
                '<input type="text" id="specName_'+opts.catId+'_'+specNum+'" maxLength="50" value="'+WST.blank(opts.val)+'" onblur="batchChangeTxt(this.value,'+opts.catId+','+specNum+')"/>',
                '</td>',
	            '<td id="uploadMsg_'+opts.catId+'_'+specNum+'">',
	            (opts.specImg)?'<img height="25"  width="25" id="specImg_'+opts.catId+'_'+specNum+'" src="'+WST.conf.RESOURCE_PATH+"/"+opts.itemImgThumb+'" v="'+opts.specImg+'"/><span class="item-del" onclick="clearSpecImg(this,'+specNum+')"></span>':"",
	            '</td><td style="padding-left:5px;"><div id="specImgPicker_'+specNum+'" class="j-specImg">上传图片</div></td>'
	         );
	if($('#specTby').children().size()==0){
    	html.push('<td style="padding-left:5px;"><button type="button" class="btn btn-success" id="specImgBtn" onclick="addSpecImg({catId:'+opts.catId+',checked:\'\'})"><i class="fa fa-plus"></i>新增</button></td>');
    }else{
    	html.push('<td style="padding-left:5px;"><button type="button" class="btn btn-primary" id="specImgBtn" onclick="delSpecImg(this,'+opts.catId+','+specNum+')"><i class="fa fa-trash-o"></i>删除</button></td>');
    }
    html.push('</tr>');
	$('#specTby').append(html.join(''));
	WST.upload({
		  num:specNum,
		  cat:opts.catId,
	  	  pick:'#specImgPicker_'+specNum,
	  	  formData: {dir:'goods',isThumb:1},
	  	  accept: {extensions: 'gif,jpg,jpeg,png',mimeTypes: 'image/jpg,image/jpeg,image/png,image/gif'},
	  	  callback:function(f){
	  		  var json = WST.toJson(f);
	  		  if(json.status==1){
	  			$('#uploadMsg_'+this.cat+"_"+this.num).html('<img id="specImg_'+this.cat+"_"+this.num+'" v="'+json.savePath+json.name+'" src="'+WST.conf.RESOURCE_PATH+"/"+json.savePath+json.thumb+'" height="25"  width="25"/><span class="item-del" onclick="clearSpecImg(this,'+this.num+')"></span>');
	  		  }
		  },
		  progress:function(rate){
		      $('#uploadMsg_'+this.cat+"_"+this.num).html('已上传'+rate+"%");
		  }
	});
	if(opts.itemId){
		id2SepcNumConverter[opts.itemId] = opts.catId+'_'+specNum;
	}
	specNum++;
}
/**删除带图片的规格值**/
function delSpecImg(obj,catId,num){
	if($('.j-spec_'+catId+'_'+num)[0].checked){
		$('.j-spec_'+catId+'_'+num)[0].checked = false;
		addSpecSaleCol();
	}
	$(obj).parent().parent().remove();
}
function clearSpecImg(obj,num){
	$(obj).parent().empty();
}
/**给销售规格表填上值**/
function fillSepcSale(){
	var ids = '',tmpids = [];
	for(var i=0;i<OBJ.saleSpec.length;i++){
		tmpids = [];
		ids = OBJ.saleSpec[i].specIds;
		ids = ids.split(':');
		for(var j=0;j<ids.length;j++){
			tmpids.push(id2SepcNumConverter[ids[j]]);
		}
		tmpids = tmpids.join('-');
		if(OBJ.saleSpec[i].isDefault)$('#isDefault_'+tmpids).attr('checked',true);
		$('#productNo_'+tmpids).val(OBJ.saleSpec[i].productNo);
		$('#marketPrice_'+tmpids).val(OBJ.saleSpec[i].marketPrice);
		$('#specWeight_'+tmpids).val(OBJ.saleSpec[i].specWeight);
		$('#specVolume_'+tmpids).val(OBJ.saleSpec[i].specVolume);
		$('#specPrice_'+tmpids).val(OBJ.saleSpec[i].specPrice);
		$('#costPrice_'+tmpids).val(OBJ.saleSpec[i].costPrice);
		$('#specStock_'+tmpids).val(OBJ.saleSpec[i].specStock);
		$('#warnStock_'+tmpids).val(OBJ.saleSpec[i].warnStock);
		$('#saleNum_'+tmpids).html(OBJ.saleSpec[i].saleNum);
		$('#saleNum_'+tmpids).attr('sid',OBJ.saleSpec[i].id);
	}
	fillProductNo();
}
function fillProductNo(){
	var maxNo = 0,tmpStr = '',tmpNo = 0;
	$('.spec-sale-goodsNo').each(function(){
        tmpStr = $(this).val();
        if(tmpStr!=''){
        	tmpStr = tmpStr.split('-');
        	tmpNo = parseInt(tmpStr[1],10);
        	if(tmpNo>maxNo)maxNo = tmpNo;
        }
	});
	$('.spec-sale-goodsNo').each(function(){
		if($(this).val()==''){
			$(this).val($('#productNo').val()+'-'+(++maxNo));
		}
	});
}
/**生成销售规格表**/
function addSpecSaleCol(){
	//获取规格分类和规格值
	var catId,snum,specCols = {},obj = [];
	$('.j-speccat').each(function(){
		if($(this)[0].checked){
			catId = $(this).attr('cat');
			snum = $(this).attr('num');
			if(!specCols[catId]){
				specCols[catId] = [];
				specCols[catId].push({id:catId+"_"+snum,val:$.trim($('#specName_'+catId+"_"+snum).val())});
			}else{
				specCols[catId].push({id:catId+"_"+snum,val:$.trim($('#specName_'+catId+"_"+snum).val())});
			}
	    }
	});
	//创建表头
	$('.j-saleTd').remove();
	var html = [],specArray = [];;
	for(var key in specCols){
		html.push('<th class="j-saleTd">'+$('#specCat_'+key).html()+'</th>');
		specArray.push(specCols[key]);
	}
	if(html.length==0){
        $('#goodsStock').removeAttr('disabled');
		$('#shopPrice').removeAttr('disabled');
		$('#marketPrice').removeAttr('disabled');
		$('#warnStock').removeAttr('disabled');
		return;
	}
	$(html.join('')).insertBefore('#thCol');
	//组合规格值
	this.combined = function(doubleArrays){
        var len = doubleArrays.length;
        if (len >= 2) {
            var arr1 = doubleArrays[0];
            var arr2 = doubleArrays[1];
            var len1 = doubleArrays[0].length;
            var len2 = doubleArrays[1].length;
            var newlen = len1 * len2;
            var temp = new Array(newlen),ntemp;
            var index = 0;
            for (var i = 0; i < len1; i++) {
            	if(arr1[i].length){
            		for (var k = 0; k < len2; k++) {
            			ntemp = arr1[i].slice();
            			ntemp.push(arr2[k]);
		                temp[index] = ntemp;
		                index++;
            		}
            	}else{
	                for (var j = 0; j < len2; j++) {
	                    temp[index] = [arr1[i],arr2[j]];
	                    index++;
	                }
            	}
            }
            var newArray = new Array(len - 1);
            newArray[0] = temp;
            if (len > 2) {
                var _count = 1;
                for (var i = 2; i < len; i++) {
                    newArray[_count] = doubleArrays[i];
                    _count++;
                }
            }
            return this.combined(newArray);
        }else {
            return doubleArrays[0];
        }
    }

	var specsRows = this.combined(specArray);
	//生成规格值表
	html = [];
	var id=[],key=1,specHtml = [];
	var productNo = $('#productNo').val(),specProductNo = '';
	for(var i=0;i<specsRows.length;i++){
		id = [],specHtml = [];
		html.push('<tr class="j-saleTd">');

		if(specsRows[i].length){
			for(var j=0;j<specsRows[i].length;j++){
				id.push(specsRows[i][j].id);
				specHtml.push('<td class="j-td_'+specsRows[i][j].id+'">' + specsRows[i][j].val + '</td>');
	        }
		}else{
			id.push(specsRows[i].id);
			specHtml.push('<td class="j-td_'+specsRows[i].id+'">' + specsRows[i].val + '</td>');
		}
		id = id.join('-');
		if(OBJ.goodsId==0){
			specProductNo = productNo+'-'+key;
		}
		html.push('  <td><input type="radio" id="isDefault_'+id+'" name="defaultSpec" class="j-ipt" value="'+id+'"/></td>');
		html.push(specHtml.join(''));
		html.push('  <td><input type="text" class="spec-sale-goodsNo j-ipt" id="productNo_'+id+'" value="'+specProductNo+'" onblur="checkProductNo(this)" ></td>',
	              '  <td><input type="text" class="spec-sale-ipt j-ipt" id="marketPrice_'+id+'" maxLength="9" onblur="WST.limitDecimal(this,2);javascript:WST.limitDecimal(this,2)" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)"></td>',
	              '  <td><input type="text" class="spec-sale-ipt j-ipt" id="specPrice_'+id+'" maxLength="9" onblur="WST.limitDecimal(this,2);javascript:WST.limitDecimal(this,2)" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)"></td>',
	              '  <td><input type="text" class="spec-sale-ipt j-ipt" id="costPrice_'+id+'" maxLength="9" onblur="WST.limitDecimal(this,2);javascript:WST.limitDecimal(this,2)" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)"></td>',
	              '  <td><input type="text" class="spec-sale-ipt j-ipt" id="specStock_'+id+'" onkeypress="return WST.isNumberKey(event)" onkeyup="javascript:WST.isChinese(this,1)"></td>',
	              '  <td><input type="text" class="spec-sale-ipt j-ipt" id="warnStock_'+id+'" onkeypress="return WST.isNumberKey(event)" onkeyup="javascript:WST.isChinese(this,1)"></td>',
	              '  <td><input type="text" class="spec-sale-ipt j-ipt" id="specWeight_'+id+'" onblur="WST.limitDecimal(this,2);javascript:WST.limitDecimal(this,2)" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)"></td>',
	              '  <td><input type="text" class="spec-sale-ipt j-ipt" id="specVolume_'+id+'" onblur="WST.limitDecimal(this,2);javascript:WST.limitDecimal(this,2)" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)"></td>',
	              '  <td class="j-ws" v="'+id+'" id="saleNum_'+id+'">0</td>',
	              '</tr>');
		key++;
	}
	$('#spec-sale-tby').append(html.join(''));
	//判断是否禁用商品价格和库存字段
	if($('#spec-sale-tby').html()!=''){
		$('#goodsStock').prop('disabled',true);
		$('#shopPrice').prop('disabled',true);
		$('#marketPrice').prop('disabled',true);
		$('#warnStock').prop('disabled',true);
		$('#goodsWeight').prop('disabled',true);
		$('#goodsVolume').prop('disabled',true);
	}
	//设置销售规格表值
	if(OBJ.saleSpec)fillSepcSale();
}
/**根据批量修改销售规格值**/
function batchChange(v,id){
	if($.trim(v)!=''){
		$('input[type=text][id^="'+id+'_"]').val(v);
	}
}
/**根据规格值修改 销售规格表 里的值**/
function batchChangeTxt(v,catId,num){
	$('.j-td_'+catId+"_"+num).each(function(){
		$(this).html(v);
	});
}
/**检测商品销售规格值是否重复**/
function checkProductNo(obj){
	v = $.trim(obj.value);
	var num = 0;
	$('input[type=text][id^="productNo_"]').each(function(){
		if(v==$.trim($(this).val()))num++;
	});
	if(num>1){
		WST.msg('已存在相同的货号',{icon:2});
		obj.value = '';
	}
}
/**获取商品规格和属性**/
function getSpecAttrs(goodsCatId){
	$('#specsAttrBox').empty();
	$('#specBtns').hide();
	specNum = 0;
	$.post(WST.U('shop/goods/getSpecAttrs'),{goodsCatId:goodsCatId,goodsType:$('#goodsType').val()},function(data,textStatus){
		var json = WST.toJson(data);
		if(json.status==1 && json.data){
			var html = [],tmp,str;
			if(json.data.spec0 || json.data.spec1 || json.data.attrs){
	    		getMouldList(goodsCatId);
			}
			if(json.data.spec0 || json.data.spec1){
				html.push('<div class="spec-head">商品规格</div>');
				html.push('<div class="spec-body">');
				if(json.data.spec0){
					tmp = json.data.spec0;
					html.push('<div id="specCat_'+tmp.catId+'">'+tmp.catName+'</div>');
					html.push('<table><tbody id="specTby"></tbody></table>');
				}
				if(json.data.spec1){
					for(var i=0;i<json.data.spec1.length;i++){
						tmp = json.data.spec1[i];
						html.push('<div class="spec-line"></div>',
						          '<div id="specCat_'+tmp.catId+'">'+tmp.catName+'</div>',
						          '<div style="height:auto;">',
						          '<button type="button" class="btn btn-success" id="specAddBtn_'+tmp.catId+'" onclick="javascript:addSpec({catId:'+tmp.catId+',checked:\'\'})"><i class="fa fa-plus"></i>新增</button>',
						          '<div style="clear:both;"></div></div>'
								);
					}
				}
				html.push('</div>');
				html.push($('#specTips').html());
				html.push('<div id="specSaleHead" class="spec-head">销售规格</div>',
				          '<table class="specs-sale-table">',
				          '  <thead id="spec-sale-hed">',
				          '   <tr>',
				          '     <th>推荐<br/>规格</th>',
				          '     <th id="thCol">货号<font color="red">*</font></th>',
				          '     <th>市场价<font color="red">*</font><br/><input type="text" class="spec-sale-ipt" onblur="WST.limitDecimal(this,2);batchChange(this.value,\'marketPrice\')" maxLength="9" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)"></th>',
				          '     <th>本店价<font color="red">*</font><br/><input type="text" class="spec-sale-ipt" onblur="WST.limitDecimal(this,2);batchChange(this.value,\'specPrice\')" maxLength="9" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)"></th>',
				          '     <th>成本价<font color="red">*</font><br/><input type="text" class="spec-sale-ipt" onblur="WST.limitDecimal(this,2);batchChange(this.value,\'costPrice\')" maxLength="9" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)"></th>',
				          '     <th>库存<font color="red">*</font><br/><input type="text" class="spec-sale-ipt" onblur="batchChange(this.value,\'specStock\')" onkeypress="return WST.isNumberKey(event)" onkeyup="javascript:WST.isChinese(this,1)"></th>',
				          '     <th>预警库存<font color="red">*</font><br/><input type="text" class="spec-sale-ipt" onblur="batchChange(this.value,\'warnStock\')" onkeypress="return WST.isNumberKey(event)" onkeyup="javascript:WST.isChinese(this,1)"></th>',
				          '     <th>商品重量(kg)<font color="red">*</font><br/><input type="text" class="spec-sale-ipt" onblur="batchChange(this.value,\'specWeight\')" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)"></th>',
				          '     <th>商品体积(m³)<font color="red">*</font><br/><input type="text" class="spec-sale-ipt" onblur="batchChange(this.value,\'specVolume\')" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)"></th>',
				          '     <th>销量</th>',
				          '   </tr>',
				          '  </thead>',
				          '  <tbody id="spec-sale-tby"></tbody></table>'
						);
			}
			if(json.data.attrs){
				html.push('<div class="spec-head">商品属性</div>');
				html.push('<div class="spec-body">');
				html.push('<table class="attr-table">');
				for(var i=0;i<json.data.attrs.length;i++){
					tmp = json.data.attrs[i];
					html.push('<tr><th width="120" nowrap valign="top" style="padding-top:6px;">'+tmp.attrName+'：</th><td>');
					if(tmp.attrType==1){
						str = tmp.attrVal.split(',');
						html.push('<div id="attrlable_'+tmp.attrId+'" class="labelattr '+((str.length>12)?"labelhide":"")+'">');
						for(var j=0;j<str.length;j++){
						    html.push('<label><input type="checkbox" class="j-ipt j-mould" name="attr_'+tmp.attrId+'" value="'+str[j]+'"/>'+str[j]+'</label>');
						}
						html.push('</div>');
					    if(str.length>12)html.push('<a id="attra_'+tmp.attrId+'" href="javascript:showHideAttr('+tmp.attrId+')" class="labela">更多</a>');
					}else if(tmp.attrType==2){
						html.push('<select name="attr_'+tmp.attrId+'" id="attr_'+tmp.attrId+'" class="j-ipt j-mould">');
						html.push('<option value="">请选择</option>');
						str = tmp.attrVal.split(',');
						for(var j=0;j<str.length;j++){
							html.push('<option value="'+str[j]+'">'+str[j]+'</option>');
						}
						html.push('</select>');
					}else{
						html.push('<input type="text" name="attr_'+tmp.attrId+'" id="attr_'+tmp.attrId+'" class="spec-sale-text j-ipt j-mould"/>');
					}
					html.push('</td></tr>');
				}
				html.push('</table>');
				html.push('</div>');
			}
			$('#specsAttrBox').html(html.join(''));

			//如果是编辑的话，第一次要设置之前设置的值
			if(OBJ.goodsId>0 && specNum==0){
				//设置规格值
				if(OBJ.spec0){
					for(var i=0;i<OBJ.spec0.length;i++){
					   if(OBJ.spec0[i].catId==json.data.spec0.catId)addSpecImg({catId:OBJ.spec0[i].catId,checked:'checked',val:OBJ.spec0[i].itemName,itemId:OBJ.spec0[i].itemId,specImg:OBJ.spec0[i].itemImg,itemImgThumb:OBJ.spec0[i].itemImgThumb});
					}
				}
				if(OBJ.spec1){
					for(var i=0;i<OBJ.spec1.length;i++){
						for(var j=0;j<json.data.spec1.length;++j){
							if(OBJ.spec1[i].catId==json.data.spec1[j].catId){
					    		addSpec({catId:OBJ.spec1[i].catId,checked:'checked',val:OBJ.spec1[i].itemName,itemId:OBJ.spec1[i].itemId});
								break;
							}
						}
					}
				}
				addSpecSaleCol();
				//设置商品属性值
				var tmp = null;
				if(OBJ.attrs.length){
					for(var i=0;i<OBJ.attrs.length;i++){
						if(OBJ.attrs[i].attrType==1){
							tmp = OBJ.attrs[i].attrVal.split(',');
							WST.setValue("attr_"+OBJ.attrs[i].attrId,tmp);
						}else{
						    WST.setValue("attr_"+OBJ.attrs[i].attrId,OBJ.attrs[i].attrVal);
						}
					}
				}

			}
			//给没有初始化的规格初始化一个输入框
			if(json.data.spec0 && !$('.j-speccat_'+json.data.spec0.catId)[0]){
				addSpecImg({catId:json.data.spec0.catId,checked:''});
			}
			if(json.data.spec1){
				for(var i=0;i<json.data.spec1.length;i++){
					if(!$('.j-speccat_'+json.data.spec1[i].catId)[0])addSpec({catId:json.data.spec1[i].catId,checked:''});
				}
			}
			$('#specBtns').show();
		}
	});
}
function showHideAttr(id){
   var obj = $('#attrlable_'+id);
   if(obj.hasClass('labelhide')){
   	    obj.animate({height:'100%'},500,function(){
            obj.removeClass('labelhide');
            $('#attra_'+id).text('隐藏');
   	    })
   }else{
        obj.animate({height:'90px'},500,function(){
        	obj.addClass('labelhide');
        	$('#attra_'+id).text('更多');
        })

   }
}
function changeGoodsType(v){
	if(v==0){
	    $('#goodsStockTr').show();
	    $('#goodsWeightTr').show();
	    $('#goodsVolumeTr').show();
		$('#isFreeShippingTr').show();
		$('#shippingFeeTypeTr').show();
		$('#shopExpressTr').show();
	    $('#goodsStock').removeAttr('disabled');
    }else{
    	$('#goodsStockTr').hide();
    	$('#goodsWeightTr').hide();
	    $('#goodsVolumeTr').hide();
	    $('#isFreeShippingTr').hide();
	    $('#shippingFeeTypeTr').hide();
	    $('#shopExpressTr').hide();
    	$('#goodsStock').prop('disabled',true);
    }
    var goodsCatId =WST.ITGetGoodsCatVal('j-goodsCats');
    getSpecAttrs(goodsCatId);
}
function toStock(id,src){
    location.href=WST.U('shop/goodsvirtuals/stock','id='+id+"&src="+src);
}
function toDetail(goodsId,key){
    window.open(WST.U('home/goods/detail','goodsId='+goodsId+"&key="+key));
}
function toolTip(){
    WST.toolTip();
}
function saleByPage(p){
    var h = WST.pageHeight();
    var cols = [
		{type:'checkbox', field:'id', fixed: 'left'},
        {title:'商品图片', field:'goodsName', width: 100, templet: function(item,rowIndex){
                var thumb = item['goodsImg'];
	        	thumb = thumb.replace('.','_thumb.');
            	return "<span class='weixin'><a style='color:blue' href='javascript:toDetail("+ item['goodsId']+",\""+item['verfiycode']+"\")'><img id='img' onmouseout='toolTip()' onmouseover='toolTip()' style='height:50px;width:50px;' src='"+WST.conf.RESOURCE_PATH+"/"+thumb
            	+"'></a><span class='imged' ><img  style='height:180px;width:180px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['goodsImg']+"'></span></span>";
        }},
        {title:'商品名称', field:'goodsName',templet: function(item,rowIndex){
        	return "<a style='color:#666' href='javascript:toDetail("+ item['goodsId']+",\""+item['verfiycode']+"\")'>"+item.goodsName+"</a> ";

        }},
        {title:'商品编号', field:'goodsSn', width: 150},
        {title:'价格(￥)<i class="fa fa-question-circle" style="margin-left:5px" title="双击修改价格"></i>', field:'shopPrice', width: 100,templet: function(item,rowIndex){
			var html = [];
			if(item['isSpec']==0) {
				html.push('<div class="goods-valign-m" ondblclick="javascript:toEditGoodsBase(2,'+item['goodsId']+',\'\')">');
				html.push('<input id="ipt_2_'+item['goodsId']+'" onkeyup="javascript:WST.isChinese(this,1)" onkeypress="return WST.isNumberdoteKey(event)" onblur="javascript:WST.limitDecimal(this,2);editGoodsBase(2,'+item['goodsId']+')" style="display:none;width:98%;border:1px solid red;" maxlength="9"/>');
				html.push('<span id="span_2_'+item['goodsId']+'" style="display: inline;cursor:pointer;color:green;">'+item['shopPrice']+'</span>');
			}else{
				html.push('<div class="goods-valign-m" ondblclick="editSpecGoods('+item['goodsId']+','+'\'sale\''+')">');
				html.push('<span style="display: inline;cursor:pointer;color:green;">'+item['shopPrice']+'</span>');
			}
			html.push('</div>');
			return html.join('');
		}},
        {title:'推荐', field:'isRecom', width: 50,templet:function(item,rowIndex){
                if(item['isRecom']==1){
                    return "<span class='statu-yes'><i class='fa fa-check-circle'></i> 是</span>";
                }else{
                    return "<span class='statu-wait'><i class='fa fa-clock-o'></i> 否</span>";
                }
            }},
        {title:'精品', field:'isBest', width: 50,templet:function(item,rowIndex){
                if(item['isBest']==1){
                    return "<span class='statu-yes'><i class='fa fa-check-circle'></i> 是</span>";
                }else{
                    return "<span class='statu-wait'><i class='fa fa-clock-o'></i> 否</span>";
                }
            }},
        {title:'新品', field:'isNew', width: 50,templet:function(item,rowIndex){
                if(item['isNew']==1){
                    return "<span class='statu-yes'><i class='fa fa-check-circle'></i> 是</span>";
                }else{
                    return "<span class='statu-wait'><i class='fa fa-clock-o'></i> 否</span>";
                }
            }},
        {title:'热销', field:'isHot', width: 50,templet:function(item,rowIndex){
                if(item['isHot']==1){
                    return "<span class='statu-yes'><i class='fa fa-check-circle'></i> 是</span>";
                }else{
                    return "<span class='statu-wait'><i class='fa fa-clock-o'></i> 否</span>";
                }
            }},
        {title:'收藏数', field:'collectNum', width: 60},
        {title:'销量', field:'saleNum', width: 60},
        {title:'库存', field:'goodsStock', width: 60},
        {title:'操作', field:'',width:150, fixed: 'right',align:'center', templet: function(item,rowIndex){
        	var h = "";
            h = '<a class="btn btn-blue btngroup btn'+item['goodsId']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
            return h;
        }}
    ];
	mmg = layui.table;
	mmg.render({
		elem: '.mmg',
		id:'dataTable',
		url:WST.U('shop/goods/saleByPage'),
		cellMinWidth: 80,
		height: WST.initGridHeight($('.wst-toolbar2').outerHeight(true)),
		skin: 'line',
		even: true,
		limit:20,
		page:{curr:p},
		cols: [cols],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadGrid(total_page);
                return;
            }
            var btns = [];var item;
            for(var i=0;i<res.data.length;i++){
            	 item = res.data[i];
                 btns = [];
                 btns.push({title: '编辑',clickFun:"toEdit", cls:"btn-blue", icon:"fa-pencil",act:102});
                 if(item['goodsType']==1)btns.push({title: '卡券',clickFun:"toStock", cls:"btn-blue", icon:"fa-pencil",act:105});
                 btns.push({title: '删除',clickFun:"del", cls:"btn-red", icon:"fa-trash-o",act:103});
                 if(item['hook']){
                 	btns.push({type: '-'});
                 	for(var j=0;j<item['hook'].length;j++){
	                 	btns.push({title: item['hook'][j]['title'],clickFun:item['hook'][j]['func'], cls:"btn-blue", icon:"",act:106});
	                }
                 }
                 layui.dropdown.render({
                    elem: '.btn'+item.goodsId,
                    dataId:item.goodsId,
                    trigger: 'hover',
                    data: btns,
                    click: function(obj,othis){
                        switch(obj.act){
                           case 102:toEdit(this.dataId);break;
                           case 103:del(this.dataId);break;
                           case 105:toStock(this.dataId);break;
                           case 106:window[obj['clickFun']](this.dataId);break;
                        }
                    }
                  });
            }
        }
	});
}
function auditByPage(p){
    var h = WST.pageHeight();
    var cols = [
		{type:'checkbox', field:'id', fixed: 'left'},
        {title:'商品图片', field:'goodsName', width: 80, templet: function(item){
               var thumb = item['goodsImg'];
	        	thumb = thumb.replace('.','_thumb.');
            	return "<span class='weixin'><a style='color:blue' href='javascript:toDetail("+ item['goodsId']+",\""+item['verfiycode']+"\")'><img id='img' onmouseout='toolTip()' onmouseover='toolTip()' style='height:50px;width:50px;' src='"+WST.conf.RESOURCE_PATH+"/"+thumb
            	+"'></a><span class='imged' ><img  style='height:180px;width:180px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['goodsImg']+"'></span></span>";
        }},
        {title:'商品名称', field:'goodsName',templet: function(item){
        	return "<a style='color:#666' href='javascript:toDetail("+ item['goodsId']+",\""+item['verfiycode']+"\")'>"+item.goodsName+"</a> ";

        }},
        {title:'商品编号', field:'goodsSn', width: 150},
        {title:'价格(￥)<i class="fa fa-question-circle" style="margin-left:5px" title="双击修改价格"></i>', field:'shopPrice', width: 100,templet: function(item){
			var html = [];
			if(item['isSpec']==0) {
				html.push('<div class="goods-valign-m" ondblclick="javascript:toEditGoodsBase(2,'+item['goodsId']+',\'\')">');
				html.push('<input id="ipt_2_'+item['goodsId']+'" onkeyup="javascript:WST.isChinese(this,1)" onkeypress="return WST.isNumberdoteKey(event)" onblur="javascript:WST.limitDecimal(this,2);editGoodsBase(2,'+item['goodsId']+')" style="display:none;width:98%;border:1px solid red;" maxlength="9"/>');
				html.push('<span id="span_2_'+item['goodsId']+'" style="display: inline;cursor:pointer;color:green;">'+item['shopPrice']+'</span>');
			}else{
				html.push('<div class="goods-valign-m" ondblclick="editSpecGoods('+item['goodsId']+','+'\'sale\''+')">');
				html.push('<span style="display: inline;cursor:pointer;color:green;">'+item['shopPrice']+'</span>');
			}
			html.push('</div>');
			return html.join('');
		}},
        {title:'推荐', field:'isRecom', width: 50,templet:function(item){
                if(item['isRecom']==1){
                    return "<span class='statu-yes'><i class='fa fa-check-circle'></i> 是</span>";
                }else{
                    return "<span class='statu-wait'><i class='fa fa-clock-o'></i> 否</span>";
                }
            }},
        {title:'精品', field:'isBest', width: 50,templet:function(item){
                if(item['isBest']==1){
                    return "<span class='statu-yes'><i class='fa fa-check-circle'></i> 是</span>";
                }else{
                    return "<span class='statu-wait'><i class='fa fa-clock-o'></i> 否</span>";
                }
            }},
        {title:'新品', field:'isNew', width: 50,templet:function(item){
                if(item['isNew']==1){
                    return "<span class='statu-yes'><i class='fa fa-check-circle'></i> 是</span>";
                }else{
                    return "<span class='statu-wait'><i class='fa fa-clock-o'></i> 否</span>";
                }
            }},
        {title:'热销', field:'isHot', width: 50,templet:function(item){
                if(item['isHot']==1){
                    return "<span class='statu-yes'><i class='fa fa-check-circle'></i> 是</span>";
                }else{
                    return "<span class='statu-wait'><i class='fa fa-clock-o'></i> 否</span>";
                }
            }},
        {title:'收藏数', field:'collectNum', width: 60},
        {title:'销量', field:'saleNum', width: 60},
        {title:'库存', field:'goodsStock', width: 60},
        {title:'操作', field:'' , fixed: 'right',width:150,align:'center', templet: function(item){
        	var h = "";
            h = '<a class="btn btn-blue btngroup btn'+item['goodsId']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
            return h;
        }}
    ];

	mmg = layui.table;
	mmg.render({
		elem: '.mmg',
		id:'dataTable',
		url:WST.U('shop/goods/auditByPage'),
		cellMinWidth: 80,
		height: WST.initGridHeight($('.wst-toolbar2').outerHeight(true)),
		skin: 'line',
		even: true,
		limit:20,
		page:{curr:p},
		cols: [cols],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadGrid(total_page);
                return;
            }
            var btns = [];var item;
            for(var i=0;i<res.data.length;i++){
            	 item = res.data[i];
                 btns = [];
                 btns.push({title: '编辑',clickFun:"toEdit", cls:"btn-blue", icon:"fa-pencil",act:102});
                 if(item['goodsType']==1)btns.push({title: '卡券',clickFun:"toStock", cls:"btn-blue", icon:"fa-pencil",act:105});
                 btns.push({title: '删除',clickFun:"del", cls:"btn-red", icon:"fa-trash-o",act:103});
                 layui.dropdown.render({
                    elem: '.btn'+item.goodsId,
                    dataId:item.goodsId,
                    trigger: 'hover',
                    data: btns,
                    click: function(obj,othis){
                        switch(obj.act){
                           case 102:toEdit(this.dataId);break;
                           case 103:del(this.dataId);break;
                           case 105:toStock(this.dataId);break;
                        }
                    }
                  });
            }
        }
	});
}
function storeByPage(p){
    var h = WST.pageHeight();
    var cols = [
		{type:'checkbox', field:'id', fixed: 'left'},
        {title:'商品图片', field:'goodsName', width: 80, templet: function(item){
                var thumb = item['goodsImg'];
	        	thumb = thumb.replace('.','_thumb.');
            	return "<span class='weixin'><a style='color:blue' href='javascript:toDetail("+ item['goodsId']+",\""+item['verfiycode']+"\")'><img id='img' onmouseout='toolTip()' onmouseover='toolTip()' style='height:50px;width:50px;' src='"+WST.conf.RESOURCE_PATH+"/"+thumb
            	+"'></a><span class='imged' ><img  style='height:180px;width:180px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['goodsImg']+"'></span></span>";
        }},
        {title:'商品名称', field:'goodsName',templet: function(item){
        	return "<a style='color:#666' href='javascript:toDetail("+ item['goodsId']+",\""+item['verfiycode']+"\")'>"+item.goodsName+"</a> ";

        }},
        {title:'商品编号', field:'goodsSn', width: 150},
        {title:'价格(￥)<i class="fa fa-question-circle" style="margin-left:5px" title="双击修改价格"></i>', field:'shopPrice', width: 100,templet: function(item){
			var html = [];
			if(item['isSpec']==0) {
				html.push('<div class="goods-valign-m" ondblclick="javascript:toEditGoodsBase(2,'+item['goodsId']+',\'\')">');
				html.push('<input id="ipt_2_'+item['goodsId']+'" onkeyup="javascript:WST.isChinese(this,1)" onkeypress="return WST.isNumberdoteKey(event)" onblur="javascript:WST.limitDecimal(this,2);editGoodsBase(2,'+item['goodsId']+')" style="display:none;width:98%;border:1px solid red;" maxlength="9"/>');
				html.push('<span id="span_2_'+item['goodsId']+'" style="display: inline;cursor:pointer;color:green;">'+item['shopPrice']+'</span>');
			}else{
				html.push('<div class="goods-valign-m" ondblclick="editSpecGoods('+item['goodsId']+','+'\'sale\''+')">');
				html.push('<span style="display: inline;cursor:pointer;color:green;">'+item['shopPrice']+'</span>');
			}
			html.push('</div>');
			return html.join('');
		}},
        {title:'推荐', field:'isRecom', width: 50,templet:function(item){
                if(item['isRecom']==1){
                    return "<span class='statu-yes'><i class='fa fa-check-circle'></i> 是</span>";
                }else{
                    return "<span class='statu-wait'><i class='fa fa-clock-o'></i> 否</span>";
                }
            }},
        {title:'精品', field:'isBest', width: 50,templet:function(item){
                if(item['isBest']==1){
                    return "<span class='statu-yes'><i class='fa fa-check-circle'></i> 是</span>";
                }else{
                    return "<span class='statu-wait'><i class='fa fa-clock-o'></i> 否</span>";
                }
            }},
        {title:'新品', field:'isNew', width: 50,templet:function(item){
                if(item['isNew']==1){
                    return "<span class='statu-yes'><i class='fa fa-check-circle'></i> 是</span>";
                }else{
                    return "<span class='statu-wait'><i class='fa fa-clock-o'></i> 否</span>";
                }
            }},
        {title:'热销', field:'isHot', width: 50,templet:function(item){
                if(item['isHot']==1){
                    return "<span class='statu-yes'><i class='fa fa-check-circle'></i> 是</span>";
                }else{
                    return "<span class='statu-wait'><i class='fa fa-clock-o'></i> 否</span>";
                }
            }},
        {title:'收藏数', field:'collectNum', width: 60},
        {title:'销量', field:'saleNum', width: 60},
        {title:'库存', field:'goodsStock', width: 60},
        {title:'操作', field:'', fixed: 'right',width:150,align:'center', templet: function(item){
            var h = "";
            h = '<a class="btn btn-blue btngroup btn'+item['goodsId']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
            return h;
        }}
    ];
	mmg = layui.table;
	mmg.render({
		elem: '.mmg',
		id:'dataTable',
		url:WST.U('shop/goods/storeByPage'),
		cellMinWidth: 80,
		height: WST.initGridHeight($('.wst-toolbar2').outerHeight(true)),
		skin: 'line',
		even: true,
		limit:20,
		page:{curr:p},
		cols: [cols],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadGrid(total_page);
                return;
            }
            var btns = [];var item;
            for(var i=0;i<res.data.length;i++){
            	 item = res.data[i];
                 btns = [];
                 btns.push({title: '编辑',clickFun:"toEdit", cls:"btn-blue", icon:"fa-pencil",act:102});
                 if(item['goodsType']==1)btns.push({title: '卡券',clickFun:"toStock", cls:"btn-blue", icon:"fa-pencil",act:105});
                 btns.push({title: '删除',clickFun:"del", cls:"btn-red", icon:"fa-trash-o",act:103});

                 layui.dropdown.render({
                    elem: '.btn'+item.goodsId,
                    dataId:item.goodsId,
                    trigger: 'hover',
                    data: btns,
                    click: function(obj,othis){
                        switch(obj.act){
                           case 102:toEdit(this.dataId);break;
                           case 103:del(this.dataId);break;
                           case 105:toStock(this.dataId);break;
                        }
                    }
                  });
            }
        }
	});
    loadGrid(p)
}
function illegalByPage(p){
    var h = WST.pageHeight();
    var cols = [
		{type:'checkbox', field:'id', fixed: 'left'},
        {title:'商品图片', field:'goodsName', width: 80, templet: function(item){
                var thumb = item['goodsImg'];
	        	thumb = thumb.replace('.','_thumb.');
            	return "<span class='weixin'><a style='color:blue' href='javascript:toDetail("+ item['goodsId']+",\""+item['verfiycode']+"\")'><img id='img' onmouseout='toolTip()' onmouseover='toolTip()' style='height:50px;width:50px;' src='"+WST.conf.RESOURCE_PATH+"/"+thumb
            	+"'></a><span class='imged' ><img  style='height:180px;width:180px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['goodsImg']+"'></span></span>";
        }},
        {title:'商品名称', field:'goodsName', width: 350, templet: function(item){
        	return "<a style='color:#666' href='javascript:toDetail("+ item['goodsId']+",\""+item['verfiycode']+"\")'>"+item.goodsName+"</a> ";

        }},
        {title:'商品编号', field:'goodsSn', width: 150},
        {title:'违规原因', field:'illegalRemarks'},
        {title:'操作', field:'', fixed: 'right' ,width:150,align:'center', templet: function(item){
            var h = "";
            h = '<a data-id="'+item['goodsId']+'" class="btn btn-blue btngroup btn'+item['goodsId']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
            return h;
        }}
    ];
	mmg = layui.table;
	mmg.render({
		elem: '.mmg',
		id:'dataTable',
		url:WST.U('shop/goods/illegalByPage'),
		cellMinWidth: 80,
		height: WST.initGridHeight(),
		skin: 'line',
		even: true,
		limit:20,
		page:{curr:p},
		cols: [cols],
        done: function(res, curr, count){
            var e = this;
            var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
            if(count>0 && curr>total_page){
                loadGrid(total_page);
                return;
            }
            WST_CURR_PAGE = curr;
            var btns = [];
            btns.push({title: '编辑', clickFun:"toEdit", cls:"btn-blue", icon:"fa-pencil"});
            btns.push({title: '删除',clickFun:"del", cls:"btn-red", icon:"fa-trash-o"});
            WST.initGridButtons({id:'.btngroup',btns:btns});
        }
	});
}
function del(id,func){
	var c = WST.confirm({content:'您确定要删除商品吗?',yes:function(){
		layer.close(c);
		var load = WST.load({msg:'正在删除，请稍后...'});
		$.post(WST.U('shop/goods/del'),{id:id},function(data,textStatus){
			layer.close(load);
		    var json = WST.toJson(data);
		    if(json.status==1){
		    	loadGrid(WST_CURR_PAGE);
		    }else{
		    	WST.msg(json.msg,{icon:2});
		    }
		});
	}});
}
function loadGrid(p){
    p = (p<=1)?1:p;
	mmg.reload('dataTable',{
		page:{curr:p},
		where:{
			cat1:$('#cat1').val(),
			cat2:$('#cat2').val(),
			goodsType:$('#goodsType').val(),
			goodsName:$('#goodsName').val(),
			goodsAttr:$('#goodsAttr').val()
		}
	});
}
//商品编辑页返回
function toBack(p,src){
    p = (p<=1)?1:p;
    if(src){
        location.href = WST.U('shop/goods/'+src,'p='+p);
	}else{
        location.reload();
	}
}
// 批量 上架/下架
function changeSale(i,func){
    var rows = mmg.checkStatus('dataTable').data;
    if(rows.length==0){
        WST.msg('请选择要修改的商品',{icon:2});
        return;
    }
    var ids = [];
    for(var s=0;s<rows.length;s++){
        ids.push(rows[s]['goodsId']);
    }
	var params = {};
	params.ids = ids;
	params.isSale = i;
	$.post(WST.U('shop/goods/changeSale'), params, function(data,textStatus){
		var json = WST.toJson(data);
		if(json.status=='1'){
			WST.msg('操作成功',{icon:1},(function(){
                loadGrid(WST_CURR_PAGE);
			}));
	    }else if(json.status=='-2'){
	    	WST.msg(json.msg, {icon: 2});
	    }else if(json.status=='2'){
	    	WST.msg(json.msg,function(){
                loadGrid(WST_CURR_PAGE);
	    	});
	    }else if(json.status=='-3'){
	    	WST.msg(json.msg, {icon: 2,time:3000});
	    }else{
	    	WST.msg('操作失败!', {icon: 2});
	    }
	});
}

// 批量设置 精品/新品/推荐/热销
function changeGoodsStatus(isWhat,func){
    var rows = mmg.checkStatus('dataTable').data;
    if(rows.length==0){
        WST.msg('请选择要修改的商品',{icon:2});
        return;
    }
    var ids = [];
    for(var s=0;s<rows.length;s++){
        ids.push(rows[s]['goodsId']);
    }
	var params = {};
	params.ids = ids;
	params.is = isWhat;
	$.post(WST.U('shop/goods/changeGoodsStatus'),params,function(data,textStatus){
		var json = WST.toJson(data);
		if(json.status=='1'){
			WST.msg('设置成功',{icon:1},function(){
				   $('#all').prop('checked',false);
                loadGrid(WST_CURR_PAGE);
			});
		}else{
			WST.msg('设置失败',{icon:2});
		}
	});
}

// 双击设置
function changSaleStatus(isWhat, obj, id){
	var params = {};
	status = $(obj).attr('status');
	params.status = status;
	params.id = id;
	switch(isWhat){
	   case 'r':params.is = "isRecom";break;
	   case 'b':params.is = "isBest";break;
	   case 'n':params.is = "isNew";break;
	   case 'h':params.is = "isHot";break;
	}
	var load = WST.load({msg:'请稍后...'});
	$.post(WST.U('shop/goods/changSaleStatus'),params,function(data,textStatus){
		layer.close(load);
		var json = WST.toJson(data);
		if(json.status==1){
			if(status==0){
				$(obj).attr('status',1);
				$(obj).removeClass('wrong').addClass('right');
			}else{
				$(obj).attr('status',0);
				$(obj).removeClass('right').addClass('wrong');
			}
		}else{
			WST.msg('操作失败',{icon:2});
		}
	});
}

//双击修改
function toEditGoodsBase(fv,goodsId,flag){
	if((fv==2 || fv==3) && flag==1){
		WST.msg('该商品存在商品属性，不能直接修改，请进入编辑页修改', {icon: 2});
		return;
	}else{
		$("#ipt_"+fv+"_"+goodsId).show();
		$("#span_"+fv+"_"+goodsId).hide();
		$("#ipt_"+fv+"_"+goodsId).focus();
		$("#ipt_"+fv+"_"+goodsId).val($("#span_"+fv+"_"+goodsId).html());
	}
}
function endEditGoodsBase(fv,goodsId){
	$('#span_'+fv+'_'+goodsId).html($('#ipt_'+fv+'_'+goodsId).val());
	$('#span_'+fv+'_'+goodsId).show();
    $('#ipt_'+fv+'_'+goodsId).hide();
}
function editGoodsBase(fv,goodsId){
    var vtext = $.trim($('#ipt_'+fv+'_'+goodsId).val());
	if(fv==2){
        if(vtext=='' || parseFloat(vtext,10)<=0){
        	WST.msg('价格必须大于0', {icon: 2});
        	return;
        }
	}else if(fv==3){
        if(vtext=='' || parseInt(vtext,10)<0 || vtext.indexOf('.')>-1){
        	WST.msg('库存必须为正整数', {icon: 2});
        	return;
        }
	}
	var params = {};
	(fv==2)?params.shopPrice=vtext:params.goodsStock=vtext;
	params.goodsId = goodsId;
	$.post(WST.U('shop/Goods/editGoodsBase'),params,function(data,textStatus){
		var json = WST.toJson(data);
		if(json.status>0){
			$('#img_'+fv+'_'+goodsId).fadeTo("fast",100);
			endEditGoodsBase(fv,goodsId);
			$('#img_'+fv+'_'+goodsId).fadeTo("slow",0);
		}else{
			WST.msg(json.msg, {icon: 2});
		}
	});
}

function benchDel(func,flag){
    var rows = mmg.checkStatus('dataTable').data;
    if(rows.length==0){
        WST.msg('请选择要删除的商品',{icon:2});
        return;
    }
    var ids = [];
    for(var s=0;s<rows.length;s++){
        ids.push(rows[s]['goodsId']);
    }
	var params = {};
	params.ids = ids;
	var load = WST.load({msg:'请稍后...'});
	$.post(WST.U('shop/goods/batchDel'),params,function(data,textStatus){
		layer.close(load);
		var json = WST.toJson(data);
		if(json.status=='1'){
			WST.msg('操作成功',{icon:1},function(){
				   $('#all').prop('checked',false);
                loadGrid(WST_CURR_PAGE);
			});
		}else{
			WST.msg('操作失败',{icon:2});
		}
	});
}

function getCat(val){
  if(val==''){
  	$('#cat2').html("<option value='' >-请选择-</option>");
  	return;
  }
  $.post(WST.U('shop/shopcats/listQuery'),{parentId:val},function(data,textStatus){
       var json = WST.toJson(data);
       var html = [],cat;
       html.push("<option value='' >-请选择-</option>");
       if(json.status==1 && json.list){
         json = json.list;
       for(var i=0;i<json.length;i++){
           cat = json[i];
           html.push("<option value='"+cat.catId+"'>"+cat.catName+"</option>");
        }
       }
       $('#cat2').html(html.join(''));
  });
}
function resetForm(){
	location.reload();
}



var goodsTotal,num=0,vtype=0,creatQrcodeCnt=0;
var goodsList = [];
var goodsDir = "";
var grqmap = [],errRqlist = [];
function toExplode(){

    var box = WST.open({title:'导出商品二维码',type:1,content:layui.$('#exportBox'),area: ['400px', '180px'],btn:['确定导出','取消'],yes:function(){
        vtype = $("#vtype").val();
        grqmap = [];
        errRqlist = [];
        var ids = [];
        var params = {};
        var rows = mmg.checkStatus('dataTable').data;
	    if(rows.length>0){
	        for(var s=0;s<rows.length;s++){
		        ids.push(rows[s]['goodsId']);
		    }
		    params.ids = ids
	    }else{
	    	params = {cat1:$('#cat1').val(),cat2:$('#cat2').val(),goodsType:$('#goodsType').val(),goodsName:$('#goodsName').val(),goodsAttr:$('#goodsAttr').val()}
	    }


        var loading = WST.msg('正在处理，请稍后...', {icon: 16,time:60000});
        $.post(WST.U('shop/goods/checkExportGoods'),params,function(data,textStatus){
                  layer.close(loading);
                  var json = WST.toJson(data);
                  if(json.status==1){
                        goodsList = json.data.glist;
                        goodsDir = json.data.gdir;
                        goodsTotal = goodsList.length;
                        for(var i in goodsList){
                            grqmap[goodsList[i]['goodsId']] = goodsList[i];
                        }
                        layer.close(box);
                        if(goodsTotal>0){
                            createGoodsQrcode();
                        }else{
                            WST.msg("没有可导出的商品",{icon:1});
                        }
                  }else{
                        WST.msg(json.msg,{icon:2});
                  }
            });
        }
    });
}

function createGoodsQrcode(){
    var goodsId = goodsList[num].goodsId;
    WST.msg("当前正在生成第"+(num+1)+"个商品,进度"+num+"/"+goodsTotal);
    $.post(WST.U('shop/goods/createGoodsQrcode'),{vtype:vtype,goodsId:goodsId,dir:goodsDir},function(data,textStatus){
        var json = WST.toJson(data);

        if(json.status!=1){
            errRqlist.push("<div style='line-height:30px;padding:0 20px;color:red;'>编号为【"+grqmap[goodsId]["goodsSn"]+"】的商品，"+json.msg+"，已跳过</div>");
        }else{
            creatQrcodeCnt++
        }
        if(num < goodsTotal-1){
            num++
            layer.closeAll();
            createGoodsQrcode();
            return;
        }else{
            num=0;
            if(creatQrcodeCnt>0){
                WST.msg("已完成生成商品二维码,共"+creatQrcodeCnt+"个",{icon:1});
                packageDownQrcode();
            }else{
                if(errRqlist.length>0){
                    WST.open({title:'提醒',
                    type:1,
                    content:errRqlist.join(""),
                    area: ['600px', '400px'],
                    btn:['确定'],
                    yes:function(){layer.closeAll();}})
                }
                WST.msg("没有商品可生成二维码",{icon:1});
            }
        }

    });
}


function packageDownQrcode(){
    var loading = WST.msg('正在打包商品二维码，请稍后...', {icon: 16,time:60000});
    $.post(WST.U('shop/goods/packageDownQrcode'),{dir:goodsDir},function(data,textStatus){
        var json = WST.toJson(data);
        if(json.status=='1'){
            layer.close(loading);
            if(errRqlist.length>0){
                WST.open({title:'提醒',
                type:1,
                content:errRqlist.join(""),
                area: ['600px', '400px'],
                btn:['确定'],
                yes:function(){layer.closeAll();}})
            }

            window.location = window.conf.DOMAIN+"/"+json.data;
        }else{
            WST.msg(json.msg,{icon:2});
        }
    });
}





function getMouldList(goodsCatId){
	$.post(WST.U('shop/moulds/getMouldList'),{goodsCatId:goodsCatId},function(data,textStatus){
		$("#selMouldBox").show();
    	var json = WST.toJson(data);
    	var html = [];
    	if(json.data && json.data.length>0){
			$("#mouldCol1").show();
			$("#updateMould").show();
		}else{
			$("#mouldCol1").hide();
			$("#updateMould").hide();
		}
		if(json.status==1 && json.data){

			for(var i=0;i<json.data.length;i++){
				var obj = json.data[i];

				html.push('<div id="mouldItem'+obj['id']+'" class="mouldItem">');
					html.push('<div class="itemBox"  data="'+obj['id']+'">');
						html.push('<span class="mouldName" id="mTitle'+obj['id']+'">'+obj['mouldName']+' </span>');
					html.push('</div>');
					html.push('<i class="fa fa fa-trash-o del" onclick="delMould('+obj['id']+')"></i>');
					html.push('<i class="fa fa-edit edit" onclick="editMouldName('+obj['id']+')"></i>');
				html.push('</div>');
			}

		}
		$("#mouldItemBox").html(html.join(""));
		$(".itemBox").on({
			click : function(){
				var mouldId = $(this).attr("data");
				$("#mouldId").val(mouldId);
				$("#mouldItemBox").toggle();
				$("#mouldTitle").html($("#mTitle"+mouldId).html());
				getMould(mouldId);
			}
		});
 	});
}


function toUpdateMould(){
	var mouldId = $("#mouldId").val();
	saveMould(mouldId);
}

function editMouldName(mouldId){
	var mouldName = $("#mTitle"+mouldId).html();
	$("#mouldName").val(mouldName);
	if(mouldName==""){
		WST.msg("请输入模板名称");return;
	}
	var title ="编辑";
	var box = WST.open({title:title,type:1,content:$('#specMouldBox'),area: ['750px', '180px'],btn:['确定','取消'],
		end:function(){
			$('#specMouldBox').hide();
		},yes:function(){
			var params = {};
			params.mouldId = mouldId;
		    params.mouldName = $("#mouldName").val();
		    var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
		 	$.post(WST.U('shop/moulds/editMouldName'),params,function(data,textStatus){
		 		layer.close(loading);
		    	var json = WST.toJson(data);
				if(json.status=='1'){
					WST.msg("操作成功",{icon:1});
					$('#specMouldBox').hide();
					$("#mouldItemBox").hide();
					var goodsCatId = WST.ITGetGoodsCatVal('j-goodsCats');
					getMouldList(goodsCatId);
					layer.close(box);
			  	}else{
			    	WST.msg(json.msg,{icon:2});
				}
		 	});
		}
	});
}


function delMould(mouldId){
	var c = WST.confirm({content:'您确定要删除吗?',yes:function(){
		layer.close(c);
		var load = WST.load({msg:'正在删除，请稍后...'});
		$.post(WST.U('shop/moulds/del'),{mouldId:mouldId},function(data,textStatus){
			layer.close(load);
		    var json = WST.toJson(data);
		    if(json.status==1){
		    	var currMouldId = $("#mouldId").val();
		    	if(currMouldId==mouldId){
		    		$("#mouldId").val(0);
		    		$("#updateMould").hide();
		    		$("#mouldTitle").html("请选择规格属性模板");
		    	}
		    	$("#mouldItem"+mouldId).remove();
		    	$("#mouldItemBox").toggle();
		    	var goodsCatId = WST.ITGetGoodsCatVal('j-goodsCats');
		    	getMouldList(goodsCatId);
		    }else{
		    	WST.msg(json.msg,{icon:2});
		    }
		});
	}});
}
var mouldBox = null;
function toSaveMould(mouldId){
	$("#mouldName").val("");
	var title = "新增";
	mouldBox = WST.open({title:title,type:1,content:$('#specMouldBox'),area: ['750px', '180px'],btn:['确定','取消'],
		end:function(){
			$('#specMouldBox').hide();
		},yes:function(){
			saveMould(mouldId)
		}
	});

}

function saveMould(mouldId){

	var specsIds = [];
	var specidsmap = [];
	var params = WST.getParams('.j-mould');
	params.mouldId = mouldId;
	params.specNum = specNum;
	var specsName,specImg;
	$('.j-speccat').each(function(){
		specsName = 'specName_'+$(this).attr('cat')+'_'+$(this).attr('num');
		specImg = 'specImg_'+$(this).attr('cat')+'_'+$(this).attr('num');

		params[specsName] = $.trim($('#'+specsName).val());
		params[specImg] = $.trim($('#'+specImg).attr('v'));

		specsIds.push($(this).attr('cat')+':'+$(this).attr('num'));
	});


	var specmap = [];
	for(var key in id2SepcNumConverter){
		specmap.push(key+":"+id2SepcNumConverter[key]);
	}
	params.specsIds = specsIds.join(',');
	params.specmap = specmap.join(',');
	var mouldName = $("#mouldName").val();
    params.mouldName = mouldName;
    params.goodsCatId = WST.ITGetGoodsCatVal('j-goodsCats');
    var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
 	$.post(WST.U('shop/moulds/addMould'),params,function(data,textStatus){
 		layer.close(loading);
    	var json = WST.toJson(data);
		if(json.status=='1'){
			WST.msg("操作成功",{icon:1});
			layer.close(mouldBox);
			if(!mouldId){
				$("#mouldItemBox").hide();
				$("#mouldId").val(json.data);
				$("#mouldTitle").html(mouldName);
				var goodsCatId = WST.ITGetGoodsCatVal('j-goodsCats');
				getMouldList(goodsCatId);
			}
	  	}else{
	    	WST.msg(json.msg,{icon:2});
		}
 	});
}

function getMould(mouldId){
	$('#specsAttrBox').empty();
	$('#specBtns').hide();
	specNum = 0;
	$.post(WST.U('shop/moulds/get'),{mouldId:mouldId},function(data,textStatus){
		var json = WST.toJson(data);
		if(json.status==1 && json.data){
			loadMould(json)
		}

	});
}


function loadMould(json){
	var html = [],tmp,str;
	if(json.data.spec0 || json.data.spec1){
		html.push('<div class="spec-head">商品规格</div>');
		html.push('<div class="spec-body">');
		if(json.data.spec0){
			tmp = json.data.spec0;
			html.push('<div id="specCat_'+tmp.catId+'">'+tmp.catName+'</div>');
			html.push('<table><tbody id="specTby"></tbody></table>');
		}
		if(json.data.spec1){
			for(var i=0;i<json.data.spec1.length;i++){
				tmp = json.data.spec1[i];
				html.push('<div class="spec-line"></div>',
				          '<div id="specCat_'+tmp.catId+'">'+tmp.catName+'</div>',
				          '<div style="height:auto;">',
				          '<button type="button" class="btn btn-success" id="specAddBtn_'+tmp.catId+'" onclick="javascript:addSpec({catId:'+tmp.catId+',checked:\'\'})"><i class="fa fa-plus"></i>新增</button>',
				          '<div style="clear:both;"></div></div>'
						);
			}
		}
		html.push('</div>');
		html.push($('#specTips').html());
		html.push('<div id="specSaleHead" class="spec-head">销售规格</div>',
		          '<table class="specs-sale-table">',
		          '  <thead id="spec-sale-hed">',
		          '   <tr>',
		          '     <th>推荐<br/>规格</th>',
		          '     <th id="thCol"><font color="red">*</font>货号</th>',
		          '     <th>市场价<font color="red">*</font><br/><input type="text" class="spec-sale-ipt" onblur="WST.limitDecimal(this,2);batchChange(this.value,\'marketPrice\')" maxLength="9" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)"></th>',
		          '     <th>本店价<font color="red">*</font><br/><input type="text" class="spec-sale-ipt" onblur="WST.limitDecimal(this,2);batchChange(this.value,\'specPrice\')" maxLength="9" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)"></th>',
		          '     <th>成本价<font color="red">*</font><br/><input type="text" class="spec-sale-ipt" onblur="WST.limitDecimal(this,2);batchChange(this.value,\'costPrice\')" maxLength="9" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)"></th>',
		          '     <th>库存<font color="red">*</font><br/><input type="text" class="spec-sale-ipt" onblur="batchChange(this.value,\'specStock\')" onkeypress="return WST.isNumberKey(event)" onkeyup="javascript:WST.isChinese(this,1)"></th>',
		          '     <th>预警库存<font color="red">*</font><br/><input type="text" class="spec-sale-ipt" onblur="batchChange(this.value,\'warnStock\')" onkeypress="return WST.isNumberKey(event)" onkeyup="javascript:WST.isChinese(this,1)"></th>',
		          '     <th>商品重量(kg)<font color="red">*</font><br/><input type="text" class="spec-sale-ipt" onblur="batchChange(this.value,\'specWeight\')" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)"></th>',
		          '     <th>商品体积(m³)<font color="red">*</font><br/><input type="text" class="spec-sale-ipt" onblur="batchChange(this.value,\'specVolume\')" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)"></th>',
		          '     <th>销量</th>',
		          '   </tr>',
		          '  </thead>',
		          '  <tbody id="spec-sale-tby"></tbody></table>'
				);
	}
	if(json.data.attrs){
		html.push('<div class="spec-head">商品属性</div>');
		html.push('<div class="spec-body">');
		html.push('<table class="attr-table">');
		for(var i=0;i<json.data.attrs.length;i++){
			tmp = json.data.attrs[i];
			html.push('<tr><th width="120" nowrap valign="top" style="padding-top:6px;">'+tmp.attrName+'：</th><td>');
			if(tmp.attrType==1){
				str = tmp.attrVal.split(',');
				html.push('<div id="attrlable_'+tmp.attrId+'" class="labelattr '+((str.length>12)?"labelhide":"")+'">');
				for(var j=0;j<str.length;j++){
				    html.push('<label><input type="checkbox" class="j-ipt j-mould" name="attr_'+tmp.attrId+'" value="'+str[j]+'"/>'+str[j]+'</label>');
				}
				html.push('</div>');
			    if(str.length>12)html.push('<a id="attra_'+tmp.attrId+'" href="javascript:showHideAttr('+tmp.attrId+')" class="labela">更多</a>');
			}else if(tmp.attrType==2){
				html.push('<select name="attr_'+tmp.attrId+'" id="attr_'+tmp.attrId+'" class="j-ipt j-mould">');
				html.push('<option value="">请选择</option>');
				str = tmp.attrVal.split(',');
				for(var j=0;j<str.length;j++){
					html.push('<option value="'+str[j]+'">'+str[j]+'</option>');
				}
				html.push('</select>');
			}else{
				html.push('<input type="text" name="attr_'+tmp.attrId+'" id="attr_'+tmp.attrId+'" class="spec-sale-text j-ipt j-mould"/>');
			}
			html.push('</td></tr>');
		}
		html.push('</table>');
		html.push('</div>');
	}
	$('#specsAttrBox').html(html.join(''));

	var specAttrObj = json.data.specAttrObj;


	//设置规格值
	if(specAttrObj.spec0){
		for(var i=0;i<specAttrObj.spec0.length;i++){
		   if(specAttrObj.spec0[i].catId==json.data.spec0.catId)addSpecImg({catId:specAttrObj.spec0[i].catId,checked:'checked',val:specAttrObj.spec0[i].itemName,itemId:specAttrObj.spec0[i].itemId,specImg:specAttrObj.spec0[i].itemImg,itemImgThumb:specAttrObj.spec0[i].itemImgThumb});
		}
	}
	if(specAttrObj.spec1){
		for(var i=0;i<specAttrObj.spec1.length;i++){
			for(var j=0;j<json.data.spec1.length;++j){
				if(specAttrObj.spec1[i].catId==json.data.spec1[j].catId){
		    		addSpec({catId:specAttrObj.spec1[i].catId,checked:'checked',val:specAttrObj.spec1[i].itemName,itemId:specAttrObj.spec1[i].itemId});
					break;
				}
			}
		}
	}
	addSpecSaleCol();
	//设置商品属性值
	var tmp = null;
	if(specAttrObj.attrs.length){
		for(var i=0;i<specAttrObj.attrs.length;i++){
			if(specAttrObj.attrs[i].attrType==1){
				tmp = specAttrObj.attrs[i].attrVal.split(',');
				WST.setValue("attr_"+specAttrObj.attrs[i].attrId,tmp);
			}else{
			    WST.setValue("attr_"+specAttrObj.attrs[i].attrId,specAttrObj.attrs[i].attrVal);
			}
		}
	}


	//给没有初始化的规格初始化一个输入框
	if(json.data.spec0 && !$('.j-speccat_'+json.data.spec0.catId)[0]){
		addSpecImg({catId:json.data.spec0.catId,checked:''});
	}
	if(json.data.spec1){
		for(var i=0;i<json.data.spec1.length;i++){
			if(!$('.j-speccat_'+json.data.spec1[i].catId)[0])addSpec({catId:json.data.spec1[i].catId,checked:''});
		}
	}
	$('#specBtns').show();
}



/************************************************************** 列表批量改价 **************************************************************/
function editSpecGoods(goodsId,src){
	OBJ = '';
	specNum = 0;
	$('#specsAttrContainer').empty();
	$('#specsAttrBox').empty();
	$.post(WST.U('shop/goods/getById'),{id:goodsId},function(data,textStatus){
		var json = WST.toJson(data);
		OBJ = json.data;
		$('#goodsId').val(OBJ.goodsId);
		$.post(WST.U('shop/goods/getSpecAttrs'),{goodsCatId:OBJ.goodsCatId,goodsType:OBJ.goodsType},function(data,textStatus){
			var json = WST.toJson(data);
			if(json.status==1 && json.data){
				var html = [],tmp,str;
				if(json.data.spec0 || json.data.spec1){
					html.push('<div class="spec-head" style="display:none;">商品规格</div>');
					html.push('<div class="spec-body" style="display:none;">');
					if(json.data.spec0){
						tmp = json.data.spec0;
						html.push('<div id="specCat_'+tmp.catId+'">'+tmp.catName+'</div>');
						html.push('<table><tbody id="specTby"></tbody></table>');
					}
					if(json.data.spec1){
						for(var i=0;i<json.data.spec1.length;i++){
							tmp = json.data.spec1[i];
							html.push('<div class="spec-line"></div>',
								'<div id="specCat_'+tmp.catId+'">'+tmp.catName+'</div>',
								'<div>',
								'<button class="btn btn-green" id="specAddBtn_'+tmp.catId+'" type="button" onclick="javascript:addSpec({catId:'+tmp.catId+',checked:\'\'})"><i class="fa fa-plus"></i>新增</button>',
								'</div>'
							);
						}
					}
					html.push('</div>');
					html.push('<table class="specs-sale-table">',
						'  <thead id="spec-sale-hed">',
						'   <tr>',
						'     <th>推荐<br/>规格</th>',
						'     <th id="thCol"><font color="red">*</font>货号</th>',
						'     <th>市场价<font color="red">*</font><br/><input type="text" class="spec-sale-ipt" onblur="WST.limitDecimal(this,2);batchChange(this.value,\'marketPrice\')" maxLength="9" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)"></th>',
						'     <th>本店价<font color="red">*</font><br/><input type="text" class="spec-sale-ipt" onblur="WST.limitDecimal(this,2);batchChange(this.value,\'specPrice\')" maxLength="9" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)"></th>',
						'     <th>成本价<font color="red">*</font><br/><input type="text" class="spec-sale-ipt" onblur="WST.limitDecimal(this,2);batchChange(this.value,\'costPrice\')" maxLength="9" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)"></th>',
						'     <th>库存<font color="red">*</font><br/><input type="text" class="spec-sale-ipt" onblur="batchChange(this.value,\'specStock\')" onkeypress="return WST.isNumberKey(event)" onkeyup="javascript:WST.isChinese(this,1)"></th>',
						'     <th>预警库存<font color="red">*</font><br/><input type="text" class="spec-sale-ipt" onblur="batchChange(this.value,\'warnStock\')" onkeypress="return WST.isNumberKey(event)" onkeyup="javascript:WST.isChinese(this,1)"></th>',
						'     <th>商品重量(kg)<font color="red">*</font><br/><input type="text" class="spec-sale-ipt" onblur="batchChange(this.value,\'specWeight\')" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)"></th>',
						'     <th>商品体积(m³)<font color="red">*</font><br/><input type="text" class="spec-sale-ipt" onblur="batchChange(this.value,\'specVolume\')" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)"></th>',
						'     <th>销量</th>',
						'   </tr>',
						'  </thead>',
						'  <tbody id="spec-sale-tby"></tbody></table>'
					);
				}
				$('#specsAttrBox').html(html.join(''));
				//如果是编辑的话，第一次要设置之前设置的值
				if(OBJ.goodsId>0 && specNum==0){
					//设置规格值
					if(OBJ.spec0){
						for(var i=0;i<OBJ.spec0.length;i++){
							addSpecImg({catId:OBJ.spec0[i].catId,checked:'checked',val:OBJ.spec0[i].itemName,itemId:OBJ.spec0[i].itemId,specImg:OBJ.spec0[i].itemImg,itemImgThumb:OBJ.spec0[i].itemImgThumb});
						}
					}
					if(OBJ.spec1){
						for(var i=0;i<OBJ.spec1.length;i++){
							addSpec({catId:OBJ.spec1[i].catId,checked:'checked',val:OBJ.spec1[i].itemName,itemId:OBJ.spec1[i].itemId});
						}
					}
					addSpecSaleCol();
				}
			}
		});
	});

	var box = WST.open({title:'编辑商品规格',type:1,content:layui.$('#goodsBox'),area: ['80%', '80%'],offset:['10%','10%'],btn: ['确定','取消'],
		yes:function(){
			var params = WST.getParams('.j-ipt');
			params.specNum = specNum;
			var specsName,specImg;
			$('.j-speccat').each(function(){
				specsName = 'specName_'+$(this).attr('cat')+'_'+$(this).attr('num');
				specImg = 'specImg_'+$(this).attr('cat')+'_'+$(this).attr('num');
				if($(this)[0].checked){
					params[specsName] = $.trim($('#'+specsName).val());
					params[specImg] = $.trim($('#'+specImg).attr('v'));
				}
			});
			var specsIds = [];
			var specidsmap = [];
			$('.j-ws').each(function(){
				specsIds.push($(this).attr('v'));
				specidsmap.push(WST.blank($(this).attr('sid'))+":"+$(this).attr('v'));
			});
			var specmap = [];
			for(var key in id2SepcNumConverter){
				specmap.push(key+":"+id2SepcNumConverter[key]);
			}
			params.specsIds = specsIds.join(',');
			params.specidsmap = specidsmap.join(',');
			params.specmap = specmap.join(',');
			var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
			$.post(WST.U('shop/goods/editSpecGoods'),params,function(data,textStatus){
				layer.close(loading);
				var json = WST.toJson(data);
				if(json.status=='1'){
					WST.msg(json.msg,{icon:1},function(){
						$('#goodsBox').hide();
						layer.close(box);
						loadGrid(0);
					});
				}else{
					WST.msg(json.msg,{icon:2});
				}
			});
		},cancel:function(){
			$('#goodsBox').hide();
		},end:function(){
		}});
}
