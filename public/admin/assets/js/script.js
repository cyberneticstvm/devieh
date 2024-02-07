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
});