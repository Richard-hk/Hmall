// JavaScript Document
//回到顶部
$(function () {              
//绑定滚动条事件  
$(window).bind("scroll", function () {  
var sTop = $(window).scrollTop();  
var sTop = parseInt(sTop);  
if (sTop >= 600) {  
if (!$(".back-top").is(":visible")) {  
try {  
$(".back-top").slideup("slow");  
} catch (e) {  
$(".back-top").show("slow");  
}                        
}  
}  
else {  
if ($(".back-top").is(":visible")) {  
try {  
$(".back-top").slidedown("slow");  
} catch (e) {  
$(".back-top").hide("slow");  
}                         
}  
}   
});  
})  

$(".back-top").click(function () {
$("body").animate({ scrollTop: 0 }, "slow"); 
});

function show4(){
	$(".show4").show();
	$(".show3").hide();
	$(".show5").show();
	}
function hide4(){
	$(".show4").hide();
	$(".show3").show();
	$(".show5").hide();
	}