$("#addproduct").on('click', function () {

    var taxOn = $("#tax_status").val();
    var disOn = $("#discount_handle").val();
    var ganakChun = $("#ganak");
    var ganak = ganakChun.val();
    var cvalue = parseInt(ganak) + 1;
    var functionNum = "'" + cvalue + "'";
    count = $('#saman-row div').length;
var disp='';
var taxp='';
    if (taxOn != 'yes') { taxp='style="display: none;"';}
        taxcolmn = "<div class=\"col-sm-1 tax_col inpad\" "+taxp+"><input type=\"text\" class=\"form-control vat\" name=\"product_tax[]\" id=\"vat-" + cvalue + "\" onkeypress=\"return isNumber(event)\"  onkeyup=\"rowTotal(" + functionNum + "),billUpyog()\" autocomplete=\"off\"></div>";
    

    if (disOn != 'yes') { disp='style="display: none;"'; }
        discolm = "<div class=\"col-sm-1 disCol inpad\" "+disp+"><input type=\"text\" class=\"form-control discount\" name=\"product_discount[]\" id=\"discount-" + cvalue + "\" onkeypress=\"return isNumber(event)\"  onkeyup=\"rowTotal(" + functionNum + "),billUpyog()\" autocomplete=\"off\"> </div>";
    
//product row

    var data = '<tr><td><input type="text" class="form-control text-center" name="product_name[]" placeholder="Enter Product name or Code" id="productname-'+ cvalue +'"></td><td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-'+ cvalue +'" onkeypress="return isNumber(event)" onkeyup="rowTotal('+ functionNum +'), billUpyog()" autocomplete="off" value="1" ></td> <td><input type="text" class="form-control req prc" name="product_price[]" id="price-'+ cvalue +'" onkeypress="return isNumber(event)" onkeyup="rowTotal('+ functionNum +'), billUpyog()" autocomplete="off"></td><td> <input type="text" class="form-control vat" name="product_tax[]" id="vat-'+ cvalue +'" onkeypress="return isNumber(event)" onkeyup="rowTotal('+ functionNum +'), billUpyog()" autocomplete="off"></td> <td id="texttaxa-'+ cvalue +'" class="text-center">0</td> <td><input type="text" class="form-control discount" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-'+ cvalue +'" onkeyup="rowTotal('+ functionNum +'), billUpyog()" autocomplete="off"></td> <td><span class="currenty">'+ currency +'</span> <strong><span class=\'ttlText\' id="result-'+ cvalue +'">0</span></strong></td> <td class="text-center"><button type="button" data-rowid="'+ cvalue +'" class="btn btn-danger removeProd" title="Remove" > <i class="icon-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-'+ cvalue +'" value="0"><input type="hidden" name="disca[]" id="disca-'+ cvalue +'" value="0"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-'+ cvalue +'" value="0"> <input type="hidden" class="pdIn" name="pid[]" id="pid-'+ cvalue +'" value="0"> </tr>';

	//ajax request
   // $('#saman-row').append(data);
    $('tr.last-item-row').before(data);
    refreshRows();
    row = cvalue;
    $('#productname-' + cvalue).autocomplete({
        source: function (request, response) {
            $.ajax({
                url: baseurl + 'search_products/search',
                dataType: "json",
                method: 'post',
                data: {
                    name_startsWith: request.term,
                    type: 'product_list',
                    row_num: row
                },
                success: function (data) {
                    response($.map(data, function (item) {
                        var product = item.split("|");
                        return {
                            label: product[0],
                            value: product[0],
                            data: item
                        }
                    }));
                }
            });
        },
        autoFocus: true,
        minLength: 0,
        select: function (event, ui) {
            var names = ui.item.data.split("|");
            id_arr = $(this).attr('id');
            id = id_arr.split("-");
            $('#amount-' + id[1]).val(1);
            $('#price-' + id[1]).val(names[1]);
            $('#pid-' + id[1]).val(names[2]);
            $('#vat-' + id[1]).val(names[3]);
			$('#discount-' + id[1]).val(names[4]);
            rowTotal(id[1]); billUpyog();



        },
        create: function (e) {
            $(this).prev('.ui-helper-hidden-accessible').remove();
        }
    });

    ganakChun.val(cvalue);
   
    var samanKullYog = samanYog();

    var totalTaxSum = shipTot();
    var totalBillVal = deciFormat(samanKullYog + totalTaxSum);

    $("#invoiceyoghtml").val(totalBillVal);
    $("#totalBill").html(totalBillVal);

    var sideh2=document.getElementById('rough').scrollHeight;
    var opx3=sideh2+50;
    document.getElementById('rough').style.height=opx3+"px";


});



//caculations
var precentCalc = function (total, percentageVal) {

    return (total / 100) * percentageVal;
};
//format
var deciFormat = function (minput) {
    return parseFloat(minput).toFixed(2);
};
var formInputGet = function (iname, inumber) {

    var inputId;
    inputId = iname + "-" + inumber;
    var inputValue = $(inputId).val();
    if (inputValue === '') {
        return 0;
    } else {
        return inputValue;
    }

};

//ship calculation
var shipTot = function () {
if($('.shipVal').val()=='') {$('.shipVal').val(0);return 0;}
else{
    return deciFormat($('.shipVal').val());}


};
//product total
var samanYog = function () {

    var itempriceList = [];
    var r = 0;
    $('.ttInput').each(function () {
        var vv = $(this).val();

        if (vv === '') {
            vv = 0;
        }

        itempriceList.push(vv);
        r++;
    });
    var sum = 0;
    var taxc = 0;
    var discs = 0;

	  for (var z = 0; z < itempriceList.length; z++) {
        sum += parseFloat(itempriceList[z]);

        if($("#taxa-" + z).val()) { taxc +=  parseFloat($("#taxa-" + z).val()); }

        if($("#disca-" + z).val()) {discs +=  parseFloat($("#disca-" + z).val());}
    }

    discs = deciFormat(discs);

    taxc = deciFormat(taxc);
    sum = deciFormat(sum);
    $("#discs").html(discs);
    $("#taxr").html(taxc);
    return sum;

};




//actions
var deleteRow = function (num) {

    var prodTotalID;
    var prodttl;
    var subttl;
    var totalSubVal;

    var totalBillVal;
    var totalSelector = $("#subttlform");


    prodTotalID = "#total-" + num;

    prodttl =$(prodTotalID).val();
    subttl = totalSelector.val();
    totalSubVal = deciFormat(subttl - prodttl);
    totalSelector.val(totalSubVal);

    $("#subttlid").html(totalSubVal);
   
     totalBillVal = totalSubVal + shipTot;
    //final total
    $("#mahayog").html(deciFormat(totalBillVal));
    $("#invoiceyoghtml").val(deciFormat(totalBillVal));


};



var updateTotal = function () {

    var totalBillVal = deciFormat(parseFloat( samanYog()) + parseFloat(shipTot()));

    //refresh value

    $("#invoiceyoghtml").val(totalBillVal);
    $("#mahayog").html(totalBillVal);

    return totalBillVal;

};

var billUpyog = function () {

    $("#subttlform").val(samanYog());
    $("#invoiceyoghtml").val(updateTotal());

};

var rowTotal = function (numb) {
    //most res
    var result;
    var totalValue;
    var amountVal = formInputGet("#amount", numb);
    var priceVal = formInputGet("#price", numb);
    var discountVal = formInputGet("#discount", numb);
	if(discountVal=='') { $("#discount-"+numb).val(0);discountVal=0;}
    var vatVal = formInputGet("#vat", numb);
	if(vatVal=='') { $("#vat-"+numb).val(0);vatVal=0;}
    var taxo = 0;
    var disco = 0;

    var totalPrice = parseInt(amountVal) * priceVal;
    var tax_status = $("#tax_status").val();

   if (tax_status == 'yes') {
        var Inpercentage = precentCalc(totalPrice, vatVal);
        totalValue = parseFloat(totalPrice) +  parseFloat(Inpercentage);
        taxo = deciFormat(Inpercentage);
    }
	else {
        totalValue = deciFormat(totalPrice);

      
    }
    

    var disFormat = $("#discount_format").val();
    if (disFormat == 'flat') {
        disco = deciFormat(discountVal);
        totalValue =  parseFloat(totalValue) -  parseFloat(discountVal);
    }
    else if (disFormat == '%') {
        var discount = precentCalc(totalValue, discountVal);
        totalValue =  parseFloat(totalValue) -  parseFloat(discount);
        disco = deciFormat(discount);
    }
	else {
		totalValue = deciFormat(totalValue); }


    $("#result-" + numb).html(deciFormat(totalValue));
    $("#taxa-" + numb).val(taxo);
    $("#texttaxa-" + numb).text(taxo);
    $("#disca-" + numb).val(disco);
    var totalID = "#total-" + numb;
    $(totalID).val(deciFormat(totalValue));
    samanYog();


};

var changeTaxFormat = function (getSelectv) {

    if (getSelectv == 'on') {

        $(".tax_col").show();
        $("#tax_status").val('yes');
        $("#tax_format").val('%');
       

    }
    else {

        $("#tax_status").val('no');
		$("#tax_format").val('off');
        $(".tax_col").hide();
    }

    refreshRows();

    var discount_handle = $("#discount_format").val();
    var tax_handle = $("#tax_status").val();

    formatRest(tax_handle, discount_handle);

}

var changeDiscountFormat = function (getSelectv) {
    if (getSelectv != '0') {

        $(".disCol").show();
        $("#discount_handle").val('yes');
        $("#discount_format").val(getSelectv);

       

    }
    else {
		$("#discount_format").val(getSelectv);
        $(".disCol").hide();
        $("#discount_handle").val('no');
    }

    refreshRows();
    var tax_status = $("#tax_status").val();
    formatRest(tax_status, getSelectv);


}

function formatRest(taxFormat, disFormat) {

    var amntArray = [];
    $('.amnt').each(function () {
        var v = deciFormat($(this).val());
        amntArray.push(v);
    });

    var prcArray = [];
    $('.prc').each(function () {
        var v = deciFormat($(this).val());
        prcArray.push(v);
    });

    var vatArray = [];
    $('.vat').each(function () {
        var v = deciFormat($(this).val());

        vatArray.push(v);		
    });


    var discountArray = [];
    $('.discount').each(function () {
        var v = deciFormat($(this).val());
        discountArray.push(v);
    });

    var taxr=0;var discsr=0;
	
    for (var i = 0; i < amntArray.length; i++) {

        amtVal = amntArray[i];
        prcVal = prcArray[i];
        vatVal = vatArray[i];
        discountVal = discountArray[i];

        var result = amtVal * prcVal;

        if (vatVal == '') {
            vatVal = 0;
        }


        if (taxFormat == 'yes') {
            var Inpercentage = precentCalc(result, vatVal);
            var result = parseFloat(result) + Inpercentage;
            taxr =parseFloat(taxr)+parseFloat(Inpercentage);

            $("#texttaxa-" + i).html(deciFormat(Inpercentage));
            $("#taxa-" + i).val(deciFormat(Inpercentage));
        } else {
            var result = parseFloat($("#amount-" + i).val())  * parseFloat( $("#price-" + i).val() );

            $("#texttaxa-" + i).html('Off');
            $("#taxa-" + i).val(0);
            taxr+=0;

        }

        if(discountVal==''){ discountVal=0;}


        if (disFormat == '%') {
            var Inpercentage = precentCalc(result, discountVal);
            var result = parseFloat(result) - parseFloat(Inpercentage);
            $("#disca-" + i).val(deciFormat(Inpercentage));
            discsr =parseFloat(discsr)+parseFloat(Inpercentage);
        } else if (disFormat == 'flat') {
            var result = parseFloat(result) - parseFloat(discountVal);
            $("#disca-" + i).val(deciFormat(discountVal));
            discsr+=parseFloat(discountVal);
        }
        else {
            discountVal = 0;

            $("#disca-" + i).val('0');

        }

        $("#total-" + i).val(deciFormat(result));
        $("#result-" + i).html(deciFormat(result));

        var sum = deciFormat(samanYog());
        var itemSum = shipTot();

        var totl = deciFormat(sum + itemSum);

        $("#subttlform").val(sum);
        $("#subttlid").html(sum);
        $("#mahayog").html(totl);
        $("#taxr").html(deciFormat(taxr));
        $("#discs").html(deciFormat(discsr));
        $("#invoiceyoghtml").val(totl);

    }

}

function refreshRows() {

    var discount_handle = $("#discount_handle").val();
    var tax_status = $("#tax_status").val();

    if (tax_status == 'no' && discount_handle != 'no') {

        if ($('#saman-row').find('.col-sm-5').length != 0) {

            $('.extendable').each(function () {
                $('#saman-row, .items-pnl-head').find('.extendable').removeClass('col-sm-5');
                $('#saman-row, .items-pnl-head').find('.extendable').addClass('col-sm-6');
            });
        }

        if ($('#saman-row').find('.col-sm-7').length != 0) {

            $('.extendable').each(function () {
                $('#saman-row, .items-pnl-head').find('.extendable').removeClass('col-sm-7');
                $('#saman-row, .items-pnl-head').find('.extendable').addClass('col-sm-6');
            });
        }

    } else if (tax_status != 'no' && discount_handle == 'no') {

        if ($('#saman-row').find('.col-sm-5').length != 0) {
            $('.extendable').each(function () {
                $('#saman-row, .items-pnl-head').find('.extendable').removeClass('col-sm-5');
                $('#saman-row, .items-pnl-head').find('.extendable').addClass('col-sm-6');
            });
        }

        if ($('#saman-row').find('.col-sm-7').length != 0) {
            $('.extendable').each(function () {
                $('#saman-row, .items-pnl-head').find('.extendable').removeClass('col-sm-7');
                $('#saman-row, .items-pnl-head').find('.extendable').addClass('col-sm-6');
            });
        }

    } else if (tax_status == 'no' && discount_handle == 'no') {

        if ($('#saman-row').find('.col-sm-6').length != 0) {
            $('.extendable').each(function () {
                $('#saman-row, .items-pnl-head').find('.extendable').removeClass('col-sm-6');
                $('#saman-row, .items-pnl-head').find('.extendable').addClass('col-sm-7');
            });
        }

        if ($('#saman-row').find('.col-sm-5').length != 0) {
            $('.extendable').each(function () {
                $('#saman-row, .items-pnl-head').find('.extendable').removeClass('col-sm-5');
                $('#saman-row, .items-pnl-head').find('.extendable').addClass('col-sm-7');
            });
        }

    }
    else {
        $('.extendable').each(function () {
            $('#saman-row, .items-pnl-head').find('.extendable').removeClass('col-sm-6');
            $('#saman-row, .items-pnl-head').find('.extendable').addClass('col-sm-5');
        });
    }

}

//remove productrow


$( '#saman-row' ).on( 'click', '.removeProd', function () {





            var pidd = $(this).closest('tr').find('.pdIn').val();
            var pqty = $(this).closest('tr').find('.amnt').val();



            pqty = pidd + '-' + pqty;
            $('<input>').attr({
                type: 'hidden',
                id: 'restock',
                name: 'restock[]',
                value: pqty
            }).appendTo('form');
        $(this).closest('tr').remove();
            $('.amnt').each(function (index) {

                rowTotal(index);billUpyog();

            });
            $('.prc').each(function (index) {
                $(this).attr('id', 'price-' + index);
                var keyupFun1 = 'rowTotal("' + index + '")' + ',billUpyog()';
                $(this).attr('onkeyup', keyupFun1);
            });
            $('.vat').each(function (index) {
                $(this).attr('id', 'vat-' + index);
                var keyupFun1 = 'rowTotal("' + index + '")' + ',billUpyog()';
                $(this).attr('onkeyup', keyupFun1);
            });
            $('.discount').each(function (index) {
                $(this).attr('id', 'discount-' + index);
                var keyupFun1 = 'rowTotal("' + index + '")' + ',billUpyog()';
                $(this).attr('onkeyup', keyupFun1);
            });
            $('.ttInput').each(function (index) {
                $(this).attr('id', 'total-' + index);
            });
            $('.ttlText').each(function (index) {
                $(this).attr('id', 'result-' + index);
            });
            $('.removeProd').each(function (index) {
                var newIndex = parseInt(index) + 1;
                var clickFun = 'deleteRow("' + newIndex + '")';
                $(this).attr('onclick', clickFun);
            });


        return false;

    });
$('#productname-0').autocomplete({
    source: function (request, response) {
        $.ajax({
            url: baseurl + 'search_products/search',
            dataType: "json",
            method: 'post',
            data: {
                name_startsWith: request.term,
                type: 'product_list',
                row_num: 1
            },
            success: function (data) {
                response($.map(data, function (item) {
                    var product = item.split("|");
                    return {
                        label: product[0],
                        value: product[0],
                        data: item
                    }
                }));
            }
        });
    },
    autoFocus: true,
    minLength: 0,
    select: function (event, ui) {
        var names = ui.item.data.split("|");
        $('#amount-0').val(1);
        $('#price-0').val(names[1]);
        $('#pid-0').val(names[2]);
        $('#vat-0').val(names[3]);
        $('#discount-0').val(names[4]);
        rowTotal(0); billUpyog();

    }
});