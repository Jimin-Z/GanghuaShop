$(function(){
   layout();
   initMenus();
   if(WST.conf.MESSAGE_BOX!=''){
        var msg = WST.conf.MESSAGE_BOX.split('||');
        for(var i=0;i<msg.length;i++){
            WST.open({type: 1,title: '系统提示', shade: false,area: ['340px', '215px'],offset: 'rb',time: 20000,anim: 2,content: "<div class='j-messsage-box'>"+msg[i]+"</div>",})}
        }
        WST.getSysMessages(WST.conf.MSG_SHOP_GRANT);
        if(WST.conf.TIME_TASK=='1'){
            setInterval(function(){
            WST.getSysMessages(WST.conf.MSG_SHOP_GRANT);
        },300000);
    }
});
$(window).resize(function () {layout();});
function layout(){
   var h = WST.pageHeight();
   $('.wrapper').height(h);
   $('.layout-main').height(h-50);
}
function initMenus(){
   $('.sidebar-menus').click(function(){
        var url = $(this).attr('dataurl');
        if(url!=''){
            $('.sidebar-menus').each(function(){
                $(this).removeClass('active');
            });
            $(this).addClass('active');
            $('#iframe').attr('src',url);
        }
   });
   $('.sidebar-menus')[0].click();
}
function showMenus(menuId){
   $('.topmenus'+menuId).addClass('active').siblings().removeClass('active');
   $('.menu').hide();
   $('.menu'+menuId).fadeIn();
   var menu = $('.menu'+menuId).eq(0);
   if(!menu.hasClass('layui-nav-itemed')){
       $('.menu'+menuId).children().eq(0).click();
   }
}
function redirect(mid){
   var url = $('.menuItem'+mid).attr('dataurl');
   if(url!=''){
        $('.sidebar-menus').each(function(){
            $(this).removeClass('active');
        });
        $(this).addClass('active');
        $('#iframe').attr('src',url);
   }
}
function logout() {
    var a = WST.msg("正在退出系统...", {
        icon: 16,
        time: 60000,
        offset: "200px"
    });
    $.post(WST.U("store/index/logout"), {},
    function(c, d) {
        layer.close(a);
        var b = WST.toJson(c);
        if (b.status == "1") {
            WST.msg(b.msg, {
                icon: 1,
                offset: "200px"
            },
            function() {
                location.href = WST.U("store/index/login")
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
        area: ["510px", "250px"],
        btn: ["确定", "取消"],
        yes: function(c, b) {
            $("#editPassFrom").isValid(function(d) {
                if (d) {
                    var f = WST.getParams(".ipt");
                    var public_key=$('#token').val();
                    var exponent="10001";
                    var res = '';
                    if(WST.conf.IS_CRYPT=='1'){
                        var rsa = new RSAKey();
                        rsa.setPublic(public_key, exponent);
                        f.oldPass = rsa.encrypt($.trim(f.oldPass));
                        f.newPass = rsa.encrypt($.trim(f.newPass));
                        f.newPass2 = rsa.encrypt($.trim(f.newPass2));
                    }
                    var e = WST.msg("正在提交数据，请稍后...");
                    $.post(WST.U("store/users/passedit"), f,
                    function(h) {
                        layer.close(e);
                        var g = WST.toJson(h);
                        if (g.status == 1) {
                            WST.msg(g.msg, {
                                icon: 1
                            });
                            $('#editPassFrom')[0].reset();
                            layer.close(a);
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
