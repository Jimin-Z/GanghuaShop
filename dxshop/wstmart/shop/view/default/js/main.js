var myChart;
$(function(){
	var laydate = layui.laydate;
	laydate.render({
	    elem: '#startDate'
	});
	laydate.render({
	    elem: '#endDate'
	});
    loadStat();
    loadStat1();
})

function loadStat(){
	$.post(WST.U('shop/reports/getNewUser'),WST.getParams('.ipt'),function(data,textStatus){
	    var json = WST.toJson(data);
        myChart = echarts.init(document.getElementById('main'));
        myChart.clear();
	    if(json.status=='1'){
			var option = {     
			    tooltip: {
			        trigger: 'axis'
			    },
			    legend: {
			        data:['新增会员']
			    },
			    toolbox: {
			        show : true,
			        feature : {
			            mark : {show: true},
			            dataView : {show: false, readOnly: false},
			            magicType : {show: true, type: ['line', 'bar', 'tiled']},
			            restore : {show: true},
			            saveAsImage : {show: true}
			        }
			    },
			    xAxis: {
			        type: 'category',
			        boundaryGap: false,
			        data: json.data.days
			    },
			    yAxis: {
			        type: 'value'
			    },
			    series: [
			        {
			            name:'新增会员',
			            type:'line',
			            data:json.data.u0
			        }
			    ]
			};
                    
			myChart.setOption(option);
			window.onresize = myChart.resize
	    }
	});  
}
function loadStat1(){
	$.post(WST.U('shop/reports/getOrders'),WST.getParams('.ipt'),function(data,textStatus){
	    var json = WST.toJson(data);
	    var myChart1 = echarts.init(document.getElementById('main1'));
	    myChart1.clear();
	    if(json.status=='1' && json.data){
			var option = {
			    tooltip : {
			        trigger: 'axis'
			    },
			    toolbox: {
			        show : true,
			        y: 'top',
			        feature : {
			            mark : {show: true},
			            dataView : {show: false, readOnly: false},
			            magicType : {show: true, type: ['line', 'bar', 'tiled']},
			            restore : {show: true},
			            saveAsImage : {show: true}
			        }
			    },
			    calculable : true,
			    legend: {
			        data:['总订单']
			    },
			    xAxis : [
			        {
			            type : 'category',
			            splitLine : {show : false},
			            data : json.data.days
			        }
			    ],
			    yAxis : [
			        {
			            type : 'value',
			            position: 'right'
			        }
			    ],
			    series : [
			        {
			            name:'总订单',
			            type:'line',
			            data:json.data['total']
			        }
			    ]
			};       
			myChart1.setOption(option);
			window.onresize = myChart1.resize
	    }else{
	    }

	});  
}