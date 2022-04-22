<script>

"use strict";
$(document).ready( function () {

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

    var quill = new Quill('#input_address', {
        theme: 'snow'
    });

    var address = $("#address").val();
    quill.clipboard.dangerouslyPasteHTML(address);
    quill.root.blur();
    $('#input_address').on('keyup', function(){
        var input_address = quill.container.firstChild.innerHTML;
        $("#address").val(input_address);
    });


    $(".select2").select2();
});

$(document).ready(function() {
    "use strict";
    $('.dropify').dropify();
    $('.dropify-fr').dropify({
        messages: {
            default: 'Glissez-déposez un fichier ici ou cliquez',
            replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
            remove: 'Supprimer',
            error: {
                'fileSize': 'The file size is too big  max.',
                'fileFormat': 'The image format is not allowed only.'
            }
        }
    });
    var drEvent = $('#input-file-events').dropify();
    drEvent.on('dropify.beforeClear', function(event, element) {
        return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
    });
    drEvent.on('dropify.afterClear', function(event, element) {
        alert('File deleted');
    });
    drEvent.on('dropify.errors', function(event, element) {
        console.log('Has Errors');
    });
    var drDestroy = $('#input-file-to-destroy').dropify();
    drDestroy = drDestroy.data('dropify')
    $('#toggleDropify').on('click', function(e) {
        e.preventDefault();
        if (drDestroy.isDropified()) {
            drDestroy.destroy();
        } else {
            drDestroy.init();
        }
    })
});
    </script>
