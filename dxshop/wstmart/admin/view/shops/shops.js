var mmg,mmg2;
function initGrid(p){
	mmg = layui.table;
	mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/shops/pageQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
		cols: [[
			{title:'#',type:'numbers'},
			{title:'店铺编号', field:'shopSn'},
			{title:'店铺账号', field:'loginName'},
			{title:'店铺名称', field:'shopName',templet: function(item){
				return "<a href=\"javascript:toView(" + item['shopId'] + ",\'index\')\">"+item['shopName']+"</a>";
			}},
			{title:'所属行业', field:'tradeName',width:200},
			{title:'店主姓名', field:'shopkeeper'},
			{title:'店主联系电话', field:'telephone'},
			{title:'店铺地址', field:'shopAddress'},
			{title:'所属公司', field:'shopCompany'},
			{title:'营业状态', field:'shopAtive',templet: function(item){
				return (item['shopAtive']==1)?"<span class='statu-yes'><i class='fa fa-check-circle'></i> 营业中</span>":"<span class='statu-wait'><i class='fa fa-coffee'></i> 休息中</span>";
			}},
			{title:'到期日期', field:'expireDate',templet: function(item){
				return (item['isExpire']==true)?"<span class='expire-yes'>"+item['expireDate']+"</span>":"<span>"+item['expireDate']+"</span>";
			}},
			{title:'操作', field:'' ,width:200, fixed: 'right',align:'center', templet: function(item){
				return '<a data-id="'+item['shopId']+'" class="btn btn-blue btngroup btn'+item['shopId']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
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
			for(var i=0;i<res.data.length;i++){
				btns = [];
				if(WST.GRANT.DPGL_02)btns.push({title: '修改',cls:"btn-blue", icon:"fa-pencil",act:102});
				if(WST.GRANT.DPGL_03 && res.data[i]['shopId'] != 1)btns.push({title: '删除',cls:"btn-red", icon:"fa fa-trash-o",act:103});
				btns.push({title: '店铺订单',cls:"btn-blue", icon:"fa fa-search",act:100});
				layui.dropdown.render({
					elem: '.btn'+res.data[i].shopId,
					dataId:res.data[i].shopId,
					trigger: 'hover',
					data: btns,
					click: function(obj,othis){
						switch(obj.act){
							case 100:toLogmoneys(this.dataId);break;
							case 102:toEdit(this.dataId,'index');break;
							case 103:toDel(this.dataId,1);break;
						}
					}
				});
			}
		}
	});
}
function loadGrid(p){
	p=(p<=1)?1:p;
	var params = WST.getParams('.j-ipt');
	params.areaIdPath = WST.ITGetAllAreaVals('areaId1','j-areas').join('_');
	mmg.reload('dataTable',{where:params,page:{curr:p}});
}

function toLogmoneys(shopId){
	location.href = WST.U('admin/orders/index','shopId='+shopId+'&src=shops&p='+WST_CURR_PAGE)
}

function initApplyGrid(p){
	var tbHeight = $('.wst-toolbar').outerHeight(true)+$('.layui-tab-title').outerHeight(true)+45;
	var h = 'full-'+tbHeight;
	mmg = layui.table;
	mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/shops/pageQueryByApply'),cellMinWidth: 80,height: h,skin: 'line',even: true,limit:20,page:{curr:p},
		cols: [[
			{title:'#',type:'numbers'},
			{title:'申请人账号', field:'loginName'},
			{title:'店铺名称', field:'shopName',templet: function(item){
				return "<a href=\"javascript:toView(" + item['shopId'] + ",\'apply\')\">"+item['shopName']+"</a>";
			}},
			{title:'所属行业', field:'tradeName',width: 200},
			{title:'所属公司', field:'shopCompany'},
			{title:'申请联系人', field:'applyLinkMan'},
			{title:'申请联系人电话', field:'applyLinkTel'},
			{title:'对接商城招商人员', field:'isInvestment' ,renderer: function (val,item,rowIndex){
				return (item['isInvestment']==1)?item['investmentStaff']:'-';
			}},
			{title:'申请日期', field:'applyTime',width:200 },
			{title:'申请状态', field:'applyStatus' ,templet: function(item){
				if(item['applyStatus']==1){
					return "<span class='statu-wait'><i class='fa fa-clock-o'></i> 待处理</span>";
				}else if(item['applyStatus']==0){
					return "<span class='statu-wait'><i class='fa fa-clock-o'></i> 填写中</span>";
				}else{
					return "<span class='statu-no'><i class='fa fa-ban'></i> 申请失败</span>";
				}
			}},
			{title:'操作', field:'' , fixed: 'right', width:200, align:'center', templet: function(item){
				var h = "";
				if(WST.GRANT.DPSQ_04)h += "<a class='btn btn-blue' href='javascript:toHandle(" + item['shopId'] + ")'><i class='fa fa-pencil'></i>操作</a> ";
				if(WST.GRANT.DPSQ_03)h += "<a class='btn btn-red' href='javascript:toDelApply(" + item['shopId'] + ")'><i class='fa fa-trash-o'></i>删除</a> ";
				return h;
			}}
		]],
		done: function(res, curr, count){
			var e = this;
			var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
			if(count>0 && curr>total_page){
				loadApplyGrid(total_page);
				return;
			}
			WST_CURR_PAGE = curr;
		}
	});
}
function loadApplyGrid(p){
	p=(p<=1)?1:p;
	var params = WST.getParams('.j-ipt');
	params.areaIdPath = WST.ITGetAllAreaVals('areaId1','j-areas').join('_');
	mmg.reload('dataTable',{where:params,page:{curr:p}});
}
function toHandle(id){
	location.href = WST.U('admin/shops/toHandleApply','id='+id+'&p='+WST_CURR_PAGE);
}
function toDelApply(id){
	var box = WST.confirm({content:"您确定要彻底删除该店铺申请信息吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           $.post(WST.U('admin/shops/delApply'),{id:id},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	layer.close(box);
	           		            loadApplyGrid(WST_CURR_PAGE);
	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}
function initStopGrid(p){
	mmg = layui.table;
	mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/shops/pageStopQuery'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
		cols: [[
			{title:'#',type:'numbers'},
			{title:'店铺编号', field:'shopSn'},
			{title:'店铺账号', field:'loginName'},
			{title:'店铺名称', field:'shopName',templet: function(item){
				return "<a href=\"javascript:toView(" + item['shopId'] + ",\'index\')\">"+item['shopName']+"</a>";
			}},
			{title:'所属行业', field:'tradeName',width:200},
			{title:'店主姓名', field:'shopkeeper'},
			{title:'店主联系电话', field:'telephone'},
			{title:'店铺地址', field:'shopAddress'},
			{title:'所属公司', field:'shopCompany'},
			{title:'操作', field:'' ,width:200, fixed: 'right',align:'center', templet: function(item){
				return '<a data-id="'+item['shopId']+'" class="btn btn-blue btngroup btn'+item['shopId']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
			}}
		]],
		done: function(res, curr, count){
			var e = this;
			var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
			if(count>0 && curr>total_page){
				loadStopGrid(total_page);
				return;
			}
			WST_CURR_PAGE = curr;
			var btns = [];
			for(var i=0;i<res.data.length;i++){
				btns = [];
				if(WST.GRANT.DPGL_02)btns.push({title: '修改',cls:"btn-blue", icon:"fa-pencil",act:102});
				if(WST.GRANT.DPGL_03)btns.push({title: '删除',cls:"btn-red", icon:"fa-trash-o",act:103});
				layui.dropdown.render({
					elem: '.btn'+res.data[i].shopId,
					dataId:res.data[i].shopId,
					trigger: 'hover',
					data: btns,
					click: function(obj,othis){
						switch(obj.act){
							case 102:toEdit(this.dataId,'stopIndex');break;
							case 103:toDel(this.dataId,2);break;
						}
					}
				});
			}
		}
	});
}
function loadStopGrid(p){
	var params = WST.getParams('.j-ipt');
	p=(p<=1)?1:p;
	params.areaIdPath = WST.ITGetAllAreaVals('areaId1','j-areas').join('_');
	mmg.reload('dataTable',{where:params,page:{curr:p}});
}
var initTab2 = false,initTab3 = false;
function initUpload(isEdit){
	if(!isEdit){
        legalCertificateImgUpload();
		businessLicenceImgUpload();
		bankAccountPermitImgUpload();
		organizationCodeUpload();
		taxRegistrationCertificateUpload();
		taxpayerQualificationUpload();
	}else{
		var element = layui.element;
		element.on('tab(msgTab)', function(data){
		   if(data.index==1){
		   	   if(initTab2)return;
		       initTab2 = true;
               legalCertificateImgUpload();
			   businessLicenceImgUpload();
			   bankAccountPermitImgUpload();
			   organizationCodeUpload();
		   }else if(data.index==2){
		   	   if(initTab3)return;
		       initTab3 = true;
               taxRegistrationCertificateUpload();
			   taxpayerQualificationUpload();
		   }
	    });
	}
}
function legalCertificateImgUpload (){
	WST.upload({
			pick:'#legalCertificateImgPicker',
			formData: {dir:'shops'},
			accept: {extensions: 'gif,jpg,jpeg,png',mimeTypes: 'image/jpg,image/jpeg,image/png,image/gif'},
			callback:function(f){
				var json = WST.toAdminJson(f);
				if(json.status==1){
				  	$('#legalCertificateImgMsg').empty().hide();
				    $('#legalCertificateImgPreview').attr('src',WST.conf.RESOURCE_PATH+"/"+json.savePath+json.thumb).show();
				    $('#legalCertificateImgPreview_a').attr('href',WST.conf.RESOURCE_PATH+"/"+json.savePath+json.name);
				    $('#legalCertificateImg').val(json.savePath+json.name);
				    $('#msg_legalCertificateImg').hide();
				}
			},
			progress:function(rate){
				$('#legalCertificateImgMsg').show().html('已上传'+rate+"%");
			}
		});
}
function businessLicenceImgUpload(){
	WST.upload({
			pick:'#businessLicenceImgPicker',
			formData: {dir:'shops'},
			accept: {extensions: 'gif,jpg,jpeg,png',mimeTypes: 'image/jpg,image/jpeg,image/png,image/gif'},
			callback:function(f){
				var json = WST.toAdminJson(f);
				if(json.status==1){
					$('#businessLicenceImgMsg').empty().hide();
					$('#businessLicenceImgPreview').attr('src',WST.conf.RESOURCE_PATH+"/"+json.savePath+json.thumb).show();
					$('#businessLicenceImgPreview_a').attr('href',WST.conf.RESOURCE_PATH+"/"+json.savePath+json.name);
					$('#businessLicenceImg').val(json.savePath+json.name);
					$('#msg_businessLicenceImg').hide();
				}
			},
			progress:function(rate){
				$('#businessLicenceImgMsg').show().html('已上传'+rate+"%");
			}
		});
}
function bankAccountPermitImgUpload(){
	WST.upload({
			pick:'#bankAccountPermitImgPicker',
			formData: {dir:'shops'},
			accept: {extensions: 'gif,jpg,jpeg,png',mimeTypes: 'image/jpg,image/jpeg,image/png,image/gif'},
			callback:function(f){
				var json = WST.toAdminJson(f);
				if(json.status==1){
					$('#bankAccountPermitImgMsg').empty().hide();
					$('#bankAccountPermitImgPreview').attr('src',WST.conf.RESOURCE_PATH+"/"+json.savePath+json.thumb).show();
					$('#bankAccountPermitImgPreview_a').attr('href',WST.conf.RESOURCE_PATH+"/"+json.savePath+json.name);
					$('#bankAccountPermitImg').val(json.savePath+json.name);
					$('#msg_bankAccountPermitImg').hide();
				}
			},
			progress:function(rate){
				$('#bankAccountPermitImgMsg').show().html('已上传'+rate+"%");
			}
		});
}
function organizationCodeUpload(){
	WST.upload({
			pick:'#organizationCodeImgPicker',
			formData: {dir:'shops'},
			accept: {extensions: 'gif,jpg,jpeg,png',mimeTypes: 'image/jpg,image/jpeg,image/png,image/gif'},
			callback:function(f){
				var json = WST.toAdminJson(f);
				if(json.status==1){
					$('#organizationCodeImgMsg').empty().hide();
					$('#organizationCodeImgPreview').attr('src',WST.conf.RESOURCE_PATH+"/"+json.savePath+json.thumb).show();
					$('#organizationCodeImgPreview_a').attr('href',WST.conf.RESOURCE_PATH+"/"+json.savePath+json.name);
					$('#organizationCodeImg').val(json.savePath+json.name);
					$('#msg_organizationCodeImg').hide();
				}
			},
			progress:function(rate){
				$('#organizationCodeImgMsg').show().html('已上传'+rate+"%");
			}
		});
}
function taxRegistrationCertificateUpload(){
	var uploader = WST.upload({
				pick:'#taxRegistrationCertificateImgPicker',
			    formData: {dir:'shops'},
				accept: {extensions: 'gif,jpg,jpeg,png',mimeTypes: 'image/jpg,image/jpeg,image/png,image/gif'},
				fileNumLimit:3,
				callback:function(f,file){
					var json = WST.toAdminJson(f);
					if(json.status==1){
					  	$('#taxRegistrationCertificateImgMsg').empty().hide();
					  	var tdiv = $("<div style='height:30px;float:left;margin:0px 5px;position:relative'><a target='_blank' href='"+WST.conf.RESOURCE_PATH+"/"+json.savePath+json.name+"'>"+
			                       "<img class='step_pic"+"' height='30' src='"+WST.conf.RESOURCE_PATH+"/"+json.savePath+json.thumb+"' v='"+json.savePath+json.name+"'></a></div>");
						var btn = $('<div style="position: absolute;top: -5px;right: 0px;cursor: pointer;background: rgba(0,0,0,0.5);width: 18px;height: 18px;text-align: center;border-radius: 50%;" ><img src="'+WST.conf.ROOT+'/wstmart/home/View/default/img/seller_icon_error.png"></div>');
						tdiv.append(btn);
						$('#taxRegistrationCertificateImgBox').append(tdiv);
						$('#msg_taxRegistrationCertificateImg').hide();
						var imgPath = [];
						$('.step_pic').each(function(){
			                imgPath.push($(this).attr('v'));
						});
			            $('#taxRegistrationCertificateImg').val(imgPath.join(','));
						btn.on('click','img',function(){
						    uploader.removeFile(file);
						    $(this).parent().parent().remove();
						    uploader.refresh();
						    if($('#taxRegistrationCertificateImgBox').children().size()<=0){
						         $('#msg_taxRegistrationCertificateImg').show();
						    }
						});
					}else{
					  		 WST.msg(json.msg,{icon:2});
					}
				},
				progress:function(rate){
					$('#taxRegistrationCertificateImgMsg').show().html('已上传'+rate+"%");
				}
			});
}
function taxpayerQualificationUpload(){
	WST.upload({
			pick:'#taxpayerQualificationImgPicker',
			formData: {dir:'shops'},
			accept: {extensions: 'gif,jpg,jpeg,png',mimeTypes: 'image/jpg,image/jpeg,image/png,image/gif'},
			callback:function(f){
				var json = WST.toAdminJson(f);
				if(json.status==1){
					$('#taxpayerQualificationImgMsg').empty().hide();
					$('#taxpayerQualificationImgPreview').attr('src',WST.conf.RESOURCE_PATH+"/"+json.savePath+json.thumb).show();
					$('#taxpayerQualificationImgPreview_a').attr('href',WST.conf.RESOURCE_PATH+"/"+json.savePath+json.name);
					$('#taxpayerQualificationImg').val(json.savePath+json.name);
					$('#msg_taxpayerQualificationImg').hide();
				}
			},
			progress:function(rate){
				$('#taxpayerQualificationImgMsg').show().html('已上传'+rate+"%");
			}
	});
}

function delVO(obj){
	$(obj).parent().remove();
	var selector = $(obj).attr('selector');
	var imgPath = [];
	$('.'+selector+'_step_pic').each(function(){
		imgPath.push($(this).attr('v'));
	});
	$('#'+selector).val(imgPath.join(','));
}
function toEdit(id,src){
	location.href=WST.U('admin/shops/toEdit','id='+id+'&p='+WST_CURR_PAGE+'&src='+src);
}
function toView(id,src){
	location.href=WST.U('admin/shops/toView','id='+id+'&p='+WST_CURR_PAGE+'&src='+src);
}
function toDel(id,type){
	var box = WST.confirm({content:"您确定要删除该店铺吗?",yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           $.post(WST.U('admin/shops/del'),{id:id},function(data,textStatus){
	           			  layer.close(loading);
	           			  var json = WST.toAdminJson(data);
	           			  if(json.status=='1'){
	           			    	WST.msg("操作成功",{icon:1});
	           			    	layer.close(box);
	           			    	if(type==1){
                                    loadGrid(WST_CURR_PAGE);
								}else{
                                    loadStopGrid(WST_CURR_PAGE)
								}

	           			  }else{
	           			    	WST.msg(json.msg,{icon:2});
	           			  }
	           		});
	            }});
}
function checkLoginKey(obj){
	if($.trim(obj.value)=='')return;
	var params = {key:obj.value,userId:0};
	var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
    $.post(WST.U('admin/users/checkLoginKey'),params,function(data,textStatus){
    	layer.close(loading);
    	var json = WST.toAdminJson(data);
    	if(json.status!='1'){
    		WST.msg(json.msg,{icon:2});
    		obj.value = '';
    	}
    });
}
function save(p,src){
	$('#editFrom').isValid(function(v){
		if(v){
			var params = WST.getParams('.ipt');
			var params = WST.getParams('.a-ipt');
            $("select[class^='j-']").each(function(idx,item){
                var fieldName = $(item).attr('data-name');
                params[fieldName] = WST.ITGetAreaVal('j-'+fieldName);
            });
			var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
		    $.post(WST.U('admin/shops/edit'),params,function(data,textStatus){
		    	layer.close(loading);
		    	var json = WST.toAdminJson(data);
		    	if(json.status=='1'){
		    		WST.msg("操作成功",{icon:1,time:1000},function(){
		    			if(params.shopStatus==1){
			    			location.href=WST.U('admin/shops/index','p='+p);
			    		}else{
                            location.href=WST.U('admin/shops/stopIndex','p='+p);
			    		}
		    		});

		    	}else{
		    		WST.msg(json.msg,{icon:2});
		    	}
		    });
		}
	});
}
function getUserByKey(){
	if($.trim($('#keyName').val())=='')return;
	$('#keyNameBox').html('');
	$('#shopUserId').val(0);
	var loading = WST.msg('正在查询用户信息...', {icon: 16,time:60000});
    $.post(WST.U('admin/users/getUserByKey'),{key:$('#keyName').val()},function(data,textStatus){
		layer.close(loading);
		var json = WST.toAdminJson(data);
		if(json.status=='1'){
		    $('#keyNameBox').html('用户：'+json.data.loginName);
		    $('#shopUserId').val(json.data.userId);
		}else{
		    WST.msg(json.msg,{icon:2});
		}
    });
}
function add(p,src){
	$('#editFrom').isValid(function(v){
		if(v){
			var params = WST.getParams('.a-ipt');
            $("select[class^='j-']").each(function(idx,item){
                var fieldName = $(item).attr('data-name');
                params[fieldName] = WST.ITGetAreaVal('j-'+fieldName);
            });
			var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
		    $.post(WST.U('admin/shops/add'),params,function(data,textStatus){
		    	layer.close(loading);
		    	var json = WST.toAdminJson(data);
		    	if(json.status=='1'){
		    		WST.msg("操作成功",{icon:1,time:1000},function(){
			    		location.href=WST.U('admin/shops/'+src,'p='+p);
		    		});
		    	}else{
		    		WST.msg(json.msg,{icon:2});
		    	}
		    });
		}
	});
}

function apply(p){
	$('#editFrom').isValid(function(v){
		if(v){
			var params = WST.getParams('.a-ipt');
            $("select[class^='j-']").each(function(idx,item){
                var fieldName = $(item).attr('data-name');
                params[fieldName] = WST.ITGetAreaVal('j-'+fieldName);
            });
			if(params.applyStatus==-1 && params.applyDesc==''){
				 WST.msg('请输入审核不通过原因!',{icon:2});
				 return;
			}
			var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
		    $.post(WST.U('admin/shops/handleApply'),params,function(data,textStatus){
		    	layer.close(loading);
		    	var json = WST.toAdminJson(data);
		    	if(json.status=='1'){
		    		WST.msg("操作成功",{icon:1,time:1000},function(){
			    		location.href=WST.U('admin/shops/apply',"p="+p);
		    		});
		    	}else{
		    		WST.msg(json.msg,{icon:2});
		    	}
		    });
		}
	});
}
function initTime($id,val){
	var html = [],t0,t1;
	var str = val.split(':');
	for(var i=0;i<24;i++){
		t0 = (val.indexOf(':00')>-1 && (parseInt(str[0],10)==i))?'selected':'';
		t1 = (val.indexOf(':30')>-1 && (parseInt(str[0],10)==i))?'selected':'';
		html.push('<option value="'+i+':00" '+t0+'>'+i+':00</option>');
		html.push('<option value="'+i+':30" '+t1+'>'+i+':30</option>');
	}
	$($id).append(html.join(''));
}
var container,map,label,marker,mapLevel = 15;
function initQQMap(longitude,latitude,mapLevel){
    var container = document.getElementById("container");
    mapLevel = WST.blank(mapLevel,13);
    var mapopts,center = null;
    mapopts = {zoom: parseInt(mapLevel)};
	map = new qq.maps.Map(container, mapopts);
	if(WST.blank(longitude)=='' || WST.blank(latitude)==''){
		var cityservice = new qq.maps.CityService({
		    complete: function (result) {
		        map.setCenter(result.detail.latLng);
		    }
		});
		cityservice.searchLocalCity();
	}else{
        marker = new qq.maps.Marker({
            position:new qq.maps.LatLng(latitude,longitude),
            map:map
        });
        map.panTo(new qq.maps.LatLng(latitude,longitude));
	}
	var url3;
	qq.maps.event.addListener(map, "click", function (e) {
		if(marker)marker.setMap(null);
		marker = new qq.maps.Marker({
            position:e.latLng,
            map:map
        });
	    $('#latitude').val(e.latLng.getLat().toFixed(6));
	    $('#longitude').val(e.latLng.getLng().toFixed(6));
	    url3 = encodeURI(window.conf.__HTTP__+'apis.map.qq.com/ws/geocoder/v1/?location=' + e.latLng.getLat() + "," + e.latLng.getLng() + "&key="+window.conf.MAP_KEY+"&output=jsonp&&callback=?");
	    $.getJSON(url3, function (result) {
	        if(result.result!=undefined){
	            document.getElementById("shopAddress").value = result.result.address;
	        }else{
	            document.getElementById("shopAddress").value = "";
	        }

	    })
	});
	qq.maps.event.addListener(map,'zoom_changed',function() {
        $('#mapLevel').val(map.getZoom());
    });
}
function mapCity(obj){
    var citys = [];
    $('.j-'+$(obj).attr('data-name')).each(function(){
        citys.push($(this).find('option:selected').text());
    })
    if(citys.length==0)return;
    var url2 = encodeURI(window.conf.__HTTP__+'apis.map.qq.com/ws/geocoder/v1/?region=' + citys.join('') + "&address=" + citys.join('') + "&key="+window.conf.MAP_KEY+"&output=jsonp&&callback=?");
    $.getJSON(url2, function (result) {
        if(result.result.location){
            map.setCenter(new qq.maps.LatLng(result.result.location.lat, result.result.location.lng));
            map.setZoom(mapLevel);
        }
    });
}

/**********移动端商家申请*************/
function initApplyGrid2(p){
	var tbHeight = $('.wst-toolbar2').outerHeight(true)+$('.layui-tab-title').outerHeight(true)+45;
	var h = 'full-'+tbHeight;
	mmg2 = layui.table;
	mmg2.render({elem: '#mmg2',id:'dataTable2',url:WST.U('admin/shopapplys/pageQuery'),cellMinWidth: 80,height: h,skin: 'line',even: true,limit:20,page:{curr:p},
		cols: [[
			{title:'#',type:'numbers'},
			{title:'申请账号', field:'loginName', templet: function(item){
				return WST.blank(item['userName'])+"【"+item['loginName']+"】";
			}},
			{title:'申请人', field:'linkman'},
			{title:'联系电话', field:'linkPhone'},
			{title:'营业范围', field:'applyIntention',templet: function(item){return '<div title="'+item['applyIntention']+'">'+item['applyIntention']+'</div>'}},
			{title:'申请日期', field:'createTime', width: 200},
			{title:'申请状态', field:'applyStatus', templet: function(item){
				if(item['applyStatus']==1){
					return "<span class='statu-yes'><i class='fa fa-check-circle'></i> 申请通过</span>";
				}else if(item['applyStatus']==-1){
					return "<span class='statu-no'><i class='fa fa-ban'></i> 申请失败</span>";
				}else{
					return "<span class='statu-wait'><i class='fa fa-clock-o'></i>待处理</span>"
				}
			}},
			{title:'店铺名称', field:'shopName'},
			{title:'操作', field:'' , fixed: 'right', width:200, align:'center', templet: function(item){
				return '<a data-id="'+item['id']+'" class="btn btn-blue btngroup btn'+item['id']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
			}}
		]],
		done: function(res, curr, count){
			var e = this;
			var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
			if(count>0 && curr>total_page){
				loadApplyGrid2(total_page);
				return;
			}
			WST_CURR_PAGE = curr;
			var btns = [];
			for(var i=0;i<res.data.length;i++){
				btns = [];
				btns.push({title: '查看',clickFun:"toView2", cls:"btn-blue", icon:"fa fa-search"});
				if(res.data[i]['applyStatus'] == 0 && WST.GRANT.DPSQ_04){
					btns.push({title: '处理',clickFun:"toEditApply2", cls:"btn-blue", icon:"fa-pencil"});
				}
				if(WST.GRANT.DPSQ_03)btns.push({title: '删除',clickFun:"toDelApply2", cls:"btn-red", icon:"fa-trash-o"});
				layui.dropdown.render({
					elem: '.btn'+res.data[i].id,
					dataId:res.data[i].id,
					trigger: 'hover',
					data: btns,
					click: function(obj,othis){
						var _fn = window[obj.clickFun];
						if($(this.elem).data('fun-'+obj.clickFun)){
							_fn && eval(obj.clickFun+'('+$(this.elem).data('fun-'+obj.clickFun)+')');
						}else{
							_fn && _fn($(this.elem).data('id'));
						}
					}
				});
			}
		}
	});
}
function loadApplyGrid2(p){
	p=(p<=1)?1:p;
	var params = WST.getParams('.ja-ipt');
	mmg2.reload('dataTable2',{where:params,page:{curr:p}});
}
function toEditApply2(id){
	var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
    $.post(WST.U('admin/shopapplys/getById'),{id:id},function(data,textStatus){
        layer.close(loading);
        var json = WST.toAdminJson(data);
        if(json.id){
        	$('#applyStatus0').attr('checked',false);
        	$('#applyStatus1').attr('checked',false);
        	$('.applyStatusTr0').css('display','none');
        	$('.applyStatusTr1').css('display','none');
        	layui.form.render('radio','applyStatusBox');
        	layui.form.on('radio(applyStatus)', function(data){
			    WST.showHide((data.value==1)?0:1,'.applyStatusTr0');
			    WST.showHide((data.value==1)?1:0,'.applyStatusTr1');
			});
        	$('#loginName').html(WST.blank(json['userName'])+"【"+json['loginName']+"】");
        	$('#linkman').html(json.linkman);
        	$('#linkPhone').html(json.linkPhone);
        	$('#applyIntention').html(json.applyIntention);
           	var box = WST.open({title:'商家入驻申请',type:1,content:$('#applyBox'),area: ['600px', '560px'],btn: ['确定','取消'],yes:function(){
			    $('#applyForm').isValid(function(v){
                    if(v){
						var params = WST.getParams('.eipt');
						params.id = id;
						var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
						$.post(WST.U('admin/shopapplys/handleApply'),params,function(data,textStatus){
						   	layer.close(loading);
						   	var json = WST.toAdminJson(data);
						   	if(json.status=='1'){
						   		WST.msg("操作成功",{icon:1});
						   		$('#applyBox').hide();
						   		$('#applyForm')[0].reset();
						   		layer.close(box);
				                loadApplyGrid2(WST_CURR_PAGE)
						   	}else{
						   		WST.msg(json.msg,{icon:2});
						   	}
						});
				    }
		        });
	        },cancel:function(){$('#applyBox').hide();},end:function(){$('#applyBox').hide();}});
        }else{
            WST.msg(json.msg,{icon:2});
        }
    });
}
function toView2(id){
	var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
    $.post(WST.U('admin/shopapplys/getById'),{id:id},function(data,textStatus){
        layer.close(loading);
        var json = WST.toAdminJson(data);
        if(json.id){
        	$('#vloginName').html(WST.blank(json['userName'])+"【"+json['loginName']+"】");
        	$('#vlinkman').html(json.linkman);
        	$('#vlinkPhone').html(json.linkPhone);
        	$('#vapplyIntention').html(json.applyIntention);
        	$('#vapplyStatus').html((json.applyStatus=='0')?"待审核":((json.applyStatus=='1')?"申请通过":"申请失败"));
        	if(json.applyStatus==0){
               WST.showHide(0,'.vapplyStatusTr0,.vapplyStatusTr1');
        	}else{
	        	WST.showHide((json.applyStatus==1)?0:1,'.vapplyStatusTr0');
	        	WST.showHide((json.applyStatus==1)?1:0,'.vapplyStatusTr1');
        	}
        	$('#vhandleReamrk').html(json.handleReamrk);
        	$('#vshopName').html(json.shopName);
           	var box = WST.open({title:'商家入驻申请',type:1,content:$('#applyBox2'),area: ['600px', '500px'],end:function(){$('#applyBox2').hide();}});
        }else{
            WST.msg(json.msg,{icon:2});
        }
    });
}
function toDelApply2(id){
  var msg = "您确定要删除该记录吗?";
	var box = WST.confirm({content:msg,yes:function(){
	           var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
	           	$.post(WST.U('admin/shopapplys/del'),{id:id},function(data,textStatus){
	           		layer.close(loading);
	           		var json = WST.toAdminJson(data);
	           		if(json.status=='1'){
	           			WST.msg("操作成功",{icon:1});
	           			   layer.close(box);
	           		       loadApplyGrid2(WST_CURR_PAGE);
	           			}else{
	           			   WST.msg(json.msg,{icon:2});
	           			}
	           		});
	}});
}



function calculateRate(obj){
    var catId = $(obj).data('catid');
    var commissionRate = parseFloat($(obj).val(),10)?parseFloat($(obj).val(),10):0;
    if(commissionRate>90 || commissionRate<0){
        WST.msg('佣金比例不超过90%');
        $(obj).val('');
        return;
    }else if(commissionRate<0){
        WST.msg('佣金比例不小于0%');
        $(obj).val('');
        return;
    }
}
function checkGoodsCat(obj){
    var catId = $(obj).val();
    if($(obj).prop('checked')){
        if(!($("#vipTr_"+catId).length>0)){
            var catName = $(obj).data('catname');
            var commissionRate = $(obj).data('commissionrate');
            var html = [];
            html.push('<tr id="vipTr_'+catId+'">');
                html.push('<th width="170">'+catName+'<font color="red">*</font>：</th>');
                html.push('<td height="23">');
                    html.push('<input class="a-ipt" type="text" id="commissionRate_'+catId+'" value="'+commissionRate+'" maxLength="10" data-rule="佣金比例:required;" data-target="#vipRate_msg_'+catId+'" data-catid="'+catId+'" onblur="javascript:WST.limitDecimal(this,2);calculateRate(this)" onkeypress="return WST.isNumberdoteKey(event)" onkeyup="javascript:WST.isChinese(this,1)" placeholder="佣金比例" style="width: 80px">%');
                    html.push('<span id="vipRate_msg_'+catId+'"></span>');
                html.push('</td>');
            html.push('</tr>');
            $("#vipTbody").append(html.join(""));
        }
    }else{
        if($("#vipTr_"+catId).length>0){
            $("#vipTr_"+catId).remove();
        }
    }
}
