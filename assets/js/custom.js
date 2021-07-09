$(document).ready(function() {
    if ($("DataTable").length) {
        $("#example1").DataTable({        
        "language": {
            "url": "http://cdn.datatables.net/plug-ins/1.10.9/i18n/Indonesian.json",
            "sEmptyTable": "Tidak ada data di database"
        },
        "bStateSave": true,
            "fnStateSave": function (oSettings, oData) {
                localStorage.setItem('example1DataTable', JSON.stringify(oData));
            },
            "fnStateLoad": function (oSettings) {
                return JSON.parse(localStorage.getItem('example1DataTable'));
            }
        });

        $('.table_default').DataTable({
            "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>><"table-responsive"t>p',
            "pageLength": 25,
            "ordering": false
        });

        var table = $('.table-export').DataTable({
            "language": {
                "url": "../vendor/DataTables/Indonesian.json",
                "sEmptyTable": "Tidak ada data di database"
            },
            "dom": '<"row"<"col-sm-6 mb-xs"B><"col-sm-6"f>><"table-responsive"t>p',
            "lengthChange": false,
            "pageLength": 25,
            "columnDefs": [
                {targets: 'no-sort', orderable: false},
                {targets: [-1], orderable: false}
            ],
            "buttons": [
                {
                    extend: 'copyHtml5',
                    text: '<i class="far fa-copy"></i>',
                    titleAttr: 'Copy',
                    title: $('.export_title').html(),
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel"></i>',
                    titleAttr: 'Excel',
                    title: $('.export_title').html(),
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'csvHtml5',
                    text: '<i class="fa fa-file-alt"></i>',
                    titleAttr: 'CSV',
                    title: $('.export_title').html(),
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf"></i>',
                    titleAttr: 'PDF',
                    title: $('.export_title').html(),
                    footer: true,
                    customize: function ( win ) {
                        win.styles.tableHeader.fontSize = 10;
                        win.styles.tableFooter.fontSize = 10;
                        win.styles.tableHeader.alignment = 'left';
                    },
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i>',
                    titleAttr: 'Print',
                    title: $('.export_title').html(),
                    customize: function ( win ) {
                        $(win.document.body)
                            .css( 'font-size', '9pt' );

                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );

                        $(win.document.body).find( 'h1' )
                            .css( 'font-size', '14pt' );
                    },
                    footer: true,
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'colvis',
                    text: '<i class="fas fa-columns"></i>',
                    titleAttr: 'Columns',
                    title: $('.export_title').html(),
                    postfixButtons: ['colvisRestore']
                },
            ]
        });
    }

    $('#password, #cpassword').on('keyup', function () {
        if ($('#password').val() !== $('#cpassword').val()) {
            $('#alertplacepwd').html('Password dan Konfirmasi Password Tidak Cocok').css('color', 'red');
            $('#form_daftar button[type="submit"]').attr('disabled',true);
        } else {
            $('#alertplacepwd').html('');
            $('#form_daftar button[type="submit"]').attr('disabled',false);
        }
    });
});


function showalert(message,alerttype) {
    $('#alertplace').append('<div id="alertdiv" class="alert ' +  alerttype + '"><button class="close" data-dismiss="alert">×</button><span>'+message+'</span></div>')
}
