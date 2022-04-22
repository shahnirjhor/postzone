<script>
"use strict";

$('#myModal').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('action', $(e.relatedTarget).data('href'));
});

$(document).ready( function () {
    "use strict";
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

$(document.body).on('click','#submit_smtp',function(){
    "use strict";
    var itemName = "{{ $ApplicationSetting->item_name  }}";
    $('#submit_smtp').addClass('disabled');

    var email = $("#email").val();
    var smtp_host = $("#smtp_host").val();
    var smtp_port = $("#smtp_port").val();
    var smtp_user = $("#smtp_user").val();
    var smtp_password = $("#smtp_password").val();
    var smtp_type = $("#smtp_type").val();
    var status = $("#status").val();


    if(email=="") {
        alertify.alert(itemName, 'Please Type Your Smtp Email');
        return;
    }

    if(smtp_host=="") {
        alertify.alert(itemName, 'Please Type Your Smtp Host');
        return;
    }
    if(smtp_port=="") {
        alertify.alert(itemName, 'Please Type Your Smtp Port');
        return;
    }
    if(smtp_user=="") {
        alertify.alert(itemName, 'Please Type Your Smtp User');
        return;
    }
    if(smtp_password=="") {
        alertify.alert(itemName, 'Please Type Your Smtp Password');
        return;
    }
    if(smtp_type == "") {
        alertify.alert(itemName, 'Please Select a SMTP Type');
        return;
    }
    if(status=="") {
        alertify.alert(itemName, 'Please Select Status');
        return;
    }

    $.ajax({
        url: '{{ url('apsetting/smtpAction') }}',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        type:'POST',
        data:{email:email,smtp_host:smtp_host,smtp_port:smtp_port,smtp_user:smtp_user,smtp_password:smtp_password,smtp_type:smtp_type,status:status},
        dataType:'json',
        success:function(response){
            if(response.status==0){
                alertify.alert(itemName, 'Oops something wrong.And try again.', function(){
                    $('#submit_smtp').removeClass('disabled');
                    location.reload();
                });
            }
            else {
                alertify.alert(itemName, 'Succussfully Insert SMTP Configuration :)', function(){
                    $('#submit_smtp').removeClass('disabled');
                    location.reload();
                });
            }
        }
    });
});

$(document.body).on('click','.edit_smtp',function(){
    "use strict";
    var itemName = "{{ $ApplicationSetting->item_name  }}";
    var smtp_table_id = $(this).attr('table_id');
    $.ajax({
        url:'{{ url('apsetting/getEditSmtpData') }}',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        method:"POST",
        data:{smtp_table_id:smtp_table_id},
        dataType:"JSON",
        success:function(data)
        {
            $("#edit_table_id").val(data.table_id);
            $("#edit_user_id").val(data.user_id);
            $("#edit_email").val(data.email);
            $("#edit_smtp_host").val(data.smtp_host);
            $("#edit_smtp_port").val(data.smtp_port);
            $("#edit_smtp_user").val(data.smtp_user);
            $("#edit_smtp_password").val(data.smtp_password);
            $("#edit_smtp_type option[value='"+data.smtp_type+"']").attr("selected","selected");
            $("#edit_status option[value='"+data.status+"']").attr("selected","selected");
            $('#edit_smtp_modal').modal('show');
        }
    });
});

$(document.body).on('click','#edit_submit_smtp',function() {
    "use strict";
    var itemName = "{{ $ApplicationSetting->item_name  }}";
    $("#edit_submit_smtp").prop("edit_submit_smtp", true);
    var table_id = $("#edit_table_id").val();
    var user_id = $("#edit_user_id").val();
    var edit_email = $("#edit_email").val();
    var edit_smtp_host = $("#edit_smtp_host").val();
    var edit_smtp_port = $("#edit_smtp_port").val();
    var edit_smtp_user = $("#edit_smtp_user").val();
    var edit_smtp_password = $("#edit_smtp_password").val();
    var edit_smtp_type = $("#edit_smtp_type").val();
    var edit_status = $("#edit_status").val();

    if (edit_email == "") {
        alertify.alert(itemName, 'Please Type Your Smtp Email');
        return;
    }

    if (edit_smtp_host == "") {
        alertify.alert(itemName, 'Please Type Your Smtp Host');
        return;
    }

    if (edit_smtp_port == "") {
        alertify.alert(itemName, 'Please Type Your Smtp Port');
        return;
    }

    if (edit_smtp_user == "") {
        alertify.alert(itemName, 'Please Type Your Smtp User');
        return;
    }

    if (edit_smtp_password == "") {
        alertify.alert(itemName, 'Please Type Your Smtp Password');
        return;
    }

    if (edit_smtp_type == "") {
        alertify.alert(itemName, 'Please Select SMTP Type');
        return;
    }

    if (edit_status == "") {
        alertify.alert(itemName, 'Please Select Status');
        return;
    }

    var demo = "{{ $ApplicationSetting->is_demo }}";
    if (demo == 1) {
        var itemName = "{{ $ApplicationSetting->item_name  }}";
        alertify.alert(itemName, 'This Feature Is Disabled In Demo Version');
    } else {
        $.ajax({
            url: '{{ url('apsetting/updateEditSmtpAction') }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            type: 'POST',
            data: {
                table_id: table_id,
                user_id: user_id,
                edit_email: edit_email,
                edit_smtp_host: edit_smtp_host,
                edit_smtp_port: edit_smtp_port,
                edit_smtp_user: edit_smtp_user,
                edit_smtp_password: edit_smtp_password,
                edit_smtp_type: edit_smtp_type,
                edit_status: edit_status
            },
            dataType: 'json',
            success: function (response) {
                // alert(response.errorMessage);
                if (response.status == 0) {
                    alertify.alert(itemName, 'Oops something wrong.And try again.', function () {
                        location.reload();
                    });
                } else {
                    alertify.alert(itemName, 'Succussfully Edit Smtp :)', function () {
                        location.reload();
                    });
                }
            }
        });
    }
});

$(document.body).on('click','.delete_smtp',function(){
    "use strict";
    var demo = "{{ $ApplicationSetting->is_demo }}";
    if(demo == 1){
        var itemName = "{{ $ApplicationSetting->item_name  }}";
        alertify.alert(itemName, 'This Feature Is Disabled In Demo Version');
    } else {
        var itemName = "{{ $ApplicationSetting->item_name  }}";
        var smtp_table_id = $(this).attr('table_id');
        alertify.confirm(itemName, 'Do you want to delete this smtp configuration from database???',
            function(clickYes){
                alertify.success('Ok');
                if(clickYes) {
                    $.ajax
                    ({
                        type:'POST',
                        url:'{{ url('apsetting/deleteSmtpAction') }}',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        data:{smtp_table_id:smtp_table_id},
                        dataType:'JSON',
                        success:function(response) {
                            if(response.success) {
                                location.reload();
                            }
                        }
                    });
                }
            },
            function(){
                alertify.error('Cancel');
            }
        );
    }
});
</script>
