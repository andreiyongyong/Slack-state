$(function () {
    $('.js-basic-example').DataTable({
        responsive: true
    });

    $('.js-basic-statuses').DataTable({
        responsive: true,
        bLengthChange : false,
        "pageLength": 100
    });

    $('.js-resources-metas').DataTable({
        responsive: true,
        bLengthChange : false,
        searching: false,
        paging: false,
        "bInfo": false
    });

    $('.group-table').DataTable({
        responsive: true,
        bLengthChange : false,
        searching: false,
        paging: false,
        order: [[ 1, "asc" ]],
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