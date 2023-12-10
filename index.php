<?php


?>
<label for="sqlTables">Select Table:</label>
<select id="sqlTables">
</select>
<br>
<br>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<table id="example" class="display" style="width:100%"></table>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $.ajax({
            url: 'server_processing.php?getTables=true',
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                var options = '<option></option>';
                $.each(data, function (key, value) {
                    options += '<option value="' + value + '">' + value + '</option>';
                });
                $('#sqlTables').html(options);
            }
        });
        $('#sqlTables').change(function () {
            var table = $(this).val();
            if (table === '') {
                return;
            }
            $.ajax({
                url: 'server_processing.php?getColoumns=true',
                type: 'POST',
                dataType: 'json',
                data: {
                    table: table
                },
                success: function (data) {
                    //destroy the table if it exists
                    if ($.fn.DataTable.isDataTable('#example')) {
                        console.log('destroying table');
                        $('#example').DataTable().clear().destroy();
                        $('#example').empty();
                    }
                    var columns = [];
                    $.each(data, function (key, value) {
                        columns.push({data: value.db, title: '<b>' + value.dt + '</b>'});
                        console.log(value.db);
                    });
                    console.log(columns);

                    $('#example').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": {
                            url: 'server_processing.php?getTable=true',
                            type: 'POST',
                            data: {
                                table: table
                            }
                        },
                        order: [],
                        columns: columns,
                    });
                }
            });
        });
    });
</script>
