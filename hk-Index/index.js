function setRootFontSize(){
    const html = document.documentElement;
    const width = html.clientWidth;
    const fontSize = width/100;
    html.style.fontSize = `${fontSize}px`;
}

window.addEventListener('resize',setRootFontSize);

// 初始化
setRootFontSize();

function bannerSwiper(){
// bannerSwiper =>缩写bS
let bSConfig ={
    currentIndex:0,
    length:0,
    interval:null,
    duration:3000,
}

const bS = document.querySelector('.hkIndex__banner-swiper');
const bSItems = document.querySelector('.hkIndex__banner-swiper-items');
const bSItem = document.querySelectorAll('.hkIndex__banner-swiper-item');
bSConfig.length = bSItem.length;

const bSLeftArrow = document.querySelector('.hkIndex__banner-arrow-left');
const bSRightArrow = document.querySelector('.hkIndex__banner-arrow-right');

// console.log(bsItems);

function sliderNext(){
    // console.log('index: ',bSConfig.currentIndex);
    bSConfig.currentIndex = (bSConfig.currentIndex+1)%bSConfig.length;
    updateSwiper();
    // console.log('trans: ',`translateX(-${bSConfig.currentIndex*100}%)`);
}

function sliderPrev(){
    bSConfig.currentIndex = (bSConfig.currentIndex-1+bSConfig.length)%bSConfig.length;
    updateSwiper();
}

function updateSwiper(){
    bSItems.style.transform = `translateX(-${bSConfig.currentIndex*100}%)`;
}

function startAutoPlay(){
    bSConfig.interval = setInterval(()=>{
        sliderNext();
    },bSConfig.duration)
}

function stopAutoPlay(){
    clearInterval(bSConfig.interval);
}

bS.addEventListener('mouseover',()=>{
    stopAutoPlay();
})

bS.addEventListener('mouseout',()=>{
    startAutoPlay();
})

bSLeftArrow.addEventListener('click',()=>{
    stopAutoPlay();
    sliderPrev();
    startAutoPlay();
});

bSRightArrow.addEventListener('click',()=>{
    stopAutoPlay();
    sliderNext();
    startAutoPlay();
});

startAutoPlay();
}


document.addEventListener('DOMContentLoaded', function() {
    // 定义 zodiacItems 函数
     const origin = window.location.origin;
    // AJAX 请求
    var s1 =origin +'/hkshop/shop/index.php?r=hkindex/hkindex';
    $.ajax({ 
        type: 'get',
        url: s1,
        data: {},
        dataType: 'json',
        success: function(data) {
            HongKongtitle(data.title); //标题
            ProductDisplay(data.flex);  //业务模块
            Businesstemplates(data.zodiacItems);  //产品销售
            Scrollthecarousel(data.carousel);  //轮播图
            tail();
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log("请求失败: " + textStatus);
            console.log("错误信息: " + errorThrown);
            console.log("响应状态: " + XMLHttpRequest.status);
            console.log("响应文本: " + XMLHttpRequest.responseText);
        }
    });
});

function tail(){
    fetch('/hkshop/hk-Index/indexTail.html')
            .then(response => response.text())
            .then(html => {
                document.getElementById('content-container').innerHTML = html;
            })
            .catch(error => console.error('Error:', error));
}


function HongKongtitle(data) {
    // 获取 zodiac-container 元素
    const container = document.querySelector('.header__title.flex');
    // 确保 container 存在
    if (!container) {
        console.error("容器元素 '.header__title flex' 未找到");
        return;
    }
    // 清空容器内容（如果需要）
    container.innerHTML = '';
    // 动态生成 HTML 内容
    const htmlContent =`
    
            <span class="header__text--underline">
                CONTENTS
            </span>
            <span class="header__text--chinese">
               `+data[0].title+`
            </span>

            <div class="lang__box">
                <!-- <a href="#" class="lang--cn">中文</a> -->
                <a href="/hkshop/hk-enIndex/enIndex.html" class="lang--en">英文</a>    
            </div>
    
    `;
    // 将生成的 HTML 内容插入到容器中
    container.innerHTML = htmlContent;
}
function Scrollthecarousel(data) {
    // 获取 zodiac-container 元素
    const container = document.querySelector('.hkIndex__banner-swiper-items');
    // 确保 container 存在
    if (!container) {
        console.error("容器元素 '.hkIndex__banner-swiper-items' 未找到");
        return;
    }
    // 清空容器内容（如果需要）
    container.innerHTML = '';
    // 遍历 data 数组，生成轮播图项
    data.forEach(item => {
        const anchor = document.createElement('a');
        anchor.href = item.address;
        anchor.className = 'hkIndex__banner-swiper-item';
        const img = document.createElement('img');
        img.src = item.Carouselurl;
        img.alt = 'bannerSwiperImg';
        img.className = 'hkIndex__banner-swiper-img';
        anchor.appendChild(img);
        container.appendChild(anchor);
    });
       container.addEventListener('click', handleClick);
       bannerSwiper()

        // 定义点击处理函数
        function handleClick(event) {
            console.log('zodiac-container 被点击了', event);
        }
}

 function Businesstemplates(data) {
        // 获取 zodiac-container 元素
        const container = document.querySelector('.hkIndex__zodiac');
        // 确保 container 存在
        if (!container) {
            console.error("容器元素 '.hkIndex__zodiac' 未找到");
            return;
        }
        // 清空容器内容（如果需要）
        container.innerHTML = '';

        // 动态生成内容
        data.forEach(item => {
            const zodiacItem = document.createElement('div');
            zodiacItem.className = 'flex--column hkIndex__zodiac-item';
            const anchor = document.createElement('a');
            anchor.href = item.address;
            anchor.className = 'hkIndex__zodiac-link';
            const img = document.createElement('img');
            img.src = item.picurl;
            img.alt = 'zodiac';
            img.className = 'hkIndex__zodiac-img';
            const desc = document.createElement('span');
            desc.className = 'hkIndex__zodiac-desc';
            desc.textContent = item.title;
            anchor.appendChild(img);
            zodiacItem.appendChild(anchor);
            zodiacItem.appendChild(desc);
            container.appendChild(zodiacItem);
        });

        // 为 zodiac-container 添加点击事件监听器
        container.addEventListener('click', handleClick);

        // 定义点击处理函数
        function handleClick(event) {
            console.log('zodiac-container 被点击了', event);
        }
    }

     function ProductDisplay(data) {
            // 获取 zodiac-container 元素
            const container = document.querySelector('.header-items.flex');
            // 确保 container 存在
            if (!container) {
                console.error("容器元素 '.header-items flex' 未找到");
                return;
            }
            // 清空容器内容（如果需要）
            container.innerHTML = '';
            // 动态生成内容
            data.forEach(item => {
                // 创建一个新的header-item元素
                const headerItem = document.createElement('div');
                headerItem.className = 'header-item flex--column';
                // 创建链接
                const link = document.createElement('a');
                link.href = item.address;
                link.className = 'header-item__link';
                link.textContent = '点我进入详情';
                headerItem.appendChild(link);
                // 创建标题和描述部分
                const textSection = document.createElement('section');
                textSection.className = 'header-item__text flex';
                const title = document.createElement('h2');
                title.className = 'header-item__title';
                title.textContent = item.business;
                textSection.appendChild(title);
                const details = document.createElement('p');
                details.className = 'header-item__details';
                details.textContent = item.explain;
                textSection.appendChild(details);
                headerItem.appendChild(textSection);
                // 创建图片
                const img = document.createElement('img');
                img.src = item.picurl;
                img.alt = item.alt;
                img.className = 'header-item__img';
                headerItem.appendChild(img);
                // 将header-item添加到父元素
                container.appendChild(headerItem);
            });
            // 为 zodiac-container 添加点击事件监听器
            container.addEventListener('click', handleClick);
            // 定义点击处理函数
            function handleClick(event) {
                console.log('zodiac-container 被点击了', event);
            }
        }