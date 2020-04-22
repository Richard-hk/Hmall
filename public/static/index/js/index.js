// JavaScript Document
/*top轮播*/
var index=0;
// <!--初始化序列号-->
var play=null;
$(".button li").mouseover(function(){
    clearInterval(play);
    // <!--清除定时器-->
	index=$(this).index();
	// <!--alert(将图片和按钮关联-->	
	$(this).addClass("hover").siblings().removeClass("hover");
	$(".banner-box img").eq(index).show().siblings("img").hide();
	})
	.mouseout(function(){autoplay();});
	// <!--自动轮播-->

function autoplay(){
	play=setInterval(function(){
	index++;
	if(index>4){index=-1;}else{
	$(".button li").eq(index).addClass("hover").siblings().removeClass("hover");
	$(".banner-box img").eq(index).show().siblings("img").hide();	}
		},3000)
	}
	autoplay();
	
$(function () {
    $(".border_animation").mouseenter(function(){
    $(this).addClass("hover");
    });
    $(".border_animation").mouseleave(function(){
    $(this).removeClass("hover");
    });
});

//二级搜索
$(function () {              
//绑定滚动条事件  
    $(window).bind("scroll", function () {  
    var sTop = $(window).scrollTop();  
    var sTop = parseInt(sTop);  
    if (sTop >= 200) {  
    if (!$(".search").is(":visible")) {  
        try {  
            $(".search").slideup();  
    } catch (e) {  
            $(".search").show();  
        }                        
    }  
    }  
    else {  
        if ($(".search").is(":visible")) {  
            try {  
            $(".search").slidedown();  
        } catch (e) {  
            $(".search").hide();  
            }                         
        }  
    }   
    });  
});  


//分类圆角

$('.first-menu li').mouseover(function () {
	$('.first-menu li:first-child').css('border-top-left-radius','18px');
	$('.first-menu').css('border-top-right-radius','0');
	$('.first-menu li:last-child').css('border-bottom-left-radius','18px');
	$('.first-menu').css('border-bottom-right-radius','0');
	// $('.first-menu li:first-child').css('border-top-right-radius','0');
}).mouseout(function () {
    $('.first-menu').css('border-top-right-radius','18px');
    $('.first-menu').css('border-bottom-right-radius','18px');
});
