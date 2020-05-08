/*!
 * Version: v0.1.0
 * @auther: Gokul Rathod
 * Copyright 2018-2019 
 * Released under the license
 * 
 */

$(document).ready(function() {
    setTimeout(function() {
        // Do something after 2 seconds
        $('#messages').hide();
    }, 2000);
    
    setTimeout(function() {
        // Do something after 15 seconds
        $('#messages_warning').hide();
    }, 15000);
    
     $('#select_all').on('click',function(){
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length){
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }
    });
    
   
   //Delete Confirmation Box
	$(document).on('click','.deleteaction',function(){
		if ($('.ischeckedaction').is(":checked")) {
			showErrorMessage('Are you sure you want to Delete ?');
			jConfirm(msg, 'Delete ?', function(r) {
				if(r){ 
					// action form submit
					$('#delete-form').submit();
				}
			});
		}else{
			//showErrorMessage('Please select atleast one record');
			showErrorMessage(select_record_error);
		}
	});

    // display image in upload mode
    $(document).ready(function() {
        var readURL = function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.profile-pic').attr('src', e.target.result);
                }
        
                reader.readAsDataURL(input.files[0]);
            }
        }
        

        $(".file-upload").on('change', function(){
            readURL(this);
        });
        
        $(".upload-button").on('click', function() {
           $(".file-upload").click();
        });
    });


    //user checkbox
    $('#user-list').on('click',function(){
        if(this.checked){
            $('.user-data').each(function(){
                $(this).prop('disabled', false);
            });
        }else{
             $('.user-data').each(function(){
                this.checked = false;
                $(this).prop('disabled', true);
            });
        }
    });  

    //Merchant checkbox
    $('#merchant-list').on('click',function(){
        if(this.checked){
            $('.merchant-data').each(function(){
                $(this).prop('disabled', false);
            });
        }else{
             $('.merchant-data').each(function(){
                this.checked = false;
                $(this).prop('disabled', true);
            });
        }
    });

    //agent checkbox
    $('#agent-list').on('click',function(){
        if(this.checked){
            $('.agent-data').each(function(){
                $(this).prop('disabled', false);
            });
        }else{
             $('.agent-data').each(function(){
                this.checked = false;
                $(this).prop('disabled', true);
            });
        }
    });
    
    //distributor checkbox
    $('#distributor-list').on('click',function(){
        if(this.checked){
            $('.distributor-data').each(function(){
               $(this).prop('disabled', false);
            });
        }else{
             $('.distributor-data').each(function(){
                this.checked = false;
                $(this).prop('disabled', true);
            });
        }
    });
    
    //sharebill checkbox
    $('#sharebill-list').on('click',function(){
        $('.sharebill-data').each(function(){
                $(this).prop('disabled', false);
            });
        if(this.checked){
        }else{
             $('.sharebill-data').each(function(){
                this.checked = false;
                $(this).prop('disabled', true);
            });
        }
    });

    //business checkbox
    $('#business-list').on('click',function(){
        if(this.checked){
            $('.business-data').each(function(){
                $(this).prop('disabled', false);
            });
        }else{
             $('.business-data').each(function(){
                this.checked = false;
                $(this).prop('disabled', true);
            });
        }
    });
    
    //category checkbox
    $('#category-list').on('click',function(){
        if(this.checked){
            $('.category-data').each(function(){
                $(this).prop('disabled', false);
            });
        }else{
             $('.category-data').each(function(){
                this.checked = false;
                $(this).prop('disabled', true);
            });
        }
    });

     //transaction limit checkbox
    $('#trans-limit').on('click',function(){
        if(this.checked){
            $('.view-limit').each(function(){
                $(this).prop('disabled', false);
            });
        }else{
             $('.view-limit').each(function(){
                this.checked = false;
                $(this).prop('disabled', true);
            });
        }
    });

    //faq checkbox
     $('#faq-list').on('click',function(){
        if(this.checked){
            $('.faq-data').each(function(){
                $(this).prop('disabled', false);
            });
        }else{
             $('.faq-data').each(function(){
                this.checked = false;
                $(this).prop('disabled', true);
            });
        }
    });

     //virtualfaq checkbox
    $('#virtualfaq-list').on('click',function(){
        if(this.checked){
            $('.virtualfaq-data').each(function(){
                $(this).prop('disabled', false);
            });
        }else{
             $('.virtualfaq-data').each(function(){
                this.checked = false;
                $(this).prop('disabled', true);
            });
        }
    }); 

    //tutorial wallet checkbox
    $('#tutorial-w-list').on('click',function(){
        if(this.checked){
            $('.tutorial-w-data').each(function(){
                $(this).prop('disabled', false);
            });
        }else{
             $('.tutorial-w-data').each(function(){
                this.checked = false;
                $(this).prop('disabled', true);
            });
        }
    }); 

    //tutorial master checkbox
    $('#tutorial-m-list').on('click',function(){
        if(this.checked){
            $('.tutorial-m-data').each(function(){
                $(this).prop('disabled', false);
            });
        }else{
             $('.tutorial-m-data').each(function(){
                this.checked = false;
                $(this).prop('disabled', true);
            });
        }
    }); 

    //settings checkbox
    // $('#web-setting').on('click',function(){
    //     if(this.checked){
    //         $('.change-password').each(function(){
    //             $(this).prop('disabled', false);
    //         });
    //     }else{
    //          $('.change-password').each(function(){
    //             this.checked = false;
    //             $(this).prop('disabled', true);
    //         });
    //     }
    // });


    $('#all-state').on('click',function(){
        if(this.checked){
            $('.dis-state').prop('disabled', true);
        }else{
            $('.dis-state').prop('disabled', false);
        }
    }); 

});

    // function to delete data in database 
    /*function deleteAction(){
        if ($('.ischeckedaction').is(":checked")) {
            swal({
                title:  "Are you sure you want to Delete?", 
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "Cancel",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                closeOnConfirm: false
            }, function () {
                swal("Deleted", "Delete successfully", "success");
                $('#delete-form').submit();
            });
        }else{
            showErrorMessage('Please select atleast one record');
        }
    }*/

	// function to delete data in database 
	function deleteAction(){
		if ($('.ischeckedaction').is(":checked")) {
            swal({
                title:  delete_confirmation, 
                type: "warning",
                showCancelButton: true,
                cancelButtonText: cancel,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: yes,
                closeOnConfirm: false
            }, function () {
                //swal(deleted, delete_successfully, success);
                swal("Deleted", "Delete successfully", "success");
				$('#delete-form').submit();
            });
		}else{
			showErrorMessage(select_record_error);
		}
	}

//alert message 
function showErrorMessage(ErrorMsg) {
    swal("",ErrorMsg);
}



// update ststus
function sweetalert(ids, status, urls, table, field, warning_msg, suc_msg) {
	var warning_msg = (warning_msg!='') ? warning_msg : '';
	var suc_msg = (suc_msg!='') ? suc_msg : '';
	var success     = success;
	var status_change   = status_change;
    swal({
        title: warning_msg,
        type: "warning",
        showCancelButton: true,
        cancelButtonText: cancel,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: yes_change,
        closeOnConfirm: false,
    }, function() {
		swal(suc_msg, status_change, success);
		var formData = {
            'ids': ids,
            'status': status,
            'table': table,
            'field': field,
        };
        $.ajax({
            type: 'POST',
            url: urls,
            dataType: 'json',
            async: false,
            data: formData,
            success: function(data) {
				if (data.isSuccess == true) {
                    refreshPge();
                } else {
                    $("#emailError").html('');
                }
            },
        });
    });
}



// function to delete single data in database 
function deleteData(id, urls){
    swal({
        title:  "Are you sure you want to Delete ?", 
        type: "warning",
        showCancelButton: true,
        cancelButtonText: "Cancel",
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        closeOnConfirm: false
    }, function () {
        swal("Deleted", "Delete successfully", "success");
            var formData    = {
                'id':id
                };
             $.ajax({
                type: 'POST',
                url: urls,
                dataType: 'json',
                async: false,
                data: formData, 
                success: function(data) {
                   refreshPge();
                },
            });
    });
}



//check staff code accept character
$(".check_no").keypress(function(e) {
    if (e.which != 8 && !(e.which >= 48 && e.which <= 57)) {
        return false;
    }
});


// page refresh
function refreshPge() {
    window.location.href = window.location.href;
}



// display image after upload
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#imgInp").change(function() {
    readURL(this);
});


// view share bill users
function getShareBillInfo(id, urls) {
    var formData = {
        'id': id,
    };
    $.ajax({
        type: 'POST',
        url: urls,
        dataType: 'json',
        async: true,
        data: formData,
        success: function(data) {
            var billData;
            data.forEach(function(key, value) {
                var record = '<tr><td>' + key.user + '</td>';
                record += '<td>' + key.amount + '</td>';
                record += '<td>' + key.status + '</td>';
                record += '<td>' + key.ref_num + '</td>';
                record += '</tr>';
                billData += record;
            });

            $('#shareBillId').html(billData);
            $("#modal-default").modal('show');
        },
    });
}

// view share bill pictures
function shareBillImage(id, urls){
    var formData = {
        'id': id,
    };
    $.ajax({
        type: 'POST',
        url: urls,
        dataType: 'json',
        async: true,
        data: formData,
        success: function(data) {
            var billImage="";
            data.forEach(function(key, value) {
                var bill = (key.bill_image!='') ? key.bill_image : "default.png";
                var record = '<img src="'+BASEURL+"uploads/share_bill/"+ bill +'"  class="margin" height="150" width="150">';   
                billImage += record;
            });            
            $('#shareBillimage').html(billImage);
            $("#bill-img").modal('show');
        },
    });
}



// view share bill pictures
function requestBillImage(id, urls){
    var formData = {
        'id': id,
    };
    $.ajax({
        type: 'POST',
        url: urls,
        dataType: 'json',
        async: true,
        data: formData,
        success: function(data) {
            var billImage="";
            data.forEach(function(key, value) {
                var bill = (key.bill_image!='') ? key.bill_image : "default.png";
                var record = '<img src="'+BASEURL+"uploads/send_request/"+ bill +'"  class="margin" height="150" width="150">';   
                billImage += record;
            });            
            $('#requestBillimage').html(billImage);
            $("#req-bill").modal('show');
        },
    });
}




function getStatesByCountryId(){
    var st_country=$("#st_country").val();
    $.post(BASEURL+"admin/agent/getStateList/",{st_country:st_country},function(data){
        $("#st_state").html(data);
    }); 
}


function getCityByStateId(){    
     var st_state=$("#st_state").val();
     $.post(BASEURL+"admin/agent/getCityList/",{st_state:st_state},function(data){
        $("#st_city").html(data);
     }); 
}

 
