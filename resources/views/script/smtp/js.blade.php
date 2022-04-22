<script>

"use strict";
$('#myModal').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('action', $(e.relatedTarget).data('href'));
});
$(document).ready( function () {
    $('#laravel_datatable').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "responsive": true,
    });
});

</script>
