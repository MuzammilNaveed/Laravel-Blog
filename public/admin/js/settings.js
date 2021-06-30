$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    // save profile info
    $("#saveProfile").submit(function(event) {
        event.preventDefault();

        let action = $(this).attr('action');
        let method = $(this).attr('method');

        $.ajax({
            url: action,
            type: method,
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend:function(data) {
                $("#profile_loader").show();
            },
            success: function(data) {
                if ((data.status == 200) & (data.success == true)) {
                    notyf.success(data.message);
                } else {
                    notyf.error(data.message);
                }
            },
            complete:function(data) {
                $("#profile_loader").hide();
            },
            error: function(e) {
                console.log(e);
                $("#profile_loader").hide();
            }

        });

    });



    // change password call
    $("#changePasswordForm").submit(function(event) {
        event.preventDefault();

        let action = $(this).attr('action');
        let method = $(this).attr('method');

        let password = $("#password").val();
        let confirm_password = $("#confirm_password").val();

        if( $.trim(password) != $.trim(confirm_password) ) {
            notyf.error('Password not matched try again...');
        }else{
            $.ajax({
                url: action,
                type: method,
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend:function(data) {
                    $("#password_loader").show();
                },
                success: function(data) {
                    console.log(data);
                    if ((data.status == 200) & (data.success == true)) {
                        notyf.success(data.message);
                    } else {
                        notyf.error(data.message);
                    }
                },
                complete:function(data) {
                    $("#password_loader").hide();
                },
                error: function(e) {
                    console.log(e);
                    $("#password_loader").hide();
                }
    
            });
        }

    });


    // save website info
    $("#settingForm").submit(function(event) {
        event.preventDefault();

        let action = $(this).attr('action');
        let method = $(this).attr('method');

        $.ajax({
            url: action,
            type: method,
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend:function(data) {
                $("#site_loader").show();
            },
            success: function(data) {
                if ((data.status == 200) & (data.success == true)) {
                    notyf.success(data.message);
                } else {
                    notyf.error(data.message);
                }
            },
            complete:function(data) {
                $("#site_loader").hide();
            },
            error: function(e) {
                console.log(e);
                $("#site_loader").hide();
            }

        });

    });






});