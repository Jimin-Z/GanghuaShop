!(function(w, d, $) {
    "use strict";
    $(function () {
        $.fn.extend({
            /*
            * 包裹多项方法123456789
            * 因为jQuery中没有直接作用于多项标签进行包裹的方法
            * 注意事项 参数 a b 必须为同级标签
            *         并且a的索引<b的索引
            * 添加后原位置的 a b标签不保留
            *
            * 示例
            * 执行前
            * <div>
            *     <p class="c"></p>
            *     <div>
            *         <span class="a"></span>
            *         <span></span>
            *         <span></span>
            *         <span class="b"></span>
            *     </div>
            * </div>
            *
            * 执行方法
            * $(".c").hq_wrap($(".a"),$(".b"));
            *
            * 执行结果
            * <div>
            *     <p class="c">
            *         <span class="a"></span>
            *         <span></span>
            *         <span></span>
            *         <span class="b"></span>
            *     </p>
            *     <div></div>
            * </div>
            * */
            hq_wrap:function (a,b) {
                var hq_warp;
                if(a.parent().is(b.parent())){
                    for(var i=a.index();i<=b.index();i++){
                        hq_warp=a.parent().children().eq(i).clone(true);
                        a.parent().children().eq(i).addClass("hq_warp_remove");
                        $(this).append(hq_warp);
                    }

                    $(".hq_warp_remove").remove();
                }else{
                    console.log("参数需为同级元素");
                }
            },


            /*
            *2018.11.29版导航专用方法
            * 方法用于根据高度进行左右换行
            * 注意事项 作用对象需使用  >选择器  例如 $(".a>li") 原因执行一次后跳出循环再执行被包裹后的对象将不会进行读取
            * 参数 a 为jQuery对象 是换行的外侧包裹项 使用了 hq_warp方法
            * 参数 b 同作用对象一样 例如例如 $(".a>li") 用来判断 当两项高度达不到height值又是最后一项的时候进行判断
            * 该项目是否为最后一项
            * 参数 height 为设置的高度
            * */
            hq_nav_br:function (a,b,height) {
                var m_h=0;
                return $(this).each(function (){
                    if(!m_h){
                        $(this).addClass("begin_nav_br");
                        m_h=$(this).outerHeight();
                        if($(this).index()==b.length-1){
                            $(this).addClass("stop_nav_br");
                            a.hq_wrap($(".begin_nav_br"),$(".stop_nav_br"));
                            $(".begin_nav_br").removeClass("begin_nav_br");
                            $(".stop_nav_br").removeClass("stop_nav_br");
                            return false;
                        }
                    }else if(m_h<height){
                        m_h=m_h+$(this).outerHeight();
                        if(m_h>height){
                            $(this).prev().addClass("stop_nav_br");
                            a.hq_wrap($(".begin_nav_br"),$(".stop_nav_br"));
                            $(".begin_nav_br").removeClass("begin_nav_br");
                            $(".stop_nav_br").removeClass("stop_nav_br");
                            return false;
                        }

                        if($(this).index()==b.length-1){
                            $(this).addClass("stop_nav_br");
                            a.hq_wrap($(".begin_nav_br"),$(".stop_nav_br"));
                            $(".begin_nav_br").removeClass("begin_nav_br");
                            $(".stop_nav_br").removeClass("stop_nav_br");
                            return false;
                        }
                    }
                });
            },


            hq_nav_br_test:function (a,b,height) {
                var m_h=0;
                return $(this).each(function (){
                    if(!m_h){
                        $(this).addClass("begin_nav_br");
                        m_h=$(this).outerHeight();
                        if($(this).index()==b.length-1){
                            $(this).addClass("stop_nav_br");
                            a.hq_wrap($(".begin_nav_br"),$(".stop_nav_br"));
                            $(".begin_nav_br").removeClass("begin_nav_br");
                            $(".stop_nav_br").removeClass("stop_nav_br");
                            return false;
                        }
                    }else if(m_h<height){
                        m_h=m_h+$(this).outerHeight();
                        if(m_h>height){
                            $(this).prev().addClass("stop_nav_br");
                            a.hq_wrap($(".begin_nav_br"),$(".stop_nav_br"));
                            $(".begin_nav_br").removeClass("begin_nav_br");
                            $(".stop_nav_br").removeClass("stop_nav_br");
                            return false;
                        }

                        if($(this).index()==b.length-1){
                            $(this).addClass("stop_nav_br");
                            a.hq_wrap($(".begin_nav_br"),$(".stop_nav_br"));
                            $(".begin_nav_br").removeClass("begin_nav_br");
                            $(".stop_nav_br").removeClass("stop_nav_br");
                            return false;
                        }
                    }
                });
            },
        })
    })
})(window, document, jQuery);