/**
 * 获取用户信息
 */
WST.getSysMessages = function(val){
  $.post(WST.U('admin/index/getSysMessages'),{tasks:val},function(data){
    var json = WST.toAdminJson(data);
    var totalNum = 0
        if(json.status==1){
            for(var key in json.data){
                $('#m-'+key).hide();
                if(json.data[key] && parseInt(json.data[key],10)>0){
                    $('#m-'+key).show();
                    $('#m-'+key+' span').html(json.data[key]);
                    totalNum += parseInt(json.data[key],10);
                }
            }
        }
    if(totalNum>0){
      $('.msg-num').show();
      $('.msg-num').addClass('layui-badge');
    }else{
      $('.msg-num').removeClass('layui-badge');
      $('.msg-num').hide();
    }
    $('.msg-num').html(totalNum);
  });
}
function logout() {
    var a = WST.msg("正在退出系统...", {
        icon: 16,
        time: 60000,
        offset: "200px"
    });
    $.post(WST.U("admin/index/logout"), {},
    function(c, d) {
        layer.close(a);
        var b = WST.toAdminJson(c);
        if (b.status == "1") {
            WST.msg(b.msg, {
                icon: 1,
                offset: "200px"
            },
            function() {
                location.href = WST.U("admin/index/login")
            })
        } else {
            WST.msg(b.msg, {
                icon: 2,
                offset: "200px"
            })
        }
    })
}
function clearCache() {
    var a = WST.msg("正在清除服务器缓存...", {
        icon: 16,
        time: 60000,
        offset: "200px"
    });
    $.post(WST.U("admin/index/clearCache"), {},
    function(c, d) {
        layer.close(a);
        var b = WST.toAdminJson(c);
        if (b.status == "1") {
            WST.msg(b.msg, {
                icon: 1,
                offset: "200px"
            })
        } else {
            WST.msg(b.msg, {
                icon: 2,
                offset: "200px"
            })
        }
    })
}
function editPassBox() {
    var a = WST.open({
        type: 1,
        title: "修改密码",
        shade: [0.6, "#000"],
        border: [0],
        content: $("#editPassBox"),
        area: ["480px", "320px"],
        btn: ["确定", "取消"],
        yes: function(c, b) {
            $("#editPassFrom").isValid(function(d) {
                if (d) {
                    var f = WST.getParams(".ipt");
                    var e = WST.msg("正在处理，请稍候...");
                    $.post(WST.U("admin/Staffs/editMyPass"), f,
                    function(h) {
                        layer.close(e);
                        var g = WST.toAdminJson(h);
                        if (g.status == 1) {
                            WST.msg(g.msg, {
                                icon: 1
                            });
                            layer.close(a)
                        } else {
                            WST.msg(g.msg, {
                                icon: 2
                            })
                        }
                    })
                }
            })
        }
    })
};
function addTab(aobj){
  var h = $('.layui-tab-content').height();
  layui.use('element', function(){
      var obj = $(aobj);
      var url = obj.attr('dataval');
      var txt = obj.find('a').html();
      var id = obj.attr('dataid');
      if(url){
          if(obj.hasClass('menu')){
              obj.addClass('active').siblings().removeClass('active');
          }else{
              obj.parent().parent().parent().addClass('active').siblings().removeClass('active');
          }
          var element = layui.element;
          var checkTab = false;
          $('.layui-tab-title li').each(function(){
             if($(this).attr('lay-id')==('m'+id))checkTab = true;
          })

          if(!checkTab){
              element.tabAdd('wsttab', {title: txt,content: '<iframe id="iframe'+id+'" class="iframe" width="100%" height="100%" src="'+url+'" frameborder="0"></iframe>',id: 'm'+id})
              element.tabChange('wsttab','m'+id);
              $('.layui-body .layui-show').height(h);
          }else{
              element.tabChange('wsttab','m'+id);
              $('#iframe'+id).attr('src',url);
          }
      }
  });
}
function showMenus(menuId){
   $('.topmenus'+menuId).addClass('active').siblings().removeClass('active');
   $('.menu').hide();
   $('.menu'+menuId).fadeIn();
   $('.menu'+menuId).children().eq(0).click();
}
function redirect(mid){
   addTab($('#menuItem'+mid)[0]);
}
function layout(){
   var h = WST.pageHeight();
   $('.layui-tab-content').height(h-88);
   var w = WST.pageWidth();
   if(w<1000)$('.wst-menu-hide').click();
}

function goHome(){
    if($("#iframe0").length>0){
        var element = layui.element;
        element.tabChange('wsttab','m0');
    }else{
        var h = WST.pageHeight();
        var element = layui.element;
        element.tabAdd('wsttab', {title: '首页',content: '<iframe id="iframe0" class="iframe" width="100%" height="100%" src="'+WST.U('admin/index/main')+'" frameborder="0"></iframe>',id: 'm0'});
        element.tabChange('wsttab','m0');
        $('.layui-show').height(h-90);
    }
}
$(function(){
  layout();
  $('.wst-menu-hide').click(function(){
     $('.layui-layout').addClass('sm');
      $(this).hide();
      $('.wstmenu-p').addClass('layui-menu-item-parent').removeClass('layui-menu-item-group');
      $('.wstmenu-c').hide();
      $('.wst-menu-show').show();
  })
  $('.wst-menu-show').click(function(){
     $('.layui-layout').removeClass('sm');
     $('.wstmenu-p').removeClass('layui-menu-item-parent').addClass('layui-menu-item-group');
     $('.wstmenu-c').show();
      $(this).hide();
      $('.wst-menu-hide').show();
  })
  $('.menu').children().eq(0).click();
  goHome();
  $(".j-clear-cache").on("click", clearCache);
  $(".j-edit-pass").on("click", editPassBox);
  $(".j-logout").on("click", logout);
  WST.getSysMessages(WST.conf.MSG_GRANT);
  if(WST.conf.TIME_TASK=='1'){
      setInterval(function(){
          WST.getSysMessages(WST.conf.MSG_GRANT);
      },300000);
  }

})
$(window).resize(function () {layout();});
