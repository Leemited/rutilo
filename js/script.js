$(document).ready(function(){
	 $(window).scroll(function(event){
		var scroll_top = $(this).scrollTop();
		if(scroll_top>139){
			$("#header .main_menu").addClass("scroll_up");
		}else{
			$("#header .main_menu").removeClass("scroll_up");
		}
	 });
	 $("#mobile_header .menu > ul > li > h4").click(function(){
		var li = $(this).parent();
		li.toggleClass("active");
		li.find("ul").slideToggle();
	 });
	 $("#mobile_header .menu_btn").click(function(){
		$(".mobile_menu").fadeIn("fast",function() {
			$(".mobile_menu > div").animate({"right":"0"});
		});
		$("html").css("overflow-y","hidden");
	 });
	 $(".mobile_menu span").click(function(){
		$(".mobile_menu > div").animate({"right":"-100%"},function(){
			$(".mobile_menu").fadeOut("fast");
		});
		$("html").css("overflow-y","auto");
	 });
});

$(function(){
	$(".select01 select").change(function(){
		var tval=$(this).val();
		var label=$(this).find("option:first-child").html();
		var data_label=$(this).find("option:selected").attr("data-label");
		if(!data_label){
			data_label="+"+tval;
		}
		if(tval==""){
			$(this).parent().find("div").html(label+"<span></span>");
			$(this).parent().css("color","#999");
		}else{
			$(this).parent().find("div").html(data_label+"<span></span>");
			$(this).parent().css("color","#000");
		}
	});
	$(".section01_nav .slide").owlCarousel({
		autoplay:false,
		smartSpeed:2000,
		loop:false,
		items:3,
		nav:false
	});
	/*$("#skin").owlCarousel({
		autoplay:false,
		smartSpeed:2000,
		loop:true,
		dots:false,
		nav:true,
		touchDrag:false,
		mouseDrag:false,
		pullDrag:false,
		freeDrag:false,
		animateOut: 'fadeOut',
		items:1,
		navText: [ '', '' ]
	});*/
});
var hash_back="";
$(window).hashchange( function(){
	console.log( location.hash + " / " +hash_back );
	if(location.hash=="" && hash_back){
		if(hash_back=="#msg"){
			msg_close();
		}
		if(hash_back=="#modal"){
			modal_close();
		}
		if(hash_back=="#small_modal"){
			modal_close();
			small_modal_close();
		}
		if(hash_back=="#menu"){
			$('#mobile_menu').removeClass('active');
			$("html").css("overflow","auto");
		}
	}else if(location.hash=="" && hash_back == ""){
		modal_close();
		console.log( location.hash + " / " +hash_back );
	}else if(location.hash=="#modal" && hash_back=="#small_modal"){
		small_modal_close();
	}
});
function msg_active(){
	document.location.hash="#msg";
	hash_back="#msg";
	$(".msg").addClass('active');
	var div_height=$(".msg > div").height();
	var d_height=$(window).height();
	if(div_height>d_height){
		$(".msg > div").css("height",d_height+"px");
	}else{
		var div_top = (d_height/2)-(div_height/2);
		$(".msg > div").animate({"top":div_top+"px"},500);
	}
	$("html").css("overflow","hidden");
}
function msg_close(){
	$(".msg").html("");
	$('.msg').removeClass('active');
	if(location.hash=="#msg" && hash_back=="#msg"){
		hash_back="";
		 window.history.back();
	}
	$("html").css("overflow","auto");
}
function number_only(t){
	t.value = t.value.replace(/[^0-9]/g, '');
}
function float_only(t){
	t.value = t.value.replace(/[^0-9.]/g, '');
}
var fromHistoryBack = false;
var myHistory;
try {
    myHistory = JSON.parse(sessionStorage.getItem('myHistory'));
} catch (e) {};
if (myHistory) {
    if (myHistory[myHistory.length-1].href == window.location.href 
            && myHistory[myHistory.length-1].referrer == document.referrer) {
        //alert('새로고침 되었습니다.');
    } else {
        if (myHistory.length > 1) {
            if (myHistory[myHistory.length-2].href == window.location.href 
                    && myHistory[myHistory.length-2].referrer == document.referrer) {
                fromHistoryBack = true;
                myHistory.pop();
                sessionStorage.setItem('myHistory', JSON.stringify(myHistory));
            }
        }
        if (myHistory.length > 10 && !fromHistoryBack) {
            myHistory.shift();
            sessionStorage.setItem('myHistory', JSON.stringify(myHistory));
        }
        if (!fromHistoryBack) {
            myHistory.push({ 
                href: window.location.href,
                referrer: document.referrer
            });
            sessionStorage.setItem('myHistory', JSON.stringify(myHistory));
        }
    }
} else {
    var newHistory = [{ 
        href: window.location.href, 
        referrer: document.referrer
    }];
    sessionStorage.setItem('myHistory', JSON.stringify(newHistory));
}