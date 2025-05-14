var mmg;
function loadStat(){
    var loading = WST.load({msg:'正在查询数据，请稍后...'});
	$.post(WST.U('shop/reports/getStatCarts'),WST.getParams('.j-ipt'),function(data,textStatus){
	    layer.close(loading);
	    var json = WST.toJson(data);
	    var myChart = echarts.init(document.getElementById('main'));
	    myChart.clear();
	    $('#mainTable').addClass('hide');
	    if(json.status=='1' && json.data){
	    	var data = json.data.data;
			var option1 = {
				title: {
					text: '商品加购统计',
					left: 'center'
				},
				tooltip: {
					trigger: 'axis',
				},
				legend: {
					data:['加购数量']
				},
				color:['#6699ff'],
				toolbox: {
					show : true,
					feature : {
						mark : {show: true},
						dataView : {show: false, readOnly: false},
						magicType : {show: true, type: ['line','bar' ]},
						restore : {show: true},
						saveAsImage : {show: true}
					}
				},
				xAxis: {
					type: 'category',
					//boundaryGap: false,
					data: data.days,
					axisLabel: {
						interval:0,
						rotate:320,
					} ,
				},
				yAxis: [
					{
						type: 'value',
						name:'加购数量',
						axisLabel: {
							show: true,
							interval: 'auto',
							formatter: '{value} '
						},
					}
				],
				series: [
					{
						name:'',
						type:'line',
						barWidth:15,
						yAxisIndex: 0,
						data:data.cartNums
					}
				]
			};
			myChart.setOption(option1,true);
	    }else{
	    	WST.msg('没有查询到记录',{icon:5});
	    }
	});
}


function getStatCartGoods(){
	mmg = layui.table;
	mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('shop/reports/getStatCartGoods'),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:true,
		cols: [[
			{title:'#',type:'numbers'},
			{type: 'checkbox', field:'cartId'},
			{title:'加购日期', field:'createTime',width: 200},
			{title:'用户帐号', field:'loginName',width: 200},
			{title:'商品图片', field:'goodsName', width: 100, templet: function(item){
				var thumb = item['goodsImg'];
				thumb = thumb.replace('.','_thumb.');
				return "<span class='weixin'><a style='color:blue' href='javascript:toDetail("+ item['goodsId']+",\""+item['verfiycode']+"\")'><img id='img' onmouseout='toolTip()' onmouseover='toolTip()' style='height:50px;' src='"+WST.conf.RESOURCE_PATH+"/"+thumb
					+"'></a><span class='imged' ><img  style='height:180px;width:180px;' src='"+WST.conf.RESOURCE_PATH+"/"+item['goodsImg']+"'></span></span>";
			}},
			{title:'商品名称', field:'goodsName', templet: function(item){
				var specNames = "";
				if(item['specNames']){
					specNames = "<div><span  style='background: #ddd;border-radius: 100px;padding: 2px 6px'>"+item['specNames']+"</span></div>"
				}
				return "<a style='color:#666' href='javascript:toDetail("+ item['goodsId']+",\""+item['verfiycode']+"\")'>"+item['goodsName']+specNames+"</a> ";

			}},
			{title:'商品编号', field:'goodsSn', width: 200},
			{title:'加购数量', field:'cartNum', width: 50}
		]],
		done: function(res, curr, count){
			var e = this;
			var total_page = (count%e.limit==0)?Math.round(count/e.limit):Math.round(count/e.limit)+1;
			if(count>0 && curr>total_page){
				loadGrid(total_page);
				return;
			}
		}
	});
}
function loadGrid(p){
	p = (p<=1)?1:p;
	mmg.reload('dataTable',{page:{curr:p},where:{startDate:$('#startDate').val(),endDate:$('#endDate').val(),goodsName:$('#goodsName').val()}});
}
function toDetail(goodsId,key){
	window.open(WST.U('home/goods/detail','goodsId='+goodsId+"&key="+key));
}
function toolTip(){
	WST.toolTip();
}
