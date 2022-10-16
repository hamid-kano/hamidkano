//reset customer
$(document).ready(function () {


//billing subtotal calculations
    function antimYog() {
        var kull = 0, mafi = 0, deliv = parseInt($('.jod.deliv').val()) || 0;
        $('#saman_list article').each(function () {
            var jodsub = $('.jod-sub', this).val(),
                iqty = $('[name="saman_qty[]"]', this).val(),
                price = $('[name="billsaman_price[]"]', this).val() || 0,
                upyog = parseInt(iqty) * parseFloat(price);
            kull += parseFloat(jodsub);
            mafi += upyog - parseFloat(jodsub);
        });
        var subT = parseFloat(kull),
            lastJod = parseFloat(kull),
            vat = parseFloat($('.jod.vvt').val()) || parseFloat($('.djod.vvt').val()),
            cvat = (vat / 100) * lastJod;
        $('.bill-disc').text(mafi.toFixed(2));
        $('#bill_disc').val(mafi.toFixed(2));

        if ($('.bill-tax').attr('data-enable-tax') === '1') {
            if ($('.bill-tax').attr('data-tax-method') === '1') {
                var zvatp = lastJod - cvat;
                var tvat = (vat / 100) * zvatp;
                var fvat = cvat - tvat;
                var subtt = zvatp + fvat;

                $('.bill-sub-yog').text(subtt.toFixed(2));
                $('#bill_upyog').val(subtt.toFixed(2));
                $('.bill-tax').text(((vat / 100) * subtt).toFixed(2));
                $('#bill_tax').val(((vat / 100) * subtt).toFixed(2));
                $('.bill-yog').text((lastJod + deliv).toFixed(2));
                $('#bill_yog').val((lastJod + deliv).toFixed(2));
            } else {

                $('.bill-sub-yog').text(subT.toFixed(2));
                $('#bill_upyog').val(subT.toFixed(2));
                $('.bill-tax').text(((vat / 100) * subT).toFixed(2));
                $('#bill_tax').val(((vat / 100) * subT).toFixed(2));
                $('.bill-yog').text((lastJod + ((vat / 100) * lastJod) + deliv).toFixed(2));
                $('#bill_yog').val((lastJod + ((vat / 100) * lastJod) + deliv).toFixed(2));
            }
        } else {
            $('.bill-sub-yog').text(subT.toFixed(2));
			$('#bill_upyog').val(subT.toFixed(2));
            $('.bill-yog').text((lastJod + deliv).toFixed(2));
            $('#bill_yog').val((lastJod + deliv).toFixed(2));
        }

    }

//billing total calculations
    function antimYogupdate(elem) {

        var tr = $(elem).closest('article'),
            iqty = $('[name="saman_qty[]"]', tr).val(),
            price = $('[name="billsaman_price[]"]', tr).val(),
            isPercent = $('[name="bill_saman_discount[]"]', tr).val().indexOf('%') > -1,
            percent = $.trim($('[name="bill_saman_discount[]"]', tr).val().replace('%', '')),
            upyog = parseInt(iqty) * parseFloat(price);

        if (percent && $.isNumeric(percent) && percent !== 0) {
            if (isPercent) {
                upyog = upyog - ((parseFloat(percent) / 100) * upyog);
            } else {
                upyog = upyog - parseFloat(percent);
            }
        } else {
            $('[name="bill_saman_discount[]"]', tr).val('');
        }

        $('.jod-sub', tr).val(upyog.toFixed(2));
    }


//select product dropdown
    $(document).on('click', ".product-select", function (e) {

        e.preventDefault;

        var product = $(this);

        $('#insert').modal({backdrop: 'static', keyboard: false}).one('click', '#selected', function (e) {

            var itemText = $('#insert').find("option:selected").text();
            var itemValue = $('#insert').find("option:selected").val();

            $(product).closest('article').find('.bill_saman').val(itemText);
            $(product).closest('article').find('.billsaman_price').val(itemValue);
            $(product).closest('article').find('.jod-sub').val(itemValue);
            antimYog();

        });

        return false;

    });
    $(document).on('click', ".product-select", function (e) {

        e.preventDefault;

        var product = $(this);

        $('#insert').modal({backdrop: 'static', keyboard: false}).one('click', '#elected', function (e) {

            var itemText = $('#insert').find("option:selected").text();
            var itemValue = $('#insert').find("option:selected").val();

            $(product).closest('article').find('.bill_saman').val(itemText);
            $(product).closest('article').find('.billsaman_price').val(itemValue);
            $(product).closest('article').find('.jod-sub').val(itemValue);
            antimYog();

        });

        return false;

    });
//select customer dropdown
    $(document).on('click', ".grahk-select", function (e) {

        e.preventDefault;

        var customer = $(this);

        $('#insert_grahk').modal({backdrop: 'static', keyboard: false});

        return false;

    });



  //  $('#tsn_date, #tsn_due').datetimepicker({
 //       showClose: true

//    });




    $('#saman_list').on('click', ".delete-row", function (e) {
        e.preventDefault();
        $(this).closest('article').remove();
        antimYog();
    });

    var cloned = $('#saman_list article:last').clone();
    $(".add-row").click(function (e) {

        e.preventDefault();
        cloned.clone().appendTo('#saman_list');
        antimYog();
    });


    $('#saman_list').on('input', '.jod', function () {
        antimYogupdate(this);
        antimYog();
    });

    $('#bill_totl').on('input', '.jod', function () {
        antimYog();
    });

    $('#bill_saman').on('input', '.jod', function () {
        antimYog();
    });


});
function farmCheck() {

    var errorNum = 0;

    $(".required").each(function (i, obj) {

        if ($(this).val() === '') {
            $(this).parent().addClass("has-error");
            errorNum++;
        } else {
            $(this).parent().removeClass("has-error");
        }


    });
    $(".vrequired").each(function (i, obj) {

        if ($(this).val() === '0') {
            $(this).parent().addClass("has-error");
            errorNum++;
        } else {
            $(this).parent().removeClass("has-error");
        }


    });

    return errorNum;
}
function farmCheck2() {

    var errorNum = 0;

    $(".crequired").each(function (i, obj) {

        if ($(this).val() === '') {
            $(this).parent().addClass("has-error");
            errorNum++;
        } else {
            $(this).parent().removeClass("has-error");
        }


    });


    return errorNum;
}
