var isShopUploadinit = false;
function toEdit(type){
	$('#einfo_'+type).show();
	$('#vinfo_'+type).hide();
	$('#einfo_'+type).removeClass('hide');
	if(type==1){
		var areaIdPath = $('#areaIdPath1').val().split("_");
		$('#areaIdPath_0').val(areaIdPath[0]);
		var aopts = {id:'areaIdPath_0',val:areaIdPath[0],childIds:areaIdPath,className:'j-areaIdPath'}
		WST.ITSetAreas(aopts);
    }else{
    	var areaIdPath = $('#areaIdPath2').val().split("_");
		$('#bankAreaIdPath_0').val(areaIdPath[0]);
		var aopts = {id:'bankAreaIdPath_0',val:areaIdPath[0],childIds:areaIdPath,className:'j-bankAreaIdPath'}
		WST.ITSetAreas(aopts);
    }
    if(!isShopUploadinit){
    	isShopUploadinit = true;
    	WST.upload({
	  	  pick:'#shopImgPicker',
	  	  formData: {dir:'shops',isThumb:1},
	  	  accept: {extensions: 'gif,jpg,jpeg,png',mimeTypes: 'image/jpg,image/jpeg,image/png,image/gif'},
	  	  callback:function(f){
	  		  var json = WST.toJson(f);
	  		  if(json.status==1){
	  			$('#uploadMsg').empty().hide();
	            $('#preview').attr('src',WST.conf.RESOURCE_PATH+"/"+json.savePath+json.thumb);
	            $('#shopImg').val(json.savePath+json.name);
	  		  }
		  },
		  progress:function(rate){
		      $('#uploadMsg').show().html('已上传'+rate+"%");
		  }
	    });
	    initTime('#serviceStartTime',$('#serviceStartTime').attr('v'));
	    initTime('#serviceEndTime',$('#serviceEndTime').attr('v'));
    }
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
function toCancel(type){
	$('#einfo_'+type).hide();
	$('#vinfo_'+type).show();
}

function editInfo(){
	$('#editFrom_1').isValid(function(v){
		if(v){
			var params = WST.getParams('.ipt_1');
			params.areaId = WST.ITGetAreaVal('j-areaIdPath');
			var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});


			params.areaIdPath = WST.ITGetAllAreaVals('areaIdPath_0','j-areaIdPath').join('_');
			params.areaId = WST.ITGetAreaVal('j-areaIdPath');
			if(params.areaIdPath==''){
				WST.msg('请选择店铺地址',{icon:2});
				return;
			}
			$.post(WST.U('shop/shops/editShopInfoByShop'),params,function(data,textStatus){
		    	layer.close(loading);
		    	var json = WST.toJson(data);
		    	if(json.status=='1'){
		    		WST.msg('操作成功',{icon:1},function(){
		    			location.reload();
		    		});
		    	}else{
		    		WST.msg(json.msg,{icon:2});
		    	}
		    });


		}
	});
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


function editBankInfo(){
	$('#editFrom_2').isValid(function(v){
		if(v){
			var params = WST.getParams('.ipt_2');
			var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
			params.bankAreaIdPath = WST.ITGetAllAreaVals('bankAreaIdPath_0','j-bankAreaIdPath').join('_');
			params.bankAreaId = WST.ITGetAreaVal('j-bankAreaIdPath');
			if(params.bankAreaIdPath==''){
				WST.msg('请选择开卡地区',{icon:2});
				return;
			}
		    $.post(WST.U('shop/shops/editShopBankInfoByShop'),params,function(data,textStatus){
		    	layer.close(loading);
		    	var json = WST.toJson(data);
		    	if(json.status=='1'){
		    		WST.msg('操作成功',{icon:1},function(){
		    			location.reload();
		    		});
		    	}else{
		    		WST.msg(json.msg,{icon:2});
		    	}
		    });
		}
	});
}