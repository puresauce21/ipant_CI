$(document).ready(function(){

  /*=============smoothscroll==============*/  
  /*$('.buttons_main').click(function(){  
      $('html, body').animate({      
          scrollTop: $( $.attr(this, 'href') ).offset().top  }, 500);
           return false;
  });*/

  setTimeout(function() {
      // Do something after 2 seconds
      $('#messages').hide();
  }, 3000);

  
  $('.sign_leftbanner2 li a').click(function(){  
    $($.attr(this, 'href'))
  });
  /*=============smoothscroll==============*/ 
});
function saveData(frmid, frmaction, redirection, message = ''){
      $('#'+message).html('');
      var formData1 = new FormData($('#'+ frmid)[0]);
      $.ajax({
          type : "POST",
          url : frmaction,
          data : formData1,
          processData:false,
          contentType: false
      }).done(function(response) {
        //alert(response); 
        console.log(response);
        var result = JSON.parse(response);
        if(result.result == '1'){
          window.location.href = redirection;
        } else {
          $('#'+message).html(result.msg);
        }
      });
}

/*=================form================*/
/*=================number_count===========*/
$(document).ready(function (){
    var countb = 10;
    function myCount() {
    if (countb < 0) {
        countb = 0;
    }
    $('.countb').text(countb);
    countb --;     
    }
    setInterval(myCount,900);
});
/*=================number_count===========*/

  $(document).on('focusout', '.finduser', function(){
    //alert('this is user');
    var mobile_email = $(this).val();    
    var mobile_id = $(this).attr("id");
    $.ajax({
        url: BASEURL+"web/sharebill/finduser",
        type: "POST",
        data: {"mobile_email":mobile_email},
        cache: false,
        success: function(response){
            //alert(response);
            var data = JSON.parse(response);            
            if(data.status == 1){
              //console.log(data.data);
              //alert('find user');
              $("#"+mobile_id).nextAll(".sendtoerr").html( "<b>You Are Sending Money To " + data.data + "</b>");
              $('.buttonfinduser').removeAttr("disabled");
            } else {
              //alert(data.message);
              $("#"+mobile_id).next(".sendtoerr").html( data.message );
              //$("#"+mobile_id).focus();
              $('.buttonfinduser').prop("disabled", true);
            }
        }
     });
  });




  // Remove function for Send Money, Receive Money, Share Bill

  $(document).on('click', '.remove_button ', function(){
    var dividd = $(this).attr('divid');
    $('#'+dividd).remove();
    $('.add-btn-block').show();
    $('#equalamount').focus();
  });






  $(document).ready(function(){

    // Send Money 


    $(document).on('click', '.add_more_button ', function(){
      
     if($("#dynamic_sendmoney > div").length > 0){
        //alert($('#dynamic_sendmoney').children().last().attr('countname'));
        var i = parseInt($('#dynamic_sendmoney').children().last().attr('countname')) + 1;
      } else {
        var i = 1;
      }
      if($("#dynamic_sendmoney > div").length == 3){
          $('.add-btn-block').hide();
      }
      $('#dynamic_sendmoney').append("<div id='first_recipient"+i+"' countname='"+i+"'><div class='col-md-4 col-sm-4 col-xs-12'><div class='add-block clearfix'><a href='javascript:void(0);' divid='first_recipient"+i+"' class='remove_button pull-right' title='Remove'><i class='fa fa-remove'></i></a><div class='col-md-12 col-sm-12 col-xs-12'><div class='form-group'><label>Send to</label><input type='text' class='form-control finduser' id='sendto"+i+"' name='info["+i+"][mobile_email]' placeholder='Receivers Number / Email id' required=''><div class='sendtoerr'></div></div></div><div class='col-md-12 col-sm-12 col-xs-12'><div class='form-group'><label>Amount</label><div class='input-group mb15 ksh-input'><span class='input-group-addon'>Tk.</span><input class='form-control  checkAmount' type='number' name='info["+i+"][amount]'  placeholder='Amount' aria-describedby='basic-addon1' min='1' step='any' max='99999' value='' required=''></div></div></div><div class='col-md-12 col-sm-12 col-xs-12'><div class='form-group'><label>Comment</label><textarea class='form-control' rows='3' name='info["+i+"][comment]' maxlength='100' placeholder='Comment (Optional)'></textarea></div></div> </div></div></div>");
    });

      // Sharebill Money 

     $(document).on('click', '.add_more_button1', function(){
      if($("#dynamic_sharebill > div").length > 0){
        //alert($('#dynamic_sharebill').children().last().attr('countname'));
        var i = parseInt($('#dynamic_sharebill').children().last().attr('countname')) + 1;
      } else {
        var i = 1;
      }
      if($("#dynamic_sharebill > div").length == 3){
          $('.add-btn-block').hide();
      }
      $('#dynamic_sharebill').append("<div id='first_recipient"+i+"' countname='"+i+"'><div class='col-md-4 col-sm-4 col-xs-12'><div class='add-block clearfix'><a href='javascript:void(0);' divid='first_recipient"+i+"' class='remove_button pull-right' title='Remove'><i class='fa fa-remove'></i></a><div class='col-md-12 col-sm-12 col-xs-12'><div class='form-group'><label> Enter Mobile Number </label> <input type='text' class='form-control finduser' id='mobile_email"+i+"' name='info["+i+"][mobile_email]' placeholder='Enter Mobile Number' minlength='10' maxlength='10' required=''><div class='sendtoerr'></div></div></div><div class='col-md-12 col-sm-12 col-xs-12'><div class='form-group'><label>Amount</label><div class='input-group mb15 ksh-input'><span class='input-group-addon'>Tk.</span><input class='form-control amount checkAmount' type='number' name='info["+i+"][amount]' id='amount' min='1' maxlength='5' max='99000' step='any' value=' placeholder='Amount' required=''></div></div></div></div></div></div>");
        $('#equalamount').focus();
    });


    // Request Money
    
    $(document).on('click', '.add_more_button2', function(){
      if($("#dynamic_receivemoney > div").length > 0){
        //alert($('#dynamic_receivemoney').children().last().attr('countname'));
        var i = parseInt($('#dynamic_receivemoney').children().last().attr('countname')) + 1;
      } else {
        var i = 1;
      }
      if($("#dynamic_receivemoney > div").length == 3){
          $('.add-btn-block').hide();
      }
      $('#dynamic_receivemoney').append("<div id='first_recipient"+i+"' countname='"+i+"'><div class='col-md-4 col-sm-4 col-xs-12'><div class='add-block clearfix'><a href='javascript:void(0);' divid='first_recipient"+i+"' class='remove_button pull-right' title='Remove'><i class='fa fa-remove'></i></a><div class='col-md-12 col-sm-12 col-xs-12'><div class='form-group'><label>Receive Details</label><input type='text' class='form-control finduser'  name='info["+i+"][mobile_email]' placeholder='Receivers Number / Email id' required='' id='sendto"+i+"'><div class='sendtoerr'></div></div></div><div class='col-md-12 col-sm-12 col-xs-12'><div class='form-group'><label>Amount</label><div class='input-group mb15 ksh-input'><span class='input-group-addon'>Tk.</span><input class='form-control  checkAmount' type='number' name='info["+i+"][amount]'  placeholder='Amount' aria-describedby='basic-addon1' min='1' step='any' max='99999' value='' required=''></div></div></div><div class='col-md-12 col-sm-12 col-xs-12'><div class='form-group'><label>Comment</label><textarea class='form-control' rows='3' name='info["+i+"][comment]' maxlength='100' placeholder='Comment (Optional)'></textarea></div></div> </div></div></div>");
    });






  });

