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
    var advance = parseFloat($(".advance").val());
    var balance = total - (advance + discount);
    $(".balance").val(parseFloat(balance).toFixed(2));
}