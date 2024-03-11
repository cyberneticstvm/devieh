$(document).ready(function () {
    "use strict"

    $("#branchSelector").modal('show');

    $('#myTable').addClass('nowrap').dataTable({
        responsive: true,
    });

    $('.select2').select2();

    $(document).on("change", ".appTime", function (e) {
        e.preventDefault();
        var formData = {
            date: $(".appdate").val(),
            doctor_id: $(".appdoctor").val(),
            branch_id: $(".appbranch").val(),
        };
        $.ajax({
            type: 'POST',
            url: '/admin/ajax/appointment/time',
            data: formData,
            dataType: 'json',
            success: function (res) {
                var xdata = $.map(res, function (obj) {
                    obj.text = obj.name || obj.id;
                    return obj;
                });
                $('.selAppTime').select2().empty();
                $('.selAppTime').select2({ data: xdata });
            },
            error: function (res) {
                failed(res);
                console.log(res);
            }
        });
    });

    $(document).on('change', '.pdct', function () {
        let dis = $(this)
        let pid = dis.val();
        if (pid > 0) {
            $.ajax({
                type: 'GET',
                url: '/admin/ajax/fetch/product/' + pid,
                dataType: 'json',
                success: function (res) {
                    dis.parent().parent().find('.qty').val('1');
                    dis.parent().parent().find('.price').val(res.price);
                    dis.parent().parent().find('.tot').val(res.price);
                    calculateTotal()
                },
                error: function (err) {
                    failed(err);
                    console.log(err);
                }
            });
        } else {
            dis.parent().parent().find('.qty').val('0');
            dis.parent().parent().find('.price').val('0.00');
            dis.parent().parent().find('.tot').val('0.00');
            calculateTotal()
        }
    });

    $(document).on('change', '.qty, .discount, .advance', function () {
        calculateTotal()
    });

    $(document).on("click", ".dltRow", function () {
        $(this).parent().parent().remove();
        calculateTotal();
    });

});

function calculateTotal() {
    var total = 0;
    $('.powerbox tr').each(function () {
        var dis = $(this);
        var qty = parseInt(dis.find(".qty").val()); var price = parseFloat(dis.find(".price").val()); var tot = (qty > 0 && price > 0) ? parseFloat(qty * price) : 0.00;
        dis.find(".tot").val(tot.toFixed(2));
        total += (tot > 0) ? tot : 0;
    });
    $(".total").val(parseFloat(total).toFixed(2));
    var discount = parseFloat($(".discount").val());
    var advance = (parseFloat($(".advance").val())) ? parseFloat($(".advance").val()) : 0;
    var balance = total - (advance + discount);
    $(".balance").val(parseFloat(balance).toFixed(2));
}

function addPharmacyOrderRow() {
    $.ajax({
        type: 'GET',
        url: '/admin/ajax/fetch/category/product/3',
        dataType: 'json',
        success: function (res) {
            $(".powerbox").append(`<tr><td><select class="form-control selPdct pdct" name="product_id[]" required><option></option></select></td><td><input type="text" name="qty[]" class="text-end qty" placeholder="0"></td><td><input type="text" name="batch_number[]" class="form-control" placeholder="Batch"></td><td><input type="text" name="dosage[]" class="form-control" placeholder="Dosage"></td><td><input type="text" name="duration[]" class="form-control" placeholder="Duration"></td><td><input type="text" name="price[]" class="text-end price" placeholder="0.00" readonly></td><td><input type="text" name="tot[]" class="text-end tot" placeholder="0.00" readonly></td><td class="text-center"><a href="javascript:void(0)" class="dltRow"><i class="fa fa-trash text-danger"></i></a></td></tr>`);
            var xdata = $.map(res, function (obj) {
                obj.text = obj.name || obj.id;
                return obj;
            });
            //$('.selPdct').last().select2().empty();                      
            $('.selPdct').last().select2({
                placeholder: 'Select',
                data: xdata
            });
        }
    });
}

function addStorePurchaseRow() {
    $.ajax({
        type: 'GET',
        url: '/admin/ajax/fetch/category/not/product/3',
        dataType: 'json',
        success: function (res) {
            $(".storePurchaseTbl").append(`<tr><td><select class="form-control purPdct" name="product_id[]" required><option></option></select></td><td><input type="number" name="qty[]" class="text-end form-control" min="1" step="1" placeholder="0"></td><td><input type="number" name="purchase_price[]" min="0" step="any" class="text-end form-control" placeholder="0.00"></td><td><input type="number" name="selling_price[]" min="0" step="any" class="text-end form-control" placeholder="0.00"></td><td class="text-center"><a href="javascript:void(0)" class="dltRow"><i class="fa fa-trash text-danger"></i></a></td></tr>`);
            var xdata = $.map(res, function (obj) {
                obj.text = obj.name || obj.id;
                return obj;
            });
            $('.purPdct').last().select2({
                placeholder: 'Select',
                data: xdata
            });
        }
    });
}

function addPharmacyPurchaseRow() {
    $.ajax({
        type: 'GET',
        url: '/admin/ajax/fetch/category/product/3',
        dataType: 'json',
        success: function (res) {
            $(".pharmacyPurchaseTbl").append(`<tr><td><select class="form-control purPdct" name="product_id[]" required><option></option></select></td><td><input type="number" name="qty[]" class="text-end form-control" min="1" step="1" placeholder="0"></td><td><input type="text" name="batch_number[]" class="form-control" placeholder="Batch Number" required></td><td><input type="date" name="expiry_date[]" class="form-control" placeholder="Batch Number" required></td><td><input type="number" name="purchase_price[]" min="0" step="any" class="text-end form-control" placeholder="0.00"></td><td><input type="number" name="selling_price[]" min="0" step="any" class="text-end form-control" placeholder="0.00"></td><td class="text-center"><a href="javascript:void(0)" class="dltRow"><i class="fa fa-trash text-danger"></i></a></td></tr>`);
            var xdata = $.map(res, function (obj) {
                obj.text = obj.name || obj.id;
                return obj;
            });
            $('.purPdct').last().select2({
                placeholder: 'Select',
                data: xdata
            });
        }
    });
}

function addStoreTransferRow() {
    $.ajax({
        type: 'GET',
        url: '/admin/ajax/fetch/category/not/product/3',
        dataType: 'json',
        success: function (res) {
            $(".storeTransferTbl").append(`<tr><td><select class="form-control purPdct" name="product_id[]" required><option></option></select></td><td><input type="number" name="qty[]" class="text-end form-control" min="1" step="1" placeholder="0" required></td><td class="text-center"><a href="javascript:void(0)" class="dltRow"><i class="fa fa-trash text-danger"></i></a></td></tr>`);
            var xdata = $.map(res, function (obj) {
                obj.text = obj.name || obj.id;
                return obj;
            });
            $('.purPdct').last().select2({
                placeholder: 'Select',
                data: xdata
            });
        }
    });
}

function addPharmacyTransferRow() {
    $.ajax({
        type: 'GET',
        url: '/admin/ajax/fetch/category/product/3',
        dataType: 'json',
        success: function (res) {
            $(".pharmacyTransferTbl").append(`<tr><td><select class="form-control purPdct" name="product_id[]" required><option></option></select></td><td><input type="text" name="batch_number[]" class="form-control" placeholder="Batch Number" required></td><td><input type="number" name="qty[]" class="text-end form-control" min="1" step="1" placeholder="0" required></td><td class="text-center"><a href="javascript:void(0)" class="dltRow"><i class="fa fa-trash text-danger"></i></a></td></tr>`);
            var xdata = $.map(res, function (obj) {
                obj.text = obj.name || obj.id;
                return obj;
            });
            $('.purPdct').last().select2({
                placeholder: 'Select',
                data: xdata
            });
        }
    });
}