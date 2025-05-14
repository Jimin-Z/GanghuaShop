const swiperItems = document.querySelector('.swiper__items');
const swiperItemCount = document.querySelectorAll('.swiper__item').length;
let currentIndex = 0;
const dots = document.querySelectorAll('.dot__item');
let interval;

// 自动轮播功能
function startAutoPlay() {
    interval = setInterval(() => {
        slideToNext();
    }, 3000); // 每3秒切换一次
}

// 暂停轮播功能
function stopAutoPlay() {
    clearInterval(interval);
}

function updateSwiper() {
    swiperItems.style.transform = `translateY(-${currentIndex * 100}%)`;
    dots.forEach(dot => dot.classList.remove('dot__item--active'));
    dots[currentIndex].classList.add('dot__item--active');
}

function slideToNext() {
    currentIndex = (currentIndex + 1) % swiperItemCount;
    updateSwiper();
}

// 点击 dot 切换
dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
        stopAutoPlay();
        currentIndex = index;
        updateSwiper();
        startAutoPlay();
    });
});

// 鼠标悬浮时暂停，移开时继续轮播
const swiper = document.querySelector('.swiper');
swiper.addEventListener('mouseover', stopAutoPlay);
swiper.addEventListener('mouseout', startAutoPlay);

// 页面加载时开始自动轮播
startAutoPlay();

function getElementTotalSize(element) {
    const style = window.getComputedStyle(element);

    // 获取宽度和高度，包括内边距和边框
    const width = element.offsetWidth;
    const height = element.offsetHeight;

    // 计算外边距
    const marginTop = parseFloat(style.marginTop);
    const marginBottom = parseFloat(style.marginBottom);
    const marginLeft = parseFloat(style.marginLeft);
    const marginRight = parseFloat(style.marginRight);

    // 计算总宽度和总高度
    const totalWidth = width + marginLeft + marginRight;
    const totalHeight = height + marginTop + marginBottom;

    // return { width: totalWidth, height: totalHeight };
    return totalWidth;
}


// swiperCard
// const swiperCard = document.querySelector('.swiper-card');
const swiperCardItems = document.querySelector('.swiper-card__items');
const items = document.querySelectorAll('.swiper-card__item');
const totalItems = items.length;
let currentCardIndex = 1;


// const itemWidth = 175; // 获取单个项目的宽度
// console.log(document.querySelector('.swiper-card__item'));
const itemWidth = getElementTotalSize(document.querySelector('.swiper-card__item'))
// const itemStyle = window.getComputedStyle(document.querySelector('.swiper-card__item'));
// const itemWidth = itemStyle.width+itemStyle.marginRight;

console.log('itemWidth: ',itemWidth);

function updateClasses() {
    // console.log(currentCardIndex);
    for (let i = 0; i < totalItems; i++) {
        items[i].classList.remove('swiper-card__item--middle', 'swiper-card__item--left', 'swiper-card__item--right');
        if (i === currentCardIndex) {
            items[i].classList.add('swiper-card__item--middle');
        } else if (i <= currentCardIndex-1) {
            items[i].classList.add('swiper-card__item--left');
        } else if(i>=currentCardIndex+1){
            items[i].classList.add('swiper-card__item--right');
        }
    }
}

function nextItem() {
    if (currentCardIndex < totalItems - 1) {
        console.log(currentCardIndex);
        currentCardIndex++; // 移动到下一个项目
        swiperCardItems.style.transform = `translateX(-${itemWidth * (currentCardIndex - 1)}px)`;
        updateClasses();
    }
}

function prevItem() {
    console.log(currentCardIndex);
    if (currentCardIndex > 1) {
        currentCardIndex--; // 移动到上一个项目
        swiperCardItems.style.transform = `translateX(-${itemWidth * (currentCardIndex - 1)}px)`;
        updateClasses();
    }else if(currentCardIndex===1){
        currentCardIndex--; // 移动到上一个项目
        swiperCardItems.style.transform = `translateX(${itemWidth}px)`;
        updateClasses();
    }
}

document.querySelector('.swiper-card__left-arrow').addEventListener('click', prevItem);
document.querySelector('.swiper-card__right-arrow').addEventListener('click', nextItem);


// -----------------------------------
// swiper--profess
const swiperProfessItems = document.querySelectorAll('.swiper__item--profess');
const professTotalItems = swiperProfessItems.length;
let currentProfessIndex = 1;
// const professItemWidth = 250;
const professItemWidth = getElementTotalSize(document.querySelector('.swiper__item--profess'))
// const professItemStyle=window.getComputedStyle(document.querySelector('.swiper__item--profess'))
// const professItemWidth = parseFloat(professItemStyle.width);
console.log('professItemWidth: ',professItemWidth);
// const scale = document.querySelector('.swiper__item--middle');
// console.log('transform: ',scale);

function professUpdate() {
    console.log('professIndex:',currentProfessIndex);
    for (let i = 0; i < professTotalItems; i++) {
        swiperProfessItems[i].classList.remove('swiper__item--middle', 'swiper__item--left', 'swiper__item--right');
    }
    // 1 0 1 2
    // 0  2 0 1
    //2  1 2 0

    let left=(currentProfessIndex-1+professTotalItems)%professTotalItems;
    let middle=currentProfessIndex;
    let right=(currentProfessIndex+1)%professTotalItems;

    swiperProfessItems[left].classList.add('swiper__item--left');
    swiperProfessItems[middle].classList.add('swiper__item--middle');
    swiperProfessItems[right].classList.add('swiper__item--right');

    if(currentProfessIndex===1){
        swiperProfessItems[left].style.transform = `translateX(0px) scale(1)`;
        swiperProfessItems[middle].style.transform = `translateX(0px) scale(1.5)`;
        swiperProfessItems[right].style.transform = `translateX(0px) scale(1)`;
    }else if(currentProfessIndex===0){
        // 2 0 1
        swiperProfessItems[left].style.transform = `translateX(-${professItemWidth*2}px) scale(1)`;
        swiperProfessItems[middle].style.transform = `translateX(${professItemWidth}px) scale(1.5)`;
        swiperProfessItems[right].style.transform = `translateX(${professItemWidth}px) scale(1)`;

        // swiperProfessItems[left].style.transition = `transform .5s ease-in-out`;        
        // swiperProfessItems[middle].style.transition = `transform .25s .25s ease-in-out`;
        // swiperProfessItems[right].style.transition = `transform .25s .25s ease-in-out`;
    }else if (currentProfessIndex===2){
        //1 2 0
        swiperProfessItems[left].style.transform = `translateX(-${professItemWidth}px) scale(1)`;
        swiperProfessItems[middle].style.transform = `translateX(-${professItemWidth}px) scale(1.5)`;
        swiperProfessItems[right].style.transform = `translateX(${professItemWidth*2}px) scale(1)`;
    }
}

function professNextItem() {
        // currentProfessIndex++; // 移动到下一个项目
        currentProfessIndex=(currentProfessIndex+1)%professTotalItems;
        professUpdate();
}

function professPrevItem() {
    // console.log(currentProfessIndex);
    currentProfessIndex=(currentProfessIndex-1+professTotalItems)%professTotalItems;
    professUpdate();
}

document.querySelector('.swiper__left-arrow--profess').addEventListener('click', professNextItem);
document.querySelector('.swiper__right-arrow--profess').addEventListener('click', professPrevItem);


const sliderItemsContainer = document.querySelector('.slider-items');
const sliderItems = document.querySelectorAll('.slider-item');

// 克隆所有的 li 元素到 ul 末尾，以实现无缝滚动
function cloneItems() {
    sliderItems.forEach(item => {
        const clone = item.cloneNode(true); // 复制每个 li
        sliderItemsContainer.appendChild(clone); // 追加到 ul 的末尾
    });
}

cloneItems();

const newSliderItems=document.querySelectorAll('.slider-item');
const profiles=document.querySelectorAll('.profile-card');

// 监听鼠标悬停事件，悬停时暂停滚动，移开时恢复滚动
const sliderContainer = document.querySelector('.slider');

sliderContainer.addEventListener('mouseover', () => {
    sliderItemsContainer.style.animationPlayState = 'paused'; // 暂停动画
});

sliderContainer.addEventListener('mouseout', () => {
    sliderItemsContainer.style.animationPlayState = 'running'; // 恢复动画
});



// 为每个 li 元素添加鼠标事件
newSliderItems.forEach((item,index) => {
    item.addEventListener('mouseover', () => {
        changeOpacity(item,index);
    });

    item.addEventListener('mouseout', () => {
        resetOpacity();
    });
});

const width = window.innerWidth;
console.log("浏览器窗口的视口宽度是：", width);

// 当鼠标悬停时改变其他 li 的 opacity
function changeOpacity(activeItem,index) {
    newSliderItems.forEach((item) => {

        if (item !== activeItem) {
            item.style.opacity = '0.5'; // 修改不被悬停的 li 的透明度
        }else if(item===activeItem){
            const itemRect = item.getBoundingClientRect(); // 获取当前项相对于视口的位置
            console.log(profiles[index]);
            console.log(itemRect.x);
            if(itemRect.x>=width/2){
                // item.style.
                profiles[index].style.left='-418px';
            }else{
                profiles[index].style.left='304px';
            }
        }
    });
}

// 鼠标移开时恢复所有 li 的 opacity
function resetOpacity() {
    newSliderItems.forEach((item) => {
        item.style.opacity = '1'; // 恢复透明度
    });
}

// 链接详情可视化
// 移民的
// 总盒子
const infoLinkItems = document.querySelectorAll('.info-center__item--migrant .info-center__item-img-link--hover');

// 要出现内容的盒子
const visLinkItems = document.querySelectorAll('.info-center__item--migrant .info-center__item-img-link--visible');

infoLinkItems.forEach((item,index)=>{
    item.addEventListener('mouseover',()=>{
        const activeItem = document.querySelector('.info-center__item--migrant .info-center__item-img-link--active');
        if(activeItem){
            activeItem.classList.remove('info-center__item-img-link--active');
        }

        visLinkItems[index].classList.add('info-center__item-img-link--active');
        console.log(index);
    })
})

// 热门
const infoLinkItems1 = document.querySelectorAll('.info-center__item--hot .info-center__item-img-link--hover');

// 要出现内容的盒子
const visLinkItems1 = document.querySelectorAll('.info-center__item--hot .info-center__item-img-link--visible');

infoLinkItems1.forEach((item,index)=>{
    item.addEventListener('mouseover',()=>{
        const activeItem = document.querySelector('.info-center__item--hot .info-center__item-img-link--active');
        if(activeItem){
            activeItem.classList.remove('info-center__item-img-link--active');
        }

        visLinkItems1[index].classList.add('info-center__item-img-link--active');
        console.log(index);
    })
})



function onLoaded(){
    updateClasses();
    professUpdate();
}

function debounce(func, wait) {
    let timeout;
    return function() {
        const context = this, args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(context, args), wait);
    };
}

function setRootFontSize() {
    const html = document.documentElement;
    const width = html.clientWidth;
    const fontSize = width / 100;  // 将根字体大小设置为视口宽度的1/100
    html.style.fontSize = `${fontSize}px`;
}

// 使用 debounce 函数包装 setRootFontSize，以防止在窗口调整大小时频繁更新
// const debouncedSetRootFontSize = debounce(setRootFontSize, 100);

// 监听窗口大小变化事件
// window.addEventListener('resize', debouncedSetRootFontSize);

window.addEventListener('resize',setRootFontSize)

setRootFontSize();

// 初次调用以设置字体大小
// debouncedSetRootFontSize();

window.onload = onLoaded; // Initialize classes on load