var mmg;
function initGrid(p){
    mmg = layui.table;
    mmg.render({elem: '#mmg',id:'dataTable',url:WST.U('admin/shopflows/fieldPageQuery',{fId:$('#fId').val()}),cellMinWidth: 80,height: WST.initGridHeight(),skin: 'line',even: true,limit:20,page:{curr:p},
        cols: [[
            {title:'#',type:'numbers'},
            {title:'表单字段', field:'fieldName'},
            {title:'数据类型', field:'dataType',width:100},
            {title:'表单标题', field:'fieldTitle'},
            {title:'数据长度', field:'dataLength',width:100},
            {title:'表现形式', field:'fieldType'},
            {title:'表单属性', field:'fieldAttr',templet: function(item){
                var h = '';
                var fieldType = item['fieldType'];
                switch(fieldType){
                    case 'input':
                        h = "表单长度："+item['fieldAttr'];
                        break;
                    case 'textarea':
                        h = "行数以及列数："+item['fieldAttr'];
                        break;
                    case 'radio':
                        h = "单选按钮名称："+item['fieldAttr'];
                        break;
                    case 'checkbox':
                        h = "多选按钮名称："+item['fieldAttr'];
                        break;
                    case 'select':
                        h = "下拉菜单值："+item['fieldAttr'];
                        break;
                    case 'other':
                        h = "";
                        break;
                }
                return h;
            }},
            {title:'表单注释', field:'fieldComment'},
            {title:'排序', field:'fieldSort',width:80 },
            {title:'是否必填', field:'isRequire' ,width:120,templet: function(item){
                var h = '';
                item['isRequire'] == 0 ? h = "" : h = "<span class='statu-yes'><i class='fa fa-check-circle'></i> 是</span>";
                return h;
            }},
            {title:'操作', field:'' , fixed: 'right', width:200, align:'center', templet: function(item){
                return '<a data-id="'+item['id']+'" class="btn btn-blue btngroup btn'+item['id']+'"><i class="fa fa-cog"></i>操作 <i class="layui-icon layui-icon-down layui-font-12"></i></a>';
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
                btns.push({title: '修改',clickFun:"getForEdit", cls:"btn-blue", icon:"fa-pencil"});
                if(res.data[i]['isDelete']==1)btns.push({title: '删除',clickFun:"toDel", cls:"btn-red", icon:"fa fa-trash-o"});
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
function loadGrid(p){
    var params = {};
    params.fId = $('#fId').val();
    params.fieldName = $('.fieldName').val();
    params.dataType = $(".dataType").val();
    params.fieldTitle = $('.fieldTitle').val();
    params.isRequire = $('.isRequire').val();
    params.fieldType = $('.fieldType').val();
    mmg.reload('dataTable',{where:params,page:{curr:p}});
}

function getForEdit(id){
    if(id!=0){
        var loading = WST.msg('正在获取数据，请稍后...', {icon: 16,time:60000});
        $.post(WST.U('admin/shopflows/getFieldById'),{id:id},function(data,textStatus){
            layer.close(loading);
            var json = WST.toAdminJson(data);
            if(json.id){
                WST.setValues(json);
                var text = '';
                var html = '';
                console.log("json:",json);
                if(json.isDelete == 0){
                    $('#fieldName').attr('readonly',true).css('background','#eee');
                    $('#dataType').attr('disabled',true).css('background','#eee');
                    $('#dataLength').attr('readonly',true).css('background','#eee');
                    $('#isShow').attr('disabled',true).css('background','#eee');
                }else{
                    $('#fieldName').attr('readonly',false).css('background','#fff');
                    $('#dataType').attr('disabled',false).css('background','#fff');
                    $('#dataLength').attr('readonly',false).css('background','#fff');
                    $('#isShow').attr('disabled',false).css('background','#fff');
                }
                // 当表单属性是系统预设的值，则不允许修改表单类型、表单属性、是否必填
                if(json.fieldAttr == 'custom') {
                    $('#fieldType').attr('disabled',true).css('background','#eee');
                    $('#isRequire').attr('disabled',true).css('background','#eee');
                    $('#fieldAttr').attr('readonly',true).css('background','#eee');
                }else{
                    $('#fieldType').attr('disabled',false).css('background','#fff');
                    $('#isRequire').attr('disabled',false).css('background','#fff');
                    $('#fieldAttr').attr('readonly',false).css('background','#fff');
                }
                switch(json.dataType) {
                    case 'date':
                        $('.dataLength').hide();
                        $('#dataLength').val(20);
                        break;
                    case 'time':
                        $('.dataLength').hide();
                        $('#dataLength').val(20);
                        break;
                    default:
                        $('.dataLength').show();
                        $('#dataLength').val(json.dataLength);
                        break;
                }
                $('.fieldRelevance').hide();
                $('.dateRelevance').hide();
                $('.timeRelevance').hide();
                $('.fileNum').hide();
                switch(json.fieldType){
                    case 'input':
                        text = "表单长度<font color='red'>*</font>：";
                        break;
                    case 'textarea':
                        text = "行数以及列数<font color='red'>*</font>：";
                        break;
                    case 'radio':
                        text = "单选按钮名称<font color='red'>*</font>：";
                        //$('.fieldRelevance').show();
                        break;
                    case 'checkbox':
                        text = "多选按钮名称<font color='red'>*</font>：";
                        break;
                    case 'select':
                        text = "下拉菜单值<font color='red'>*</font>：";
                        break;
                    case 'other':
                        var areaCheck = '';
                        var dateCheck = '';
                        var timeCheck = '';
                        var fileCheck = '';
                        switch(json.fieldAttr) {
                            case 'area':
                                areaCheck = 'selected';
                                break;
                            case 'date':
                                dateCheck = 'selected';
                                $('.dateRelevance').show();
                                $('.isShow').show();
                                break;
                            case 'time':
                                timeCheck = 'selected';
                                $('.timeRelevance').show();
                                $('.isShow').show();
                                break;
                            case 'file':
                                fileCheck = 'selected';
                                $('.fileNum').show();
                                break;
                        }
                        text = "选择类型：";
                        html += "<select id='fieldAttr' name='fieldAttr' class='ipt' style='width:70%;padding-left:10px;' onchange='changeFieldAttrType(this)'>";
                        html += "<option value='area' "+areaCheck+">地区类型</option>";
                        html += "<option value='date' "+dateCheck+">日期类型</option>";
                        html += "<option value='time' "+timeCheck+">时间类型</option>";
                        html += "<option value='file' "+fileCheck+">文件上传</option>";
                        html += "</select>";
                        $('.fieldAttr').html(html);
                        break;
                }
                $('.fieldAttrTitle').html(text);
                toEdit(json.id);
            }else{
                WST.msg(json.msg,{icon:2});
            }
        });
    }else{
        $('#id').val('');
        $('#flowId').val($('#fId').val());
        $('#fieldName').attr('readonly',false).css('background','#fff');
        $('#dataType').attr('disabled',false).css('background','#fff');
        $('#dataLength').attr('readonly',false).css('background','#fff');
        $('#isShow').attr('disabled',false).css('background','#fff');
        $('#fieldType').attr('disabled',false).css('background','#fff');
        $('#isRequire').attr('disabled',false).css('background','#fff');
        $('#fieldAttr').attr('readonly',false).css('background','#fff');
        $('.dateRelevance').hide();
        $('.timeRelevance').hide();
        $('.fileNum').hide();
        //$('.fieldRelevance').hide();
        toEdit(0);
    }
}

function toEdit(id){
    var text = "<span>表单长度<font color='red'>*</font>：<span>";
    var html = "<input type='text'  id='fieldAttr' name='fieldAttr'  style='width:70%;' class='ipt' value='' data-rule='表单属性:required;'  data-msg-required='请填写表单属性' data-target='#fieldAttrMsg'/><span id='fieldAttrMsg'></span>";
    var title =(id==0)?"新增":"编辑";
    var obj = $('#fieldBox');
    var box =WST.open({title:title,type:1,offset:'0px',content:obj,area: [WST.pageWidth()+'px',WST.pageHeight()+'px'],btn: ['确定','取消'],yes:function(){
        $('#fieldForm').isValid(function(v) {
            if (v) {
                var params = WST.getParams('.ipt');
                var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
                $.post(WST.U('admin/shopflows/saveField'),params,function(data,textStatus){
                    layer.close(loading);
                    var json = WST.toAdminJson(data);
                    if(json.status=='1'){
                        WST.msg(json.msg,{icon:1});
                        $('#fieldForm')[0].reset();
                        $('.fieldAttr').html(html);
                        $('.fieldAttrTitle').html(text);
                        layer.close(box);
                        loadGrid(WST_CURR_PAGE);
                    }else{
                        WST.msg(json.msg,{icon:2});
                    }
                });
            }
        });
    },cancel:function(){
        //重置表单
        $('#fieldForm')[0].reset();
        $('.fieldAttr').html(html);
        $('.fieldAttrTitle').html(text);
    },end:function(){
        $('#fieldBox').hide();
        //重置表单
        $('#fieldForm')[0].reset();
        $('.fieldAttr').html(html);
        $('.fieldAttrTitle').html(text);
    }});
}

function changeDataType(obj) {
    var dataType = $(obj).val();
    switch(dataType) {
        case 'date':
            $('.dataLength').hide();
            $('#dataLength').val(20);
            break;
        case 'time':
            $('.dataLength').hide();
            $('#dataLength').val(20);
            break;
        default:
            $('.dataLength').show();
            $('#dataLength').val('');
            break;
    }
}

function changeFieldAttrType(obj) {
    var fieldAttrType = $(obj).val();
    switch(fieldAttrType) {
        case 'date':
            $('.dateRelevance').show();
            $('.timeRelevance').hide();
            $('.fileNum').hide();
            break;
        case 'time':
            $('.timeRelevance').show();
            $('.dateRelevance').hide();
            $('.fileNum').hide();
            break;
        case 'file':
            $('.fileNum').show();
            $('.dateRelevance').hide();
            $('.timeRelevance').hide();
            break;
        default:
            $('.dateRelevance').hide();
            $('.timeRelevance').hide();
            $('.fileNum').hide();
            break;
    }
}

function changeFieldType(obj){
    var fieldType = $(obj).val();
    $('.fieldAttr').html('');
    //$('.fieldRelevance').hide();
    $('.dateRelevance').hide();
    $('.timeRelevance').hide();
    $('.fileNum').hide();
    var html = '';
    var text = '';
    switch(fieldType){
        case 'input':
            text = "<span>表单长度<font color='red'>*</font>：<span>";
            html = "<input type='text'  id='fieldAttr' name='fieldAttr'  style='width:70%;' class='ipt' value='' data-rule='表单属性:required;'  data-msg-required='请填写表单属性' data-target='#fieldAttrMsg'/><span id='fieldAttrMsg'></span>";
            break;
        case 'textarea':
            text = "<span>行数以及列数<font color='red'>*</font>：<span>";
            html = "<input type='text'  id='fieldAttr' name='fieldAttr' placeholder='行数列数以,分隔。例如：行数,列数' style='width:70%;' class='ipt' value='' data-rule='表单属性:required;'  data-msg-required='请填写表单属性' data-target='#fieldAttrMsg'/><span id='fieldAttrMsg'></span>";
            break;
        case 'radio':
            text = "<span>单选按钮名称<font color='red'>*</font>：<span>";
            html = "<input type='text'  id='fieldAttr' name='fieldAttr' placeholder='格式：值||内容，以,分隔' style='width:70%;' class='ipt' value='' data-rule='表单属性:required;'  data-msg-required='请填写表单属性' data-target='#fieldAttrMsg'/><span id='fieldAttrMsg'></span>";
            //$('.fieldRelevance').show();
            break;
        case 'checkbox':
            text = "<span>多选按钮名称<font color='red'>*</font>：<span>";
            html = "<input type='text'  id='fieldAttr' name='fieldAttr' placeholder='格式：值||内容，以,分隔' style='width:70%;' class='ipt' value='' data-rule='表单属性:required;'  data-msg-required='请填写表单属性' data-target='#fieldAttrMsg'/><span id='fieldAttrMsg'></span>";
            break;
        case 'select':
            text = "<span>下拉菜单值<font color='red'>*</font>：<span>";
            html = "<input type='text'  id='fieldAttr' name='fieldAttr' placeholder='格式：值||内容，以,分隔' style='width:70%;' class='ipt' value='' data-rule='表单属性:required;'  data-msg-required='请填写表单属性' data-target='#fieldAttrMsg'/><span id='fieldAttrMsg'></span>";
            break;
        case 'other':
            text = "<span>选择类型&nbsp;：<span>";
            html += "<select id='fieldAttr' name='fieldAttr' class='ipt' style='width:70%;padding-left:10px;' onchange='changeFieldAttrType(this)'>";
            html += "<option value='area' >地区类型</option>";
            html += "<option value='date' >日期类型</option>";
            html += "<option value='time' >时间类型</option>";
            html += "<option value='file' >文件上传</option>";
            html += "</select>";
            break;
    }
    $('.fieldAttr').html(html);
    $('.fieldAttrTitle').html(text);
}

function toDel(id){
    var box = WST.confirm({content:"您确定要删除该字段吗?",yes:function(){
        var loading = WST.msg('正在提交数据，请稍后...', {icon: 16,time:60000});
        $.post(WST.U('admin/shopflows/delField'),{id:id},function(data,textStatus){
            layer.close(loading);
            var json = WST.toAdminJson(data);
            if(json.status=='1'){
                WST.msg("操作成功",{icon:1});
                layer.close(box);
                loadGrid(WST_CURR_PAGE)
            }else{
                WST.msg(json.msg,{icon:2});
            }
        });
    }});
}
