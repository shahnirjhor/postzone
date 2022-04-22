<script>

"use strict";
$(document).ready( function () {

    $('.dropify').dropify();

    var rolefor = $('#role_for').val();
    if(rolefor == '1') {
        $('#staff_block').show();
        $('#user_block').hide();
    } else {
        $('#staff_block').hide();
        $('#user_block').show();
    }

    $('#role_for').change(function(){
        if($('#role_for').val() == '1') {
            $('#staff_block').show();
            $('#user_block').hide();
        } else {
            $('#staff_block').hide();
            $('#user_block').show();
        }
    });
});

$(document).ready(function() {
    "use strict";
    $(".select2").select2();
});

$(document).ready(function() {
    "use strict";
    var equill = new Quill('#edit_input_address', {
        theme: 'snow'
    });
    var address = $("#address").val();
    equill.clipboard.dangerouslyPasteHTML(address);
    equill.root.blur();
    $('#edit_input_address').on('keyup', function(){
         var edit_input_address = equill.container.firstChild.innerHTML;
         $("#address").val(edit_input_address);
    });

});
</script>
