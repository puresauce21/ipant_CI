/****************header js starts here*****************/

  /********CHANGE HEADER COLOR WHEN SCROLL*********/
  $(window).on("scroll", function() {
    if($(window).scrollTop() > 680) {
        $(".header").addClass("active-head");
    } else {
        
       $(".header").removeClass("active-head");
    }
});

/***********Menu Toggle Mega Dropdown*******/
        $(".dropdown a").click(function(){
           if ($("body").hasClass("slideup")) {
                 $( "header" ).addClass('data_menu');
                 
           }
           else if (!$("body").hasClass("slideup")) {
             $("header").css({backgroundColor : "#DE1F5F"});
             $( "header" ).removeClass('data_menu');
          }
         });
          $(".data-toggle1 a").click(function(event){
           if ($(".data-toggle1").hasClass("open")) {
           $("body").removeClass("slideup");

             $( ".toggle1" ).show();
           $( ".toggle2" ).hide();
           }
            else if (!$(".data-toggle1").hasClass("open")) {
               $("body").addClass("slideup");
              $( "header" ).removeClass('data_menu');
             
             $( ".toggle1" ).show();
              $( ".toggle2" ).hide();
          }
          });
          $(".data-toggle2 a").click(function(){
           if ($(".data-toggle2").hasClass("open")) {
            $("body").removeClass("slideup");
            $( ".toggle2" ).show();
             $( ".toggle1" ).hide();
            }
            else if (!$(".data-toggle2").hasClass("open")) {
               $("body").addClass("slideup");
              $( "header" ).removeClass('data_menu');
             $( ".toggle2" ).show();
             $( ".toggle1" ).hide();
          }
          });
 /**************************push mobile menu******************************/

 var $menuTrigger = $('.js-menuToggle');
var $topNav = $('.js-topPushNav');
var $openLevel = $('.js-openLevel');
var $closeLevel = $('.js-closeLevel');
var $closeLevelTop = $('.js-closeLevelTop');
var $navLevel = $('.js-pushNavLevel');
var self = this;
this.$topNav = $topNav;
this.$openLevel = $openLevel;

function openPushNav() {
  this.$topNav.addClass('isOpen');
  $('body').addClass('pushNavIsOpen');
}

function closePushNav() {
  this.$topNav.removeClass('isOpen');
 this.$openLevel.siblings().removeClass('isOpen');
  $('body').removeClass('pushNavIsOpen');
}

this.$menuTrigger.on('click touchstart', function(e) {
  e.preventDefault();
  if ($topNav.hasClass('isOpen')) {
    self.closePushNav();
  } else {
    self.openPushNav();
  }
});

$($openLevel).on('click touchstart', function(){
  $(this).next($navLevel).addClass('isOpen');
});

$($closeLevel).on('click touchstart', function(){
  $(this).closest($navLevel).removeClass('isOpen');
});

$($closeLevelTop).on('click touchstart', function(){
  self.closePushNav();
});

$('.screen').click(function() {
    closePushNav();
}); 

$(".burger").click(function(){
  if ($("body").hasClass("pushNavIsOpen")) {
    $(".burger").addClass('toggle-right');
    $(".burger").removeClass('toggle-left');
              //$(".burger").css({left : "322px"});
            }
    else if  (!$("body").hasClass("pushNavIsOpen")){
$(".burger").removeClass('toggle-right');
$(".burger").addClass('toggle-left');
}       
});

$(".close-level-inner").click(function(){
if  (!$("body").hasClass("pushNavIsOpen")){
$(".burger").removeClass('toggle-right');
$(".burger").addClass('toggle-left');
$(".mobile-logo-wrap").show();
}       
});

$(".burger").click(function(){
if  ($("body").hasClass("pushNavIsOpen")){
//$(".mobile-logo-wrap").removeClass('toggle-right');
$(".login-mobile").hide();
$(".mobile-logo").css({left : "auto"});
$(".mobile-logo").css({right : "0"});

}
else if   (!$("body").hasClass("pushNavIsOpen")){ 
//$(".mobile-logo-wrap").show();
$(".login-mobile").show();
$(".mobile-logo").css({left : "0"});
$(".mobile-logo").css({right : "0"});
}     
});
/****************header js ends here*****************/

 /**********INDEX PAGE SLIDER MOVE*******/
   $(".left-hero").hover( 
    function () 
  {
    $(this).addClass("left-hero-expanded");
    //$(".initial").css("display: none");
    $(".right-hero").addClass("right-hero-collapsed");
    //$(".right-hero-collapsed .hide_other_p").css("display", "none");
  },
  function () {
    $(".left-hero").removeClass("left-hero-expanded");
    //$(".hide_other_p").css("display", "block");
    $(".right-hero").removeClass("right-hero-collapsed");
  }
);

  $(".right-hero").hover( 
    function () 
  { 
    $(this).addClass("right-hero-expanded");
    //$(".hide_other_p").css("display", "block");
    //$(".initial").css("display: none");
    $(".left-hero").addClass("left-hero-collapsed");
    //$(".left-hero-collapsed .hide_other_p").css("display", "none");
  },
    function () 
  {
    $(".right-hero").removeClass("right-hero-expanded");
    //$(".left-hero").css("left", "-35%");
    $(".left-hero").removeClass("left-hero-collapsed");
     
  }
);

  /***********FORM SECTION FOR INPUT RISING LABEL STARTS HERE**************/
  $('input').focus(function(){
  $(this).parents('.form-group').addClass('focused');
});

$('input').blur(function(){
  var inputValue = $(this).val();
  if ( inputValue == "" ) {
    $(this).removeClass('filled');
    $(this).parents('.form-group').removeClass('focused');  
  } else {
    $(this).addClass('filled');
  }
});
  $('textarea').focus(function(){
  $(this).parents('.form-group').addClass('focused');
});
$('textarea').blur(function(){
  var inputValue = $(this).val();
  if ( inputValue == "" ) {
    $(this).removeClass('filled');
    $(this).parents('.form-group').removeClass('focused');  
  } else {
    $(this).addClass('filled');
  }
}); 

/***********FORM SECTION FOR INPUT RISING LABEL ENDS HERE**************/
$(document).ready(function () {
  $('.form').parsley('validate');
    $(document).on("scroll", onScroll);
    
    //smoothscroll
   /* $('a[href^="#"]').on('click', function (e) {
        e.preventDefault();
        $(document).off("scroll");
        
        $('a').each(function () {
            $(this).removeClass('active_li');
        })
        $(this).addClass('active_li');
      
        var target = this.hash,
            menu = target;
        $target = $(target);
        $('html, body').stop().animate({
            'scrollTop': $target.offset().top+5
        }, 1000, 'swing', function () {
            window.location.hash = target;
            $(document).on("scroll", onScroll);
        });
    });*/
});

function onScroll(event){
    var scrollPos = $(document).scrollTop();
    $('.scrool_ul a').each(function () {
        var currLink = $(this);
        var refElement = $(currLink.attr("href"));
        if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
            $('ul.scrool_ul li a').removeClass("active");
            currLink.addClass("active");
        }
        else{
            currLink.removeClass("active");
        }
    });
}
/************FIX WHEN SCROLLING*******************/


$(window).scroll(function() {
var $height = $(window).scrollTop();
var menuposition = $(".aboutpagelink").position();
//alert(menuposition.top);

 if($height > menuposition.top()) {
    $('.aboutpagelink').addClass('activetop');
 } else {
    $('.aboutpagelink').removeClass('activetop');
 }
});




$('.submit_btn').click(function(){
 $('#contact_form').submit();
});

/**************add class active when tab change*********/
$(document).ready(function(){
  $('ul.headersecondpart li a').click(function(){
    $('li a').removeClass("active_account");
    $(this).addClass("active_account");
    // alert('ghvjk');
});
});