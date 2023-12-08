<?php


?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<table id="example" class="display" style="width:100%"></table>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: 'server_processing.php',
                type: 'POST'
            },
            order: [],
            columns: []
        });
    });
</script>
