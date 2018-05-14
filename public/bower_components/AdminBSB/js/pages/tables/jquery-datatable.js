$(function () {
    $('.js-basic-example').DataTable({
        responsive: true
    });

    $('.js-basic-statuses').DataTable({
        responsive: true,
        "bLengthChange" : false
    });

    //Exportable table
    $('.js-exportable').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});