// JavaScript Document
/*top轮播*/
var index=0;<!--初始化序列号-->
var play=null;
$(".button li").mouseover(function(){
	clearInterval(play);<!--清除定时器-->
	index=$(this).index();
	<!--alert(将图片和按钮关联-->	
	$(this).addClass("hover").siblings().removeClass("hover");
	$(".banner-box img").eq(index).show().siblings("img").hide();
	})
	.mouseout(function(){autoplay();});
	<!--自动轮播-->
function autoplay(){
	play=setInterval(function(){
	index++;
	if(index>2){index=-1;}else{
	$(".button li").eq(index).addClass("hover").siblings().removeClass("hover");
	$(".banner-box img").eq(index).show().siblings("img").hide();	}
		},2600)
	}
	autoplay();
	 
	function show1(){$(".div1").hide();$(".shop1").hide();}
	function show2(){$(".div1").show();$(".shop1").show();}	
	function show3(){$(".div2").hide();$(".shop2").hide();}
	function show4(){$(".div2").show();$(".shop2").show();}	
	function show5(){$(".div3").hide();$(".shop3").hide();}
	function show6(){$(".div3").show();$(".shop3").show();}	
	function show7(){$(".div4").hide();$(".shop4").hide();}
	function show8(){$(".div4").show();$(".shop4").show();}	
	function show9(){$(".div5").hide();$(".shop5").hide();}
	function show10(){$(".div5").show();$(".shop5").show();}	
	
			 		 