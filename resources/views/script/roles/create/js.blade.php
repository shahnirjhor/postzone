<script>
    "use strict";
    $(document).ready(function () {
        if ($("#role_for").val() == "1") {
            $("#user_block").hide();
        } else {
            $("#user_block").show();
        }
        $("#role_for").change(function () {
            if ($("#role_for").val() == "1") {
                $("#user_block").hide();
            } else if ($("#role_for").val() == "0") {
                $("#user_block").show();
            }
        });

    });
</script>
