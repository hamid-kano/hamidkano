function selectCustomer(cid, cname, cadd1, cadd2, ph, email, discount = 0) {
    $('#customer_id').val(cid);
    $('#custom_discount').val(discount);
    $('#customer_name').html('<strong>' + cname + '</strong>');
    $('#customer_name').val(cname);
    $('#customer_address1').html('<strong>' + cadd1 + '<br>' + cadd2 + '</strong>');
    $('#customer_phone').html('Phone: <strong>' + ph + '</strong><br>Email: <strong>' + email + '</strong>');
    $("#customer-box").val();
    $("#customer-box-result").hide();
    $(".sbox-result").hide();
    $("#customer").show();
}

function PselectCustomer(cid, cname, discount) {
    $('#customer_id').val(cid);
    $('#custom_discount').val(discount);

    $('#customer_name').html('<strong>' + cname + '</strong>');
    $("#customer-box-result").hide();
    $("#customer").show();
}

function selectSupplier(cid, cname, cadd1, cadd2, ph, email) {
    $('#customer_id').val(cid);
    $('#customer_name').html('<strong>' + cname + '</strong>');
    $('#customer_name').val(cname);
    $('#customer_address1').html('<strong>' + cadd1 + '<br>' + cadd2 + '</strong>');
    $('#customer_phone').html('Phone: <strong>' + ph + '</strong><br>Email: <strong>' + email + '</strong>');
    $("#customer-box").val();
    $("#supplier-box-result").hide();
    $("#customer").show();
}


function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 44 || charCode > 57)) {
        return false;
    }
    return true;
}


$(document).ready(function () {


    $("#customer-box").keyup(function () {
        $.ajax({
            type: "GET",
            url: baseurl + 'search_products/csearch',
            data: 'keyword=' + $(this).val() + '&' + crsf_token + '=' + crsf_hash,
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

    $("#pos-customer-box").keyup(function () {
        $.ajax({
            type: "GET",
            url: baseurl + 'search_products/pos_c_search',
            data: 'keyword=' + $(this).val() + '&' + crsf_token + '=' + crsf_hash,
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

    $('#warehouses').change(function () {
        var whr = $('#warehouses option:selected').val();
        var cat = $('#categories option:selected').val();
        $.ajax({
            type: "POST",
            url: baseurl + 'search_products/pos_search',
            data: 'wid=' + whr + '&cid=' + cat + '&' + crsf_token + '=' + crsf_hash,
            beforeSend: function () {
                $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {

                $("#pos_item").html(data);

            }
        });
    });


    $('#categories').change(function () {
        var whr = $('#warehouses option:selected').val();
        var cat = $('#categories option:selected').val();
        $.ajax({
            type: "POST",
            url: baseurl + 'search_products/pos_search',
            data: 'wid=' + whr + '&cid=' + cat + '&' + crsf_token + '=' + crsf_hash,
            beforeSend: function () {
                $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {

                $("#pos_item").html(data);

            }
        });
    });


    $('#search_bar').keyup(function () {
        var whr = $('#warehouses option:selected').val();
        var cat = $('#categories option:selected').val();
        $.ajax({
            type: "POST",
            url: baseurl + 'search_products/pos_search',
            data: 'name=' + $(this).val() + '&wid=' + whr + '&cid=' + cat + '&' + crsf_token + '=' + crsf_hash,
            beforeSend: function () {
                $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {

                $("#pos_item").html(data);

            }
        });
    });


    $('#v2_search_bar').keyup(function () {

        var whr = $('#v2_warehouses option:selected').val();
        var cat = $('#v2_categories option:selected').val();
        $.ajax({
            type: "POST",
            url: baseurl + 'search_products/v2_pos_search',
            data: 'name=' + $(this).val() + '&wid=' + whr + '&cid=' + cat + '&' + crsf_token + '=' + crsf_hash,
            beforeSend: function () {

                $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {

                $("#pos_item").html(data);

            }
        });
    });

    $("#supplier-box").keyup(function () {

        $.ajax({
            type: "GET",
            url: baseurl + 'search_products/supplier',
            data: 'keyword=' + $(this).val() + '&' + crsf_token + '=' + crsf_hash,
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
            data: 'keyword=' + $(this).val() + '&' + crsf_token + '=' + crsf_hash,
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
            data: 'keyword=' + $(this).val() + '&' + crsf_token + '=' + crsf_hash,
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

$(document).on('click', "#thermal_p", function (e) {
    var ptid = $(this).attr('data-ptid');
    e.preventDefault();
    $.ajax({
        url: baseurl + 'pos_invoices/thermal_print?id=' + ptid,
        dataType: 'json',
        data: crsf_token + '=' + crsf_hash,
        success: function (data) {
            if (data.status == 'Success') {
                $("#thermal_a").removeClass("alert-warning").addClass("alert alert-info").fadeIn();
                $("#thermal_a .message").html(data.message);
                $("html, body").animate({scrollTop: $('#thermal_a').offset().bottom}, 1000);
            } else {
                $("#thermal_a").removeClass("alert-success").addClass("alert-warning").fadeIn();
                $("#thermal_a .message").html(data.message);
                $("html, body").animate({scrollTop: $('#thermal_a').offset().bottom}, 1000);
            }
        }
    });
});

$(document).on('click', "#thermal_server", function (e) {
    var ptid = $(this).attr('data-ptid');
    var url = $(this).attr('data-url');
    e.preventDefault();
    $.ajax({
        url: url + '?id=' + ptid,
        data: crsf_token + '=' + crsf_hash,
        dataType: 'html',
        success: function (data) {
            $("#thermal_a").removeClass("alert-warning").addClass("alert alert-info").fadeIn();
            $("#thermal_a .message").html('Success');
            $("html, body").animate({scrollTop: $('#thermal_a').offset().bottom}, 1000);
        }
    });

});

//part
$(document).on('click', "#submitpayment", function (e) {
    e.preventDefault();

    var pyurl = baseurl + 'transactions/payinvoice';
    payInvoice(pyurl);

});
$(document).on('click', "#purchasepayment", function (e) {
    e.preventDefault();

    var pyurl = baseurl + 'transactions/paypurchase';

    payInvoice(pyurl);


});
$(document).on('click', "#recpayment", function (e) {
    e.preventDefault();

    var pyurl = baseurl + 'transactions/pay_recinvoice';

    payInvoice(pyurl);


});

function payInvoice(pyurl) {

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
            data: $('form.payment').serialize() + '&' + crsf_token + '=' + crsf_hash,
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

function loadEmailTem(action) {

    jQuery.ajax({

        url: baseurl + 'emailinvoice/template',
        type: 'POST',
        data: action + '&' + crsf_token + '=' + crsf_hash,
        dataType: 'json',
        beforeSend: function () {
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

$('.sendbill').click(function (e) {
    e.preventDefault();
    $('#emailtype').val($(this).attr('data-type'));
    $('#itype').val($(this).attr('data-itype'));

});
$('.sendsms').click(function (e) {
    e.preventDefault();
    $('#smstype').val($(this).attr('data-type'));

});
$("#sendEmail").on("show.bs.modal", function (e) {
    var action = 'ttype=' + $('#emailtype').val() + '&invoiceid=' + $('#invoiceid').val() + '&itype=' + $('#itype').val()+ '&ref=' + $('#ref').val();
    loadEmailTem(action);
});

$("#sendSMS").on("show.bs.modal", function (e) {
    var action = 'ttype=' + $('#smstype').val() + '&invoiceid=' + $('#invoiceid').val()+ '&ref=' + $('#ref').val();
    loadSmsTem(action);
});

function loadSmsTem(action) {

    jQuery.ajax({

        url: baseurl + 'sms/template',
        type: 'POST',
        data: action + '&' + crsf_token + '=' + crsf_hash,
        dataType: 'json',
        beforeSend: function () {
            setTimeout(
                console.log('loading')
                , 5000);
        },
        success: function (data) {
            $('#request_sms').hide();
            $('#smsbody').show();
            $('#sms_tem').html(data.message);
        },
        error: function (data) {
            $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
            $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
            $("html, body").scrollTop($("body").offset().top);
        }
    });

}

$('#submitSMS').on('click', function (e) {
    e.preventDefault();
    $("#sendSMS").modal('hide');

    var action = 'mobile=' + $('#smstype').val() + '&message=' + $('#invoiceid').val();

    sendSms(action);

});

function sendSms(message) {
    var errorNum = farmCheck();
    $("#sendEmail").modal('hide');
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to enter mobile number!");
        $("html, body").animate({scrollTop: $('#notify').offset().bottom}, 1000);
    } else {
        jQuery.ajax({
            url: baseurl + 'sms/send_sms',
            type: 'POST',
            data: $('#sendsms').serialize() + '&' + crsf_token + '=' + crsf_hash,
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

//mail
function sendBill(message) {
    var errorNum = farmCheck();
    $("#sendEmail").modal('hide');
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to enter email!");
        $("html, body").animate({scrollTop: $('#notify').offset().bottom}, 1000);
    } else {
        jQuery.ajax({
            url: baseurl + 'communication/send_invoice',
            type: 'POST',
            data: $('#sendbill').serialize() + '&message=' + encodeURIComponent(message) + '&' + crsf_token + '=' + crsf_hash,
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
        var acturl = 'transactions/cancelinvoice';
        cancelBill(acturl);
    });
});

function cancelBill(acturl) {
    var $btn;
    var errorNum = farmCheck();
    $("#cancel_bill").modal('hide');
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>");
        $("html, body").animate({scrollTop: $('#notify').offset().bottom}, 1000);
    } else {
        jQuery.ajax({
            url: baseurl + acturl,
            type: 'POST',
            data: $('form.cancelbill').serialize() + '&' + crsf_token + '=' + crsf_hash,
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
    var actionurl = baseurl + 'reports/customincome';
    actionCaculate(actionurl);
});
$("#calculate_expense").click(function (e) {
    e.preventDefault();
    var actionurl = baseurl + 'reports/customexpense';
    actionCaculate(actionurl);
});

function actionCaculate(actionurl, f_name = '#product_action') {
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
            data: $(f_name).serialize() + '&' + crsf_token + '=' + crsf_hash,
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
    var actionurl = baseurl + 'invoices/addcustomer';
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
            data: $("#product_action").serialize() + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {
                if (data.status == 'Success') {


                    $("#statusMsg").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#statusMsg").removeClass("alert-warning").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('html, body').offset().top}, 200);
                    $('#customer_id').val(data.cid);
                    $('#customer_name').html('<strong>' + $('#mcustomer_name').val() + '</strong>');
                    $('#customer_address1').html('<strong>' + $('#mcustomer_address1').val() + '<br>' + $('#mcustomer_city').val() + ',' + $('#mcustomer_country').val() + '</strong>');
                    $('#customer_phone').html('Phone: <strong>' + $('#mcustomer_phone').val() + '</strong><br>Email: <strong>' + $('#mcustomer_email').val() + '</strong>');
                    $('#customer_pass').html('Login Password ' + data.pass);
                     $('#custom_discount').val(data.discount);
                    $("#customer-box").val();
                    $("#customer-box-result").hide();
                    $("#customer").show();
                    $('#addCustomer').find('input:text,input:hidden').val('');
                    $("#addCustomer").modal('toggle');
                    $("#Pos_addCustomer").modal('toggle');
                } else {
                    $("#statusMsg").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#statusMsg").removeClass("alert-success").addClass("alert-warning").fadeIn();
                    $("html, body").animate({scrollTop: $('#statusMsg').offset().top}, 1000);
                }
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
$('.icheck-activity').click(function (e) {
    var actionurl = 'tools/set_task';
    var id = $(this)[0].value;
    var stat = '';
    var hid = $(this).attr('id');
    if ($(this)[0].checked) {
        stat = 'Done';
        $('#s' + hid).removeClass("task_Due").addClass('task_Done');
    } else {
        stat = 'Due';
        $('#s' + hid).removeClass("task_Done").addClass('task_Due');
    }
    $('#s' + hid).text(stat);
    $.ajax({
        url: baseurl + actionurl,
        type: 'POST',
        data: 'tid=' + id + '&stat=' + stat + '&' + crsf_token + '=' + crsf_hash,
        dataType: 'json',
        success: function (data) {

        }
    });

});

$(document).on('click', ".check", function (e) {
    e.preventDefault();
    var actionurl = 'tools/set_task';
    var rval = 'Due';
    var id = $(this).attr('data-id');
    var stat = $(this).attr('data-stat');
    if (stat == 'Done') {
        $(this).attr('data-stat', 'Due');
        $(this).toggleClass('text-success text-default');
    } else {
        $(this).toggleClass('text-default text-success');
        $(this).attr('data-stat', 'Done');
        rval = 'Done';
    }
    $.ajax({
        url: baseurl + actionurl,
        type: 'POST',
        data: 'tid=' + id + '&stat=' + rval + '&' + crsf_token + '=' + crsf_hash,
        dataType: 'json',
        success: function (data) {
        }
    });
});
//universal list item delete from table
$(document).on('click', ".delete-object", function (e) {
    e.preventDefault();
    $('#object-id').val($(this).attr('data-object-id'));
    $('#object-ref').val($(this).attr('data-object-ref'));
    
    $(this).closest('tr').attr('id', $(this).attr('data-object-id'));
    $(this).closest('tr').attr('ref', $(this).attr('data-object-ref'));
    $('#delete_model').modal({backdrop: 'static', keyboard: false});

});
$(document).on('click', ".delete-object2", function (e) {
    e.preventDefault();
    $('#object-id2').val($(this).attr('data-object-id'));
    $('#object-ref').val($(this).attr('data-object-ref'));
    $(this).closest('tr').attr('id', $(this).attr('data-object-id'));
     $(this).closest('tr').attr('ref', $(this).attr('data-object-ref'));
    $('#delete_model2').modal({backdrop: 'static', keyboard: false});

});
$("#delete-confirm").on("click", function () {
    var o_data = 'deleteid=' + $('#object-id').val()+'&ref=' + $('#object-ref').val();
    var action_url = $('#delete_model #action-url').val();
    removeObject(o_data, action_url)
});
$("#delete-confirm2").on("click", function () {
    var o_data = 'deleteid=' + $('#object-id2').val();
    var action_url = $('#delete_model2 #action-url2').val();
    $('#' + $('#object-id2').val()).remove();
    removeObject(o_data, action_url);
});



function removeObject(action, action_url) {
    if ($("#notify").length == 0) {
        $("#c_body").html('<div id="notify" class="alert" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
    }
    jQuery.ajax({
        url: baseurl + action_url,
        type: 'POST',
        data: action + '&' + crsf_token + '=' + crsf_hash,
        dataType: 'json',
        success: function (data) {
            if (data.status == "Success") {
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                $("html, body").scrollTop($("body").offset().top);
                $('#' + $('#object-id').val()).remove();
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
$("#submit-data").on("click", function (e) {
    e.preventDefault();
    var o_data = $("#data_form").serialize();
    var action_url = $('#action-url').val();
    addObject(o_data, action_url);
});
$("#submit-data2").on("click", function (e) {
    e.preventDefault();
    var o_data = $("#data_form2").serialize();
    var action_url = $('#action-url2').val();
    addObject(o_data, action_url);
});

function addObject(action, action_url) {
    var errorNum = farmCheck();
    var $btn;
    if ($("#notify").length == 0) {
        $("#c_body").html('<div id="notify" class="alert" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
    }
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to complete something!");
        $("html, body").scrollTop($("body").offset().top);
    } else {
        jQuery.ajax({
            url: baseurl + action_url,
            type: 'POST',
            data: action + '&' + crsf_token + '=' + crsf_hash,
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
            data: $("#product_action").serialize() + '&' + crsf_token + '=' + crsf_hash,
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
    var o_data = $("#sendmail_form").serialize();
    var action_url = $('#sendMail #action-url').val();
    sendMail_g(o_data, action_url);
});

$(document).on('click', "#upda", function (e) {
    e.preventDefault();
    var errorNum = farmCheck();
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to details!");
        $("html, body").animate({scrollTop: $('body').offset().top}, 1000);
    } else {
        var action_url = $("#core").val();
        $.ajax({
            url: baseurl + action_url,
            type: 'POST',
            data: $("#activ").serialize() + '&' + crsf_token + '=' + crsf_hash,
            dataType: 'json',
            success: function (data) {

                if (data.status == 'Success') {
                    $("#notify .message").html("<strong>Success</strong>: Thank You! License updated, please refresh the page.");
                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                    setTimeout(function () {
                        window.location.href = baseurl;
                    }, 1000);
                } else if (data.status == 'WError') {
                    $("#notify .message").html("<strong>Error</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                } else if (data.status == 'Error') {
                    $("#notify .message").html("<strong>Error</strong>: " + data.message + " <a class='blue' href='http://bit.ly/georegular' target='_blank'>Purchase another copy</a> OR <a href='http://bit.ly/2IsOoFa' target='_blank'> Read the license terms!</a>");
                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                } else {
                    setTimeout(function () {
                        window.location.href = baseurl;
                    }, 100);
                }
            }
        });

    }
});


function sendMail_g(o_data, action_url) {
    var errorNum = farmCheck();
    $("#sendMail").modal('hide');
    if ($("#notify").length == 0) {
        $("#c_body").html('<div id="notify" class="alert" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
    }

    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
        $("#notify .message").html("<strong>Error</strong>");
        $("html, body").animate({scrollTop: $('body').offset().top}, 1000);
    } else {
        jQuery.ajax({
            url: baseurl + action_url,
            type: 'POST',
            data: o_data + '&' + crsf_token + '=' + crsf_hash,
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
    var o_data = $("#form_model").serialize();
    var action_url = $('#form_model #action-url').val();
    $("#pop_model").modal('hide');
    saveMData(o_data, action_url);
});

$(document).on('click', "#submit_model2", function (e) {
    e.preventDefault();
    var o_data = $("#form_model2").serialize();
    var action_url = $('#form_model2 #action-url').val();
    $("#pop_model2").modal('hide');
    saveMData(o_data, action_url);
});

$(document).on('click', "#submit_model3", function (e) {
    e.preventDefault();
    var o_data = $("#form_model3").serialize();
    var action_url = $('#form_model3 #action-url').val();
    $("#pop_model3").modal('hide');
    saveMData(o_data, action_url);
});

function saveMData(o_data, action_url) {
    var errorNum = farmCheck();
    if (errorNum > 0) {
        $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
        $("#notify .message").html("<strong>Error</strong>");
        $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
    } else {
        jQuery.ajax({
            url: baseurl + action_url,
            type: 'POST',
            data: o_data + '&' + crsf_token + '=' + crsf_hash,
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
    var d_csrf = crsf_token + '=' + crsf_hash;
    $.ajax({
        url: baseurl + actionurl,
        type: 'POST',
        dataType: 'json',
        data: d_csrf,
        success: function (data) {
            var i = 0;
            //  var obj = jQuery.parseJSON(data);
            $.each(data, function (key, value) {
                for (ind in value) {
                    $('#dash_' + i).text(value[ind]);
                    i++;
                }
            });
        }
    });
}

//universal list item delete from table

$(document).on('click', ".delete-custom", function (e) {
    e.preventDefault();
    var did = $(this).attr('data-did');
    $('#object-id_' + did).val($(this).attr('data-object-id'));
    // $(this).closest('section').attr('id','d_'+$(this).attr('data-object-id'));
    $(this).closest("*[data-block]").attr('id', 'd_' + $(this).attr('data-object-id'));

    $('#delete_model_' + did).modal({backdrop: 'static', keyboard: false});
    // $("#notify .message")
    $('#delete_model_' + did + ' .delete-confirm').attr('data-mid', did);
});

$(".delete-confirm").on("click", function () {
    var did = $(this).attr('data-mid');
    var o_data = $('#mform_' + did).serialize();
    var action_url = $('#action-url_' + did).val();
    $('#d_' + $('#object-id_' + did).val()).remove();
    removeObject_c(o_data, action_url);
});

function removeObject_c(action, action_url) {

    jQuery.ajax({
        url: baseurl + action_url,
        type: 'POST',
        data: action + '&' + crsf_token + '=' + crsf_hash,
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

$("#copy_address").change(function () {
    if ($(this).prop("checked") == true) {
        // alert("Checkbox is checked." );
        $('#mcustomer_name_s').val($('#mcustomer_name').val());
        $('#mcustomer_phone_s').val($('#mcustomer_phone').val());
        $('#mcustomer_email_s').val($('#mcustomer_email').val());
        $('#mcustomer_address1_s').val($('#mcustomer_address1').val());
        $('#mcustomer_city_s').val($('#mcustomer_city').val());
        $('#region_s').val($('#region').val());
        $('#mcustomer_country_s').val($('#mcustomer_country').val());
        $('#postbox_s').val($('#postbox').val());
    } else {
        $('#mcustomer_name_s').val('');
        $('#mcustomer_phone_s').val('');
        $('#mcustomer_email_s').val('');
        $('#mcustomer_address1_s').val('');
        $('#mcustomer_city_s').val('');
        $('#region_s').val('');
        $('#mcustomer_country_s').val('');
        $('#postbox_s').val('');
    }
});

$('.apply_coupon').click(function (e) {

    e.preventDefault();
    var actionurl = 'pos_invoices/set_coupon';
    var coupon = $('#coupon').val();

    $.ajax({

        url: baseurl + actionurl,
        type: 'POST',
        data: 'coupon=' + coupon + '&' + crsf_token + '=' + crsf_hash,
        dataType: 'json',
        success: function (data) {
            $('#r_coupon').html(data.message);
            if (data.status == 'Success') $('#i_coupon').val(data.message);
            $('#coupon_amount').val(accounting.unformat(data.amount, accounting.settings.number.decimal));
            billUpyog();
        }

    });

});
