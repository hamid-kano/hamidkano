function selectCustomer(cid, cname, cadd1, cadd2, ph, email) {


    $('#customer_id').val(cid);
    $('#customer_name').html('<strong>'+cname+'</strong>');
    $('#customer_name').val(cname);
    $('#customer_address1').html('<strong>'+cadd1+'<br>'+cadd2+'</strong>');
    $('#customer_phone').html('Phone: <strong>'+ph+'</strong><br>Email: <strong>'+email+'</strong>');
    $("#customer-box").val();

    $("#customer-box-result").hide();
    $("#customer").show();
}






function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 46 || charCode > 57)) {
        return false;
    }
    return true;
}






$(document).ready(function () {


    $("#customer-box").keyup(function () {
        $.ajax({
            type: "GET",
            url: baseurl + 'search_products/csearch',
            data: 'keyword=' + $(this).val(),
            beforeSend: function () {
                $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#customer-box-result").show();
                $("#customer-box-result").html(data);
                $("#customer-box").css("background", "none");

            }
        });
    });

    $("#supplier-box").keyup(function () {
        $.ajax({
            type: "GET",
            url: baseurl + 'search_products/supplier',
            data: 'keyword=' + $(this).val(),
            beforeSend: function () {
                $("#supplier-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#supplier-box-result").show();
                $("#supplier-box-result").html(data);
                $("#supplier-box").css("background", "none");

            }
        });
    });

    $("#invoice-box").keyup(function () {
        $.ajax({
            type: "GET",
            url: baseurl + 'search/invoice',
            data: 'keyword=' + $(this).val(),
            beforeSend: function () {
                $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#invoice-box-result").show();
                $("#invoice-box-result").html(data);
                $("#invoice-box").css("background", "none");

            }
        });
    });

    $("#head-customerbox").keyup(function () {
        $.ajax({
            type: "GET",
            url: baseurl + 'search/customer',
            data: 'keyword=' + $(this).val(),
            beforeSend: function () {
                $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {
                $("#head-customerbox-result").show();
                $("#head-customerbox-result").html(data);
                //$("#invoice-box").css("background", "none");

            }
        });
    });



});
//make payment 


//part
$(document).on('click', "#submitpayment", function (e) {
    e.preventDefault();

   var pyurl=baseurl + 'transactions/payinvoice';

        payInvoice(pyurl);


});
$(document).on('click', "#purchasepayment", function (e) {
    e.preventDefault();

    var pyurl=baseurl + 'transactions/paypurchase';

    payInvoice(pyurl);


});
$(document).on('click', "#recpayment", function (e) {
    e.preventDefault();

    var pyurl=baseurl + 'transactions/pay_recinvoice';

    payInvoice(pyurl);


});
function payInvoice(pyurl) {
    var $btn;
    var errorNum = farmCheck();
    $("#part_payment").modal('hide');
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to enter partial amount!");
        $("html, body").animate({scrollTop: $('#notify').offset().bottom}, 1000);
    } else {
        jQuery.ajax({

            url: pyurl,
            type: 'POST',
            data: $('form.payment').serialize(),
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#pstatus').html(data.pstatus);
                    $('#activity').append(data.activity);
                    $('#rmpay').val(data.amt);
                    $('#paymade').text(data.ttlpaid);
                    $('#paydue').text(data.amt);

                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);

                }

            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    }

}

//////////////send

function loadEmailTem (action) {

    jQuery.ajax({

        url: baseurl + 'emailinvoice/template',
        type: 'POST',
        data: action,
        dataType: 'json',
        beforeSend: function() {
            setTimeout(

                console.log('loading')
                , 5000);
        },
        success: function (data) {
            $('#request').hide();
            $('#emailbody').show();
            $('#subject').val(data.subject);
            $('.note-editable').html(data.message);




        },
        error: function (data) {
            $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
            $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
            $("html, body").scrollTop($("body").offset().top);
        }
    });

}
$('.sendbill').click( function (e) {
    e.preventDefault();
    $('#emailtype').val($(this).attr('data-type'));

});

$("#sendEmail").on("show.bs.modal", function(e) {
    var action= 'ttype='+$('#emailtype').val()+'&invoiceid='+$('#invoiceid').val();
       loadEmailTem(action);



});



function sendBill(message) {

    var errorNum = farmCheck();
    $("#sendEmail").modal('hide');
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to enter partial amount!");
        $("html, body").animate({scrollTop: $('#notify').offset().bottom}, 1000);
    } else {
        jQuery.ajax({

            url: baseurl + 'communication/send_invoice',
            type: 'POST',
            data: $('#sendbill').serialize()+'&message='+encodeURIComponent(message),
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }

            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    }

}
////////////////////////////////////////////////////////////

//////////////cancel


$(document).on('click', "#cancel-bill", function (e) {
    e.preventDefault();

    $('#cancel_bill').modal({backdrop: 'static', keyboard: false}).one('click', '#send', function () {
        var acturl='transactions/cancelinvoice';
        cancelBill(acturl);


    });
});





function cancelBill(acturl) {
    var $btn;
    var errorNum = farmCheck();
    $("#cancel_bill").modal('hide');
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to enter partial amount!");
        $("html, body").animate({scrollTop: $('#notify').offset().bottom}, 1000);
    } else {
        jQuery.ajax({

            url: baseurl + acturl,
            type: 'POST',
            data: $('form.cancelbill').serialize(),
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
                setTimeout(function () {// wait for 5 secs(2)
                    location.reload(); // then reload the page.(3)
                }, 2000);

            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    }

}


/////// product add edit actions

//calcualtions


$("#calculate_income").click(function (e) {
    e.preventDefault();
    var actionurl= baseurl + 'reports/customincome';
    actionCaculate(actionurl);
});
$("#calculate_expense").click(function (e) {
    e.preventDefault();
    var actionurl= baseurl + 'reports/customexpense';
    actionCaculate(actionurl);
});
function actionCaculate(actionurl) {

    var errorNum = farmCheck();
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to complete something!");
        $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
    } else {

        $(".required").parent().removeClass("has-error");


        $.ajax({

            url: actionurl,
            type: 'POST',
            data: $("#product_action").serialize(),
            dataType: 'json',
            success: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-warning").addClass("alert-success").fadeIn();


                $("html, body").animate({scrollTop: $('html, body').offset().top}, 200);
              //  $("#product_action").remove();
                $("#param1").html(data.param1);
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);

            }

        });
    }

}




$("#mclient_add").click(function (e) {
    e.preventDefault();
    var actionurl = baseurl + 'customers/addcustomer';
    searchCS(actionurl);
});
$("#msupplier_add").click(function (e) {
    e.preventDefault();
    var actionurl = baseurl + 'supplier/addsupplier';
    searchCS(actionurl);
});
function searchCS(actionurl) {


    var errorNum = farmCheck2();
    if (errorNum > 0) {
        $("#statusMsg").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#statusMsg").html("<strong>Error</strong>: It appears you have forgotten to complete something!");
        $("html, body").animate({scrollTop: $('#statusMsg').offset().top}, 1000);
    } else {

        $(".crequired").parent().removeClass("has-error");


        $.ajax({

            url: actionurl,
            type: 'POST',
            data: $("#product_action").serialize(),
            dataType: 'json',
            success: function (data) {
                $("#statusMsg").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#statusMsg").removeClass("alert-warning").addClass("alert-success").fadeIn();


                $("html, body").animate({scrollTop: $('html, body').offset().top}, 200);



                $('#customer_id').val(data.cid);
                $('#customer_name').html('<strong>'+$('#mcustomer_name').val()+'</strong>');
                $('#customer_address1').html('<strong>'+$('#mcustomer_address1').val()+'<br>'+$('#mcustomer_city').val()+','+$('#mcustomer_country').val()+'</strong>');
                $('#customer_phone').html('Phone: <strong>'+$('#mcustomer_phone').val()+'</strong><br>Email: <strong>'+$('#mcustomer_email').val()+'</strong>');
                $("#customer-box").val();

                $("#customer-box-result").hide();
                $("#customer").show();



                $('#addCustomer').find('input:text,input:hidden').val('');
                $("#addCustomer").modal('toggle');

            },
            error: function (data) {
                $("#statusMsg").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#statusMsg").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").animate({scrollTop: $('#statusMsg').offset().top}, 1000);

            }

        });
    }


}


//task manager

$('.checkbox').click(function (e) {


    var actionurl=  'tools/set_task';
    var id =$(this)[0].value;var stat='';


   if($(this)[0].checked){stat=1;}else {stat=0;}

    $.ajax({

        url: baseurl+actionurl,
        type: 'POST',
        data: {'tid':id,'stat':stat},
        dataType: 'json',
        success: function (data) {

        }

    });

});

$(document).on('click', ".check", function (e) {
    e.preventDefault();

    var actionurl=  'tools/set_task';var rval=0;
    var id =$(this).attr('data-id');var stat=$(this).attr('data-stat');


    if(stat==1){$(this).attr('data-stat',0);
        $(this).toggleClass('text-success text-default');} else {$(this).toggleClass('text-default text-success');$(this).attr('data-stat',1); rval=1;}

    $.ajax({

        url: baseurl+actionurl,
        type: 'POST',
        data: {'tid':id,'stat':rval},
        dataType: 'json',
        success: function (data) {

        }

    });

});



//universal list item delete from table

$(document).on('click', ".delete-object", function (e) {
    e.preventDefault();
    $('#object-id').val($(this).attr('data-object-id'));
    $(this).closest('tr').attr('id',$(this).attr('data-object-id'));
    $('#delete_model').modal({backdrop: 'static', keyboard: false});

});

$("#delete-confirm").on("click", function() {
    var o_data = 'deleteid=' + $('#object-id').val();
    var action_url= $('#action-url').val();
    $('#'+$('#object-id').val()).remove();
    removeObject(o_data,action_url);
});

function removeObject(action,action_url) {

    jQuery.ajax({

        url: baseurl + action_url,
        type: 'POST',
        data: action,
        dataType: 'json',
        success: function (data) {
            if (data.status == "Success") {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            } else {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);

            }

        },
        error: function (data) {
            $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
            $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
            $("html, body").scrollTop($("body").offset().top);

        }
    });

}

//universal create
$("#submit-data").on("click", function(e) {
    e.preventDefault();
    var o_data =  $("#data_form").serialize();
    var action_url= $('#action-url').val();
    addObject(o_data,action_url);
});

function addObject(action,action_url) {


    var errorNum = farmCheck();
    var $btn;
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to complete something!");
        $("html, body").scrollTop($("body").offset().top);
    } else {

        jQuery.ajax({

            url: baseurl + action_url,
            type: 'POST',
            data: action,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $("#data_form").remove();

                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);

                }

            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").scrollTop($("body").offset().top);

            }
        });
    }

}

//
function actionProduct(actionurl) {

    var errorNum = farmCheck();
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to complete something!");
        $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
    } else {

        $(".required").parent().removeClass("has-error");


        $.ajax({

            url: actionurl,
            type: 'POST',
            data: $("#product_action").serialize(),
            dataType: 'json',
            success: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-warning").addClass("alert-success").fadeIn();


                $("html, body").animate({scrollTop: $('html, body').offset().top}, 200);
                //   $("#product_action").remove();
            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);

            }

        });
    }

}

//uni sender

$('#sendMail').on('click', '#sendNow', function (e) {
    e.preventDefault();
    var o_data =  $("#sendmail_form").serialize();
    var action_url= $('#sendMail #action-url').val();


    sendMail_g(o_data,action_url);

});


function sendMail_g(o_data,action_url) {

    var errorNum = farmCheck();
    $("#sendMail").modal('hide');
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to enter partial amount!");
        $("html, body").animate({scrollTop: $('body').offset().top}, 1000);
    } else {
        jQuery.ajax({

            url: baseurl + action_url,
            type: 'POST',
            data: o_data,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").animate({scrollTop: $('body').offset().top}, 1000);
                }

            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").animate({scrollTop: $('body').offset().top}, 1000);
            }
        });
    }

}

//generic model

//part
$(document).on('click', "#submit_model", function (e) {
    e.preventDefault();

    var o_data =  $("#form_model").serialize();
    var action_url= $('#form_model #action-url').val();
    $("#pop_model").modal('hide');

    saveMData(o_data,action_url);


});

$(document).on('click', "#submit_model2", function (e) {
    e.preventDefault();

    var o_data =  $("#form_model2").serialize();
    var action_url= $('#form_model2 #action-url').val();
    $("#pop_model2").modal('hide');

    saveMData(o_data,action_url);


});
function saveMData(o_data,action_url) {

    var errorNum = farmCheck();

    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to enter partial amount!");
        $("html, body").animate({scrollTop: $('#notify').offset().bottom}, 1000);
    } else {
        jQuery.ajax({

            url: baseurl + action_url,
            type: 'POST',
            data: o_data,
            dataType: 'json',
            success: function (data) {
                if (data.status == "Success") {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                    $('#pstatus').html(data.pstatus);


                } else {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);

                }

            },
            error: function (data) {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
            }
        });
    }

}

function miniDash() {

    var actionurl = $('#dashurl').val();


    $.ajax({

        url: baseurl + actionurl,
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            var i=0;
            //  var obj = jQuery.parseJSON(data);
            $.each(data, function (key, value) {

                for ( ind in value ) {

                    $('#dash_'+i).text(value[ind]);

                    i++;
                }
            });




        }

    });

}