$(document).ready(function() {

    // change password call
    $("#changePasswordForm").submit(function(event) {
        event.preventDefault();

        let action = $(this).attr('action');
        let method = $(this).attr('method');

        let password = $("#password").val();
        let confirm_password = $("#confirm_password").val();

        if( $.trim(password) != $.trim(confirm_password) ) {
            alert("not matched");
        }else{
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: action,
                type: method,
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                },
                error: function(e) {
                    console.log(e)
                }
    
            });
        }

    });


    // change password call
    $("#settingForm").submit(function(event) {
        event.preventDefault();

        let action = $(this).attr('action');
        let method = $(this).attr('method');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: action,
            type: method,
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log(data);
            },
            error: function(e) {
                console.log(e)
            }

        });

    });


});