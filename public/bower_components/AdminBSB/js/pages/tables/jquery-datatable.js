$(function () {
    $('.js-basic-example').DataTable({
        responsive: true
    });

    $('.js-basic-statuses').DataTable({
        responsive: true,
        bLengthChange : false
    });

    $('.js-resources-metas').DataTable({
        responsive: true,
        bLengthChange : false,
        searching: false,
        paging: false,
        "bInfo": false
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