$(document).ready(function () {
    "use strict"

    $("#branchSelector").modal('show');

    $('#myTable').addClass('nowrap').dataTable({
        responsive: true,
    });

    $('.select2').select2();
});