$(document).ready(function() {



    $(".newletter-btn").click(function() {

        // <span id="show-message"></span>

        let email = $("#newsletter_email").val();

        if( $.trim( email ) == '' || $.trim( email ) == null) {

            $("#show-message").html(
                "<span class='text-danger small'> Please enter your email address </span>"
            )

        }else{
            $("#show-message").html(" ");
            $.ajax({
                headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                type: "POST",
                url: '/newsletter-subscription',
                data: { email:email },
                dataType: "json",
                success: function(data) {
                    if(data.status == 200 && data.success == true) {
                        $("#show-message").html(
                            `<span class='text-success small'> `+data.message+` </span>`
                        )
                    }else{
                        $("#show-message").html(
                            `<span class='text-danger small'> `+data.message+` </span>`
                        )
                    }
                    console.log(data);
                },
                error: function(e) {
                    console.log(e);
                    if(e.responseJSON) {
                        let error = e.responseJSON.errors.email[0];
                        $("#show-message").html(`<span class="text-danger small">`+error+`</span>`);
                    }
                }
            });
        }

    });



});