$(document).ready(function() {
  function setHeight() {
    windowHeight = $(window).innerHeight();
    $('.page-content').css('min-height', windowHeight - '249');
  };
  setHeight();
  
  $(window).resize(function() {
    setHeight();
  });
});